<?php

namespace Codemax;

trait StripeEndpoints
{

    public function allCharges()
    {
        return $this->getQuery('charges', []);
    }

    public function allCustomers()
    {
        return $this->getQuery('customers', []);
    }

    public function createCharge($customer_token, $payment_token, $amount, $description)
    {
        $args = [
            'customer' => $customer_token,
            'source' => $payment_token,
            'amount' => $amount,
            'description' => $description,
            'currency' => 'usd'
        ];

        return $this->postQuery('charges', $args);
    }

    public function createCustomer($name, $email, $args = array())
    {
        $args['description'] = $name;
        $args['email'] = $email;

        return $this->postQuery('customers', $args);
    }

    public function initPayment($amount, $pay_method, $args)
    {
        $args['amount'] = $amount;
        $args['currency'] = 'usd';
        $args['payment_method_types'][] = $pay_method;
        $args['capture_method'] = 'automatic';

        return $this->postQuery('payment_intents', $args);
    }
}