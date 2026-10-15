<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class BaseService
{
    protected function post(string $endpoint, array $payload = [], string $service = 'default')
    {
        return $this->request('POST', $endpoint, $payload, $service);
    }

    protected function get(string $endpoint, array $query = [], string $service = 'default')
    {
        return $this->request('GET', $endpoint, $query, $service);
    }

    protected function put(string $endpoint, array $payload = [], string $service = 'default')
    {
        return $this->request('PUT', $endpoint, $payload, $service);
    }

    protected function patch(string $endpoint, array $payload = [], string $service = 'default')
    {
        return $this->request('PATCH', $endpoint, $payload, $service);
    }

    protected function delete(string $endpoint, array $payload = [], string $service = 'default')
    {
        return $this->request('DELETE', $endpoint, $payload, $service);
    }

    private function request(string $method, string $endpoint, array $data, string $service)
    {
        try {
            $baseUrl = $this->getBaseUrl($service);

            $http = Http::timeout(30)
                ->withHeaders($this->getHeaders());

            $response = match ($method) {
                'GET' => $http->get($baseUrl . $endpoint, $data),
                'POST' => $http->post($baseUrl . $endpoint, $data),
                'PUT' => $http->put($baseUrl . $endpoint, $data),
                'PATCH' => $http->patch($baseUrl . $endpoint, $data),
                'DELETE' => $http->delete($baseUrl . $endpoint, $data),
                default => throw new Exception("Invalid HTTP method"),
            };

            Log::info('API Request', [
                'method' => $method,
                'url' => $baseUrl . $endpoint,
                'payload' => $data,
                'response' => $response->json()
            ]);

            if ($response->failed()) {
                throw new Exception($response->body());
            }

            return $response->json();

        } catch (Exception $e) {
            $baseUrl = $this->getBaseUrl($service);

            Log::error('BaseService error', [
                'method' => $method,
                'endpoint' => $endpoint,
                'message' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    protected function getBaseUrl(string $service): string
    {
        return match ($service) {
            'core_service' => config('services.third_party.core_service_url'),
            'payment_service' => config('services.third_party.payment_service_url'),
            default => config('app.url'),

        };
    }

    protected function getHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }
}
