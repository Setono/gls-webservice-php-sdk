<?php

declare(strict_types=1);

namespace Setono\GLS\Webservice\Response;

use GuzzleHttp\Psr7\Message;
use Psr\Http\Message\ResponseInterface;
use stdClass;

final class Response
{
    private ResponseInterface $response;

    private ?stdClass $result;

    public function __construct(string $headers, string $body, ?stdClass $result)
    {
        $this->response = Message::parseResponse($headers . "\r\n" . $body);
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
