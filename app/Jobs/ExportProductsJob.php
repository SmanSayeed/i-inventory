<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
class ExportProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $products = Product::all();
        $csvContent = "ID,Name,Description,Price,Quantity,Category\n";

        foreach ($products as $product) {
            $csvContent .= "{$product->id},{$product->name},{$product->description},{$product->price},{$product->quantity},{$product->category->name}\n";
        }

        Storage::put('public/products.csv', $csvContent);
    }
}
