<?php

namespace MailPoetVendor\Sabberworm\CSS\Comment;

use MailPoetVendor\Sabberworm\CSS\Renderable;
class Comment implements \MailPoetVendor\Sabberworm\CSS\Renderable
{
    protected $iLineNo;
    protected $sComment;
    public function __construct($sComment = '', $iLineNo = 0)
    {
        $this->sComment = $sComment;
        $this->iLineNo = $iLineNo;
    }
    /**
     * @return string
     */
    public function getComment()
    {
        return $this->sComment;
    }
    /**
     * @return int
     */
    public function getLineNo()
    {
        return $this->iLineNo;
    }
    /**
     * @return string
     */
    public function setComment($sComment)
    {
        $this->sComment = $sComment;
    }
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render(new \MailPoetVendor\Sabberworm\CSS\OutputFormat());
    }
    /**
     * @return string
     */
    public function render(\MailPoetVendor\Sabberworm\CSS\OutputFormat $oOutputFormat)
    {
        return '/*' . $this->sComment . '*/';
    }
}
