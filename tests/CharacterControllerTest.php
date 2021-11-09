<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use function PHPUnit\Framework\assertTrue;

class CharacterControllerTest extends WebTestCase
{
    private $client;
    private $content;
    private static $identifier;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function defineIdentifier()
    {
        self::$identifier = $this->content['identifier'];
    }

    public function assertIdentifier()
    {
        $this->assertArrayHasKey('identifier', $this->content);
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

        $this->assertJsonResponse();
    }

    /**
     * Tests create
     */
    public function testCreate()
    {
        $this->client->request('POST', '/character/create');

        $this->assertJsonResponse();
        $this->defineIdentifier();
        $this->assertIdentifier();
    }

    /**
     * Tests display
     */
    public function testDisplay(): void
    {
        $this->client->request('GET', '/character/display/' . self::$identifier);

        $this->assertJsonResponse();
    }

    /**
     * Asserts that a response is in JSON
     * @param $response
     */
    public function assertJsonResponse(): void
    {
        $response = $this->client->getResponse();
        $this->content = json_decode($response->getContent(), true, 50);
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
        $this->client->request('GET', '/character/display/' . self::$identifier);

        $this->assertError404();
    }

    /**
     * Tests modify
     */
    public function testModify()
    {
        $this->client->request('PUT', 'character/modify/' . self::$identifier);

        $this->assertJsonResponse();
    }

    /**
     * Tests modify
     */
    public function testDelete()
    {
        $this->client->request('DELETE', 'character/delete/' . self::$identifier);

        $this->assertJsonResponse();
    }

    /**
     * Tests images
     */
    public function testImages()
    {
        //tests without kind
        $this->client->request('GET', 'character/images/3');
        $this->assertJsonResponse();

        //tests with kind
        $this->client->request('GET', 'character/images/dames/3');
        $this->assertJsonResponse();
    }
}
