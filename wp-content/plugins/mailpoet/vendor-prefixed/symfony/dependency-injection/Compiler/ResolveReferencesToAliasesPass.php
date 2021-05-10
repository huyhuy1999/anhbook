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

use MailPoetVendor\Symfony\Component\DependencyInjection\ContainerBuilder;
use MailPoetVendor\Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException;
use MailPoetVendor\Symfony\Component\DependencyInjection\Reference;
/**
 * Replaces all references to aliases with references to the actual service.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class ResolveReferencesToAliasesPass extends \MailPoetVendor\Symfony\Component\DependencyInjection\Compiler\AbstractRecursivePass
{
    /**
     * {@inheritdoc}
     */
    public function process(\MailPoetVendor\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        parent::process($container);
        foreach ($container->getAliases() as $id => $alias) {
            $aliasId = $container->normalizeId($alias);
            if ($aliasId !== ($defId = $this->getDefinitionId($aliasId, $container))) {
                $container->setAlias($id, $defId)->setPublic($alias->isPublic())->setPrivate($alias->isPrivate());
            }
        }
    }
    /**
     * {@inheritdoc}
     */
    protected function processValue($value, $isRoot = \false)
    {
        if ($value instanceof \MailPoetVendor\Symfony\Component\DependencyInjection\Reference) {
            $defId = $this->getDefinitionId($id = $this->container->normalizeId($value), $this->container);
            if ($defId !== $id) {
                return new \MailPoetVendor\Symfony\Component\DependencyInjection\Reference($defId, $value->getInvalidBehavior());
            }
        }
        return parent::processValue($value);
    }
    /**
     * Resolves an alias into a definition id.
     *
     * @param string           $id        The definition or alias id to resolve
     * @param ContainerBuilder $container
     *
     * @return string The definition id with aliases resolved
     */
    private function getDefinitionId($id, \MailPoetVendor\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        $seen = [];
        while ($container->hasAlias($id)) {
            if (isset($seen[$id])) {
                throw new \MailPoetVendor\Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException($id, \array_merge(\array_keys($seen), [$id]));
            }
            $seen[$id] = \true;
            $id = $container->normalizeId($container->getAlias($id));
        }
        return $id;
    }
}
