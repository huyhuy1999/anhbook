<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MailPoetVendor\Twig\Profiler\Node;

use MailPoetVendor\Twig\Compiler;
use MailPoetVendor\Twig\Node\Node;
/**
 * Represents a profile leave node.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class LeaveProfileNode extends \MailPoetVendor\Twig\Node\Node
{
    public function __construct($varName)
    {
        parent::__construct([], ['var_name' => $varName]);
    }
    public function compile(\MailPoetVendor\Twig\Compiler $compiler)
    {
        $compiler->write("\n")->write(\sprintf("\$%s->leave(\$%s);\n\n", $this->getAttribute('var_name'), $this->getAttribute('var_name') . '_prof'));
    }
}
\class_alias('MailPoetVendor\\Twig\\Profiler\\Node\\LeaveProfileNode', 'MailPoetVendor\\Twig_Profiler_Node_LeaveProfile');
