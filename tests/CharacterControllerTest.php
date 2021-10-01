<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use function PHPUnit\Framework\assertTrue;

class CharacterControllerTest extends WebTestCase
{
    /**
     * Tests index
     */
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/character');

        $this->assertJsonResponse($client->getResponse());
    }

    /**
     * Tests display
     */
    public function testDisplay(): void
    {
        $client = static::createClient();
        $client->request('GET', '/character/display/34057e7ac1089cf22a73d5c2b8a4d176c9463725');

        $this->assertJsonResponse($client->getResponse());
    }

    /**
     * Asserts that a response is in JSON
     * @param $response
     */
    public function assertJsonResponse($response): void
    {
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    }
}
