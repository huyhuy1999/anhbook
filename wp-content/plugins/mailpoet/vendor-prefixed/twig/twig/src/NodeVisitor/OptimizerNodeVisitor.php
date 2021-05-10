<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MailPoetVendor\Twig\NodeVisitor;

use MailPoetVendor\Twig\Environment;
use MailPoetVendor\Twig\Node\BlockReferenceNode;
use MailPoetVendor\Twig\Node\BodyNode;
use MailPoetVendor\Twig\Node\Expression\AbstractExpression;
use MailPoetVendor\Twig\Node\Expression\BlockReferenceExpression;
use MailPoetVendor\Twig\Node\Expression\ConstantExpression;
use MailPoetVendor\Twig\Node\Expression\FilterExpression;
use MailPoetVendor\Twig\Node\Expression\FunctionExpression;
use MailPoetVendor\Twig\Node\Expression\GetAttrExpression;
use MailPoetVendor\Twig\Node\Expression\NameExpression;
use MailPoetVendor\Twig\Node\Expression\ParentExpression;
use MailPoetVendor\Twig\Node\Expression\TempNameExpression;
use MailPoetVendor\Twig\Node\ForNode;
use MailPoetVendor\Twig\Node\IncludeNode;
use MailPoetVendor\Twig\Node\Node;
use MailPoetVendor\Twig\Node\PrintNode;
use MailPoetVendor\Twig\Node\SetTempNode;
/**
 * Tries to optimize the AST.
 *
 * This visitor is always the last registered one.
 *
 * You can configure which optimizations you want to activate via the
 * optimizer mode.
 *
 * @final
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class OptimizerNodeVisitor extends \MailPoetVendor\Twig\NodeVisitor\AbstractNodeVisitor
{
    const OPTIMIZE_ALL = -1;
    const OPTIMIZE_NONE = 0;
    const OPTIMIZE_FOR = 2;
    const OPTIMIZE_RAW_FILTER = 4;
    const OPTIMIZE_VAR_ACCESS = 8;
    protected $loops = [];
    protected $loopsTargets = [];
    protected $optimizers;
    protected $prependedNodes = [];
    protected $inABody = \false;
    /**
     * @param int $optimizers The optimizer mode
     */
    public function __construct($optimizers = -1)
    {
        if (!\is_int($optimizers) || $optimizers > (self::OPTIMIZE_FOR | self::OPTIMIZE_RAW_FILTER | self::OPTIMIZE_VAR_ACCESS)) {
            throw new \InvalidArgumentException(\sprintf('Optimizer mode "%s" is not valid.', $optimizers));
        }
        $this->optimizers = $optimizers;
    }
    protected function doEnterNode(\MailPoetVendor\Twig\Node\Node $node, \MailPoetVendor\Twig\Environment $env)
    {
        if (self::OPTIMIZE_FOR === (self::OPTIMIZE_FOR & $this->optimizers)) {
            $this->enterOptimizeFor($node, $env);
        }
        if (\PHP_VERSION_ID < 50400 && self::OPTIMIZE_VAR_ACCESS === (self::OPTIMIZE_VAR_ACCESS & $this->optimizers) && !$env->isStrictVariables() && !$env->hasExtension('MailPoetVendor\\Twig\\Extension\\SandboxExtension')) {
            if ($this->inABody) {
                if (!$node instanceof \MailPoetVendor\Twig\Node\Expression\AbstractExpression) {
                    if ('Twig_Node' !== \get_class($node)) {
                        \array_unshift($this->prependedNodes, []);
                    }
                } else {
                    $node = $this->optimizeVariables($node, $env);
                }
            } elseif ($node instanceof \MailPoetVendor\Twig\Node\BodyNode) {
                $this->inABody = \true;
            }
        }
        return $node;
    }
    protected function doLeaveNode(\MailPoetVendor\Twig\Node\Node $node, \MailPoetVendor\Twig\Environment $env)
    {
        $expression = $node instanceof \MailPoetVendor\Twig\Node\Expression\AbstractExpression;
        if (self::OPTIMIZE_FOR === (self::OPTIMIZE_FOR & $this->optimizers)) {
            $this->leaveOptimizeFor($node, $env);
        }
        if (self::OPTIMIZE_RAW_FILTER === (self::OPTIMIZE_RAW_FILTER & $this->optimizers)) {
            $node = $this->optimizeRawFilter($node, $env);
        }
        $node = $this->optimizePrintNode($node, $env);
        if (self::OPTIMIZE_VAR_ACCESS === (self::OPTIMIZE_VAR_ACCESS & $this->optimizers) && !$env->isStrictVariables() && !$env->hasExtension('MailPoetVendor\\Twig\\Extension\\SandboxExtension')) {
            if ($node instanceof \MailPoetVendor\Twig\Node\BodyNode) {
                $this->inABody = \false;
            } elseif ($this->inABody) {
                if (!$expression && 'Twig_Node' !== \get_class($node) && ($prependedNodes = \array_shift($this->prependedNodes))) {
                    $nodes = [];
                    foreach (\array_unique($prependedNodes) as $name) {
                        $nodes[] = new \MailPoetVendor\Twig\Node\SetTempNode($name, $node->getTemplateLine());
                    }
                    $nodes[] = $node;
                    $node = new \MailPoetVendor\Twig\Node\Node($nodes);
                }
            }
        }
        return $node;
    }
    protected function optimizeVariables(\MailPoetVendor\Twig_NodeInterface $node, \MailPoetVendor\Twig\Environment $env)
    {
        if ('Twig_Node_Expression_Name' === \get_class($node) && $node->isSimple()) {
            $this->prependedNodes[0][] = $node->getAttribute('name');
            return new \MailPoetVendor\Twig\Node\Expression\TempNameExpression($node->getAttribute('name'), $node->getTemplateLine());
        }
        return $node;
    }
    /**
     * Optimizes print nodes.
     *
     * It replaces:
     *
     *   * "echo $this->render(Parent)Block()" with "$this->display(Parent)Block()"
     *
     * @return \Twig_NodeInterface
     */
    protected function optimizePrintNode(\MailPoetVendor\Twig_NodeInterface $node, \MailPoetVendor\Twig\Environment $env)
    {
        if (!$node instanceof \MailPoetVendor\Twig\Node\PrintNode) {
            return $node;
        }
        $exprNode = $node->getNode('expr');
        if ($exprNode instanceof \MailPoetVendor\Twig\Node\Expression\BlockReferenceExpression || $exprNode instanceof \MailPoetVendor\Twig\Node\Expression\ParentExpression) {
            $exprNode->setAttribute('output', \true);
            return $exprNode;
        }
        return $node;
    }
    /**
     * Removes "raw" filters.
     *
     * @return \Twig_NodeInterface
     */
    protected function optimizeRawFilter(\MailPoetVendor\Twig_NodeInterface $node, \MailPoetVendor\Twig\Environment $env)
    {
        if ($node instanceof \MailPoetVendor\Twig\Node\Expression\FilterExpression && 'raw' == $node->getNode('filter')->getAttribute('value')) {
            return $node->getNode('node');
        }
        return $node;
    }
    /**
     * Optimizes "for" tag by removing the "loop" variable creation whenever possible.
     */
    protected function enterOptimizeFor(\MailPoetVendor\Twig_NodeInterface $node, \MailPoetVendor\Twig\Environment $env)
    {
        if ($node instanceof \MailPoetVendor\Twig\Node\ForNode) {
            // disable the loop variable by default
            $node->setAttribute('with_loop', \false);
            \array_unshift($this->loops, $node);
            \array_unshift($this->loopsTargets, $node->getNode('value_target')->getAttribute('name'));
            \array_unshift($this->loopsTargets, $node->getNode('key_target')->getAttribute('name'));
        } elseif (!$this->loops) {
            // we are outside a loop
            return;
        } elseif ($node instanceof \MailPoetVendor\Twig\Node\Expression\NameExpression && 'loop' === $node->getAttribute('name')) {
            $node->setAttribute('always_defined', \true);
            $this->addLoopToCurrent();
        } elseif ($node instanceof \MailPoetVendor\Twig\Node\Expression\NameExpression && \in_array($node->getAttribute('name'), $this->loopsTargets)) {
            $node->setAttribute('always_defined', \true);
        } elseif ($node instanceof \MailPoetVendor\Twig\Node\BlockReferenceNode || $node instanceof \MailPoetVendor\Twig\Node\Expression\BlockReferenceExpression) {
            $this->addLoopToCurrent();
        } elseif ($node instanceof \MailPoetVendor\Twig\Node\IncludeNode && !$node->getAttribute('only')) {
            $this->addLoopToAll();
        } elseif ($node instanceof \MailPoetVendor\Twig\Node\Expression\FunctionExpression && 'include' === $node->getAttribute('name') && (!$node->getNode('arguments')->hasNode('with_context') || \false !== $node->getNode('arguments')->getNode('with_context')->getAttribute('value'))) {
            $this->addLoopToAll();
        } elseif ($node instanceof \MailPoetVendor\Twig\Node\Expression\GetAttrExpression && (!$node->getNode('attribute') instanceof \MailPoetVendor\Twig\Node\Expression\ConstantExpression || 'parent' === $node->getNode('attribute')->getAttribute('value')) && (\true === $this->loops[0]->getAttribute('with_loop') || $node->getNode('node') instanceof \MailPoetVendor\Twig\Node\Expression\NameExpression && 'loop' === $node->getNode('node')->getAttribute('name'))) {
            $this->addLoopToAll();
        }
    }
    /**
     * Optimizes "for" tag by removing the "loop" variable creation whenever possible.
     */
    protected function leaveOptimizeFor(\MailPoetVendor\Twig_NodeInterface $node, \MailPoetVendor\Twig\Environment $env)
    {
        if ($node instanceof \MailPoetVendor\Twig\Node\ForNode) {
            \array_shift($this->loops);
            \array_shift($this->loopsTargets);
            \array_shift($this->loopsTargets);
        }
    }
    protected function addLoopToCurrent()
    {
        $this->loops[0]->setAttribute('with_loop', \true);
    }
    protected function addLoopToAll()
    {
        foreach ($this->loops as $loop) {
            $loop->setAttribute('with_loop', \true);
        }
    }
    public function getPriority()
    {
        return 255;
    }
}
\class_alias('MailPoetVendor\\Twig\\NodeVisitor\\OptimizerNodeVisitor', 'MailPoetVendor\\Twig_NodeVisitor_Optimizer');
