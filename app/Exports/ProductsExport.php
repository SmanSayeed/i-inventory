<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    /**
     * Get the collection of products.
     */
    public function collection()
    {
        return Product::all(['id', 'name', 'description', 'price', 'quantity']);
    }

    /**
     * Define the headers for the Excel file.
     */
    public function headings(): array
    {
        return ['ID', 'Name', 'Description', 'Price', 'Quantity'];
    }
}
