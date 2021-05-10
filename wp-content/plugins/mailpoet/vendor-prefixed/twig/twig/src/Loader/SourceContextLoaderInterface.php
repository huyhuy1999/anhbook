<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MailPoetVendor\Twig\Loader;

use MailPoetVendor\Twig\Error\LoaderError;
use MailPoetVendor\Twig\Source;
/**
 * Adds a getSourceContext() method for loaders.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @deprecated since 1.27 (to be removed in 3.0)
 */
interface SourceContextLoaderInterface
{
    /**
     * Returns the source context for a given template logical name.
     *
     * @param string $name The template logical name
     *
     * @return Source
     *
     * @throws LoaderError When $name is not found
     */
    public function getSourceContext($name);
}
\class_alias('MailPoetVendor\\Twig\\Loader\\SourceContextLoaderInterface', 'MailPoetVendor\\Twig_SourceContextLoaderInterface');
