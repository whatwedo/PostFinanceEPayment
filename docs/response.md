# Transaction Feedback

you can either get a transaction feedback with GET variables when user is redirecting back to your page or you can
choose a server-side method. for both, you can use this code snippet to get the result of the transaction:

```php
<?php

require(__DIR__ . "/../vendor/autoload.php");

use whatwedo\PostFinanceEPayment\Environment\TestEnvironment;
use whatwedo\PostFinanceEPayment\Exception\NotValidSignatureException;
use whatwedo\PostFinanceEPayment\Model\PaymentStatus;
use whatwedo\PostFinanceEPayment\PostFinanceEPayment;

$env = new TestEnvironment(
    "abcTEST", // PSPID
    "ABC", // SHA-IN
    "ABC" // SHA-OUT
);
$env->setHashAlgorithm(TestEnvironment::HASH_SHA512); // if you want to use another algorithm than sha-1

$ePayment = new PostFinanceEPayment($env);

$response = $ePayment->getResponse(); // takes $_GET array to look for PostFinance variables
// $response = $ePayment->getResponse($_POST); // takes $_POST array to look for PostFinance variables

try {
    $response = $ePayment->getResponse($parameters);
}
catch(NotValidSignatureException $e) {
    die("PostFinance signature does not match, maybe fraud access?");
}

if ($response->hasError()) {
    switch($response->getStatus()) {
        case PaymentStatus::INCOMPLETE:
            echo "Payment incomplete. ";
            break;
        case PaymentStatus::DECLINED:
            echo "Payment declined. ";
            break;
        default:
            printf("Error: %s.", $response->getError());
            break;
    }
    if ($response->isRetryError()) {
        echo "You should try again.";
    }
} else {
    echo "success";
}
```

* [create a payment request](request.md)
* [back to index](index.md)
