<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Tag;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $carts = DB::table('carts')
    ->join('produks', 'carts.kode_produk', '=', 'produks.kode_produk') // Join based on 'kode_produk'
    ->where('carts.user_id', Auth::user()->id) // Filter by logged-in user
    ->select('carts.id as id_cart' ,'carts.quantity', 'produks.*') // Select fields from both tables
    ->get();

        return view('frontend.cart',compact('carts'));
    }

    public function cart_post(Request $request)
{
    // Get input values
    $kode_barang = $request->input('kode_barang');
    $user_id = Auth::user()->id;
    $quantity = $request->input('quantity', 1); // Default quantity is 1 if not provided

    // Check if the product exists in the 'produks' table
    $product = DB::table('produks')->where('kode_produk', $kode_barang)->first();

    if (!$product) {
        return redirect()->back()->with('error', 'Product not found!');
    }

    // Check if the product already exists in the user's cart
    $cartItem = DB::table('carts')
                    ->where('user_id', $user_id)
                    ->where('kode_produk', $kode_barang)
                    ->first();

    if ($cartItem) {
        // If the product already exists in the cart, update the quantity
        DB::table('carts')
            ->where('user_id', $user_id)
            ->where('kode_produk', $kode_barang)
            ->update([
                'quantity' => $cartItem->quantity + $quantity
            ]);
    } else {
        // If the product does not exist in the cart, insert it as a new item
        DB::table('carts')->insert([
            'user_id' => $user_id,
            'kode_produk' => $kode_barang,
            'quantity' => $quantity,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    // Redirect to the cart page with a success message
    return redirect()->route('cart.index')->with('success', 'Product added to cart successfully!');
}
public function cart_update(Request $request)
{
    // Get the logged-in user's ID
    $user_id = Auth::user()->id;

    // Loop through the updated quantities from the request
    foreach ($request->quantities as $kode_produk => $quantity) {
        // Check if the product exists in the 'produks' table
        $product = DB::table('produks')->where('kode_produk', $kode_produk)->first();

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found: ' . $kode_produk]);
        }

        // Check if the product already exists in the user's cart
        $cartItem = DB::table('carts')
                        ->where('user_id', $user_id)
                        ->where('kode_produk', $kode_produk)
                        ->first();

        if ($cartItem) {
            // If the product exists in the cart, update the quantity
            DB::table('carts')
                ->where('user_id', $user_id)
                ->where('kode_produk', $kode_produk)
                ->update([
                    'quantity' => $quantity  // Update quantity to the new value
                ]);
        } else {
            // If the product doesn't exist in the cart, insert it as a new item
            DB::table('carts')->insert([
                'user_id' => $user_id,
                'kode_produk' => $kode_produk,
                'quantity' => $quantity,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    // Return success response
    return response()->json(['success' => true, 'message' => 'Cart updated successfully!']);
}
public function cart_delete(Request $request)
{
    // Get the cart item ID from the request
    $cartItemId = $request->input('id_Cart');
    $user_id = Auth::user()->id; // Get the logged-in user's ID
    // Find the cart item
    $cartItem = DB::table('carts')->where('id', $cartItemId)->where('user_id', $user_id)->first();

    if ($cartItem) {
        // If the item exists in the cart, delete it
        DB::table('carts')->where('id', $cartItemId)->where('user_id', $user_id)->delete();
        return response()->json(['success' => true, 'message' => 'Cart item deleted successfully.']);
    } else {
        // If the cart item doesn't exist, return an error
        return response()->json(['success' => false, 'message' => 'Cart item not found.']);
    }
}


    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
