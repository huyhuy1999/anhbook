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
namespace MailPoetVendor\Doctrine\DBAL\Cache;

use MailPoetVendor\Doctrine\Common\Cache\Cache;
/**
 * Query Cache Profile handles the data relevant for query caching.
 *
 * It is a value object, setter methods return NEW instances.
 *
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 */
class QueryCacheProfile
{
    /**
     * @var \MailPoetVendor\Doctrine\Common\Cache\Cache|null
     */
    private $resultCacheDriver;
    /**
     * @var integer
     */
    private $lifetime = 0;
    /**
     * @var string|null
     */
    private $cacheKey;
    /**
     * @param integer                           $lifetime
     * @param string|null                       $cacheKey
     * @param \MailPoetVendor\Doctrine\Common\Cache\Cache|null $resultCache
     */
    public function __construct($lifetime = 0, $cacheKey = null, \MailPoetVendor\Doctrine\Common\Cache\Cache $resultCache = null)
    {
        $this->lifetime = $lifetime;
        $this->cacheKey = $cacheKey;
        $this->resultCacheDriver = $resultCache;
    }
    /**
     * @return \MailPoetVendor\Doctrine\Common\Cache\Cache|null
     */
    public function getResultCacheDriver()
    {
        return $this->resultCacheDriver;
    }
    /**
     * @return integer
     */
    public function getLifetime()
    {
        return $this->lifetime;
    }
    /**
     * @return string
     *
     * @throws \MailPoetVendor\Doctrine\DBAL\Cache\CacheException
     */
    public function getCacheKey()
    {
        if ($this->cacheKey === null) {
            throw \MailPoetVendor\Doctrine\DBAL\Cache\CacheException::noCacheKey();
        }
        return $this->cacheKey;
    }
    /**
     * Generates the real cache key from query, params and types.
     *
     * @param string $query
     * @param array  $params
     * @param array  $types
     *
     * @return array
     */
    public function generateCacheKeys($query, $params, $types)
    {
        $realCacheKey = $query . "-" . \serialize($params) . "-" . \serialize($types);
        // should the key be automatically generated using the inputs or is the cache key set?
        if ($this->cacheKey === null) {
            $cacheKey = \sha1($realCacheKey);
        } else {
            $cacheKey = $this->cacheKey;
        }
        return array($cacheKey, $realCacheKey);
    }
    /**
     * @param \MailPoetVendor\Doctrine\Common\Cache\Cache $cache
     *
     * @return \MailPoetVendor\Doctrine\DBAL\Cache\QueryCacheProfile
     */
    public function setResultCacheDriver(\MailPoetVendor\Doctrine\Common\Cache\Cache $cache)
    {
        return new \MailPoetVendor\Doctrine\DBAL\Cache\QueryCacheProfile($this->lifetime, $this->cacheKey, $cache);
    }
    /**
     * @param string|null $cacheKey
     *
     * @return \MailPoetVendor\Doctrine\DBAL\Cache\QueryCacheProfile
     */
    public function setCacheKey($cacheKey)
    {
        return new \MailPoetVendor\Doctrine\DBAL\Cache\QueryCacheProfile($this->lifetime, $cacheKey, $this->resultCacheDriver);
    }
    /**
     * @param integer $lifetime
     *
     * @return \MailPoetVendor\Doctrine\DBAL\Cache\QueryCacheProfile
     */
    public function setLifetime($lifetime)
    {
        return new \MailPoetVendor\Doctrine\DBAL\Cache\QueryCacheProfile($lifetime, $this->cacheKey, $this->resultCacheDriver);
    }
}
