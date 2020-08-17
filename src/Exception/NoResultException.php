<?php

declare(strict_types=1);

namespace Setono\GLS\Webservice\Exception;

use RuntimeException;
use Setono\GLS\Webservice\Response\Response;

final class NoResultException extends RuntimeException
{
    /** @var Response */
    private $response;

    public function __construct(Response $response, string $message = 'The response result was empty')
    {
        $this->response = $response;

        parent::__construct($message);
    }

    public function getResponse(): Response
    {
        return $this->response;
    }
}
