<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MailPoetVendor\Twig\Node\Expression\Filter;

use MailPoetVendor\Twig\Compiler;
use MailPoetVendor\Twig\Node\Expression\ConditionalExpression;
use MailPoetVendor\Twig\Node\Expression\ConstantExpression;
use MailPoetVendor\Twig\Node\Expression\FilterExpression;
use MailPoetVendor\Twig\Node\Expression\GetAttrExpression;
use MailPoetVendor\Twig\Node\Expression\NameExpression;
use MailPoetVendor\Twig\Node\Expression\Test\DefinedTest;
use MailPoetVendor\Twig\Node\Node;
/**
 * Returns the value or the default value when it is undefined or empty.
 *
 *  {{ var.foo|default('foo item on var is not defined') }}
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class DefaultFilter extends \MailPoetVendor\Twig\Node\Expression\FilterExpression
{
    public function __construct(\MailPoetVendor\Twig_NodeInterface $node, \MailPoetVendor\Twig\Node\Expression\ConstantExpression $filterName, \MailPoetVendor\Twig_NodeInterface $arguments, $lineno, $tag = null)
    {
        $default = new \MailPoetVendor\Twig\Node\Expression\FilterExpression($node, new \MailPoetVendor\Twig\Node\Expression\ConstantExpression('default', $node->getTemplateLine()), $arguments, $node->getTemplateLine());
        if ('default' === $filterName->getAttribute('value') && ($node instanceof \MailPoetVendor\Twig\Node\Expression\NameExpression || $node instanceof \MailPoetVendor\Twig\Node\Expression\GetAttrExpression)) {
            $test = new \MailPoetVendor\Twig\Node\Expression\Test\DefinedTest(clone $node, 'defined', new \MailPoetVendor\Twig\Node\Node(), $node->getTemplateLine());
            $false = \count($arguments) ? $arguments->getNode(0) : new \MailPoetVendor\Twig\Node\Expression\ConstantExpression('', $node->getTemplateLine());
            $node = new \MailPoetVendor\Twig\Node\Expression\ConditionalExpression($test, $default, $false, $node->getTemplateLine());
        } else {
            $node = $default;
        }
        parent::__construct($node, $filterName, $arguments, $lineno, $tag);
    }
    public function compile(\MailPoetVendor\Twig\Compiler $compiler)
    {
        $compiler->subcompile($this->getNode('node'));
    }
}
\class_alias('MailPoetVendor\\Twig\\Node\\Expression\\Filter\\DefaultFilter', 'MailPoetVendor\\Twig_Node_Expression_Filter_Default');
