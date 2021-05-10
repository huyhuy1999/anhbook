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
namespace MailPoetVendor\Twig\Node\Expression\Binary;

use MailPoetVendor\Twig\Compiler;
use MailPoetVendor\Twig\Node\Expression\AbstractExpression;
abstract class AbstractBinary extends \MailPoetVendor\Twig\Node\Expression\AbstractExpression
{
    public function __construct(\MailPoetVendor\Twig_NodeInterface $left, \MailPoetVendor\Twig_NodeInterface $right, $lineno)
    {
        parent::__construct(['left' => $left, 'right' => $right], [], $lineno);
    }
    public function compile(\MailPoetVendor\Twig\Compiler $compiler)
    {
        $compiler->raw('(')->subcompile($this->getNode('left'))->raw(' ');
        $this->operator($compiler);
        $compiler->raw(' ')->subcompile($this->getNode('right'))->raw(')');
    }
    public abstract function operator(\MailPoetVendor\Twig\Compiler $compiler);
}
\class_alias('MailPoetVendor\\Twig\\Node\\Expression\\Binary\\AbstractBinary', 'MailPoetVendor\\Twig_Node_Expression_Binary');
