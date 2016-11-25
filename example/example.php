<?php
include('../src/feefo.php');
require_once('../vendor/autoload.php');

$feefo = new Evoluted\Feefo\Feefo(
	'', // Merchant identifier
	'' // API Key
);

echo '<pre>';
print_r($feefo->reviews());
echo '</pre>';
echo '<hr>';

echo '<pre>';
print_r($feefo->get('10/products/ratings', [
	'merchant_identifier' => $feefo->merchantIdentifier,
    'review_count' => '10',
    'since' => 'year'
]));
echo '</pre>';
echo '<hr>';

// You can also do direct calls to other areas of the api. For example:
$reviews = $feefo->get('10/reviews/service', [
	'merchant_identifier' => $feefo->merchantIdentifier,
]);

// Post requests can also be made, ideal for pushing sales to your feefo account.
$sale = $feefo->post('entersaleremotely', [
	'apikey' => $feefo->apiKey, 
    'merchantidentifier' => $feefo->merchantIdentifier, 
    'email' => 'customer@example.com', 
    'name' => 'John Smith', 
    'date' => '2016-11-25', 
    'description' => 'Our Product', 
    'productsearchcode' => '123456', 
    'orderref' => 'ORDER123456', 
    'amount' => '123.45', 
    'productlink' => 'http://www.example.com/product/123456',
    'customerref' => '987654'
]);