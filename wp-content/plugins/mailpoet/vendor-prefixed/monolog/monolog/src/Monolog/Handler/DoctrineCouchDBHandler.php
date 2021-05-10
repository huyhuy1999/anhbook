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

use MailPoetVendor\Monolog\Logger;
use MailPoetVendor\Monolog\Formatter\NormalizerFormatter;
use MailPoetVendor\Doctrine\CouchDB\CouchDBClient;
/**
 * CouchDB handler for Doctrine CouchDB ODM
 *
 * @author Markus Bachmann <markus.bachmann@bachi.biz>
 */
class DoctrineCouchDBHandler extends \MailPoetVendor\Monolog\Handler\AbstractProcessingHandler
{
    private $client;
    public function __construct(\MailPoetVendor\Doctrine\CouchDB\CouchDBClient $client, $level = \MailPoetVendor\Monolog\Logger::DEBUG, $bubble = \true)
    {
        $this->client = $client;
        parent::__construct($level, $bubble);
    }
    /**
     * {@inheritDoc}
     */
    protected function write(array $record)
    {
        $this->client->postDocument($record['formatted']);
    }
    protected function getDefaultFormatter()
    {
        return new \MailPoetVendor\Monolog\Formatter\NormalizerFormatter();
    }
}
