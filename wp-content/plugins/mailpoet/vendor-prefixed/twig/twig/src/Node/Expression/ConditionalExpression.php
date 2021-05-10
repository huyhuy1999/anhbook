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
namespace MailPoetVendor\Twig\Node\Expression;

use MailPoetVendor\Twig\Compiler;
class ConditionalExpression extends \MailPoetVendor\Twig\Node\Expression\AbstractExpression
{
    public function __construct(\MailPoetVendor\Twig\Node\Expression\AbstractExpression $expr1, \MailPoetVendor\Twig\Node\Expression\AbstractExpression $expr2, \MailPoetVendor\Twig\Node\Expression\AbstractExpression $expr3, $lineno)
    {
        parent::__construct(['expr1' => $expr1, 'expr2' => $expr2, 'expr3' => $expr3], [], $lineno);
    }
    public function compile(\MailPoetVendor\Twig\Compiler $compiler)
    {
        $compiler->raw('((')->subcompile($this->getNode('expr1'))->raw(') ? (')->subcompile($this->getNode('expr2'))->raw(') : (')->subcompile($this->getNode('expr3'))->raw('))');
    }
}
\class_alias('MailPoetVendor\\Twig\\Node\\Expression\\ConditionalExpression', 'MailPoetVendor\\Twig_Node_Expression_Conditional');
