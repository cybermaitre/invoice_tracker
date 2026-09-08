<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\InvoiceMailable;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $invoices = $request->user()->invoices()
            ->with('items', 'client')
            ->latest()
            ->get();

        return response()->json($invoices);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $Validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'invoice_number' => 'required|string',
            'due_date' => 'nullable|date',
            'items' => 'required|array|min:1',
            'items.*.item' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',

        ]);

        if ($Validator->fails()) {
            return response()->json(['errors' => $Validator->errors()], 422);
        }

        $client = $request->user()->clients()->find($request->client_id);
        if (! $client) {
            return response()->json(['errors' => ['client_id' => ['Client not found']]], 422);
        }
        $invoice = DB::transaction(function () use ($request, $client) {
            $invoice = $request->user()->invoices()->create([
                'client_id' => $client->id,
                'invoice_number' => $request->invoice_number,
                'due_date' => $request->due_date,
            ]);

            foreach ($request->items as $item) {
                $invoice->items()->create($item);
            }

            $invoice->recalculateTotal();

            return $invoice;
        });

        return response()->json($invoice->load('items', 'client'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Invoice $invoice)
    {
        //
        if ($invoice->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json($invoice->load('items', 'client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
        if ($invoice->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Not found'], 404);
        }
        if ($invoice->status !== 'draft') {
            return response()->json(['message' => 'Only draft invoices can be edited'], 422);
        }
        $validator = Validator::make($request->all(), [
            'invoice_number' => 'sometimes|required|string|max:255',
            'due_date' => 'nullable|date',
            'items' => 'sometimes|array|min:1',
            'items.*.item' => 'required_with:items|string|max:255',
            'items.*.quantity' => 'required_with:items|integer|min:1',
            'items.*.unit_price' => 'required_with:items|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::transaction(function () use ($request, $invoice) {
            $invoice->update($request->only(['invoice_number', 'due_date']));

            if ($request->has('items')) {
                $invoice->items()->delete();

                foreach ($request->items as $item) {
                    $invoice->items()->create($item);
                }
            }

            $invoice->recalculateTotal();
        });

        return response()->json($invoice->fresh()->load('items', 'client'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Invoice $invoice)
    {
        //
        if ($invoice->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Not found'], 404);
        }
        $invoice->delete();

        return response()->json(['message' => 'Invoice deleted']);
    }



    public function send(Request $request, Invoice $invoice)
    {
        if ($invoice->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Not found'], 404);
        }

        if ($invoice->status !== 'draft') {
            return response()->json(['message' => 'Only draft invoices can be sent'], 422);
        }

        if ($invoice->items()->count() === 0) {
            return response()->json(['message' => 'Cannot send an invoice with no items'], 422);
        }

        $invoice->update([
            'status' => 'sent',
            'sent_at' => now(),
            'due_date' => $invoice->due_date ?? now()->addDays(14),
        ]);

        Mail::to($invoice->client->email)->send(new InvoiceMailable($invoice));

        return response()->json($invoice->fresh()->load('items', 'client'));
    }

    public function markPaid(Request $request, Invoice $invoice)
    {
        if ($invoice->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Not found'], 404);
        }

        if (! in_array($invoice->status, ['sent', 'overdue'])) {
            return response()->json(['message' => 'Only sent or overdue invoices can be marked as paid'], 422);
        }

        $invoice->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return response()->json($invoice->fresh()->load('items', 'client'));
    }
}
