<?php

declare(strict_types=1);

namespace Setono\GLS\Webservice\Exception;

use PHPUnit\Framework\TestCase;
use Setono\GLS\Webservice\Response\Response;
use SoapFault;

final class ExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function soap_exception_implements_exception_interface(): void
    {
        $soapFault = new SoapFault('Server', 'Test error');
        $exception = new SoapException($soapFault, 'Test error');

        self::assertInstanceOf(ExceptionInterface::class, $exception);
        self::assertSame('Test error', $exception->getMessage());
        self::assertSame($soapFault, $exception->getSoapFault());
    }

    /**
     * @test
     */
    public function connection_exception_implements_exception_interface(): void
    {
        $soapFault = new SoapFault('HTTP', 'Could not connect to host');
        $exception = new ConnectionException($soapFault);

        self::assertInstanceOf(ExceptionInterface::class, $exception);
        self::assertInstanceOf(SoapException::class, $exception);
        self::assertSame($soapFault, $exception->getSoapFault());
    }

    /**
     * @test
     */
    public function client_exception_implements_exception_interface(): void
    {
        $soapFault = new SoapFault('Server', 'Server error');
        $response = new Response("HTTP/1.1 500 Internal Server Error\r\n", '', null);
        $exception = new ClientException($soapFault, $response);

        self::assertInstanceOf(ExceptionInterface::class, $exception);
        self::assertInstanceOf(SoapException::class, $exception);
        self::assertSame($response, $exception->getResponse());
        self::assertSame($soapFault, $exception->getSoapFault());
    }

    /**
     * @test
     */
    public function parcel_shop_not_found_exception_implements_exception_interface(): void
    {
        $exception = new ParcelShopNotFoundException('12345');

        self::assertInstanceOf(ExceptionInterface::class, $exception);
        self::assertStringContainsString('12345', $exception->getMessage());
    }

    /**
     * @test
     */
    public function no_result_exception_implements_exception_interface(): void
    {
        $response = new Response("HTTP/1.1 200 OK\r\n", '', null);
        $exception = new NoResultException($response, 'No data');

        self::assertInstanceOf(ExceptionInterface::class, $exception);
        self::assertSame('No data', $exception->getMessage());
        self::assertSame($response, $exception->getResponse());
    }
}
