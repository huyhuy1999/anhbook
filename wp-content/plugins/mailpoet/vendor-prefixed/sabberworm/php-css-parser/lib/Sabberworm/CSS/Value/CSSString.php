<?php

namespace MailPoetVendor\Sabberworm\CSS\Value;

class CSSString extends \MailPoetVendor\Sabberworm\CSS\Value\PrimitiveValue
{
    private $sString;
    public function __construct($sString, $iLineNo = 0)
    {
        $this->sString = $sString;
        parent::__construct($iLineNo);
    }
    public function setString($sString)
    {
        $this->sString = $sString;
    }
    public function getString()
    {
        return $this->sString;
    }
    public function __toString()
    {
        return $this->render(new \MailPoetVendor\Sabberworm\CSS\OutputFormat());
    }
    public function render(\MailPoetVendor\Sabberworm\CSS\OutputFormat $oOutputFormat)
    {
        $sString = \addslashes($this->sString);
        $sString = \str_replace("\n", '\\A', $sString);
        return $oOutputFormat->getStringQuotingType() . $sString . $oOutputFormat->getStringQuotingType();
    }
}
