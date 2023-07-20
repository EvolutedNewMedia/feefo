# Feefo API PHP SDK
A framework agnostic library for working with the Feefo API for E-commerce sales reviews.

----

## Installation
This project can be installed via [Composer](https://getcomposer.org):

```sh
$ composer require evoluted/feefo
```

## Usage
Using the Feefo api package is fairly easy. Once you've loaded the library via Composer, you can initialise it as follows, remembering to add your Feefo credentials:

```php
$feefo = new Evoluted\Feefo\Feefo(
	'', // Merchant identifier
	'' // API Key
);
```

Once initialised you are able to retrieve the latest reviews with:

```php
$feefo->reviews();
```
You can optionally increase or decrease the number of results from the default of 5 like so:

```php
$feefo->reviews(10);
```

### Custom Calls
You can make custom calls for additional information using the generic get or post request handlers.

#### Retrieving product ratings

```php
$feefo->get('10/products/ratings', [
    'merchant_identifier' => $feefo->merchantIdentifier,
    'review_count' => '10',
    'since' => 'year',
]);
```
#### Adding Sales

```php
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
    'customerref' => '987654',
]);
```

For an example of the above implementation, see the included example file.

## Resources
* [Feefo Developer Documentation](https://support.feefo.com/support/solutions/8000050385)
