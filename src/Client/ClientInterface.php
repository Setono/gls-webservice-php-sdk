<?php

declare(strict_types=1);

namespace Setono\GLS\Webservice\Client;

use Setono\GLS\Webservice\Exception\ParcelShopNotFoundException;
use Setono\GLS\Webservice\Model\ParcelShop;

/**
 * Implements the methods here: http://www.gls.dk/webservices_v4/wsShopFinder.asmx.
 */
interface ClientInterface
{
    /**
     * Returns all ParcelShops in a given country.
     *
     * @param string $countryCode The alpha 2 country code (https://en.wikipedia.org/wiki/List_of_ISO_3166_country_codes)
     *
     * @return ParcelShop[]
     */
    public function getAllParcelShops(string $countryCode): array;

    /**
     * Get one ParcelShop.
     *
     * @throws ParcelShopNotFoundException
     */
    public function getOneParcelShop(string $parcelShopNumber): ParcelShop;

    /**
     * Get ParcelShop drop point close to an address.
     *
     * @param string $countryCode The alpha 2 country code (https://en.wikipedia.org/wiki/List_of_ISO_3166_country_codes)
     *
     * @return ParcelShop[]
     */
    public function getParcelShopDropPoint(string $street, string $zipCode, string $countryCode, int $amount): array;

    /**
     * Returns all ParcelShops in a zip code - or the 3 nearest in other zip codes.
     *
     * @param string $countryCode The alpha 2 country code (https://en.wikipedia.org/wiki/List_of_ISO_3166_country_codes)
     *
     * @return ParcelShop[]
     */
    public function getParcelShopsInZipCode(string $zipCode, string $countryCode): array;

    /**
     * Search for nearest ParcelShops to an address.
     *
     * NOTICE: It looks like (judging by the returned results) this returns the same results as getParcelShopDropPoint
     * but GLS' IT support does not know, so the safest bet is to use this method because this is the one they recommend
     *
     * @return ParcelShop[]
     */
    public function searchNearestParcelShops(string $street, string $zipCode, string $countryCode, int $amount): array;
}
