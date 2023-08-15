<?php

namespace App\Http\Controllers;

use App\Common\ServiceDiscovery;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class Hbv2Controller extends Controller
{
    public function processRequest(Request $request, $serviceName, $serviceEndpoint)
    {

        if (empty(ServiceDiscovery::get($serviceName))) {
            return response()->json(['message' => "Service not found."], 404);
        }

        $serviceUrl = ServiceDiscovery::get($serviceName);
        $url = $serviceUrl . "/api/" . $serviceEndpoint;

        $client = new Client();

        try {
            $method = $request->method();
            $headers = $request->header();
            $queryParams = $request->query();
            $body = $request->getContent();

            $response = $client->request($method, $url, [
                'headers' => $headers,
                'query' => $queryParams,
                'body' => $body,
            ]);

            $statusCode = $response->getStatusCode();
            $responseHeaders = $response->getHeaders();
            $responseBody = $response->getBody()->getContents();

            return response($responseBody, $statusCode);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to proxy request', 'message' => $e->getMessage()], 500);
        }
    }
}

