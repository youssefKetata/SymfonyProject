<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;

class pdfService
{

    private $domPDF;
    public function __construct()
    {
        $this->domPDF = new Dompdf();

        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Garamond');

        $this->domPDF->setOptions($pdfOptions);
    }
    public function showPdfFile($html){
        $this->domPDF->loadHtml($html);
        $this->domPDF->render();
        $this->domPDF->stream('details.pdf', [
            'Attachment' => false
        ]);
    }

    public function generateBinaryPDF($html)
    {
        $this->domPDF->loadHtml($html);
        $this->domPDF->render();
        $this->domPDF->output();

    }
}