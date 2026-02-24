<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $pageTitle }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; line-height: 1.5; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; }
        .header { display: table; width: 100%; border-bottom: 2px solid #eee; padding-bottom: 20px; }
        .logo { width: 150px; }
        .title { text-align: right; }
        .title h1 { margin: 0; color: #555; font-size: 28px; }
        .info { margin-top: 30px; width: 100%; }
        .info td { vertical-align: top; width: 50%; }
        .details-table { width: 100%; margin-top: 40px; border-collapse: collapse; }
        .details-table th { background: #f9f9f9; text-align: left; padding: 10px; border-bottom: 1px solid #eee; }
        .details-table td { padding: 10px; border-bottom: 1px solid #eee; }
        .total { text-align: right; margin-top: 30px; font-size: 18px; font-weight: bold; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #999; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <div style="display: table-cell;">
                @php
                    $logoPath = public_path('assets/images/logo_icon/logo.png');
                    $base64Logo = '';
                    if (file_exists($logoPath)) {
                        $base64Logo = base64_encode(file_get_contents($logoPath));
                    }
                @endphp
                @if($base64Logo)
                    <img src="data:image/png;base64,{{ $base64Logo }}" class="logo">
                @else
                    <h2>{{ gs('site_name') }}</h2>
                @endif
            </div>
            <div style="display: table-cell;" class="title">
                <h1>RECEIPT</h1>
                <p>#{{ $transaction->trx }}<br>{{ showDateTime($transaction->created_at, 'M d, Y') }}</p>
            </div>
        </div>

        <table class="info">
            <tr>
                <td>
                    <strong>Billed To:</strong><br>
                    {{ $user->fullname }}<br>
                    {{ $user->email }}<br>
                    {{ @$user->address->address }}
                </td>
                <td>
                    <strong>From:</strong><br>
                    {{ gs('site_name') }}<br>
                    contact@influenced.com
                </td>
            </tr>
        </table>

        <table class="details-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th style="text-align: right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ __($transaction->details) }}</td>
                    <td style="text-align: right;">{{ showAmount($transaction->amount) }}</td>
                </tr>
                @if($transaction->gst_amount > 0)
                <tr>
                    <td>GST Amount (15%):</td>
                    <td style="text-align: right;">{{ showAmount($transaction->gst_amount) }}</td>
                </tr>
                @endif
            </tbody>
        </table>

        <div class="total">
            Total: {{ showAmount($transaction->amount + $transaction->gst_amount) }}
        </div>

        <div class="footer">
            Thank you for using {{ gs('site_name') }}. This is a computer-generated receipt.
        </div>
    </div>
</body>
</html>
