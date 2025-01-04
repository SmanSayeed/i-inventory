<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Jobs\ExportProductsJob;
use App\Exports\ProductsExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search
        if ($request->has('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                ->orWhere('description', 'like', "%{$request->search}%");
        }

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by price range
        if ($request->has('price_min') && $request->has('price_max')) {
            $query->whereBetween('price', [$request->price_min, $request->price_max]);
        }

        $products = $query->paginate(10);
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $product = Product::create($request->all());

        if ($request->hasFile('image')) {
            $product->addMedia($request->file('image'))->toMediaCollection('product_images');
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $product->update($request->all());

        if ($request->hasFile('image')) {
            $product->clearMediaCollection('product_images');
            $product->addMedia($request->file('image'))->toMediaCollection('product_images');
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function exportProductsView()
    {
        ExportProductsJob::dispatch();
        return redirect()->route('products.index')->with('success', 'CSV export has been queued.');
    }

    /**
     * Export all products to a CSV file asynchronously.
     */
    public function exportProducts()
    {
        try {
            // Define the file path
            $filePath = 'exports/products_' . now()->format('Y_m_d_H_i_s') . '.xlsx';

            // Dispatch the job for background export
            ExportProductsJob::dispatch($filePath);

            return response()->json([
                'success' => true,
                'message' => 'Products export is in progress. You will be notified once it is ready.',
                'filePath' => $filePath,  // You can store or send this information to notify the user later
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to export products: ' . $e->getMessage(),
            ]);
        }
    }

    public function downloadExport($fileName)
    {
        $filePath = storage_path('app/public/exports/' . $fileName);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        return response()->json([
            'success' => false,
            'message' => 'File not found.',
        ]);
    }



    // public function exportProducts()
    // {
    //     try {
    //         $filePath = 'exports/products_' . now()->format('Y_m_d_H_i_s') . '.xlsx';

    //         // Use Excel facade to store the file
    //         Excel::store(new ProductsExport, $filePath, 'public');

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Products exported successfully.',
    //             'url' => asset('storage/' . $filePath),
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to export products: ' . $e->getMessage(),
    //         ]);
    //     }
    // }

    public function showExportedFiles()
    {
        // Define the path where exported files are stored
        $exportDirectory = storage_path('app/public/exports');

        // Get all files in the directory
        $files = File::allFiles($exportDirectory);

        return view('products.list', ['files' => $files]);
    }
}
