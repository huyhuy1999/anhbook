<?php

/*
 * This file is part of Twig.
 *
 * (c) Fabien Potencier
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MailPoetVendor\Twig\Test;

use MailPoetVendor\PHPUnit\Framework\TestCase;
use MailPoetVendor\Twig\Environment;
use MailPoetVendor\Twig\Error\Error;
use MailPoetVendor\Twig\Extension\ExtensionInterface;
use MailPoetVendor\Twig\Loader\ArrayLoader;
use MailPoetVendor\Twig\Loader\SourceContextLoaderInterface;
use MailPoetVendor\Twig\RuntimeLoader\RuntimeLoaderInterface;
use MailPoetVendor\Twig\Source;
use MailPoetVendor\Twig\TwigFilter;
use MailPoetVendor\Twig\TwigFunction;
use MailPoetVendor\Twig\TwigTest;
/**
 * Integration test helper.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Karma Dordrak <drak@zikula.org>
 */
abstract class IntegrationTestCase extends \MailPoetVendor\PHPUnit\Framework\TestCase
{
    /**
     * @return string
     */
    protected abstract function getFixturesDir();
    /**
     * @return RuntimeLoaderInterface[]
     */
    protected function getRuntimeLoaders()
    {
        return [];
    }
    /**
     * @return ExtensionInterface[]
     */
    protected function getExtensions()
    {
        return [];
    }
    /**
     * @return TwigFilter[]
     */
    protected function getTwigFilters()
    {
        return [];
    }
    /**
     * @return TwigFunction[]
     */
    protected function getTwigFunctions()
    {
        return [];
    }
    /**
     * @return TwigTest[]
     */
    protected function getTwigTests()
    {
        return [];
    }
    /**
     * @dataProvider getTests
     */
    public function testIntegration($file, $message, $condition, $templates, $exception, $outputs)
    {
        $this->doIntegrationTest($file, $message, $condition, $templates, $exception, $outputs);
    }
    /**
     * @dataProvider getLegacyTests
     * @group legacy
     */
    public function testLegacyIntegration($file, $message, $condition, $templates, $exception, $outputs)
    {
        $this->doIntegrationTest($file, $message, $condition, $templates, $exception, $outputs);
    }
    public function getTests($name, $legacyTests = \false)
    {
        $fixturesDir = \realpath($this->getFixturesDir());
        $tests = [];
        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($fixturesDir), \RecursiveIteratorIterator::LEAVES_ONLY) as $file) {
            if (!\preg_match('/\\.test$/', $file)) {
                continue;
            }
            if ($legacyTests xor \false !== \strpos($file->getRealpath(), '.legacy.test')) {
                continue;
            }
            $test = \file_get_contents($file->getRealpath());
            if (\preg_match('/--TEST--\\s*(.*?)\\s*(?:--CONDITION--\\s*(.*))?\\s*((?:--TEMPLATE(?:\\(.*?\\))?--(?:.*?))+)\\s*(?:--DATA--\\s*(.*))?\\s*--EXCEPTION--\\s*(.*)/sx', $test, $match)) {
                $message = $match[1];
                $condition = $match[2];
                $templates = self::parseTemplates($match[3]);
                $exception = $match[5];
                $outputs = [[null, $match[4], null, '']];
            } elseif (\preg_match('/--TEST--\\s*(.*?)\\s*(?:--CONDITION--\\s*(.*))?\\s*((?:--TEMPLATE(?:\\(.*?\\))?--(?:.*?))+)--DATA--.*?--EXPECT--.*/s', $test, $match)) {
                $message = $match[1];
                $condition = $match[2];
                $templates = self::parseTemplates($match[3]);
                $exception = \false;
                \preg_match_all('/--DATA--(.*?)(?:--CONFIG--(.*?))?--EXPECT--(.*?)(?=\\-\\-DATA\\-\\-|$)/s', $test, $outputs, \PREG_SET_ORDER);
            } else {
                throw new \InvalidArgumentException(\sprintf('Test "%s" is not valid.', \str_replace($fixturesDir . '/', '', $file)));
            }
            $tests[] = [\str_replace($fixturesDir . '/', '', $file), $message, $condition, $templates, $exception, $outputs];
        }
        if ($legacyTests && empty($tests)) {
            // add a dummy test to avoid a PHPUnit message
            return [['not', '-', '', [], '', []]];
        }
        return $tests;
    }
    public function getLegacyTests()
    {
        return $this->getTests('testLegacyIntegration', \true);
    }
    protected function doIntegrationTest($file, $message, $condition, $templates, $exception, $outputs)
    {
        if (!$outputs) {
            $this->markTestSkipped('no tests to run');
        }
        if ($condition) {
            eval('$ret = ' . $condition . ';');
            if (!$ret) {
                $this->markTestSkipped($condition);
            }
        }
        $loader = new \MailPoetVendor\Twig\Loader\ArrayLoader($templates);
        foreach ($outputs as $i => $match) {
            $config = \array_merge(['cache' => \false, 'strict_variables' => \true], $match[2] ? eval($match[2] . ';') : []);
            $twig = new \MailPoetVendor\Twig\Environment($loader, $config);
            $twig->addGlobal('global', 'global');
            foreach ($this->getRuntimeLoaders() as $runtimeLoader) {
                $twig->addRuntimeLoader($runtimeLoader);
            }
            foreach ($this->getExtensions() as $extension) {
                $twig->addExtension($extension);
            }
            foreach ($this->getTwigFilters() as $filter) {
                $twig->addFilter($filter);
            }
            foreach ($this->getTwigTests() as $test) {
                $twig->addTest($test);
            }
            foreach ($this->getTwigFunctions() as $function) {
                $twig->addFunction($function);
            }
            $p = new \ReflectionProperty($twig, 'templateClassPrefix');
            $p->setAccessible(\true);
            $p->setValue($twig, '__TwigTemplate_' . \hash('sha256', \uniqid(\mt_rand(), \true), \false) . '_');
            try {
                $template = $twig->load('index.twig');
            } catch (\Exception $e) {
                if (\false !== $exception) {
                    $message = $e->getMessage();
                    $this->assertSame(\trim($exception), \trim(\sprintf('%s: %s', \get_class($e), $message)));
                    $last = \substr($message, \strlen($message) - 1);
                    $this->assertTrue('.' === $last || '?' === $last, $message, 'Exception message must end with a dot or a question mark.');
                    return;
                }
                throw new \MailPoetVendor\Twig\Error\Error(\sprintf('%s: %s', \get_class($e), $e->getMessage()), -1, null, $e);
            }
            try {
                $output = \trim($template->render(eval($match[1] . ';')), "\n ");
            } catch (\Exception $e) {
                if (\false !== $exception) {
                    $this->assertSame(\trim($exception), \trim(\sprintf('%s: %s', \get_class($e), $e->getMessage())));
                    return;
                }
                $e = new \MailPoetVendor\Twig\Error\Error(\sprintf('%s: %s', \get_class($e), $e->getMessage()), -1, null, $e);
                $output = \trim(\sprintf('%s: %s', \get_class($e), $e->getMessage()));
            }
            if (\false !== $exception) {
                list($class) = \explode(':', $exception);
                $constraintClass = \class_exists('MailPoetVendor\\PHPUnit\\Framework\\Constraint\\Exception') ? 'PHPUnit\\Framework\\Constraint\\Exception' : 'PHPUnit_Framework_Constraint_Exception';
                $this->assertThat(null, new $constraintClass($class));
            }
            $expected = \trim($match[3], "\n ");
            if ($expected !== $output) {
                \printf("Compiled templates that failed on case %d:\n", $i + 1);
                foreach (\array_keys($templates) as $name) {
                    echo "Template: {$name}\n";
                    $loader = $twig->getLoader();
                    if (!$loader instanceof \MailPoetVendor\Twig\Loader\SourceContextLoaderInterface) {
                        $source = new \MailPoetVendor\Twig\Source($loader->getSource($name), $name);
                    } else {
                        $source = $loader->getSourceContext($name);
                    }
                    echo $twig->compile($twig->parse($twig->tokenize($source)));
                }
            }
            $this->assertEquals($expected, $output, $message . ' (in ' . $file . ')');
        }
    }
    protected static function parseTemplates($test)
    {
        $templates = [];
        \preg_match_all('/--TEMPLATE(?:\\((.*?)\\))?--(.*?)(?=\\-\\-TEMPLATE|$)/s', $test, $matches, \PREG_SET_ORDER);
        foreach ($matches as $match) {
            $templates[$match[1] ? $match[1] : 'index.twig'] = $match[2];
        }
        return $templates;
    }
}
\class_alias('MailPoetVendor\\Twig\\Test\\IntegrationTestCase', 'MailPoetVendor\\Twig_Test_IntegrationTestCase');
