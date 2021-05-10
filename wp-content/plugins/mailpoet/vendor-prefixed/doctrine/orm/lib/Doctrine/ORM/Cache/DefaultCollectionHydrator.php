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

use MailPoetVendor\Doctrine\ORM\Query;
use MailPoetVendor\Doctrine\ORM\PersistentCollection;
use MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata;
use MailPoetVendor\Doctrine\ORM\EntityManagerInterface;
/**
 * Default hydrator cache for collections
 *
 * @since   2.5
 * @author  Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class DefaultCollectionHydrator implements \MailPoetVendor\Doctrine\ORM\Cache\CollectionHydrator
{
    /**
     * @var \MailPoetVendor\Doctrine\ORM\EntityManagerInterface
     */
    private $em;
    /**
     * @var \MailPoetVendor\Doctrine\ORM\UnitOfWork
     */
    private $uow;
    /**
     * @var array
     */
    private static $hints = array(\MailPoetVendor\Doctrine\ORM\Query::HINT_CACHE_ENABLED => \true);
    /**
     * @param \MailPoetVendor\Doctrine\ORM\EntityManagerInterface $em The entity manager.
     */
    public function __construct(\MailPoetVendor\Doctrine\ORM\EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->uow = $em->getUnitOfWork();
    }
    /**
     * {@inheritdoc}
     */
    public function buildCacheEntry(\MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $metadata, \MailPoetVendor\Doctrine\ORM\Cache\CollectionCacheKey $key, $collection)
    {
        $data = array();
        foreach ($collection as $index => $entity) {
            $data[$index] = new \MailPoetVendor\Doctrine\ORM\Cache\EntityCacheKey($metadata->name, $this->uow->getEntityIdentifier($entity));
        }
        return new \MailPoetVendor\Doctrine\ORM\Cache\CollectionCacheEntry($data);
    }
    /**
     * {@inheritdoc}
     */
    public function loadCacheEntry(\MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $metadata, \MailPoetVendor\Doctrine\ORM\Cache\CollectionCacheKey $key, \MailPoetVendor\Doctrine\ORM\Cache\CollectionCacheEntry $entry, \MailPoetVendor\Doctrine\ORM\PersistentCollection $collection)
    {
        $assoc = $metadata->associationMappings[$key->association];
        /* @var $targetPersister \MailPoetVendor\Doctrine\ORM\Cache\Persister\CachedPersister */
        $targetPersister = $this->uow->getEntityPersister($assoc['targetEntity']);
        $targetRegion = $targetPersister->getCacheRegion();
        $list = array();
        $entityEntries = $targetRegion->getMultiple($entry);
        if ($entityEntries === null) {
            return null;
        }
        /* @var $entityEntries \MailPoetVendor\Doctrine\ORM\Cache\EntityCacheEntry[] */
        foreach ($entityEntries as $index => $entityEntry) {
            $list[$index] = $this->uow->createEntity($entityEntry->class, $entityEntry->resolveAssociationEntries($this->em), self::$hints);
        }
        \array_walk($list, function ($entity, $index) use($collection) {
            $collection->hydrateSet($index, $entity);
        });
        $this->uow->hydrationComplete();
        return $list;
    }
}
