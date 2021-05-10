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

use MailPoetVendor\Twig\Error\SyntaxError;
use MailPoetVendor\Twig\Token;
/**
 * Extends a template by another one.
 *
 *  {% extends "base.html" %}
 *
 * @final
 */
class ExtendsTokenParser extends \MailPoetVendor\Twig\TokenParser\AbstractTokenParser
{
    public function parse(\MailPoetVendor\Twig\Token $token)
    {
        $stream = $this->parser->getStream();
        if (!$this->parser->isMainScope()) {
            throw new \MailPoetVendor\Twig\Error\SyntaxError('Cannot extend from a block.', $token->getLine(), $stream->getSourceContext());
        }
        if (null !== $this->parser->getParent()) {
            throw new \MailPoetVendor\Twig\Error\SyntaxError('Multiple extends tags are forbidden.', $token->getLine(), $stream->getSourceContext());
        }
        $this->parser->setParent($this->parser->getExpressionParser()->parseExpression());
        $stream->expect(\MailPoetVendor\Twig\Token::BLOCK_END_TYPE);
    }
    public function getTag()
    {
        return 'extends';
    }
}
\class_alias('MailPoetVendor\\Twig\\TokenParser\\ExtendsTokenParser', 'MailPoetVendor\\Twig_TokenParser_Extends');
