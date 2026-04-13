<?php

declare(strict_types=1);

namespace Setono\GLS\Webservice\Model;

use PHPUnit\Framework\TestCase;
use stdClass;

final class OpeningHoursTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates_from_std_class(): void
    {
        $data = new stdClass();
        $data->day = 'Monday';
        $data->openAt = new stdClass();
        $data->openAt->From = '08:00';
        $data->openAt->To = '20:00';

        $openingHours = OpeningHours::createFromStdClass($data);

        self::assertSame('Monday', $openingHours->getDay());
        self::assertSame('08:00', $openingHours->getOpenFrom());
        self::assertSame('20:00', $openingHours->getOpenTo());
    }

    /**
     * @test
     */
    public function it_returns_values_from_constructor(): void
    {
        $openingHours = new OpeningHours('Tuesday', '09:00', '17:00');

        self::assertSame('Tuesday', $openingHours->getDay());
        self::assertSame('09:00', $openingHours->getOpenFrom());
        self::assertSame('17:00', $openingHours->getOpenTo());
    }
}
