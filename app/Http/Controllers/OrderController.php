<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\calculateSubTotalController;

class OrderController extends Controller
{
    private Order $order;
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd($this->order->with('products')->get());
        return Inertia('Orders/IndexOrders',[
            'orders' => $this->order->with('products')->orderBy('id', 'asc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(calculateSubTotalController $subtotalCalculator)
    {
        return Inertia('Orders/Form/CreateOrder', [
            'amount' => number_format($subtotalCalculator->calculate(), 2, '.', ''),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'string|required'
        ]);

        if($validated['status'] != 'canceled'){
            return abort(404);
        }

        $order->status = $validated['status'];
        $order->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
