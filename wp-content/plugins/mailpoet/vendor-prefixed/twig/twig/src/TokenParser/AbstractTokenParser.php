<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MailPoetVendor\Twig\TokenParser;

use MailPoetVendor\Twig\Parser;
/**
 * Base class for all token parsers.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
abstract class AbstractTokenParser implements \MailPoetVendor\Twig\TokenParser\TokenParserInterface
{
    protected $parser;
    public function setParser(\MailPoetVendor\Twig\Parser $parser)
    {
        $this->parser = $parser;
    }
}
\class_alias('MailPoetVendor\\Twig\\TokenParser\\AbstractTokenParser', 'MailPoetVendor\\Twig_TokenParser');
