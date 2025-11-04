<?php

namespace Source\Support;

use Google\Client as GoogleClient;
use Google\Service\Calendar as GoogleCalendarService;
use Google_Service_Calendar_Event;

class GoogleCalendar
{
    private GoogleClient $client;
    private GoogleCalendarService $service;

    public function __construct()
    {
        $this->client = new GoogleClient();
        $this->client->setAuthConfig(CONF_PROJECT_ROOT . "/config/secret/service-account.json");
        $this->client->addScope(GoogleCalendarService::CALENDAR_EVENTS);

        $this->service = new GoogleCalendarService($this->client);
    }

    public function createEvent(array $eventData): Google_Service_Calendar_Event
    {
        $event = new Google_Service_Calendar_Event($eventData);
        return $this->service->events->insert(CONF_GOOGLE_CALENDAR_ID, $event);
    }

    public function updateEvent(string $eventId, array $eventData): Google_Service_Calendar_Event
    {
        $event = new Google_Service_Calendar_Event($eventData);
        return $this->service->events->update(CONF_GOOGLE_CALENDAR_ID, $eventId, $event);
    }

    public function deleteEvent(string $eventId)
    {
        return $this->service->events->delete(CONF_GOOGLE_CALENDAR_ID, $eventId);
    }
}
