<?php

declare(strict_types=1);

namespace Setono\GLS\Webservice\Client;

use Setono\GLS\Webservice\Exception\ParcelShopNotFoundException;
use Setono\GLS\Webservice\Model\ParcelShop;
use Setono\GLS\Webservice\Response\Response;
use SoapClient;
use SoapFault;

final class Client implements ClientInterface
{
    /**
     * @var SoapClient
     */
    private $soapClient;

    public function __construct(SoapClient $soapClient)
    {
        $this->soapClient = $soapClient;
    }

    public function getAllParcelShops(string $countryCode): array
    {
        $response = $this->sendRequest('GetAllParcelShops', [
            'countryIso3166A2' => $countryCode,
        ]);

        $parcelShops = [];

        if (200 !== $response->getStatusCode()) {
            return $parcelShops;
        }

        if (null === $response->getResult()) {
            return $parcelShops;
        }

        foreach ($response->getResult()->GetAllParcelShopsResult->PakkeshopData as $parcelShop) {
            $parcelShops[] = ParcelShop::createFromStdClass($parcelShop);
        }

        return $parcelShops;
    }

    public function getOneParcelShop(string $parcelShopNumber): ParcelShop
    {
        $response = $this->sendRequest('GetOneParcelShop', ['ParcelShopNumber' => $parcelShopNumber]);
        if (200 !== $response->getStatusCode()) {
            throw new ParcelShopNotFoundException($parcelShopNumber);
        }

        if (null === $response->getResult()) {
            throw new ParcelShopNotFoundException($parcelShopNumber);
        }

        return ParcelShop::createFromStdClass($response->getResult()->GetOneParcelShopResult);
    }

    public function getParcelShopDropPoint(string $street, string $zipCode, string $countryCode, int $amount): array
    {
        $response = $this->sendRequest('GetParcelShopDropPoint', [
            'street' => $street,
            'zipcode' => $zipCode,
            'countryIso3166A2' => $countryCode,
            'Amount' => $amount,
        ]);

        $parcelShops = [];

        if (200 !== $response->getStatusCode()) {
            return $parcelShops;
        }

        if (null === $response->getResult()) {
            return $parcelShops;
        }

        foreach ($response->getResult()->GetParcelShopDropPointResult->parcelshops->PakkeshopData as $parcelShop) {
            $parcelShops[] = ParcelShop::createFromStdClass($parcelShop);
        }

        return $parcelShops;
    }

    public function getParcelShopsInZipCode(string $zipCode, string $countryCode): array
    {
        $response = $this->sendRequest('GetParcelShopsInZipCode', [
            'zipcode' => $zipCode,
            'countryIso3166A2' => $countryCode,
        ]);

        $parcelShops = [];

        if (200 !== $response->getStatusCode()) {
            return $parcelShops;
        }

        if (null === $response->getResult()) {
            return $parcelShops;
        }

        foreach ($response->getResult()->GetParcelShopsInZipcodeResult->PakkeshopData as $parcelShop) {
            $parcelShops[] = ParcelShop::createFromStdClass($parcelShop);
        }

        return $parcelShops;
    }

    public function searchNearestParcelShops(string $street, string $zipCode, string $countryCode, int $amount = 10): array
    {
        $response = $this->sendRequest('SearchNearestParcelShops', [
            'street' => $street,
            'zipcode' => $zipCode,
            'countryIso3166A2' => $countryCode,
            'Amount' => $amount,
        ]);

        $parcelShops = [];

        if (200 !== $response->getStatusCode()) {
            return $parcelShops;
        }

        if (null === $response->getResult()) {
            return $parcelShops;
        }

        foreach ($response->getResult()->SearchNearestParcelShopsResult->parcelshops->PakkeshopData as $parcelShop) {
            $parcelShops[] = ParcelShop::createFromStdClass($parcelShop);
        }

        return $parcelShops;
    }

    private function sendRequest(string $method, array $arguments = []): Response
    {
        $result = null;

        try {
            $result = $this->soapClient->{$method}($arguments);
        } catch (SoapFault $exception) {
        } finally {
            return new Response($this->soapClient->__getLastResponseHeaders(), $this->soapClient->__getLastResponse(), $result);
        }
    }
}
