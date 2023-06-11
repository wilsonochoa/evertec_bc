<?php

namespace App\Http\Controllers\Web;

use App\Domain\Orders\Actions\UpdateOrderStatus;
use App\Domain\Orders\Models\Order;
use App\Domain\Orders\ViewModels\DetailViewModel;
use App\Domain\Payments\Actions\GetOrderPayments;
use App\Domain\Payments\Actions\UpdatePaymentStatus;
use App\Http\Controllers\Controller;
use App\Support\Definitions\OrderStatus;
use App\Support\Definitions\PaymentStatus;
use App\Support\Exceptions\UnsupportedPaymentMethod;
use App\Support\Services\PaymentFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Order/List');
    }

    /**
     * @throws UnsupportedPaymentMethod
     */
    public function show(Order $order, PaymentFactory $paymentFactory): Response|RedirectResponse
    {
        if ($order->user_id !== Auth::id()) {
            return redirect()->route('dashboard');
        }
        $payment = GetOrderPayments::execute(['order_id' => $order->id]);
        if ($payment) {
            $processor = $paymentFactory->initializePayment($payment->payment_type);
            $status = $processor->getPaymentStatus((string) $payment->request_id);
            UpdatePaymentStatus::execute(['id' => $payment->id, 'status' => $status]);

            if ($status === PaymentStatus::APPROVED->value) {
                UpdateOrderStatus::execute(['id' => $order->id, 'status' => OrderStatus::COMPLETED->value]);
                $order->refresh();
            }
        }

        return Inertia::render('Order/Detail', new DetailViewModel($order));
    }
}
