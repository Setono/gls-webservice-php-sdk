<?php

declare(strict_types=1);

namespace Setono\GLS\Webservice\Response;

use function GuzzleHttp\Psr7\parse_response;
use GuzzleHttp\Psr7\Response as PsrResponse;
use stdClass;

final class Response
{
    /** @var PsrResponse */
    private $response;

    /** @var stdClass|null */
    private $result;

    public function __construct(string $headers, string $body, ?stdClass $result)
    {
        $this->response = parse_response($headers . "\r\n" . $body);
        $this->result = $result;
    }

    public function getStatusCode(): int
    {
        return $this->response->getStatusCode();
    }

    public function getResult(): ?stdClass
    {
        return $this->result;
    }

    public function isOk(): bool
    {
        return $this->getStatusCode() === 200;
    }

    public function is404(): bool
    {
        return $this->getStatusCode() === 404;
    }
}
