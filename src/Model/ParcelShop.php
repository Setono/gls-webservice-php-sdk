<?php

declare(strict_types=1);

namespace Setono\GLS\Webservice\Model;

use stdClass;

final class ParcelShop
{
    /** @var string */
    private $number;

    /** @var string */
    private $companyName;

    /** @var string */
    private $streetName;

    /** @var string */
    private $streetName2;

    /** @var string */
    private $zipCode;

    /** @var string */
    private $city;

    /** @var string */
    private $countryCode;

    /** @var string */
    private $telephone;

    /** @var string */
    private $longitude;

    /** @var string */
    private $latitude;

    /** @var int */
    private $distanceMetersAsTheCrowFlies;

    /** @var OpeningHours[] */
    private $openingHours;

    public function __construct(
        string $number,
        string $companyName,
        string $streetName,
        string $zipCode,
        string $city,
        string $countryCode,
        string $longitude,
        string $latitude,
        string $streetName2 = '',
        string $telephone = '',
        int $distanceMetersAsTheCrowFlies = 0,
        array $openingHours = []
    ) {
        // mandatory attributes
        $this->number = $number;
        $this->companyName = $companyName;
        $this->streetName = $streetName;
        $this->zipCode = $zipCode;
        $this->city = $city;
        $this->countryCode = $countryCode;
        $this->longitude = $longitude;
        $this->latitude = $latitude;

        // optional attributes
        $this->streetName2 = $streetName2;
        $this->telephone = $telephone;
        $this->distanceMetersAsTheCrowFlies = $distanceMetersAsTheCrowFlies;
        $this->openingHours = $openingHours;
    }

    public static function createFromStdClass(stdClass $result): self
    {
        $openingHours = [];

        if (isset($result->OpeningHours, $result->OpeningHours->Weekday) && is_array($result->OpeningHours->Weekday)) {
            foreach ($result->OpeningHours->Weekday as $weekday) {
                $openingHours[] = OpeningHours::createFromStdClass($weekday);
            }
        }

        return new self(
            $result->Number,
            $result->CompanyName,
            $result->Streetname,
            $result->ZipCode,
            $result->CityName,
            $result->CountryCodeISO3166A2,
            $result->Longitude,
            $result->Latitude,
            $result->Streetname2,
            $result->Telephone,
            $result->DistanceMetersAsTheCrowFlies,
            $openingHours
        );
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    public function getStreetName(): string
    {
        return $this->streetName;
    }

    public function getStreetName2(): string
    {
        return $this->streetName2;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function getLongitude(): string
    {
        return $this->longitude;
    }

    public function getLatitude(): string
    {
        return $this->latitude;
    }

    public function getDistanceMetersAsTheCrowFlies(): int
    {
        return $this->distanceMetersAsTheCrowFlies;
    }

    /**
     * @return OpeningHours[]
     */
    public function getOpeningHours(): array
    {
        return $this->openingHours;
    }
}
