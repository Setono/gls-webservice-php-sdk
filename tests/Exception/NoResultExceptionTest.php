<?php

declare(strict_types=1);

namespace Setono\GLS\Webservice\Exception;

use PHPUnit\Framework\TestCase;
use Setono\GLS\Webservice\Response\Response;

final class NoResultExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function it_implements_exception_interface(): void
    {
        $response = new Response("HTTP/1.1 200 OK\r\n", '', null);
        $exception = new NoResultException($response);

        self::assertInstanceOf(ExceptionInterface::class, $exception);
    }
}
