<?php

namespace App\Imports;

use App\Models\GoodsReceivedNote;
use Maatwebsite\Excel\Concerns\ToModel;

class GoodsReceivedNoteImport implements ToModel
{

    public function model(array $row)
    {
        return new GoodsReceivedNote([
        ]);
    }
}
