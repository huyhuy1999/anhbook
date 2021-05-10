<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MailPoetVendor\Symfony\Component\DependencyInjection\Compiler;

use MailPoetVendor\Symfony\Component\DependencyInjection\Argument\ArgumentInterface;
use MailPoetVendor\Symfony\Component\DependencyInjection\ContainerBuilder;
use MailPoetVendor\Symfony\Component\DependencyInjection\Definition;
use MailPoetVendor\Symfony\Component\DependencyInjection\Reference;
/**
 * Propagate "container.hot_path" tags to referenced services.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
class ResolveHotPathPass extends \MailPoetVendor\Symfony\Component\DependencyInjection\Compiler\AbstractRecursivePass
{
    private $tagName;
    private $resolvedIds = [];
    public function __construct($tagName = 'container.hot_path')
    {
        $this->tagName = $tagName;
    }
    /**
     * {@inheritdoc}
     */
    public function process(\MailPoetVendor\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        try {
            parent::process($container);
            $container->getDefinition('service_container')->clearTag($this->tagName);
        } finally {
            $this->resolvedIds = [];
        }
    }
    /**
     * {@inheritdoc}
     */
    protected function processValue($value, $isRoot = \false)
    {
        if ($value instanceof \MailPoetVendor\Symfony\Component\DependencyInjection\Argument\ArgumentInterface) {
            return $value;
        }
        if ($value instanceof \MailPoetVendor\Symfony\Component\DependencyInjection\Definition && $isRoot && (isset($this->resolvedIds[$this->currentId]) || !$value->hasTag($this->tagName) || $value->isDeprecated())) {
            return $value->isDeprecated() ? $value->clearTag($this->tagName) : $value;
        }
        if ($value instanceof \MailPoetVendor\Symfony\Component\DependencyInjection\Reference && \MailPoetVendor\Symfony\Component\DependencyInjection\ContainerBuilder::IGNORE_ON_UNINITIALIZED_REFERENCE !== $value->getInvalidBehavior() && $this->container->has($id = $this->container->normalizeId($value))) {
            $definition = $this->container->findDefinition($id);
            if (!$definition->hasTag($this->tagName) && !$definition->isDeprecated()) {
                $this->resolvedIds[$id] = \true;
                $definition->addTag($this->tagName);
                parent::processValue($definition, \false);
            }
            return $value;
        }
        return parent::processValue($value, $isRoot);
    }
}
