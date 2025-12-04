<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PDFService
{
    function createRegistrationInvoicePDF($type = null, $data)
    {
        if ($type == 'download') {
            $showFields = 0;
        }

        $customPaper = array(0, 0, 668, 863);
        $pdf = PDF::loadView('pdf.registration-invoice', compact('data'))->setPaper($customPaper);
        if (!file_exists(public_path() . '/invoices')) {
            mkdir(public_path() . '/invoices');
            chmod(public_path() . '/invoices', 0775);
        }
        if (!file_exists(public_path() . '/invoices/registration-invoice')) {
            mkdir(public_path() . '/invoices/registration-invoice');
            chmod(public_path() . '/invoices/registration-invoice', 0775);
        }
        Storage::put('public/invoices/registration-invoice/' . $data['order']['invoice_no'] . '.pdf', $pdf->output());
        if ($type == 'view') {
            return view('pdf.repair-shop-invoice', compact('data'));
        } else if ($type == 'download') {
            return $data['order']['invoice_no'] . '.pdf';
            // return $pdf->download('invoice-' . $item->invoice_no . '.pdf');
        }
    }
}
