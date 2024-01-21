<?php

namespace App\Imports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Str;
class BooksImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Book([
            'name' => $row['name'],
            'code' => $row['code'],
            'description' => $row['description'],
            'weight' => $row['weight'],
            'format' => $row['format'],
            'year' => $row['year'],
            'language' => $row['language'],
            'size' => $row['size'],
            'num_pages' => $row['num_pages'],
            'translator' => $row['translator'],
            'link_pdf' => $row['link_pdf'],
            'supplier_id' => $row['supplier_id'],
            'publisher_id' => $row['publisher_id'],
            'slug' => Str::slug($row['name']),
            'book_type' => $row['book_type'],
            'overrate' => $row['overrate']
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}
