<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MailPoetVendor\Twig\Extension;

use MailPoetVendor\Twig\NodeVisitor\OptimizerNodeVisitor;
/**
 * @final
 */
class OptimizerExtension extends \MailPoetVendor\Twig\Extension\AbstractExtension
{
    protected $optimizers;
    public function __construct($optimizers = -1)
    {
        $this->optimizers = $optimizers;
    }
    public function getNodeVisitors()
    {
        return [new \MailPoetVendor\Twig\NodeVisitor\OptimizerNodeVisitor($this->optimizers)];
    }
    public function getName()
    {
        return 'optimizer';
    }
}
\class_alias('MailPoetVendor\\Twig\\Extension\\OptimizerExtension', 'MailPoetVendor\\Twig_Extension_Optimizer');
