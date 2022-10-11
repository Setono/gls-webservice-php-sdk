<?php

declare(strict_types=1);

namespace Setono\GLS\Webservice\Exception;

use SoapFault;

final class ConnectionException extends SoapException
{
    public function __construct(SoapFault $soapFault)
    {
        parent::__construct($soapFault, sprintf('Could not connect to host. See %s::getSoapFault() for details', self::class));
    }
}
