<?php

namespace App\Imports;

use App\Models\EdBookingDetail;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EdBookingDetailImprot implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new EdBookingDetail([
            'po_no'=>$row['po_no'],
            'case_qty'=>$row['case_qty'],
            'case_length'=>$row['case_length'],
            'case_width'=>$row['case_width'],
            'case_height'=>$row['case_height'],
            'case_weight'=>$row['case_weight']
        ]);
    }
    public function batchSize(): int
    {
        return 1000;
    }
}
