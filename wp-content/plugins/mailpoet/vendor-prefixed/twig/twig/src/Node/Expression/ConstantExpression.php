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
class ConstantExpression extends \MailPoetVendor\Twig\Node\Expression\AbstractExpression
{
    public function __construct($value, $lineno)
    {
        parent::__construct([], ['value' => $value], $lineno);
    }
    public function compile(\MailPoetVendor\Twig\Compiler $compiler)
    {
        $compiler->repr($this->getAttribute('value'));
    }
}
\class_alias('MailPoetVendor\\Twig\\Node\\Expression\\ConstantExpression', 'MailPoetVendor\\Twig_Node_Expression_Constant');
