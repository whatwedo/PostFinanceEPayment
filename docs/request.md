# Create A Payment Request

```php
<?php
require(__DIR__ . "/../vendor/autoload.php");

use whatwedo\PostFinanceEPayment\Client\Client;
use whatwedo\PostFinanceEPayment\Environment\TestEnvironment;
use whatwedo\PostFinanceEPayment\Order\Order;
use whatwedo\PostFinanceEPayment\PostFinanceEPayment;

$env = new TestEnvironment(
    "abcTEST", // PSPID
    "ABC", // SHA-IN
    "ABC" // SHA-OUT
);

$env->setHashAlgorithm(TestEnvironment::HASH_SHA512); // if you want to use another algorithm than sha-1

// if you want, you can set this in the backoffice
$env->setAcceptUrl("https://www.example.com/checkout/postfinance/accept");
$env->setCancelUrl("https://www.example.com/checkout/postfinance/cancel");
$env->setCatalogUrl("https://www.example.com/shop");
$env->setDeclineUrl("https://www.example.com/checkout/postfinance/decline");
$env->setExceptionUrl("https://www.example.com/checkout/postfinance/exception");
$env->setHomeUrl("https://www.example.com/");

$ePayment = new PostFinanceEPayment($env);

/*
 * you can implement ClientInterface and OrderInterface
 * to use it with your existing classes or create a custom class
 * by extending AbstractClient oder AbstractOrder
 */
$client = new Client();
$client->setId(5)
    ->setName("John McClane")
    ->setAddress("Willisstrasse 3")
    ->setTown("3000 Bern")
    ->setCountry("CH")
    ->setTel("+41 99 999 99 99")
    ->setEmail("yippee-ki-yay-motherf_cker@nypd.us")
    ->setLocale("de_CH");

$order = new Order();
$order->setId(10)
    ->setAmount(30.35)
    ->setCurrency("CHF")
    ->setOrderText("example order");

// creates a Payment-object with all form information.
$payment = $ePayment->createPayment($client, $order);

// or directly print the form
echo $payment->getForm()->getHtml("my form fields...", "<input type=\"submit\" value=\"buy/pay!\">");
```

## Passing own parameters

optionally, you can pass more payment parameters to the `createPayment` method.

```php
$payment = $ePayment->createPayment($client, $order, [
    // Adding ALIAS Parameter for recurring payments
    Parameter::ALIAS      => sprintf('RECURRING_%s_CLIENT_%s', $order->getId(), $client->getId()),
    Parameter::ALIASUSAGE => 'Recurring Invoice for Domain example.com'
]);
```

* [back to index](index.md)
* [transaction feedback](response.md)
