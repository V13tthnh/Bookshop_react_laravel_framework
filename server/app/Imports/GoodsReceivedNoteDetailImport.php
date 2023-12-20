<?php

namespace App\Imports;

use App\Models\GoodsReceivedNote;
use App\Models\GoodsReceivedNoteDetail;
use Maatwebsite\Excel\Concerns\ToModel;

class GoodsReceivedNoteDetailImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new GoodsReceivedNoteDetail([
            'book_id' => $row[0],
            'quantity' => $row[1],
            'cost_price' => $row[2],
            'selling_price' => $row[3],
        ]);
    }
}
