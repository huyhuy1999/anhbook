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

use MailPoetVendor\Symfony\Component\DependencyInjection\Alias;
use MailPoetVendor\Symfony\Component\DependencyInjection\ContainerBuilder;
/**
 * Overwrites a service but keeps the overridden one.
 *
 * @author Christophe Coevoet <stof@notk.org>
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Diego Saint Esteben <diego@saintesteben.me>
 */
class DecoratorServicePass implements \MailPoetVendor\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    public function process(\MailPoetVendor\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        $definitions = new \SplPriorityQueue();
        $order = \PHP_INT_MAX;
        foreach ($container->getDefinitions() as $id => $definition) {
            if (!($decorated = $definition->getDecoratedService())) {
                continue;
            }
            $definitions->insert([$id, $definition], [$decorated[2], --$order]);
        }
        $decoratingDefinitions = [];
        foreach ($definitions as list($id, $definition)) {
            list($inner, $renamedId) = $definition->getDecoratedService();
            $definition->setDecoratedService(null);
            if (!$renamedId) {
                $renamedId = $id . '.inner';
            }
            // we create a new alias/service for the service we are replacing
            // to be able to reference it in the new one
            if ($container->hasAlias($inner)) {
                $alias = $container->getAlias($inner);
                $public = $alias->isPublic();
                $private = $alias->isPrivate();
                $container->setAlias($renamedId, new \MailPoetVendor\Symfony\Component\DependencyInjection\Alias($container->normalizeId($alias), \false));
            } else {
                $decoratedDefinition = $container->getDefinition($inner);
                $public = $decoratedDefinition->isPublic();
                $private = $decoratedDefinition->isPrivate();
                $decoratedDefinition->setPublic(\false);
                $container->setDefinition($renamedId, $decoratedDefinition);
                $decoratingDefinitions[$inner] = $decoratedDefinition;
            }
            if (isset($decoratingDefinitions[$inner])) {
                $decoratingDefinition = $decoratingDefinitions[$inner];
                $definition->setTags(\array_merge($decoratingDefinition->getTags(), $definition->getTags()));
                $autowiringTypes = $decoratingDefinition->getAutowiringTypes(\false);
                if ($types = \array_merge($autowiringTypes, $definition->getAutowiringTypes(\false))) {
                    $definition->setAutowiringTypes($types);
                }
                $decoratingDefinition->setTags([]);
                if ($autowiringTypes) {
                    $decoratingDefinition->setAutowiringTypes([]);
                }
                $decoratingDefinitions[$inner] = $definition;
            }
            $container->setAlias($inner, $id)->setPublic($public)->setPrivate($private);
        }
    }
}
