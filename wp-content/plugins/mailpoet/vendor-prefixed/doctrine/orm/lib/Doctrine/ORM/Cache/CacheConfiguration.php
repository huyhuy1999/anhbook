<?php

/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */
namespace MailPoetVendor\Doctrine\ORM\Cache;

use MailPoetVendor\Doctrine\ORM\Cache\Logging\CacheLogger;
/**
 * Configuration container for second-level cache.
 *
 * @since   2.5
 * @author  Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class CacheConfiguration
{
    /**
     * @var \MailPoetVendor\Doctrine\ORM\Cache\CacheFactory|null
     */
    private $cacheFactory;
    /**
     * @var \MailPoetVendor\Doctrine\ORM\Cache\RegionsConfiguration|null
     */
    private $regionsConfig;
    /**
     * @var \MailPoetVendor\Doctrine\ORM\Cache\Logging\CacheLogger|null
     */
    private $cacheLogger;
    /**
     * @var \MailPoetVendor\Doctrine\ORM\Cache\QueryCacheValidator|null
     */
    private $queryValidator;
    /**
     * @return \MailPoetVendor\Doctrine\ORM\Cache\CacheFactory|null
     */
    public function getCacheFactory()
    {
        return $this->cacheFactory;
    }
    /**
     * @param \MailPoetVendor\Doctrine\ORM\Cache\CacheFactory $factory
     *
     * @return void
     */
    public function setCacheFactory(\MailPoetVendor\Doctrine\ORM\Cache\CacheFactory $factory)
    {
        $this->cacheFactory = $factory;
    }
    /**
     * @return \MailPoetVendor\Doctrine\ORM\Cache\Logging\CacheLogger|null
     */
    public function getCacheLogger()
    {
        return $this->cacheLogger;
    }
    /**
     * @param \MailPoetVendor\Doctrine\ORM\Cache\Logging\CacheLogger $logger
     */
    public function setCacheLogger(\MailPoetVendor\Doctrine\ORM\Cache\Logging\CacheLogger $logger)
    {
        $this->cacheLogger = $logger;
    }
    /**
     * @return \MailPoetVendor\Doctrine\ORM\Cache\RegionsConfiguration
     */
    public function getRegionsConfiguration()
    {
        if ($this->regionsConfig === null) {
            $this->regionsConfig = new \MailPoetVendor\Doctrine\ORM\Cache\RegionsConfiguration();
        }
        return $this->regionsConfig;
    }
    /**
     * @param \MailPoetVendor\Doctrine\ORM\Cache\RegionsConfiguration $regionsConfig
     */
    public function setRegionsConfiguration(\MailPoetVendor\Doctrine\ORM\Cache\RegionsConfiguration $regionsConfig)
    {
        $this->regionsConfig = $regionsConfig;
    }
    /**
     * @return \MailPoetVendor\Doctrine\ORM\Cache\QueryCacheValidator
     */
    public function getQueryValidator()
    {
        if ($this->queryValidator === null) {
            $this->queryValidator = new \MailPoetVendor\Doctrine\ORM\Cache\TimestampQueryCacheValidator($this->cacheFactory->getTimestampRegion());
        }
        return $this->queryValidator;
    }
    /**
     * @param \MailPoetVendor\Doctrine\ORM\Cache\QueryCacheValidator $validator
     */
    public function setQueryValidator(\MailPoetVendor\Doctrine\ORM\Cache\QueryCacheValidator $validator)
    {
        $this->queryValidator = $validator;
    }
}
