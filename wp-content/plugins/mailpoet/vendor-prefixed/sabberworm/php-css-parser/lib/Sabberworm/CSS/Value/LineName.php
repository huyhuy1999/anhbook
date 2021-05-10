<?php

namespace MailPoetVendor\Sabberworm\CSS\Value;

class LineName extends \MailPoetVendor\Sabberworm\CSS\Value\ValueList
{
    public function __construct($aComponents = array(), $iLineNo = 0)
    {
        parent::__construct($aComponents, ' ', $iLineNo);
    }
    public function __toString()
    {
        return $this->render(new \MailPoetVendor\Sabberworm\CSS\OutputFormat());
    }
    public function render(\MailPoetVendor\Sabberworm\CSS\OutputFormat $oOutputFormat)
    {
        return '[' . parent::render(\MailPoetVendor\Sabberworm\CSS\OutputFormat::createCompact()) . ']';
    }
}
