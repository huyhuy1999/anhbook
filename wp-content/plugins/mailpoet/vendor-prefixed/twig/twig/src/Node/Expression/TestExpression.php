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
use MailPoetVendor\Twig\TwigTest;
class TestExpression extends \MailPoetVendor\Twig\Node\Expression\CallExpression
{
    public function __construct(\MailPoetVendor\Twig_NodeInterface $node, $name, \MailPoetVendor\Twig_NodeInterface $arguments = null, $lineno)
    {
        $nodes = ['node' => $node];
        if (null !== $arguments) {
            $nodes['arguments'] = $arguments;
        }
        parent::__construct($nodes, ['name' => $name], $lineno);
    }
    public function compile(\MailPoetVendor\Twig\Compiler $compiler)
    {
        $name = $this->getAttribute('name');
        $test = $compiler->getEnvironment()->getTest($name);
        $this->setAttribute('name', $name);
        $this->setAttribute('type', 'test');
        $this->setAttribute('thing', $test);
        if ($test instanceof \MailPoetVendor\Twig\TwigTest) {
            $this->setAttribute('arguments', $test->getArguments());
        }
        if ($test instanceof \MailPoetVendor\Twig_TestCallableInterface || $test instanceof \MailPoetVendor\Twig\TwigTest) {
            $this->setAttribute('callable', $test->getCallable());
        }
        if ($test instanceof \MailPoetVendor\Twig\TwigTest) {
            $this->setAttribute('is_variadic', $test->isVariadic());
        }
        $this->compileCallable($compiler);
    }
}
\class_alias('MailPoetVendor\\Twig\\Node\\Expression\\TestExpression', 'MailPoetVendor\\Twig_Node_Expression_Test');
