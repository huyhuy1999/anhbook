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

@\trigger_error('The ' . __NAMESPACE__ . '\\AutowireExceptionPass class is deprecated since Symfony 3.4 and will be removed in 4.0. Use the DefinitionErrorExceptionPass class instead.', \E_USER_DEPRECATED);
use MailPoetVendor\Symfony\Component\DependencyInjection\ContainerBuilder;
/**
 * Throws autowire exceptions from AutowirePass for definitions that still exist.
 *
 * @deprecated since version 3.4, will be removed in 4.0.
 *
 * @author Ryan Weaver <ryan@knpuniversity.com>
 */
class AutowireExceptionPass implements \MailPoetVendor\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    private $autowirePass;
    private $inlineServicePass;
    public function __construct(\MailPoetVendor\Symfony\Component\DependencyInjection\Compiler\AutowirePass $autowirePass, \MailPoetVendor\Symfony\Component\DependencyInjection\Compiler\InlineServiceDefinitionsPass $inlineServicePass)
    {
        $this->autowirePass = $autowirePass;
        $this->inlineServicePass = $inlineServicePass;
    }
    public function process(\MailPoetVendor\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        // the pass should only be run once
        if (null === $this->autowirePass || null === $this->inlineServicePass) {
            return;
        }
        $inlinedIds = $this->inlineServicePass->getInlinedServiceIds();
        $exceptions = $this->autowirePass->getAutowiringExceptions();
        // free up references
        $this->autowirePass = null;
        $this->inlineServicePass = null;
        foreach ($exceptions as $exception) {
            if ($this->doesServiceExistInTheContainer($exception->getServiceId(), $container, $inlinedIds)) {
                throw $exception;
            }
        }
    }
    private function doesServiceExistInTheContainer($serviceId, \MailPoetVendor\Symfony\Component\DependencyInjection\ContainerBuilder $container, array $inlinedIds)
    {
        if ($container->hasDefinition($serviceId)) {
            return \true;
        }
        // was the service inlined? Of so, does its parent service exist?
        if (isset($inlinedIds[$serviceId])) {
            foreach ($inlinedIds[$serviceId] as $parentId) {
                if ($this->doesServiceExistInTheContainer($parentId, $container, $inlinedIds)) {
                    return \true;
                }
            }
        }
        return \false;
    }
}
