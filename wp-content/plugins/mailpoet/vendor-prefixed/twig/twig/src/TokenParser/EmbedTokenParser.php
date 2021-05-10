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

use MailPoetVendor\Twig\Node\EmbedNode;
use MailPoetVendor\Twig\Node\Expression\ConstantExpression;
use MailPoetVendor\Twig\Node\Expression\NameExpression;
use MailPoetVendor\Twig\Token;
/**
 * Embeds a template.
 *
 * @final
 */
class EmbedTokenParser extends \MailPoetVendor\Twig\TokenParser\IncludeTokenParser
{
    public function parse(\MailPoetVendor\Twig\Token $token)
    {
        $stream = $this->parser->getStream();
        $parent = $this->parser->getExpressionParser()->parseExpression();
        list($variables, $only, $ignoreMissing) = $this->parseArguments();
        $parentToken = $fakeParentToken = new \MailPoetVendor\Twig\Token(\MailPoetVendor\Twig\Token::STRING_TYPE, '__parent__', $token->getLine());
        if ($parent instanceof \MailPoetVendor\Twig\Node\Expression\ConstantExpression) {
            $parentToken = new \MailPoetVendor\Twig\Token(\MailPoetVendor\Twig\Token::STRING_TYPE, $parent->getAttribute('value'), $token->getLine());
        } elseif ($parent instanceof \MailPoetVendor\Twig\Node\Expression\NameExpression) {
            $parentToken = new \MailPoetVendor\Twig\Token(\MailPoetVendor\Twig\Token::NAME_TYPE, $parent->getAttribute('name'), $token->getLine());
        }
        // inject a fake parent to make the parent() function work
        $stream->injectTokens([new \MailPoetVendor\Twig\Token(\MailPoetVendor\Twig\Token::BLOCK_START_TYPE, '', $token->getLine()), new \MailPoetVendor\Twig\Token(\MailPoetVendor\Twig\Token::NAME_TYPE, 'extends', $token->getLine()), $parentToken, new \MailPoetVendor\Twig\Token(\MailPoetVendor\Twig\Token::BLOCK_END_TYPE, '', $token->getLine())]);
        $module = $this->parser->parse($stream, [$this, 'decideBlockEnd'], \true);
        // override the parent with the correct one
        if ($fakeParentToken === $parentToken) {
            $module->setNode('parent', $parent);
        }
        $this->parser->embedTemplate($module);
        $stream->expect(\MailPoetVendor\Twig\Token::BLOCK_END_TYPE);
        return new \MailPoetVendor\Twig\Node\EmbedNode($module->getTemplateName(), $module->getAttribute('index'), $variables, $only, $ignoreMissing, $token->getLine(), $this->getTag());
    }
    public function decideBlockEnd(\MailPoetVendor\Twig\Token $token)
    {
        return $token->test('endembed');
    }
    public function getTag()
    {
        return 'embed';
    }
}
\class_alias('MailPoetVendor\\Twig\\TokenParser\\EmbedTokenParser', 'MailPoetVendor\\Twig_TokenParser_Embed');
