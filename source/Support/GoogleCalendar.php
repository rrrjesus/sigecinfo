<?php

namespace Source\Support;

use Google\Client as GoogleClient;
use Google\Service\Calendar as GoogleCalendarService;
use Google_Service_Calendar_Event;
use Source\Domain\Shared\Models\GoogleToken;

class GoogleCalendar
{
    private GoogleClient $client;

    public function __construct()
    {
        $this->client = new GoogleClient();
        $this->client->setAuthConfig(CONF_PROJECT_ROOT . "/client_secret.json");
        $this->client->setRedirectUri(url("/auth/google/callback"));
        $this->client->addScope(GoogleCalendarService::CALENDAR);
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');
    }

    public function getClient(): GoogleClient
    {
        return $this->client;
    }

    public function getAuthUrl(): string
    {
        return $this->client->createAuthUrl();
    }

    public function fetchAccessTokenWithAuthCode(string $authCode): array
    {
        return $this->client->fetchAccessTokenWithAuthCode($authCode);
    }

    public function setAccessToken(array $token)
    {
        $this->client->setAccessToken($token);
    }

    public function createEvent(string $calendarId, array $eventData): Google_Service_Calendar_Event
    {
        $service = new GoogleCalendarService($this->client);
        $event = new Google_Service_Calendar_Event($eventData);
        return $service->events->insert($calendarId, $event);
    }

    public function isTokenExpired(): bool
    {
        return $this->client->isAccessTokenExpired();
    }

    public function fetchAccessTokenWithRefreshToken(string $refreshToken)
    {
        return $this->client->fetchAccessTokenWithRefreshToken($refreshToken);
    }
}
