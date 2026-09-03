# Pola Integrasi Sistem Eksternal

Setiap sistem eksternal (SSO, LDAP, API pihak ketiga, sistem HR, dll.)
wajib dibuat satu file class sendiri di direktori ini.

## Aturan Umum

1. Satu file per sistem eksternal: `{NamaSistem}.php`
2. Namespace: `App\Infrastructure\External`
3. Constructor setup Guzzle Client dengan `base_uri` dari `config` (jangan hardcode)
4. Semua HTTP call lewat `makeRequest()`, jangan panggil Guzzle langsung
5. Exception handling konsisten lewat `handleException()`
6. Token caching pakai `Cache::remember` jika sistem butuh autentikasi

## Template Class

```php
<?php

namespace App\Infrastructure\External;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Facades\Cache;
use App\Exceptions\ApiRequestException;

class NamaSistemEksternal
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('services.nama_sistem.url'),
            'timeout' => 5.0,
        ]);
    }

    private function handleException(\Exception $e, string $errorType): never
    {
        $result = [];
        if ($e instanceof ClientException || $e instanceof ServerException) {
            $response = $e->getResponse();
            $result = json_decode($response->getBody()->getContents(), true) ?? [];
        }
        $message = $result['message'] ?? $e->getMessage();
        throw new ApiRequestException("{$errorType}: {$message}", $e->getCode());
    }

    private function makeRequest(string $method, string $uri, array $options = []): array
    {
        try {
            $response = $this->client->{$method}($uri, $options);
            return json_decode($response->getBody()->getContents(), true) ?? [];
        } catch (ClientException $e) {
            $this->handleException($e, ClientException::class);
        } catch (ServerException $e) {
            $this->handleException($e, ServerException::class);
        } catch (\Exception $e) {
            throw new ApiRequestException('Unexpected error: ' . $e->getMessage(), 500);
        }
    }

    protected function getToken(): string
    {
        return Cache::remember('token_nama_sistem', 3500, function () {
            $result = $this->makeRequest('POST', '/oauth/token', [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => config('services.nama_sistem.client_id'),
                    'client_secret' => config('services.nama_sistem.client_secret'),
                ],
            ]);
            return $result['access_token'];
        });
    }

    // --- Method publik spesifik sesuai kebutuhan bisnis ---

    public function syncData(array $payload): array
    {
        return $this->makeRequest('POST', '/api/sync', [
            'headers' => ['Authorization' => 'Bearer ' . $this->getToken()],
            'json' => $payload,
        ]);
    }

    public function getStatus(string $id): array
    {
        return $this->makeRequest('GET', "/api/status/{$id}");
    }
}
```

## Catatan

- `ApiRequestException` harus didefinisikan terpisah (misal di `app/Exceptions/`)
- Konfigurasi tiap sistem didefinisikan di `config/services.php`
- Untuk sistem tanpa autentikasi token, method `getToken()` bisa dihapus
- Timeout default 5 detik — bisa disesuaikan per sistem jika perlu
