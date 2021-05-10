<?php

namespace MailPoetVendor\Sabberworm\CSS\Value;

class URL extends \MailPoetVendor\Sabberworm\CSS\Value\PrimitiveValue
{
    private $oURL;
    public function __construct(\MailPoetVendor\Sabberworm\CSS\Value\CSSString $oURL, $iLineNo = 0)
    {
        parent::__construct($iLineNo);
        $this->oURL = $oURL;
    }
    public function setURL(\MailPoetVendor\Sabberworm\CSS\Value\CSSString $oURL)
    {
        $this->oURL = $oURL;
    }
    public function getURL()
    {
        return $this->oURL;
    }
    public function __toString()
    {
        return $this->render(new \MailPoetVendor\Sabberworm\CSS\OutputFormat());
    }
    public function render(\MailPoetVendor\Sabberworm\CSS\OutputFormat $oOutputFormat)
    {
        return "url({$this->oURL->render($oOutputFormat)})";
    }
}
