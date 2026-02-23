<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $pageTitle }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; line-height: 1.5; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; }
        .header { border-bottom: 2px solid #28c76f; padding-bottom: 20px; margin-bottom: 20px; }
        .header table { width: 100%; }
        .logo { font-size: 28px; font-weight: bold; color: #28c76f; }
        .invoice-info { text-align: right; }
        .section-title { font-size: 18px; font-weight: bold; margin-bottom: 10px; color: #28c76f; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        .details table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .details th { background: #f8f9fa; text-align: left; padding: 12px; border-bottom: 2px solid #eee; }
        .details td { padding: 12px; border-bottom: 1px solid #eee; }
        .summary { margin-top: 30px; width: 100%; }
        .summary table { width: 300px; margin-left: auto; border-collapse: collapse; }
        .summary td { padding: 8px; text-align: right; }
        .summary .total { font-weight: bold; font-size: 18px; color: #28c76f; border-top: 2px solid #28c76f; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #777; border-top: 1px solid #eee; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <table>
                <tr>
                    <td class="logo">{{ gs('site_name') }}</td>
                    <td class="invoice-info">
                        <strong>Payout Receipt:</strong> #{{ $transaction->trx }}<br>
                        <strong>Date:</strong> {{ showDateTime($transaction->created_at, 'd M, Y') }}
                    </td>
                </tr>
            </table>
        </div>

        <table style="width: 100%; margin-bottom: 40px;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <div class="section-title">Paid To</div>
                    <strong>{{ $influencer->fullname }}</strong><br>
                    Username: {{ $influencer->username }}<br>
                    Email: {{ $influencer->email }}<br>
                    Country: {{ $influencer->country_name }}
                </td>
                <td style="width: 50%; vertical-align: top; text-align: right;">
                    <div class="section-title">Platform Remittance</div>
                    {{ gs('site_name') }} Marketplace<br>
                    {{ gs('email_from') }}<br>
                    Status: <span style="color: #28c76f;">Released</span>
                </td>
            </tr>
        </table>

        <div class="details">
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th style="text-align: right;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            Earnings Release: Campaign Job Completed<br>
                            <small>Reference: {{ $transaction->details }}</small>
                        </td>
                        <td style="text-align: right;">{{ gs('cur_sym') }}{{ showAmount($transaction->amount + $transaction->charge) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="summary">
            <table>
                <tr>
                    <td>Gross Earnings:</td>
                    <td>{{ gs('cur_sym') }}{{ showAmount($transaction->amount + $transaction->charge) }}</td>
                </tr>
                <tr>
                    <td>Platform Service Fee ({{ getAmount($transaction->charge > 0 ? ($transaction->charge / ($transaction->amount + $transaction->charge) * 100) : 0) }}%):</td>
                    <td>-{{ gs('cur_sym') }}{{ showAmount($transaction->charge) }}</td>
                </tr>
                @if($transaction->gst_amount > 0)
                <tr>
                    <td>GST Return:</td>
                    <td>+{{ gs('cur_sym') }}{{ showAmount($transaction->gst_amount) }}</td>
                </tr>
                @endif
                <tr class="total">
                    <td>Net Payout:</td>
                    <td>{{ gs('cur_sym') }}{{ showAmount($transaction->amount) }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            This is a computer-generated payout receipt for your records. <br>
            {{ gs('site_name') }} | Professional Influencer Marketplace
        </div>
    </div>
</body>
</html>
