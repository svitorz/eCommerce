<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\calculateSubTotalController;
use App\Http\Controllers\PaymentController;
use App\Models\Payment;
use App\Actions\Payment\StoreNewPayment;

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
            'orders' => $this->order->with(['payments','products'])->orderBy('id', 'asc')->get(),
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
    public function store(Request $request, calculateSubTotalController $subtotalCalculator,StoreNewPayment $storePayment)
    {
        $validated = $request->validate([
            'fullName' => 'required|string|min:3|max:255',
            'ccv' => 'required|digits:3',
            'cardNumber' => 'required|regex:/^[0-9\s]{16,20}$/', // Aceita números e espaços
            'cardExpiration' => 'required|date_format:m/Y|after_or_equal:today',
        ]);
        $order = Order::create(
            [
                'status' => 'pending_payment',
                'subtotal' => number_format($subtotalCalculator->calculate(), 2, '.', ''),
                'user_id' => auth()->user()->id,
            ]
        );
        $payment = new Payment([
           'full_name' => $validated['fullName'],
            'ccv'=> $validated['ccv'],
            'card_number'=> $validated['cardNumber'],
            'card_expiration'=>\Carbon\Carbon::createFromFormat('m/Y', $validated['cardExpiration'])->startOfMonth()->format('Y-m-d'),
            'order_id'=> $order,

        ]);
        $storePayment->handle($payment,$order);

        return to_route('orders.index');
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
