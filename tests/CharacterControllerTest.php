<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use function PHPUnit\Framework\assertTrue;

class CharacterControllerTest extends WebTestCase
{
    /**
     * Tests index redirection
     */
    public function testRedirectIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/character');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    /**
     * Tests index
     */
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/character/index');

        $this->assertJsonResponse($client->getResponse());
    }

    /**
     * Tests display
     */
    public function testDisplay(): void
    {
        $client = static::createClient();
        $client->request('GET', '/character/display/661858914ca042c04da73931d1ab7ebf0857b233');

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
