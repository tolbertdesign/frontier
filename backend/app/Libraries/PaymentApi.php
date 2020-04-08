<?php

namespace App\Libraries;

interface PaymentApi
{
    public function authorizePayment($paymentForm, $total, $school, $program, $orderId);

    public function settlePayment($transaction_id);
}
