<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SalesBill;
use Illuminate\Http\Request;

class PosBilling extends Controller
{
    public function pos_biller()
    {
        return view('pos.biller');
    }

    public function pos_scanner()
    {
        return view('pos.scanner');
    }

    public function get_product(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string'
        ]);

        $product = Product::where('product_code', $request->barcode)->first();

        if ($product) {
            return response()->json(['status' => 'success', 'product' => $product]);
        }

        return response()->json(['status' => 'error', 'message' => 'Product not found']);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'total_amount' => 'required|numeric',
            'total_items' => 'required|integer',
            'items' => 'required|array'
        ]);

        $posId = $request->session()->get('pos_id');
        
        $bill = SalesBill::create([
            'pos_id' => $posId,
            'total_amount' => $request->total_amount,
            'total_items' => $request->total_items,
            'items_data' => $request->items
        ]);

        return response()->json(['status' => 'success', 'bill_id' => $bill->bill_id]);
    }

    public function print_bill($bill_id)
    {
        $bill = SalesBill::findOrFail($bill_id);
        
        return view('pos.receipt', compact('bill'));
    }
}