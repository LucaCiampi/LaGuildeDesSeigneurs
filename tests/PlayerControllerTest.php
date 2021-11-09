<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use function PHPUnit\Framework\assertTrue;

class PlayerControllerTest extends WebTestCase
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
        $this->client->request('GET', '/player');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Tests index
     */
    public function testIndex(): void
    {
        $this->client->request('GET', '/player/index');

        $this->assertJsonResponse();
    }

    /**
     * Tests create
     */
    public function testCreate()
    {
        $this->client->request(
            'POST',
            '/player/create',
            array(), // parameters
            array(), // files
            array('CONTENT_TYPE' => 'application/json'), //server
            '{"firstname":"Dame", "lastname":"Eldalote", "email":"luca.ciampi@hotmail.fr", 
                "mirian":120}'
        );

        $this->assertJsonResponse();
        $this->defineIdentifier();
        $this->assertIdentifier();
    }

    /**
     * Tests modify
     */
    public function testModify()
    {
        // Partial
        $this->client->request(
            'PUT',
            '/player/modify/' . self::$identifier,
            array(), // parameters
            array(), // files
            array('CONTENT_TYPE' => 'application/json'), //server
            '{"firstname":"Dame", "lastname":"Eldalote"}'
        );

        $this->assertJsonResponse();
        $this->assertIdentifier();
        
        // Whole content
        $this->client->request(
            'PUT',
            '/player/modify/' . self::$identifier,
            array(), // parameters
            array(), // files
            array('CONTENT_TYPE' => 'application/json'), //server
            '{"firstname":"Dame", "lastname":"Eldalote", "email":"luca.ciampi@hotmail.fr", 
                "mirian":120}'
        );

        $this->assertJsonResponse();
        $this->assertIdentifier();
    }

    /**
     * Tests display
     */
    public function testDisplay(): void
    {
        $this->client->request('GET', '/player/display/' . self::$identifier);

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
        $this->client->request('GET', '/player/display/badIdentifier');

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
        $this->client->request('GET', '/player/display/error');

        $this->assertError404();
    }

    /**
     * Tests modify
     */
    public function testDelete()
    {
        $this->client->request('DELETE', '/player/delete/' . self::$identifier);

        $this->assertJsonResponse();
    }
}
