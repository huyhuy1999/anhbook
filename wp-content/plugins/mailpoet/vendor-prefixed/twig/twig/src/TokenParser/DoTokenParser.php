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

use MailPoetVendor\Twig\Node\DoNode;
use MailPoetVendor\Twig\Token;
/**
 * Evaluates an expression, discarding the returned value.
 *
 * @final
 */
class DoTokenParser extends \MailPoetVendor\Twig\TokenParser\AbstractTokenParser
{
    public function parse(\MailPoetVendor\Twig\Token $token)
    {
        $expr = $this->parser->getExpressionParser()->parseExpression();
        $this->parser->getStream()->expect(\MailPoetVendor\Twig\Token::BLOCK_END_TYPE);
        return new \MailPoetVendor\Twig\Node\DoNode($expr, $token->getLine(), $this->getTag());
    }
    public function getTag()
    {
        return 'do';
    }
}
\class_alias('MailPoetVendor\\Twig\\TokenParser\\DoTokenParser', 'MailPoetVendor\\Twig_TokenParser_Do');
