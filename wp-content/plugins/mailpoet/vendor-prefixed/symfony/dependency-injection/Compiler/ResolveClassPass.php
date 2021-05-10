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

use MailPoetVendor\Symfony\Component\DependencyInjection\ChildDefinition;
use MailPoetVendor\Symfony\Component\DependencyInjection\ContainerBuilder;
use MailPoetVendor\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class ResolveClassPass implements \MailPoetVendor\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    private $changes = [];
    /**
     * {@inheritdoc}
     */
    public function process(\MailPoetVendor\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        foreach ($container->getDefinitions() as $id => $definition) {
            if ($definition->isSynthetic() || null !== $definition->getClass()) {
                continue;
            }
            if (\preg_match('/^[a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*+(?:\\\\[a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*+)++$/', $id)) {
                if ($definition instanceof \MailPoetVendor\Symfony\Component\DependencyInjection\ChildDefinition && !\class_exists($id)) {
                    throw new \MailPoetVendor\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException(\sprintf('Service definition "%s" has a parent but no class, and its name looks like a FQCN. Either the class is missing or you want to inherit it from the parent service. To resolve this ambiguity, please rename this service to a non-FQCN (e.g. using dots), or create the missing class.', $id));
                }
                $this->changes[\strtolower($id)] = $id;
                $definition->setClass($id);
            }
        }
    }
    /**
     * @internal
     *
     * @deprecated since 3.3, to be removed in 4.0.
     */
    public function getChanges()
    {
        $changes = $this->changes;
        $this->changes = [];
        return $changes;
    }
}
