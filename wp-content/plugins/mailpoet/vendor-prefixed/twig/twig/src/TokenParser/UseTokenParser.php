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

use MailPoetVendor\Twig\Error\SyntaxError;
use MailPoetVendor\Twig\Node\Expression\ConstantExpression;
use MailPoetVendor\Twig\Node\Node;
use MailPoetVendor\Twig\Token;
/**
 * Imports blocks defined in another template into the current template.
 *
 *    {% extends "base.html" %}
 *
 *    {% use "blocks.html" %}
 *
 *    {% block title %}{% endblock %}
 *    {% block content %}{% endblock %}
 *
 * @see https://twig.symfony.com/doc/templates.html#horizontal-reuse for details.
 *
 * @final
 */
class UseTokenParser extends \MailPoetVendor\Twig\TokenParser\AbstractTokenParser
{
    public function parse(\MailPoetVendor\Twig\Token $token)
    {
        $template = $this->parser->getExpressionParser()->parseExpression();
        $stream = $this->parser->getStream();
        if (!$template instanceof \MailPoetVendor\Twig\Node\Expression\ConstantExpression) {
            throw new \MailPoetVendor\Twig\Error\SyntaxError('The template references in a "use" statement must be a string.', $stream->getCurrent()->getLine(), $stream->getSourceContext());
        }
        $targets = [];
        if ($stream->nextIf('with')) {
            do {
                $name = $stream->expect(\MailPoetVendor\Twig\Token::NAME_TYPE)->getValue();
                $alias = $name;
                if ($stream->nextIf('as')) {
                    $alias = $stream->expect(\MailPoetVendor\Twig\Token::NAME_TYPE)->getValue();
                }
                $targets[$name] = new \MailPoetVendor\Twig\Node\Expression\ConstantExpression($alias, -1);
                if (!$stream->nextIf(\MailPoetVendor\Twig\Token::PUNCTUATION_TYPE, ',')) {
                    break;
                }
            } while (\true);
        }
        $stream->expect(\MailPoetVendor\Twig\Token::BLOCK_END_TYPE);
        $this->parser->addTrait(new \MailPoetVendor\Twig\Node\Node(['template' => $template, 'targets' => new \MailPoetVendor\Twig\Node\Node($targets)]));
        return new \MailPoetVendor\Twig\Node\Node();
    }
    public function getTag()
    {
        return 'use';
    }
}
\class_alias('MailPoetVendor\\Twig\\TokenParser\\UseTokenParser', 'MailPoetVendor\\Twig_TokenParser_Use');
