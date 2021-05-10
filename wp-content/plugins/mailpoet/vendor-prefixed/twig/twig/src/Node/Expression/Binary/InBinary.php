<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MailPoetVendor\Twig\Node\Expression\Binary;

use MailPoetVendor\Twig\Compiler;
class InBinary extends \MailPoetVendor\Twig\Node\Expression\Binary\AbstractBinary
{
    public function compile(\MailPoetVendor\Twig\Compiler $compiler)
    {
        $compiler->raw('\\MailPoetVendor\\twig_in_filter(')->subcompile($this->getNode('left'))->raw(', ')->subcompile($this->getNode('right'))->raw(')');
    }
    public function operator(\MailPoetVendor\Twig\Compiler $compiler)
    {
        return $compiler->raw('in');
    }
}
\class_alias('MailPoetVendor\\Twig\\Node\\Expression\\Binary\\InBinary', 'MailPoetVendor\\Twig_Node_Expression_Binary_In');
