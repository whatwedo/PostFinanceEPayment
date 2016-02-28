<?php

/*
 * This file is part of the whatwedo PostFinance E-Payment library.
 *
 * (c) 2014 whatwedo GmbH (https://whatwedo.ch)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (!is_file($autoloadFile = __DIR__.'/../vendor/autoload.php')) {
    throw new \RuntimeException('vendor/autoload.php not found. Did you run "composer install --dev"?');
}

$loader = require $autoloadFile;
$loader->add('JMS\Serializer\Tests', __DIR__);
