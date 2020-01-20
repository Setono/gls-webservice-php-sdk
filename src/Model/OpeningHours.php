<?php

declare(strict_types=1);

namespace Setono\GLS\Webservice\Model;

use stdClass;

final class OpeningHours
{
    /** @var string */
    private $day;

    /** @var string */
    private $openFrom;

    /** @var string */
    private $openTo;

    public function __construct(string $day, string $openFrom, string $openTo)
    {
        $this->day = $day;
        $this->openFrom = $openFrom;
        $this->openTo = $openTo;
    }

    public static function createFromStdClass(stdClass $result): self
    {
        return new self(
            $result->day,
            $result->openAt->From,
            $result->openAt->To
        );
    }

    public function getDay(): string
    {
        return $this->day;
    }

    public function getOpenFrom(): string
    {
        return $this->openFrom;
    }

    public function getOpenTo(): string
    {
        return $this->openTo;
    }
}
