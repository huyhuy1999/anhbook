<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MailPoetVendor\Twig\Node\Expression;

use MailPoetVendor\Twig\Compiler;
use MailPoetVendor\Twig\Node\Expression\Binary\AndBinary;
use MailPoetVendor\Twig\Node\Expression\Test\DefinedTest;
use MailPoetVendor\Twig\Node\Expression\Test\NullTest;
use MailPoetVendor\Twig\Node\Expression\Unary\NotUnary;
use MailPoetVendor\Twig\Node\Node;
class NullCoalesceExpression extends \MailPoetVendor\Twig\Node\Expression\ConditionalExpression
{
    public function __construct(\MailPoetVendor\Twig_NodeInterface $left, \MailPoetVendor\Twig_NodeInterface $right, $lineno)
    {
        $test = new \MailPoetVendor\Twig\Node\Expression\Binary\AndBinary(new \MailPoetVendor\Twig\Node\Expression\Test\DefinedTest(clone $left, 'defined', new \MailPoetVendor\Twig\Node\Node(), $left->getTemplateLine()), new \MailPoetVendor\Twig\Node\Expression\Unary\NotUnary(new \MailPoetVendor\Twig\Node\Expression\Test\NullTest($left, 'null', new \MailPoetVendor\Twig\Node\Node(), $left->getTemplateLine()), $left->getTemplateLine()), $left->getTemplateLine());
        parent::__construct($test, $left, $right, $lineno);
    }
    public function compile(\MailPoetVendor\Twig\Compiler $compiler)
    {
        /*
         * This optimizes only one case. PHP 7 also supports more complex expressions
         * that can return null. So, for instance, if log is defined, log("foo") ?? "..." works,
         * but log($a["foo"]) ?? "..." does not if $a["foo"] is not defined. More advanced
         * cases might be implemented as an optimizer node visitor, but has not been done
         * as benefits are probably not worth the added complexity.
         */
        if (\PHP_VERSION_ID >= 70000 && $this->getNode('expr2') instanceof \MailPoetVendor\Twig\Node\Expression\NameExpression) {
            $this->getNode('expr2')->setAttribute('always_defined', \true);
            $compiler->raw('((')->subcompile($this->getNode('expr2'))->raw(') ?? (')->subcompile($this->getNode('expr3'))->raw('))');
        } else {
            parent::compile($compiler);
        }
    }
}
\class_alias('MailPoetVendor\\Twig\\Node\\Expression\\NullCoalesceExpression', 'MailPoetVendor\\Twig_Node_Expression_NullCoalesce');
