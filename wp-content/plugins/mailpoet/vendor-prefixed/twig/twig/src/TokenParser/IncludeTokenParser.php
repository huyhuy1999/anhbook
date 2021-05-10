<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 * (c) Armin Ronacher
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MailPoetVendor\Twig\TokenParser;

use MailPoetVendor\Twig\Node\IncludeNode;
use MailPoetVendor\Twig\Token;
/**
 * Includes a template.
 *
 *   {% include 'header.html' %}
 *     Body
 *   {% include 'footer.html' %}
 */
class IncludeTokenParser extends \MailPoetVendor\Twig\TokenParser\AbstractTokenParser
{
    public function parse(\MailPoetVendor\Twig\Token $token)
    {
        $expr = $this->parser->getExpressionParser()->parseExpression();
        list($variables, $only, $ignoreMissing) = $this->parseArguments();
        return new \MailPoetVendor\Twig\Node\IncludeNode($expr, $variables, $only, $ignoreMissing, $token->getLine(), $this->getTag());
    }
    protected function parseArguments()
    {
        $stream = $this->parser->getStream();
        $ignoreMissing = \false;
        if ($stream->nextIf(\MailPoetVendor\Twig\Token::NAME_TYPE, 'ignore')) {
            $stream->expect(\MailPoetVendor\Twig\Token::NAME_TYPE, 'missing');
            $ignoreMissing = \true;
        }
        $variables = null;
        if ($stream->nextIf(\MailPoetVendor\Twig\Token::NAME_TYPE, 'with')) {
            $variables = $this->parser->getExpressionParser()->parseExpression();
        }
        $only = \false;
        if ($stream->nextIf(\MailPoetVendor\Twig\Token::NAME_TYPE, 'only')) {
            $only = \true;
        }
        $stream->expect(\MailPoetVendor\Twig\Token::BLOCK_END_TYPE);
        return [$variables, $only, $ignoreMissing];
    }
    public function getTag()
    {
        return 'include';
    }
}
\class_alias('MailPoetVendor\\Twig\\TokenParser\\IncludeTokenParser', 'MailPoetVendor\\Twig_TokenParser_Include');
