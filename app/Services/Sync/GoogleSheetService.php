<?php

namespace App\Services\Sync;

use Google\Client;
use Google\Service\Sheets;
use Illuminate\Support\Facades\Cache;

class GoogleSheetService
{
    private Client $client;
    private Sheets $service;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setApplicationName('MCOP Quest');
        $this->client->setScopes([Sheets::SPREADSHEETS_READONLY]);
        $this->client->setAuthConfig(storage_path('app/google-credentials.json'));
        $this->client->setAccessType('offline');

        $this->service = new Sheets($this->client);
    }

    public function getSheetData(string $spreadsheetId, string $range): ?array
    {
        // Cache Key based on Sheet ID and Range (1 minute cache)
        $cacheKey = "sheet_{$spreadsheetId}_{$range}";

        return Cache::remember($cacheKey, 60, function () use ($spreadsheetId, $range) {
            try {
                $response = $this->service->spreadsheets_values->get($spreadsheetId, $range);
                return $response->getValues();
            } catch (\Exception $e) {
                // Log error
                logger()->error("Google Sheet Sync Error: " . $e->getMessage());
                return null;
            }
        });
    }
}
