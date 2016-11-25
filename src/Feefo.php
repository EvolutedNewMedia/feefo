<?php
namespace Evoluted\Feefo;

use \GuzzleHttp\Client;
use \GuzzleHttp\Psr7\Response;

/**
 * The Feefo api package provides a generic api to integrate with Feefo. 
 *
 * Out of the box it provides a way of retrieving revies and product ratings,
 * however also allows you to make custom calls to the api, such as posting 
 * sales details.
 *
 * @package     Feefo
 * @author      Rick Mills <rick@evoluted.net>
 * @author      Evoluted New Media <developers@evoluted.net>
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/evolutednewmedia/feefo
 *
 */
class Feefo
{
    public $merchantIdentifier;
    public $apiKey;

    public $apiUrl = 'https://api.feefo.com/api/';

    /**
     * Initialise the class
     * 
     * @param string Merchant Identifier
     * @param string API Key
     */
    public function __construct($merchantIdentifier, $apiKey)
    {
        $this->merchantIdentifier = $merchantIdentifier;
        $this->apiKey = $apiKey;
    }

    /**
     * Retrieve all reviews in a sightly more formatted way. Pulls the
     * latest reviews, and returning in an array.
     * 
     * @param  integer Number of reviews to retrieve
     * @return array Array of basic review details
     */
    public function reviews($limit = 5)
    {
        $params = [
            'merchant_identifier' => $this->merchantIdentifier,
        ];

        $result = $this->get('10/reviews/service', $params);

        $reviews = [];

        $i = 0;

        foreach ($result->reviews as $review) {
            if ($i < $limit) {

                $reviews[] = [
                    'url ' => $review->url,
                    'customer_name' => (! empty($review->customer->display_name) ? $review->customer->display_name : null),
                    'location' => (! empty($review->customer->location) ? $review->customer->location : null),
                    'rating_min' => $review->service->rating->min,
                    'rating_max' => $review->service->rating->max,
                    'rating' => $review->service->rating->rating,
                    'product' => (! empty($review->products_purchased[0]) ? $review->products_purchased[0] : null),
                    'review' => $review->service->review
                ];
                $i++;
            }
        }
        
        return $reviews;
    }

    /**
     * A generic reusable get request handler for the api.
     * 
     * @param  string The API endpoint, including version number if applicable
     * @param  array Array of query string paramters to send with the request
     * 
     * @return object Returns the full api response
     */
    public function get($endpoint, $params)
    {
        return $this->__request($endpoint, $params);
    }

    /**
     * A generic reusable post request handler for the api.
     * 
     * @param  string The API endpoint, including version number if applicable
     * @param  array Array of post data paramters to send with the request
     * 
     * @return object Returns the full api response
     */
    public function post($path, $params)
    {
        return $this->__request($endpoint, $params, 'post');
    }

    /**
     * Handles formatting and sending the API requests via the Guzzle Http library
     * 
     * @param  string Endpoint to call
     * @param  array The query string or post params to send with the request
     * @param  string The type of request. Defaults to get but can be switched to post
     * 
     * @return object Returns the decoded response object
     */
    private function __request($endpoint, $params, $type = 'get')
    {
        $client = new \GuzzleHttp\Client(['base_uri' => $this->apiUrl]);

        if ($type == 'get') {
            $response = $client->request('GET', $endpoint, [
                'query' => $params
            ]);

        } elseif ($type == 'post') {
            $response = $client->request('POST', $endpoint, [
                'form_params' => $params
            ]);
        }

        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody()->getContents());
        }

        return false;
    }
}
