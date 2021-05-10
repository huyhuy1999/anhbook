<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 * (c) Armin Ronacher
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MailPoetVendor\Twig\Error;

/**
 * Exception thrown when an error occurs at runtime.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class RuntimeError extends \MailPoetVendor\Twig\Error\Error
{
}
\class_alias('MailPoetVendor\\Twig\\Error\\RuntimeError', 'MailPoetVendor\\Twig_Error_Runtime');
