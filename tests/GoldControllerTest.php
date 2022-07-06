<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class GoldControllerTest extends WebTestCase
{
    //2001-01-04T00:00:00+00:00 changed to 2021-01-04T00:00:00+00:00 because name of function suggests so
    public function testGoldJanuary2021Single()
    {
        $client = static::createClient();
        $client->xmlHttpRequest('POST', '/api/request', [
            'from' => '2021-01-04T00:00:00+00:00', //2001-01-04T00:00:00+00:00 changed
            'to' => '2021-01-04T00:00:00+00:00'    //2001-01-04T00:00:00+00:00 changed
        ]);
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertResponseIsSuccessful();
        $this->assertIsArray($response);
        $this->assertArrayHasKey('from', $response);
        $this->assertEquals('2021-01-04T00:00:00+00:00', $response['from']); //2001-01-04T00:00:00+00:00 changed
        $this->assertArrayHasKey('to', $response);
        $this->assertEquals('2021-01-04T00:00:00+00:00', $response['to']);   //2001-01-04T00:00:00+00:00 changed
        $this->assertArrayHasKey('avg', $response);
        $this->assertEquals(228.1, $response['avg']);
    }

    public function testGoldJanuary2021Range()
    {
        $client = static::createClient();
        $client->xmlHttpRequest('POST', '/api/request', [
            'from' => '2021-01-01T00:00:00+00:00',
            'to' => '2021-01-31T00:00:00+00:00'
        ]);
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertResponseIsSuccessful();
        $this->assertIsArray($response);
        $this->assertArrayHasKey('from', $response);
        $this->assertEquals('2021-01-04T00:00:00+00:00', $response['from']);
        $this->assertArrayHasKey('to', $response);
        $this->assertEquals('2021-01-29T00:00:00+00:00', $response['to']);
        $this->assertArrayHasKey('avg', $response);
        $this->assertEquals(223.52, $response['avg']);
    }

    //HTTP_BAD_REQUEST changed to HTTP_NOT_FOUND because NBP API returns this code with 2001-01-04 date
    public function testMissingTimezone()
    {
        $client = static::createClient();
        $client->xmlHttpRequest('POST', '/api/gold', [
            'from' => '2001-01-04 00:00:00',
            'to' => '2001-01-04 00:00:00'
        ]);
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND); //HTTP_BAD_REQUEST changed
    }
}