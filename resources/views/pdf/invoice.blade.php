<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 14px; color: #222; }
        h1 { font-size: 20px; margin-bottom: 4px; }
        .meta { margin-bottom: 20px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f5f5f5; }
        .total-row td { font-weight: bold; }
        .status { text-transform: uppercase; font-size: 12px; color: #888; }
    </style>
</head>
<body>
    <h1>Invoice {{ $invoice->invoice_number }}</h1>
    <p class="status">Status: {{ $invoice->status }}</p>

    <div class="meta">
        <strong>Billed to:</strong> {{ $invoice->client->name }}<br>
        {{ $invoice->client->email }}<br>
        @if ($invoice->client->address)
            {{ $invoice->client->address }}<br>
        @endif
        <br>
        <strong>Issue date:</strong> {{ $invoice->issue_date?->format('d M Y') ?? '—' }}<br>
        <strong>Due date:</strong> {{ $invoice->due_date?->format('d M Y') ?? '—' }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Qty</th>
                <th>Unit price</th>
                <th>Line total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price, 2) }}</td>
                    <td>{{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3">Total</td>
                <td>{{ number_format($invoice->total, 2) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>