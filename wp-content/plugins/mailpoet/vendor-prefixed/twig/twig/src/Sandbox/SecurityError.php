<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MailPoetVendor\Twig\Sandbox;

use MailPoetVendor\Twig\Error\Error;
/**
 * Exception thrown when a security error occurs at runtime.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class SecurityError extends \MailPoetVendor\Twig\Error\Error
{
}
\class_alias('MailPoetVendor\\Twig\\Sandbox\\SecurityError', 'MailPoetVendor\\Twig_Sandbox_SecurityError');
