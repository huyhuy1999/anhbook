<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MailPoetVendor\Symfony\Component\DependencyInjection\LazyProxy\PhpDumper;

use MailPoetVendor\Symfony\Component\DependencyInjection\Definition;
/**
 * Null dumper, negates any proxy code generation for any given service definition.
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 *
 * @final since version 3.3
 */
class NullDumper implements \MailPoetVendor\Symfony\Component\DependencyInjection\LazyProxy\PhpDumper\DumperInterface
{
    /**
     * {@inheritdoc}
     */
    public function isProxyCandidate(\MailPoetVendor\Symfony\Component\DependencyInjection\Definition $definition)
    {
        return \false;
    }
    /**
     * {@inheritdoc}
     */
    public function getProxyFactoryCode(\MailPoetVendor\Symfony\Component\DependencyInjection\Definition $definition, $id, $factoryCode = null)
    {
        return '';
    }
    /**
     * {@inheritdoc}
     */
    public function getProxyCode(\MailPoetVendor\Symfony\Component\DependencyInjection\Definition $definition)
    {
        return '';
    }
}
