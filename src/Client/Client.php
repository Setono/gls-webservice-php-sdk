<?php

declare(strict_types=1);

namespace Setono\GLS\Webservice\Client;

use Setono\GLS\Webservice\Exception\ClientException;
use Setono\GLS\Webservice\Exception\ConnectionException;
use Setono\GLS\Webservice\Exception\ExceptionInterface;
use Setono\GLS\Webservice\Exception\NoResultException;
use Setono\GLS\Webservice\Exception\ParcelShopNotFoundException;
use Setono\GLS\Webservice\Exception\SoapException;
use Setono\GLS\Webservice\Factory\SoapClientFactoryInterface;
use Setono\GLS\Webservice\Model\ParcelShop;
use Setono\GLS\Webservice\Response\Response;
use SoapClient;
use SoapFault;
use stdClass;

final class Client implements ClientInterface
{
    private ?SoapClient $soapClient = null;

    private SoapClientFactoryInterface $soapClientFactory;

    public function __construct(SoapClientFactoryInterface $soapClientFactory)
    {
        $this->soapClientFactory = $soapClientFactory;
    }

    public function getAllParcelShops(string $countryCode): array
    {
        try {
            $response = $this->sendRequest('GetAllParcelShops', [
                'countryIso3166A2' => $countryCode,
            ]);

            $result = $response->getResult();
            if (null === $result) {
                throw new NoResultException($response, sprintf('There was no result for the country code %s', $countryCode));
            }

            if (!isset($result->GetAllParcelShopsResult->PakkeshopData)) {
                throw new NoResultException($response, sprintf('There was no result for the country code %s', $countryCode));
            }

            return self::mapParcelShops($result->GetAllParcelShopsResult->PakkeshopData);
        } catch (ClientException $e) {
            return [];
        }
    }

    public function getOneParcelShop(string $parcelShopNumber): ParcelShop
    {
        try {
            $response = $this->sendRequest('GetOneParcelShop', ['ParcelShopNumber' => $parcelShopNumber]);
            $result = $response->getResult();

            if (null === $result || !isset($result->GetOneParcelShopResult)) {
                throw new ParcelShopNotFoundException($parcelShopNumber);
            }

            $shopData = $result->GetOneParcelShopResult;
            if (!$shopData instanceof stdClass) {
                throw new ParcelShopNotFoundException($parcelShopNumber);
            }

            return ParcelShop::createFromStdClass($shopData);
        } catch (ClientException $e) {
            if ($e->getResponse()->is404() || $e->getResponse()->getResult() === null) {
                throw new ParcelShopNotFoundException($parcelShopNumber);
            }

            throw $e;
        }
    }

    public function getParcelShopDropPoint(string $street, string $zipCode, string $countryCode, int $amount): array
    {
        try {
            $response = $this->sendRequest('GetParcelShopDropPoint', [
                'street' => $street,
                'zipcode' => $zipCode,
                'countryIso3166A2' => $countryCode,
                'Amount' => $amount,
            ]);

            $result = $response->getResult();
            if (null === $result || !isset($result->GetParcelShopDropPointResult->parcelshops->PakkeshopData)) {
                return [];
            }

            return self::mapParcelShops($result->GetParcelShopDropPointResult->parcelshops->PakkeshopData);
        } catch (ClientException $e) {
            return [];
        }
    }

    public function getParcelShopsInZipCode(string $zipCode, string $countryCode): array
    {
        try {
            $response = $this->sendRequest('GetParcelShopsInZipCode', [
                'zipcode' => $zipCode,
                'countryIso3166A2' => $countryCode,
            ]);

            $result = $response->getResult();
            if (null === $result || !isset($result->GetParcelShopsInZipcodeResult->PakkeshopData)) {
                return [];
            }

            return self::mapParcelShops($result->GetParcelShopsInZipcodeResult->PakkeshopData);
        } catch (ClientException $e) {
            return [];
        }
    }

    public function searchNearestParcelShops(string $street, string $zipCode, string $countryCode, int $amount = 10): array
    {
        try {
            $response = $this->sendRequest('SearchNearestParcelShops', [
                'street' => $street,
                'zipcode' => $zipCode,
                'countryIso3166A2' => $countryCode,
                'Amount' => $amount,
            ]);

            $result = $response->getResult();
            if (null === $result || !isset($result->SearchNearestParcelShopsResult->parcelshops->PakkeshopData)) {
                return [];
            }

            return self::mapParcelShops($result->SearchNearestParcelShopsResult->parcelshops->PakkeshopData);
        } catch (ClientException $e) {
            return [];
        }
    }

    /**
     * @param array<array-key, stdClass>|stdClass $data
     *
     * @return list<ParcelShop>
     */
    private static function mapParcelShops(array|stdClass $data): array
    {
        if ($data instanceof stdClass) {
            return [ParcelShop::createFromStdClass($data)];
        }

        $parcelShops = [];
        foreach ($data as $item) {
            if ($item instanceof stdClass) {
                $parcelShops[] = ParcelShop::createFromStdClass($item);
            }
        }

        return $parcelShops;
    }

    /**
     * @param array<string, mixed> $arguments
     */
    private function sendRequest(string $method, array $arguments = []): Response
    {
        $soapClient = $this->getSoapClient();

        try {
            /** @var stdClass|null $result */
            $result = $soapClient->{$method}($arguments);

            return new Response(
                (string) $soapClient->__getLastResponseHeaders(),
                (string) $soapClient->__getLastResponse(),
                $result instanceof stdClass ? $result : null,
            );
        } catch (SoapFault $soapFault) {
            throw $this->parseException($soapFault);
        }
    }

    private function parseException(SoapFault $soapFault): ExceptionInterface
    {
        $message = $soapFault->getMessage();

        if ('Could not connect to host' === $message) {
            return new ConnectionException($soapFault);
        }

        $soapClient = $this->getSoapClient();
        $responseHeaders = $soapClient->__getLastResponseHeaders();

        if (is_string($responseHeaders)) {
            return new ClientException(
                $soapFault,
                new Response($responseHeaders, (string) $soapClient->__getLastResponse(), null),
            );
        }

        return new SoapException($soapFault, $soapFault->getMessage());
    }

    private function getSoapClient(): SoapClient
    {
        if (null === $this->soapClient) {
            $this->soapClient = $this->soapClientFactory->create();
        }

        return $this->soapClient;
    }
}
