<?php

declare(strict_types=1);

namespace Setono\GLS\Webservice\Exception;

use Setono\GLS\Webservice\Response\Response;
use SoapFault;

final class ClientException extends SoapException
{
    /** @var Response */
    private $response;

    public function __construct(SoapFault $soapFault, Response $response)
    {
        parent::__construct($soapFault, $soapFault->getMessage());
        $this->response = $response;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }
}
