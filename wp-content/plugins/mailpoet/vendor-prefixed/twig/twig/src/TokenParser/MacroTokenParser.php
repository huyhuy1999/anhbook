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
use MailPoetVendor\Twig\Node\BodyNode;
use MailPoetVendor\Twig\Node\MacroNode;
use MailPoetVendor\Twig\Token;
/**
 * Defines a macro.
 *
 *   {% macro input(name, value, type, size) %}
 *      <input type="{{ type|default('text') }}" name="{{ name }}" value="{{ value|e }}" size="{{ size|default(20) }}" />
 *   {% endmacro %}
 *
 * @final
 */
class MacroTokenParser extends \MailPoetVendor\Twig\TokenParser\AbstractTokenParser
{
    public function parse(\MailPoetVendor\Twig\Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();
        $name = $stream->expect(\MailPoetVendor\Twig\Token::NAME_TYPE)->getValue();
        $arguments = $this->parser->getExpressionParser()->parseArguments(\true, \true);
        $stream->expect(\MailPoetVendor\Twig\Token::BLOCK_END_TYPE);
        $this->parser->pushLocalScope();
        $body = $this->parser->subparse([$this, 'decideBlockEnd'], \true);
        if ($token = $stream->nextIf(\MailPoetVendor\Twig\Token::NAME_TYPE)) {
            $value = $token->getValue();
            if ($value != $name) {
                throw new \MailPoetVendor\Twig\Error\SyntaxError(\sprintf('Expected endmacro for macro "%s" (but "%s" given).', $name, $value), $stream->getCurrent()->getLine(), $stream->getSourceContext());
            }
        }
        $this->parser->popLocalScope();
        $stream->expect(\MailPoetVendor\Twig\Token::BLOCK_END_TYPE);
        $this->parser->setMacro($name, new \MailPoetVendor\Twig\Node\MacroNode($name, new \MailPoetVendor\Twig\Node\BodyNode([$body]), $arguments, $lineno, $this->getTag()));
    }
    public function decideBlockEnd(\MailPoetVendor\Twig\Token $token)
    {
        return $token->test('endmacro');
    }
    public function getTag()
    {
        return 'macro';
    }
}
\class_alias('MailPoetVendor\\Twig\\TokenParser\\MacroTokenParser', 'MailPoetVendor\\Twig_TokenParser_Macro');
