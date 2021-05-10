<?php

namespace MailPoetVendor\Sabberworm\CSS\Parsing;

/**
* Thrown if the CSS parsers attempts to print something invalid
*/
class OutputException extends \MailPoetVendor\Sabberworm\CSS\Parsing\SourceException
{
    public function __construct($sMessage, $iLineNo = 0)
    {
        parent::__construct($sMessage, $iLineNo);
    }
}
