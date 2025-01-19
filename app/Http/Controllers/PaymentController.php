<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Models\Order;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function store(StorePaymentRequest $request,Order $order)
    {
        $validated = $request->validated();
        $payment = new Payment($validated);
        $payment->order_id = $order->id;
        if ($payment->save()) {
            $order->status = 'transporting';
            $order->save();

            return redirect()->route('orders.index')->with('success', 'Pagamento realizado com sucesso!');
        }

        // Caso o pagamento falhe, retorna para a página anterior com erro
        return redirect()->route('orders.index');
    }
}
