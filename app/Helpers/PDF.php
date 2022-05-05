<?php

namespace App\Helpers;

use Codedge\Fpdf\Fpdf\Fpdf;

class PDF extends Fpdf
{
    public function addTitle($title)
    {
        $this->SetFont('Arial', 'B', 20);
        $this->SetLineWidth(.6);
        $this->SetDrawColor(18, 166, 166);
        $this->SetTextColor(233, 0, 136);
        $this->SetFillColor(195, 209, 235);
        $this->MultiCell(0, 10, $title, 1, 'C', true);
    }
}
