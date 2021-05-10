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

@\trigger_error('The ' . __NAMESPACE__ . '\\LoggingFormatter class is deprecated since Symfony 3.3 and will be removed in 4.0. Use the ContainerBuilder::log() method instead.', \E_USER_DEPRECATED);
/**
 * Used to format logging messages during the compilation.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 *
 * @deprecated since version 3.3, to be removed in 4.0. Use the ContainerBuilder::log() method instead.
 */
class LoggingFormatter
{
    public function formatRemoveService(\MailPoetVendor\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface $pass, $id, $reason)
    {
        return $this->format($pass, \sprintf('Removed service "%s"; reason: %s.', $id, $reason));
    }
    public function formatInlineService(\MailPoetVendor\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface $pass, $id, $target)
    {
        return $this->format($pass, \sprintf('Inlined service "%s" to "%s".', $id, $target));
    }
    public function formatUpdateReference(\MailPoetVendor\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface $pass, $serviceId, $oldDestId, $newDestId)
    {
        return $this->format($pass, \sprintf('Changed reference of service "%s" previously pointing to "%s" to "%s".', $serviceId, $oldDestId, $newDestId));
    }
    public function formatResolveInheritance(\MailPoetVendor\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface $pass, $childId, $parentId)
    {
        return $this->format($pass, \sprintf('Resolving inheritance for "%s" (parent: %s).', $childId, $parentId));
    }
    public function formatUnusedAutowiringPatterns(\MailPoetVendor\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface $pass, $id, array $patterns)
    {
        return $this->format($pass, \sprintf('Autowiring\'s patterns "%s" for service "%s" don\'t match any method.', \implode('", "', $patterns), $id));
    }
    public function format(\MailPoetVendor\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface $pass, $message)
    {
        return \sprintf('%s: %s', \get_class($pass), $message);
    }
}
