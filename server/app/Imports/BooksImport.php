<?php

namespace App\Imports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\ToModel;

class BooksImport implements ToModel
{
    public function model(array $row)
    {
        return new Book([
            'name' => $row[0],
            'code' => $row[1],
            'description' => $row[2],
            'weight' => $row[3],
            'format' => $row[4],
            'year' => $row[5],
            'language' => $row[6],
            'size' => $row[7],
            'num_pages' => $row[8],
            'translator' => $row[9],
            'link_pdf' => $row[10],
            'supplier_id' => $row[11],
            'publisher_id' => $row[12],
            'book_type' => $row[13],
        ]);
    }
}
