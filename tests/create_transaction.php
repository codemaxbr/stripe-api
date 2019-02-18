<?php

use Codemax\Stripe;

require '../vendor/autoload.php';
$stripe = new Stripe('sk_test_zQu0SczdxI8yaplfkgn0TlbG');

//$customers = $stripe->allCustomers();
//$charges = $stripe->initPayment(1090, 'card', []);

//$customer = $stripe->createCustomer('Jonh Doe', 'jonh@example.com');

$charge = $stripe->createCharge('cus_EYAM7skUutI5pT', 'card_1E545lKRQS1jPcOnkqOW85jg', 9900, 'Teste da API');
//echo "<pre>";
print_r($charge);