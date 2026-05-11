<?php

namespace App\Services\Kiosk;

use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReceiptService
{
    public function __construct()
    {
    }

    public static function generateRefNo(): string
    {
        $suffix = 'NP';
        $date = Carbon::now()->format('ymd');
        $random = Str::upper(Str::random(5));

        $referenceNo = "{$suffix}-{$date}-{$random}";

        if (Payment::query()->where('reference_no', $referenceNo)->exists()) {
            return self::generateRefNo();
        }
        return $referenceNo;
    }

    public static function generateReceiptPdf(array $receiptData): Dompdf
    {
        $options = new Options();
        $options->set('isRemoteEnabled', false);
        $options->set('isPhpEnabled', true);
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);

        $html = self::renderReceiptHtml($receiptData);
        $dompdf->loadHtml($html);

        $dompdf->setPaper([0, 0, 226.77, 465.58]);
        $dompdf->render();

        return $dompdf;
    }

    private static function renderReceiptHtml(array $data): string
    {
        $formattedAmount = function($amount) {
            return number_format($amount, 2);
        };

        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        html, body {
            margin: 0;
            padding: 0;
            background: white;
        }
        body {
            font-family: 'Courier New', monospace;
            font-size: 10pt;
            width: 80mm;
            line-height: 1.4;
            color: #000;
        }
        .receipt-container {
            width: 100%;
            padding: 4mm;
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 4mm;
            margin-right: 8mm;
        }
        .receipt-logo {
            width: 60px;
            height: auto;
            margin-bottom: 3mm;
        }
        .receipt-title {
            font-weight: bold;
            font-size: 12pt;
            margin-bottom: 1mm;
            text-transform: uppercase;
        }
        .receipt-subtitle {
            font-size: 9pt;
            margin-bottom: 1mm;
        }
        .receipt-contact {
            font-size: 8pt;
            color: #333;
            margin-bottom: 4mm;
        }

        .separator {
            border-top: 1px dashed #000;
            margin: 4mm 0;
            width: 100%;
        }

        .receipt-section {
            margin-bottom: 4mm;
            page-break-inside: avoid;
        }
        .receipt-row {
            display: flex;
            justify-content: space-between;
            font-size: 9pt;
            margin-bottom: 1mm;
            word-break: break-word;
        }
        .receipt-row-label {
            font-weight: bold;
            flex: 0 0 auto;
            margin-right: 2mm;
        }
        .receipt-row-value {
            text-align: right;
            flex: 1;
        }
        .receipt-footer {
            text-align: center;
            font-size: 8pt;
            margin-top: 6mm;
            color: #000;
        }
        .receipt-footer p {
            margin-bottom: 1mm;
            margin-right: 8mm;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <div class="receipt-title">PAYMENT RECEIPT</div>
            <div class="receipt-subtitle">Nexus Pay System</div>
            <div class="receipt-contact">
                109 Samson Road corner Caimito Road, Caloocan City, Metro Manila, 1400<br>
                Email: support@nexuspay.com
            </div>
        </div>

        <div class="separator"></div>

        <div class="receipt-section">
            <div class="receipt-row">
                <span class="receipt-row-label">Reference No:</span>
                <span class="receipt-row-value">{$data['reference_number']}</span>
            </div>
            <div class="receipt-row">
                <span class="receipt-row-label">Date:</span>
                <span class="receipt-row-value">{$data['transaction_date']}</span>
            </div>
        </div>

        <div class="separator"></div>

        <div class="receipt-section">
            <div class="receipt-row">
                <span class="receipt-row-label">Student Name:</span>
                <span class="receipt-row-value">{$data['student_name']}</span>
            </div>
            <div class="receipt-row">
                <span class="receipt-row-label">Student ID:</span>
                <span class="receipt-row-value">{$data['student_id']}</span>
            </div>
            <div class="receipt-row">
                <span class="receipt-row-label">Email:</span>
                <span class="receipt-row-value" style="font-size: 8pt;">{$data['student_email']}</span>
            </div>
        </div>

        <div class="separator"></div>

        <div class="receipt-section">
            <div class="receipt-row">
                <span class="receipt-row-label">Fee Category:</span>
                <span class="receipt-row-value">{$data['fee_category']}</span>
            </div>
            <div class="receipt-row">
                <span class="receipt-row-label">Payment Channel:</span>
                <span class="receipt-row-value">{$data['payment_channel']}</span>
            </div>
            <div class="receipt-row">
                <span class="receipt-row-label">Payment Method:</span>
                <span class="receipt-row-value">{$data['payment_method']}</span>
            </div>
        </div>

        <div class="separator"></div>

        <div class="receipt-section">
            <div class="receipt-row">
                <span class="receipt-row-label">Amount Paid:</span>
                <span class="receipt-row-value">PHP {$formattedAmount($data['amount_paid'])}</span>
            </div>
            <div class="receipt-row">
                <span class="receipt-row-label">Status:</span>
                <span class="receipt-row-value" style="text-transform: uppercase;">{$data['status']}</span>
            </div>
        </div>

        <div class="separator"></div>

        <div class="receipt-section">
            <div class="receipt-row">
                <span class="receipt-row-label">Total Paid to Date:</span>
                <span class="receipt-row-value">PHP {$formattedAmount($data['total_paid_to_date'])}</span>
            </div>
            <div class="receipt-row">
                <span class="receipt-row-label">Outstanding Balance:</span>
                <span class="receipt-row-value">PHP {$formattedAmount($data['outstanding_balance'])}</span>
            </div>
            <div class="receipt-row">
                <span class="receipt-row-label">Account Credit:</span>
                <span class="receipt-row-value">PHP {$formattedAmount($data['total_overpayment'])}</span>
            </div>
        </div>

        <div class="separator"></div>

        <div class="receipt-footer">
            <p>Thank you for your payment!</p>
            <p>Please keep this receipt for your records.</p>
        </div>
    </div>
</body>
</html>
HTML;
    }
}
