<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use function PHPUnit\Framework\assertTrue;

class CharacterControllerTest extends WebTestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * Tests index redirection
     */
    public function testRedirectIndex(): void
    {
        $this->client->request('GET', '/character');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Tests index
     */
    public function testIndex(): void
    {
        $this->client->request('GET', '/character/index');

        $this->assertJsonResponse($this->client->getResponse());
    }

    /**
     * Tests display
     */
    public function testDisplay(): void
    {
        $this->client->request('GET', '/character/display/661858914ca042c04da73931d1ab7ebf0857b233');

        $this->assertJsonResponse($this->client->getResponse());
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

    /**
     * Tests a bad identifier
     */
    public function testBadIdentifier()
    {
        $this->client->request('GET', '/character/display/badIdentifier');

        $this->assertError404();
    }

    /**
     * Asserts that Response returns 404
     */
    public function assertError404()
    {
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Tests if an identifier is inexisting
     */
    public function testInexistingIdentifier()
    {
        $this->client->request('GET', '/character/display/661858914ca042c04da73931d1ab7ebf085error');

        $this->assertError404();
    }
}
