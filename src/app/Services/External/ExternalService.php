<?php

namespace App\Services\External;

use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExternalService
{
    private const BASE_URL = 'https://httpbin.org';

    public function notifyProductCreated(Product $product): void {

        $notifyCreateURL = self::BASE_URL . '/post'; //the created notification endpoint goes here
        $response        = Http::withToken('someTokenHere')->post($notifyCreateURL, $product->toArray());
        if (!$response->successful()) {
            Log::warning('Product creation notification failed. Payload was: '.json_encode($product->toArray()));
        } else {
            Log::info('Product creation notification success. Payload was: ' . json_encode($product->toArray()));
        }
    }

    public function notifyProductUpdated(Product $product): void {
        $notifyUpdateURL = self::BASE_URL .  '/post'; //the update notification endpoint goes here
        $response = Http::withToken('someTokenHere')->post($notifyUpdateURL, $product->toArray());
        if (!$response->successful()) {
            Log::warning('Product update notification failed. Payload was: '.json_encode($product->toArray()));
        } else {
            Log::info('Product update notification success. Payload was: ' . json_encode($product->toArray()));
        }
    }
}
