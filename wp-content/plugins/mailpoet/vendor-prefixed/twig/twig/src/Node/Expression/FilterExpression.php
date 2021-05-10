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
use MailPoetVendor\Twig\TwigFilter;
class FilterExpression extends \MailPoetVendor\Twig\Node\Expression\CallExpression
{
    public function __construct(\MailPoetVendor\Twig_NodeInterface $node, \MailPoetVendor\Twig\Node\Expression\ConstantExpression $filterName, \MailPoetVendor\Twig_NodeInterface $arguments, $lineno, $tag = null)
    {
        parent::__construct(['node' => $node, 'filter' => $filterName, 'arguments' => $arguments], [], $lineno, $tag);
    }
    public function compile(\MailPoetVendor\Twig\Compiler $compiler)
    {
        $name = $this->getNode('filter')->getAttribute('value');
        $filter = $compiler->getEnvironment()->getFilter($name);
        $this->setAttribute('name', $name);
        $this->setAttribute('type', 'filter');
        $this->setAttribute('thing', $filter);
        $this->setAttribute('needs_environment', $filter->needsEnvironment());
        $this->setAttribute('needs_context', $filter->needsContext());
        $this->setAttribute('arguments', $filter->getArguments());
        if ($filter instanceof \MailPoetVendor\Twig_FilterCallableInterface || $filter instanceof \MailPoetVendor\Twig\TwigFilter) {
            $this->setAttribute('callable', $filter->getCallable());
        }
        if ($filter instanceof \MailPoetVendor\Twig\TwigFilter) {
            $this->setAttribute('is_variadic', $filter->isVariadic());
        }
        $this->compileCallable($compiler);
    }
}
\class_alias('MailPoetVendor\\Twig\\Node\\Expression\\FilterExpression', 'MailPoetVendor\\Twig_Node_Expression_Filter');
