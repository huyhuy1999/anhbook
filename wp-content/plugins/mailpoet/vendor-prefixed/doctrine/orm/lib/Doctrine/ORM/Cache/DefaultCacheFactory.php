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

use MailPoetVendor\Doctrine\Common\Cache\Cache as CacheAdapter;
use MailPoetVendor\Doctrine\Common\Cache\CacheProvider;
use MailPoetVendor\Doctrine\Common\Cache\MultiGetCache;
use MailPoetVendor\Doctrine\ORM\Cache;
use MailPoetVendor\Doctrine\ORM\Cache\Persister\Collection\NonStrictReadWriteCachedCollectionPersister;
use MailPoetVendor\Doctrine\ORM\Cache\Persister\Collection\ReadOnlyCachedCollectionPersister;
use MailPoetVendor\Doctrine\ORM\Cache\Persister\Collection\ReadWriteCachedCollectionPersister;
use MailPoetVendor\Doctrine\ORM\Cache\Persister\Entity\NonStrictReadWriteCachedEntityPersister;
use MailPoetVendor\Doctrine\ORM\Cache\Persister\Entity\ReadOnlyCachedEntityPersister;
use MailPoetVendor\Doctrine\ORM\Cache\Persister\Entity\ReadWriteCachedEntityPersister;
use MailPoetVendor\Doctrine\ORM\Cache\Region;
use MailPoetVendor\Doctrine\ORM\Cache\Region\DefaultMultiGetRegion;
use MailPoetVendor\Doctrine\ORM\Cache\Region\DefaultRegion;
use MailPoetVendor\Doctrine\ORM\Cache\Region\FileLockRegion;
use MailPoetVendor\Doctrine\ORM\Cache\Region\UpdateTimestampCache;
use MailPoetVendor\Doctrine\ORM\EntityManagerInterface;
use MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata;
use MailPoetVendor\Doctrine\ORM\Persisters\Collection\CollectionPersister;
use MailPoetVendor\Doctrine\ORM\Persisters\Entity\EntityPersister;
/**
 * @since   2.5
 * @author  Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class DefaultCacheFactory implements \MailPoetVendor\Doctrine\ORM\Cache\CacheFactory
{
    /**
     * @var CacheAdapter
     */
    private $cache;
    /**
     * @var \MailPoetVendor\Doctrine\ORM\Cache\RegionsConfiguration
     */
    private $regionsConfig;
    /**
     * @var \MailPoetVendor\Doctrine\ORM\Cache\TimestampRegion|null
     */
    private $timestampRegion;
    /**
     * @var \MailPoetVendor\Doctrine\ORM\Cache\Region[]
     */
    private $regions = array();
    /**
     * @var string|null
     */
    private $fileLockRegionDirectory;
    /**
     * @param RegionsConfiguration $cacheConfig
     * @param CacheAdapter         $cache
     */
    public function __construct(\MailPoetVendor\Doctrine\ORM\Cache\RegionsConfiguration $cacheConfig, \MailPoetVendor\Doctrine\Common\Cache\Cache $cache)
    {
        $this->cache = $cache;
        $this->regionsConfig = $cacheConfig;
    }
    /**
     * @param string $fileLockRegionDirectory
     */
    public function setFileLockRegionDirectory($fileLockRegionDirectory)
    {
        $this->fileLockRegionDirectory = (string) $fileLockRegionDirectory;
    }
    /**
     * @return string
     */
    public function getFileLockRegionDirectory()
    {
        return $this->fileLockRegionDirectory;
    }
    /**
     * @param \MailPoetVendor\Doctrine\ORM\Cache\Region $region
     */
    public function setRegion(\MailPoetVendor\Doctrine\ORM\Cache\Region $region)
    {
        $this->regions[$region->getName()] = $region;
    }
    /**
     * @param \MailPoetVendor\Doctrine\ORM\Cache\TimestampRegion $region
     */
    public function setTimestampRegion(\MailPoetVendor\Doctrine\ORM\Cache\TimestampRegion $region)
    {
        $this->timestampRegion = $region;
    }
    /**
     * {@inheritdoc}
     */
    public function buildCachedEntityPersister(\MailPoetVendor\Doctrine\ORM\EntityManagerInterface $em, \MailPoetVendor\Doctrine\ORM\Persisters\Entity\EntityPersister $persister, \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $metadata)
    {
        $region = $this->getRegion($metadata->cache);
        $usage = $metadata->cache['usage'];
        if ($usage === \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata::CACHE_USAGE_READ_ONLY) {
            return new \MailPoetVendor\Doctrine\ORM\Cache\Persister\Entity\ReadOnlyCachedEntityPersister($persister, $region, $em, $metadata);
        }
        if ($usage === \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata::CACHE_USAGE_NONSTRICT_READ_WRITE) {
            return new \MailPoetVendor\Doctrine\ORM\Cache\Persister\Entity\NonStrictReadWriteCachedEntityPersister($persister, $region, $em, $metadata);
        }
        if ($usage === \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata::CACHE_USAGE_READ_WRITE) {
            return new \MailPoetVendor\Doctrine\ORM\Cache\Persister\Entity\ReadWriteCachedEntityPersister($persister, $region, $em, $metadata);
        }
        throw new \InvalidArgumentException(\sprintf("Unrecognized access strategy type [%s]", $usage));
    }
    /**
     * {@inheritdoc}
     */
    public function buildCachedCollectionPersister(\MailPoetVendor\Doctrine\ORM\EntityManagerInterface $em, \MailPoetVendor\Doctrine\ORM\Persisters\Collection\CollectionPersister $persister, array $mapping)
    {
        $usage = $mapping['cache']['usage'];
        $region = $this->getRegion($mapping['cache']);
        if ($usage === \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata::CACHE_USAGE_READ_ONLY) {
            return new \MailPoetVendor\Doctrine\ORM\Cache\Persister\Collection\ReadOnlyCachedCollectionPersister($persister, $region, $em, $mapping);
        }
        if ($usage === \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata::CACHE_USAGE_NONSTRICT_READ_WRITE) {
            return new \MailPoetVendor\Doctrine\ORM\Cache\Persister\Collection\NonStrictReadWriteCachedCollectionPersister($persister, $region, $em, $mapping);
        }
        if ($usage === \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata::CACHE_USAGE_READ_WRITE) {
            return new \MailPoetVendor\Doctrine\ORM\Cache\Persister\Collection\ReadWriteCachedCollectionPersister($persister, $region, $em, $mapping);
        }
        throw new \InvalidArgumentException(\sprintf("Unrecognized access strategy type [%s]", $usage));
    }
    /**
     * {@inheritdoc}
     */
    public function buildQueryCache(\MailPoetVendor\Doctrine\ORM\EntityManagerInterface $em, $regionName = null)
    {
        return new \MailPoetVendor\Doctrine\ORM\Cache\DefaultQueryCache($em, $this->getRegion(array('region' => $regionName ?: \MailPoetVendor\Doctrine\ORM\Cache::DEFAULT_QUERY_REGION_NAME, 'usage' => \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata::CACHE_USAGE_NONSTRICT_READ_WRITE)));
    }
    /**
     * {@inheritdoc}
     */
    public function buildCollectionHydrator(\MailPoetVendor\Doctrine\ORM\EntityManagerInterface $em, array $mapping)
    {
        return new \MailPoetVendor\Doctrine\ORM\Cache\DefaultCollectionHydrator($em);
    }
    /**
     * {@inheritdoc}
     */
    public function buildEntityHydrator(\MailPoetVendor\Doctrine\ORM\EntityManagerInterface $em, \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $metadata)
    {
        return new \MailPoetVendor\Doctrine\ORM\Cache\DefaultEntityHydrator($em);
    }
    /**
     * {@inheritdoc}
     */
    public function getRegion(array $cache)
    {
        if (isset($this->regions[$cache['region']])) {
            return $this->regions[$cache['region']];
        }
        $cacheAdapter = clone $this->cache;
        if ($cacheAdapter instanceof \MailPoetVendor\Doctrine\Common\Cache\CacheProvider) {
            $cacheAdapter->setNamespace($cache['region']);
        }
        $name = $cache['region'];
        $lifetime = $this->regionsConfig->getLifetime($cache['region']);
        $region = $cacheAdapter instanceof \MailPoetVendor\Doctrine\Common\Cache\MultiGetCache ? new \MailPoetVendor\Doctrine\ORM\Cache\Region\DefaultMultiGetRegion($name, $cacheAdapter, $lifetime) : new \MailPoetVendor\Doctrine\ORM\Cache\Region\DefaultRegion($name, $cacheAdapter, $lifetime);
        if ($cache['usage'] === \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata::CACHE_USAGE_READ_WRITE) {
            if (!$this->fileLockRegionDirectory) {
                throw new \LogicException('If you what to use a "READ_WRITE" cache an implementation of "MailPoetVendor\\Doctrine\\ORM\\Cache\\ConcurrentRegion" is required, ' . 'The default implementation provided by doctrine is "MailPoetVendor\\Doctrine\\ORM\\Cache\\Region\\FileLockRegion" if you what to use it please provide a valid directory, DefaultCacheFactory#setFileLockRegionDirectory(). ');
            }
            $directory = $this->fileLockRegionDirectory . \DIRECTORY_SEPARATOR . $cache['region'];
            $region = new \MailPoetVendor\Doctrine\ORM\Cache\Region\FileLockRegion($region, $directory, $this->regionsConfig->getLockLifetime($cache['region']));
        }
        return $this->regions[$cache['region']] = $region;
    }
    /**
     * {@inheritdoc}
     */
    public function getTimestampRegion()
    {
        if ($this->timestampRegion === null) {
            $name = \MailPoetVendor\Doctrine\ORM\Cache::DEFAULT_TIMESTAMP_REGION_NAME;
            $lifetime = $this->regionsConfig->getLifetime($name);
            $this->timestampRegion = new \MailPoetVendor\Doctrine\ORM\Cache\Region\UpdateTimestampCache($name, clone $this->cache, $lifetime);
        }
        return $this->timestampRegion;
    }
    /**
     * {@inheritdoc}
     */
    public function createCache(\MailPoetVendor\Doctrine\ORM\EntityManagerInterface $em)
    {
        return new \MailPoetVendor\Doctrine\ORM\Cache\DefaultCache($em);
    }
}
