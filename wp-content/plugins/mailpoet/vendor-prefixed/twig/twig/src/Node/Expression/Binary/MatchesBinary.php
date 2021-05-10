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
class MatchesBinary extends \MailPoetVendor\Twig\Node\Expression\Binary\AbstractBinary
{
    public function compile(\MailPoetVendor\Twig\Compiler $compiler)
    {
        $compiler->raw('preg_match(')->subcompile($this->getNode('right'))->raw(', ')->subcompile($this->getNode('left'))->raw(')');
    }
    public function operator(\MailPoetVendor\Twig\Compiler $compiler)
    {
        return $compiler->raw('');
    }
}
\class_alias('MailPoetVendor\\Twig\\Node\\Expression\\Binary\\MatchesBinary', 'MailPoetVendor\\Twig_Node_Expression_Binary_Matches');
