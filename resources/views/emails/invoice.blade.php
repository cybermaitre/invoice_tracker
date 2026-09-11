<h2>Invoice {{ $invoice->invoice_number }}</h2>
<p>Hello {{ $invoice->client->client_name }},</p>
<p>Please find your invoice details below.</p>

<table cellpadding="8">
    <thead>
        <tr><th>Item</th><th>Qty</th><th>Unit price</th></tr>
    </thead>
    <tbody>
        @foreach ($invoice->items as $item)
            <tr>
                <td>{{ $item->item }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->unit_price, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<p><strong>Total: {{ number_format($invoice->total, 2) }}</strong></p>
<p>Due date: {{ $invoice->due_date?->format('d M Y') }}</p>