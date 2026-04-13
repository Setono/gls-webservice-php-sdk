<?php

declare(strict_types=1);

namespace Setono\GLS\Webservice\Response;

use PHPUnit\Framework\TestCase;
use stdClass;

final class ResponseTest extends TestCase
{
    /**
     * @test
     */
    public function it_parses_200_response(): void
    {
        $result = new stdClass();
        $response = new Response("HTTP/1.1 200 OK\r\n", '', $result);

        self::assertSame(200, $response->getStatusCode());
        self::assertTrue($response->isOk());
        self::assertFalse($response->is404());
        self::assertSame($result, $response->getResult());
    }

    /**
     * @test
     */
    public function it_parses_404_response(): void
    {
        $response = new Response("HTTP/1.1 404 Not Found\r\n", '', null);

        self::assertSame(404, $response->getStatusCode());
        self::assertFalse($response->isOk());
        self::assertTrue($response->is404());
        self::assertNull($response->getResult());
    }

    /**
     * @test
     */
    public function it_parses_500_response(): void
    {
        $response = new Response("HTTP/1.1 500 Internal Server Error\r\n", '', null);

        self::assertSame(500, $response->getStatusCode());
        self::assertFalse($response->isOk());
        self::assertFalse($response->is404());
    }
}
