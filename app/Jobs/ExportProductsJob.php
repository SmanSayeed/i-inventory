<?php
namespace App\Jobs;

use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;

class ExportProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function handle()
    {
        try {
            // Export the products and store them
            Excel::store(new ProductsExport, $this->filePath, 'public');

            // Send a notification or take additional actions here if needed
            // For example, you could trigger a notification or an event to notify the user when done

        } catch (\Exception $e) {
            \Log::error('Failed to export products: ' . $e->getMessage());
        }
    }
}
