<?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MailPoetVendor\Monolog\Handler;

use MailPoetVendor\Monolog\Formatter\NormalizerFormatter;
use MailPoetVendor\Monolog\Logger;
/**
 * Handler sending logs to Zend Monitor
 *
 * @author  Christian Bergau <cbergau86@gmail.com>
 */
class ZendMonitorHandler extends \MailPoetVendor\Monolog\Handler\AbstractProcessingHandler
{
    /**
     * Monolog level / ZendMonitor Custom Event priority map
     *
     * @var array
     */
    protected $levelMap = array(\MailPoetVendor\Monolog\Logger::DEBUG => 1, \MailPoetVendor\Monolog\Logger::INFO => 2, \MailPoetVendor\Monolog\Logger::NOTICE => 3, \MailPoetVendor\Monolog\Logger::WARNING => 4, \MailPoetVendor\Monolog\Logger::ERROR => 5, \MailPoetVendor\Monolog\Logger::CRITICAL => 6, \MailPoetVendor\Monolog\Logger::ALERT => 7, \MailPoetVendor\Monolog\Logger::EMERGENCY => 0);
    /**
     * Construct
     *
     * @param  int                       $level
     * @param  bool                      $bubble
     * @throws MissingExtensionException
     */
    public function __construct($level = \MailPoetVendor\Monolog\Logger::DEBUG, $bubble = \true)
    {
        if (!\function_exists('MailPoetVendor\\zend_monitor_custom_event')) {
            throw new \MailPoetVendor\Monolog\Handler\MissingExtensionException('You must have Zend Server installed in order to use this handler');
        }
        parent::__construct($level, $bubble);
    }
    /**
     * {@inheritdoc}
     */
    protected function write(array $record)
    {
        $this->writeZendMonitorCustomEvent($this->levelMap[$record['level']], $record['message'], $record['formatted']);
    }
    /**
     * Write a record to Zend Monitor
     *
     * @param int    $level
     * @param string $message
     * @param array  $formatted
     */
    protected function writeZendMonitorCustomEvent($level, $message, $formatted)
    {
        zend_monitor_custom_event($level, $message, $formatted);
    }
    /**
     * {@inheritdoc}
     */
    public function getDefaultFormatter()
    {
        return new \MailPoetVendor\Monolog\Formatter\NormalizerFormatter();
    }
    /**
     * Get the level map
     *
     * @return array
     */
    public function getLevelMap()
    {
        return $this->levelMap;
    }
}
