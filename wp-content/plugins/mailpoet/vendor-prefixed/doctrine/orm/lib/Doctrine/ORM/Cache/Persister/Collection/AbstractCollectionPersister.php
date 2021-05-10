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
namespace MailPoetVendor\Doctrine\ORM\Cache\Persister\Collection;

use MailPoetVendor\Doctrine\Common\Collections\Criteria;
use MailPoetVendor\Doctrine\ORM\Cache\EntityCacheKey;
use MailPoetVendor\Doctrine\ORM\Cache\CollectionCacheKey;
use MailPoetVendor\Doctrine\ORM\Cache\Persister\Entity\CachedEntityPersister;
use MailPoetVendor\Doctrine\ORM\Persisters\Collection\CollectionPersister;
use MailPoetVendor\Doctrine\ORM\PersistentCollection;
use MailPoetVendor\Doctrine\ORM\EntityManagerInterface;
use MailPoetVendor\Doctrine\ORM\Cache\Region;
use MailPoetVendor\Doctrine\Common\Util\ClassUtils;
/**
 * @author Fabio B. Silva <fabio.bat.silva@gmail.com>
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @since 2.5
 */
abstract class AbstractCollectionPersister implements \MailPoetVendor\Doctrine\ORM\Cache\Persister\Collection\CachedCollectionPersister
{
    /**
     * @var \MailPoetVendor\Doctrine\ORM\UnitOfWork
     */
    protected $uow;
    /**
     * @var \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadataFactory
     */
    protected $metadataFactory;
    /**
     * @var \MailPoetVendor\Doctrine\ORM\Persisters\Collection\CollectionPersister
     */
    protected $persister;
    /**
     * @var \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata
     */
    protected $sourceEntity;
    /**
     * @var \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata
     */
    protected $targetEntity;
    /**
     * @var array
     */
    protected $association;
    /**
     * @var array
     */
    protected $queuedCache = array();
    /**
     * @var \MailPoetVendor\Doctrine\ORM\Cache\Region
     */
    protected $region;
    /**
     * @var string
     */
    protected $regionName;
    /**
     * @var \MailPoetVendor\Doctrine\ORM\Cache\CollectionHydrator
     */
    protected $hydrator;
    /**
     * @var \MailPoetVendor\Doctrine\ORM\Cache\Logging\CacheLogger
     */
    protected $cacheLogger;
    /**
     * @param \MailPoetVendor\Doctrine\ORM\Persisters\Collection\CollectionPersister $persister   The collection persister that will be cached.
     * @param \MailPoetVendor\Doctrine\ORM\Cache\Region                              $region      The collection region.
     * @param \MailPoetVendor\Doctrine\ORM\EntityManagerInterface                    $em          The entity manager.
     * @param array                                                   $association The association mapping.
     */
    public function __construct(\MailPoetVendor\Doctrine\ORM\Persisters\Collection\CollectionPersister $persister, \MailPoetVendor\Doctrine\ORM\Cache\Region $region, \MailPoetVendor\Doctrine\ORM\EntityManagerInterface $em, array $association)
    {
        $configuration = $em->getConfiguration();
        $cacheConfig = $configuration->getSecondLevelCacheConfiguration();
        $cacheFactory = $cacheConfig->getCacheFactory();
        $this->region = $region;
        $this->persister = $persister;
        $this->association = $association;
        $this->regionName = $region->getName();
        $this->uow = $em->getUnitOfWork();
        $this->metadataFactory = $em->getMetadataFactory();
        $this->cacheLogger = $cacheConfig->getCacheLogger();
        $this->hydrator = $cacheFactory->buildCollectionHydrator($em, $association);
        $this->sourceEntity = $em->getClassMetadata($association['sourceEntity']);
        $this->targetEntity = $em->getClassMetadata($association['targetEntity']);
    }
    /**
     * {@inheritdoc}
     */
    public function getCacheRegion()
    {
        return $this->region;
    }
    /**
     * {@inheritdoc}
     */
    public function getSourceEntityMetadata()
    {
        return $this->sourceEntity;
    }
    /**
     * {@inheritdoc}
     */
    public function getTargetEntityMetadata()
    {
        return $this->targetEntity;
    }
    /**
     * @param \MailPoetVendor\Doctrine\ORM\PersistentCollection     $collection
     * @param \MailPoetVendor\Doctrine\ORM\Cache\CollectionCacheKey $key
     *
     * @return \MailPoetVendor\Doctrine\ORM\PersistentCollection|null
     */
    public function loadCollectionCache(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection, \MailPoetVendor\Doctrine\ORM\Cache\CollectionCacheKey $key)
    {
        if (($cache = $this->region->get($key)) === null) {
            return null;
        }
        if (($cache = $this->hydrator->loadCacheEntry($this->sourceEntity, $key, $cache, $collection)) === null) {
            return null;
        }
        return $cache;
    }
    /**
     * {@inheritdoc}
     */
    public function storeCollectionCache(\MailPoetVendor\Doctrine\ORM\Cache\CollectionCacheKey $key, $elements)
    {
        /* @var $targetPersister CachedEntityPersister */
        $associationMapping = $this->sourceEntity->associationMappings[$key->association];
        $targetPersister = $this->uow->getEntityPersister($this->targetEntity->rootEntityName);
        $targetRegion = $targetPersister->getCacheRegion();
        $targetHydrator = $targetPersister->getEntityHydrator();
        // Only preserve ordering if association configured it
        if (!(isset($associationMapping['indexBy']) && $associationMapping['indexBy'])) {
            // Elements may be an array or a Collection
            $elements = \array_values(\is_array($elements) ? $elements : $elements->getValues());
        }
        $entry = $this->hydrator->buildCacheEntry($this->targetEntity, $key, $elements);
        foreach ($entry->identifiers as $index => $entityKey) {
            if ($targetRegion->contains($entityKey)) {
                continue;
            }
            $class = $this->targetEntity;
            $className = \MailPoetVendor\Doctrine\Common\Util\ClassUtils::getClass($elements[$index]);
            if ($className !== $this->targetEntity->name) {
                $class = $this->metadataFactory->getMetadataFor($className);
            }
            $entity = $elements[$index];
            $entityEntry = $targetHydrator->buildCacheEntry($class, $entityKey, $entity);
            $targetRegion->put($entityKey, $entityEntry);
        }
        $cached = $this->region->put($key, $entry);
        if ($this->cacheLogger && $cached) {
            $this->cacheLogger->collectionCachePut($this->regionName, $key);
        }
    }
    /**
     * {@inheritdoc}
     */
    public function contains(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection, $element)
    {
        return $this->persister->contains($collection, $element);
    }
    /**
     * {@inheritdoc}
     */
    public function containsKey(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection, $key)
    {
        return $this->persister->containsKey($collection, $key);
    }
    /**
     * {@inheritdoc}
     */
    public function count(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection)
    {
        $ownerId = $this->uow->getEntityIdentifier($collection->getOwner());
        $key = new \MailPoetVendor\Doctrine\ORM\Cache\CollectionCacheKey($this->sourceEntity->rootEntityName, $this->association['fieldName'], $ownerId);
        $entry = $this->region->get($key);
        if ($entry !== null) {
            return \count($entry->identifiers);
        }
        return $this->persister->count($collection);
    }
    /**
     * {@inheritdoc}
     */
    public function get(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection, $index)
    {
        return $this->persister->get($collection, $index);
    }
    /**
     * {@inheritdoc}
     */
    public function removeElement(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection, $element)
    {
        if ($persisterResult = $this->persister->removeElement($collection, $element)) {
            $this->evictCollectionCache($collection);
            $this->evictElementCache($this->sourceEntity->rootEntityName, $collection->getOwner());
            $this->evictElementCache($this->targetEntity->rootEntityName, $element);
        }
        return $persisterResult;
    }
    /**
     * {@inheritdoc}
     */
    public function slice(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection, $offset, $length = null)
    {
        return $this->persister->slice($collection, $offset, $length);
    }
    /**
     * {@inheritDoc}
     */
    public function loadCriteria(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection, \MailPoetVendor\Doctrine\Common\Collections\Criteria $criteria)
    {
        return $this->persister->loadCriteria($collection, $criteria);
    }
    /**
     * Clears cache entries related to the current collection
     *
     * @param PersistentCollection $collection
     */
    protected function evictCollectionCache(\MailPoetVendor\Doctrine\ORM\PersistentCollection $collection)
    {
        $key = new \MailPoetVendor\Doctrine\ORM\Cache\CollectionCacheKey($this->sourceEntity->rootEntityName, $this->association['fieldName'], $this->uow->getEntityIdentifier($collection->getOwner()));
        $this->region->evict($key);
        if ($this->cacheLogger) {
            $this->cacheLogger->collectionCachePut($this->regionName, $key);
        }
    }
    /**
     * @param string $targetEntity
     * @param object $element
     */
    protected function evictElementCache($targetEntity, $element)
    {
        /* @var $targetPersister CachedEntityPersister */
        $targetPersister = $this->uow->getEntityPersister($targetEntity);
        $targetRegion = $targetPersister->getCacheRegion();
        $key = new \MailPoetVendor\Doctrine\ORM\Cache\EntityCacheKey($targetEntity, $this->uow->getEntityIdentifier($element));
        $targetRegion->evict($key);
        if ($this->cacheLogger) {
            $this->cacheLogger->entityCachePut($targetRegion->getName(), $key);
        }
    }
}
