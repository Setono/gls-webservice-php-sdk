<?php

declare(strict_types=1);

namespace Setono\GLS\Webservice\Exception;

use RuntimeException;
use SoapFault;

class SoapException extends RuntimeException implements ExceptionInterface
{
    private SoapFault $soapFault;

    public function __construct(SoapFault $soapFault, string $message)
    {
        parent::__construct($message);

        $this->soapFault = $soapFault;
    }

    public function getSoapFault(): SoapFault
    {
        return $this->soapFault;
    }
}
