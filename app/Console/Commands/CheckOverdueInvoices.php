<?php

namespace App\Console\Commands;

use App\Models\Invoice;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('invoices:check-overdue')]
#[Description('Mark sent invoices as overdue once their due date has passed')]
class CheckOverdueInvoices extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //
        $count = Invoice::where('status', 'sent')
            ->whereDate('due_date', '<', now())
            ->update(['status' => 'overdue']);

        $this->info("Marked {$count} invoice(s) as overdue.");
    }
}
