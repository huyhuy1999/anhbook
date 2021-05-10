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
namespace MailPoetVendor\Doctrine\ORM;

use Exception;
use MailPoetVendor\Doctrine\Common\EventManager;
use MailPoetVendor\Doctrine\DBAL\Connection;
use MailPoetVendor\Doctrine\DBAL\LockMode;
use MailPoetVendor\Doctrine\ORM\Query\ResultSetMapping;
use MailPoetVendor\Doctrine\ORM\Proxy\ProxyFactory;
use MailPoetVendor\Doctrine\ORM\Query\FilterCollection;
use MailPoetVendor\Doctrine\Common\Util\ClassUtils;
/**
 * The EntityManager is the central access point to ORM functionality.
 *
 * It is a facade to all different ORM subsystems such as UnitOfWork,
 * Query Language and Repository API. Instantiation is done through
 * the static create() method. The quickest way to obtain a fully
 * configured EntityManager is:
 *
 *     use Doctrine\ORM\Tools\Setup;
 *     use Doctrine\ORM\EntityManager;
 *
 *     $paths = array('/path/to/entity/mapping/files');
 *
 *     $config = Setup::createAnnotationMetadataConfiguration($paths);
 *     $dbParams = array('driver' => 'pdo_sqlite', 'memory' => true);
 *     $entityManager = EntityManager::create($dbParams, $config);
 *
 * For more information see
 * {@link http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/configuration.html}
 *
 * You should never attempt to inherit from the EntityManager: Inheritance
 * is not a valid extension point for the EntityManager. Instead you
 * should take a look at the {@see \MailPoetVendor\Doctrine\ORM\Decorator\EntityManagerDecorator}
 * and wrap your entity manager in a decorator.
 *
 * @since   2.0
 * @author  Benjamin Eberlei <kontakt@beberlei.de>
 * @author  Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author  Jonathan Wage <jonwage@gmail.com>
 * @author  Roman Borschel <roman@code-factory.org>
 */
/* final */
class EntityManager implements \MailPoetVendor\Doctrine\ORM\EntityManagerInterface
{
    /**
     * The used Configuration.
     *
     * @var \MailPoetVendor\Doctrine\ORM\Configuration
     */
    private $config;
    /**
     * The database connection used by the EntityManager.
     *
     * @var \MailPoetVendor\Doctrine\DBAL\Connection
     */
    private $conn;
    /**
     * The metadata factory, used to retrieve the ORM metadata of entity classes.
     *
     * @var \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadataFactory
     */
    private $metadataFactory;
    /**
     * The UnitOfWork used to coordinate object-level transactions.
     *
     * @var \MailPoetVendor\Doctrine\ORM\UnitOfWork
     */
    private $unitOfWork;
    /**
     * The event manager that is the central point of the event system.
     *
     * @var \MailPoetVendor\Doctrine\Common\EventManager
     */
    private $eventManager;
    /**
     * The proxy factory used to create dynamic proxies.
     *
     * @var \MailPoetVendor\Doctrine\ORM\Proxy\ProxyFactory
     */
    private $proxyFactory;
    /**
     * The repository factory used to create dynamic repositories.
     *
     * @var \MailPoetVendor\Doctrine\ORM\Repository\RepositoryFactory
     */
    private $repositoryFactory;
    /**
     * The expression builder instance used to generate query expressions.
     *
     * @var \MailPoetVendor\Doctrine\ORM\Query\Expr
     */
    private $expressionBuilder;
    /**
     * Whether the EntityManager is closed or not.
     *
     * @var bool
     */
    private $closed = \false;
    /**
     * Collection of query filters.
     *
     * @var \MailPoetVendor\Doctrine\ORM\Query\FilterCollection
     */
    private $filterCollection;
    /**
     * @var \MailPoetVendor\Doctrine\ORM\Cache The second level cache regions API.
     */
    private $cache;
    /**
     * Creates a new EntityManager that operates on the given database connection
     * and uses the given Configuration and EventManager implementations.
     *
     * @param \MailPoetVendor\Doctrine\DBAL\Connection     $conn
     * @param \MailPoetVendor\Doctrine\ORM\Configuration   $config
     * @param \MailPoetVendor\Doctrine\Common\EventManager $eventManager
     */
    protected function __construct(\MailPoetVendor\Doctrine\DBAL\Connection $conn, \MailPoetVendor\Doctrine\ORM\Configuration $config, \MailPoetVendor\Doctrine\Common\EventManager $eventManager)
    {
        $this->conn = $conn;
        $this->config = $config;
        $this->eventManager = $eventManager;
        $metadataFactoryClassName = $config->getClassMetadataFactoryName();
        $this->metadataFactory = new $metadataFactoryClassName();
        $this->metadataFactory->setEntityManager($this);
        $this->metadataFactory->setCacheDriver($this->config->getMetadataCacheImpl());
        $this->repositoryFactory = $config->getRepositoryFactory();
        $this->unitOfWork = new \MailPoetVendor\Doctrine\ORM\UnitOfWork($this);
        $this->proxyFactory = new \MailPoetVendor\Doctrine\ORM\Proxy\ProxyFactory($this, $config->getProxyDir(), $config->getProxyNamespace(), $config->getAutoGenerateProxyClasses());
        if ($config->isSecondLevelCacheEnabled()) {
            $cacheConfig = $config->getSecondLevelCacheConfiguration();
            $cacheFactory = $cacheConfig->getCacheFactory();
            $this->cache = $cacheFactory->createCache($this);
        }
    }
    /**
     * {@inheritDoc}
     */
    public function getConnection()
    {
        return $this->conn;
    }
    /**
     * Gets the metadata factory used to gather the metadata of classes.
     *
     * @return \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadataFactory
     */
    public function getMetadataFactory()
    {
        return $this->metadataFactory;
    }
    /**
     * {@inheritDoc}
     */
    public function getExpressionBuilder()
    {
        if ($this->expressionBuilder === null) {
            $this->expressionBuilder = new \MailPoetVendor\Doctrine\ORM\Query\Expr();
        }
        return $this->expressionBuilder;
    }
    /**
     * {@inheritDoc}
     */
    public function beginTransaction()
    {
        $this->conn->beginTransaction();
    }
    /**
     * {@inheritDoc}
     */
    public function getCache()
    {
        return $this->cache;
    }
    /**
     * {@inheritDoc}
     */
    public function transactional($func)
    {
        if (!\is_callable($func)) {
            throw new \InvalidArgumentException('Expected argument of type "callable", got "' . \gettype($func) . '"');
        }
        $this->conn->beginTransaction();
        try {
            $return = \call_user_func($func, $this);
            $this->flush();
            $this->conn->commit();
            return $return ?: \true;
        } catch (\Exception $e) {
            $this->close();
            $this->conn->rollback();
            throw $e;
        }
    }
    /**
     * {@inheritDoc}
     */
    public function commit()
    {
        $this->conn->commit();
    }
    /**
     * {@inheritDoc}
     */
    public function rollback()
    {
        $this->conn->rollback();
    }
    /**
     * Returns the ORM metadata descriptor for a class.
     *
     * The class name must be the fully-qualified class name without a leading backslash
     * (as it is returned by get_class($obj)) or an aliased class name.
     *
     * Examples:
     * MyProject\Domain\User
     * sales:PriceRequest
     *
     * Internal note: Performance-sensitive method.
     *
     * @param string $className
     *
     * @return \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata
     */
    public function getClassMetadata($className)
    {
        return $this->metadataFactory->getMetadataFor($className);
    }
    /**
     * {@inheritDoc}
     */
    public function createQuery($dql = '')
    {
        $query = new \MailPoetVendor\Doctrine\ORM\Query($this);
        if (!empty($dql)) {
            $query->setDql($dql);
        }
        return $query;
    }
    /**
     * {@inheritDoc}
     */
    public function createNamedQuery($name)
    {
        return $this->createQuery($this->config->getNamedQuery($name));
    }
    /**
     * {@inheritDoc}
     */
    public function createNativeQuery($sql, \MailPoetVendor\Doctrine\ORM\Query\ResultSetMapping $rsm)
    {
        $query = new \MailPoetVendor\Doctrine\ORM\NativeQuery($this);
        $query->setSql($sql);
        $query->setResultSetMapping($rsm);
        return $query;
    }
    /**
     * {@inheritDoc}
     */
    public function createNamedNativeQuery($name)
    {
        list($sql, $rsm) = $this->config->getNamedNativeQuery($name);
        return $this->createNativeQuery($sql, $rsm);
    }
    /**
     * {@inheritDoc}
     */
    public function createQueryBuilder()
    {
        return new \MailPoetVendor\Doctrine\ORM\QueryBuilder($this);
    }
    /**
     * Flushes all changes to objects that have been queued up to now to the database.
     * This effectively synchronizes the in-memory state of managed objects with the
     * database.
     *
     * If an entity is explicitly passed to this method only this entity and
     * the cascade-persist semantics + scheduled inserts/removals are synchronized.
     *
     * @param null|object|array $entity
     *
     * @return void
     *
     * @throws \MailPoetVendor\Doctrine\ORM\OptimisticLockException If a version check on an entity that
     *         makes use of optimistic locking fails.
     */
    public function flush($entity = null)
    {
        $this->errorIfClosed();
        $this->unitOfWork->commit($entity);
    }
    /**
     * Finds an Entity by its identifier.
     *
     * @param string       $entityName  The class name of the entity to find.
     * @param mixed        $id          The identity of the entity to find.
     * @param integer|null $lockMode    One of the \MailPoetVendor\Doctrine\DBAL\LockMode::* constants
     *                                  or NULL if no specific lock mode should be used
     *                                  during the search.
     * @param integer|null $lockVersion The version of the entity to find when using
     *                                  optimistic locking.
     *
     * @return object|null The entity instance or NULL if the entity can not be found.
     *
     * @throws OptimisticLockException
     * @throws ORMInvalidArgumentException
     * @throws TransactionRequiredException
     * @throws ORMException
     */
    public function find($entityName, $id, $lockMode = null, $lockVersion = null)
    {
        $class = $this->metadataFactory->getMetadataFor(\ltrim($entityName, '\\'));
        if (!\is_array($id)) {
            if ($class->isIdentifierComposite) {
                throw \MailPoetVendor\Doctrine\ORM\ORMInvalidArgumentException::invalidCompositeIdentifier();
            }
            $id = array($class->identifier[0] => $id);
        }
        foreach ($id as $i => $value) {
            if (\is_object($value) && $this->metadataFactory->hasMetadataFor(\MailPoetVendor\Doctrine\Common\Util\ClassUtils::getClass($value))) {
                $id[$i] = $this->unitOfWork->getSingleIdentifierValue($value);
                if ($id[$i] === null) {
                    throw \MailPoetVendor\Doctrine\ORM\ORMInvalidArgumentException::invalidIdentifierBindingEntity();
                }
            }
        }
        $sortedId = array();
        foreach ($class->identifier as $identifier) {
            if (!isset($id[$identifier])) {
                throw \MailPoetVendor\Doctrine\ORM\ORMException::missingIdentifierField($class->name, $identifier);
            }
            $sortedId[$identifier] = $id[$identifier];
            unset($id[$identifier]);
        }
        if ($id) {
            throw \MailPoetVendor\Doctrine\ORM\ORMException::unrecognizedIdentifierFields($class->name, \array_keys($id));
        }
        $unitOfWork = $this->getUnitOfWork();
        // Check identity map first
        if (($entity = $unitOfWork->tryGetById($sortedId, $class->rootEntityName)) !== \false) {
            if (!$entity instanceof $class->name) {
                return null;
            }
            switch (\true) {
                case \MailPoetVendor\Doctrine\DBAL\LockMode::OPTIMISTIC === $lockMode:
                    $this->lock($entity, $lockMode, $lockVersion);
                    break;
                case \MailPoetVendor\Doctrine\DBAL\LockMode::NONE === $lockMode:
                case \MailPoetVendor\Doctrine\DBAL\LockMode::PESSIMISTIC_READ === $lockMode:
                case \MailPoetVendor\Doctrine\DBAL\LockMode::PESSIMISTIC_WRITE === $lockMode:
                    $persister = $unitOfWork->getEntityPersister($class->name);
                    $persister->refresh($sortedId, $entity, $lockMode);
                    break;
            }
            return $entity;
            // Hit!
        }
        $persister = $unitOfWork->getEntityPersister($class->name);
        switch (\true) {
            case \MailPoetVendor\Doctrine\DBAL\LockMode::OPTIMISTIC === $lockMode:
                if (!$class->isVersioned) {
                    throw \MailPoetVendor\Doctrine\ORM\OptimisticLockException::notVersioned($class->name);
                }
                $entity = $persister->load($sortedId);
                $unitOfWork->lock($entity, $lockMode, $lockVersion);
                return $entity;
            case \MailPoetVendor\Doctrine\DBAL\LockMode::NONE === $lockMode:
            case \MailPoetVendor\Doctrine\DBAL\LockMode::PESSIMISTIC_READ === $lockMode:
            case \MailPoetVendor\Doctrine\DBAL\LockMode::PESSIMISTIC_WRITE === $lockMode:
                if (!$this->getConnection()->isTransactionActive()) {
                    throw \MailPoetVendor\Doctrine\ORM\TransactionRequiredException::transactionRequired();
                }
                return $persister->load($sortedId, null, null, array(), $lockMode);
            default:
                return $persister->loadById($sortedId);
        }
    }
    /**
     * {@inheritDoc}
     */
    public function getReference($entityName, $id)
    {
        $class = $this->metadataFactory->getMetadataFor(\ltrim($entityName, '\\'));
        if (!\is_array($id)) {
            $id = array($class->identifier[0] => $id);
        }
        $sortedId = array();
        foreach ($class->identifier as $identifier) {
            if (!isset($id[$identifier])) {
                throw \MailPoetVendor\Doctrine\ORM\ORMException::missingIdentifierField($class->name, $identifier);
            }
            $sortedId[$identifier] = $id[$identifier];
        }
        // Check identity map first, if its already in there just return it.
        if (($entity = $this->unitOfWork->tryGetById($sortedId, $class->rootEntityName)) !== \false) {
            return $entity instanceof $class->name ? $entity : null;
        }
        if ($class->subClasses) {
            return $this->find($entityName, $sortedId);
        }
        if (!\is_array($sortedId)) {
            $sortedId = array($class->identifier[0] => $sortedId);
        }
        $entity = $this->proxyFactory->getProxy($class->name, $sortedId);
        $this->unitOfWork->registerManaged($entity, $sortedId, array());
        return $entity;
    }
    /**
     * {@inheritDoc}
     */
    public function getPartialReference($entityName, $identifier)
    {
        $class = $this->metadataFactory->getMetadataFor(\ltrim($entityName, '\\'));
        // Check identity map first, if its already in there just return it.
        if (($entity = $this->unitOfWork->tryGetById($identifier, $class->rootEntityName)) !== \false) {
            return $entity instanceof $class->name ? $entity : null;
        }
        if (!\is_array($identifier)) {
            $identifier = array($class->identifier[0] => $identifier);
        }
        $entity = $class->newInstance();
        $class->setIdentifierValues($entity, $identifier);
        $this->unitOfWork->registerManaged($entity, $identifier, array());
        $this->unitOfWork->markReadOnly($entity);
        return $entity;
    }
    /**
     * Clears the EntityManager. All entities that are currently managed
     * by this EntityManager become detached.
     *
     * @param string|null $entityName if given, only entities of this type will get detached
     *
     * @return void
     */
    public function clear($entityName = null)
    {
        $this->unitOfWork->clear($entityName);
    }
    /**
     * {@inheritDoc}
     */
    public function close()
    {
        $this->clear();
        $this->closed = \true;
    }
    /**
     * Tells the EntityManager to make an instance managed and persistent.
     *
     * The entity will be entered into the database at or before transaction
     * commit or as a result of the flush operation.
     *
     * NOTE: The persist operation always considers entities that are not yet known to
     * this EntityManager as NEW. Do not pass detached entities to the persist operation.
     *
     * @param object $entity The instance to make managed and persistent.
     *
     * @return void
     *
     * @throws ORMInvalidArgumentException
     */
    public function persist($entity)
    {
        if (!\is_object($entity)) {
            throw \MailPoetVendor\Doctrine\ORM\ORMInvalidArgumentException::invalidObject('EntityManager#persist()', $entity);
        }
        $this->errorIfClosed();
        $this->unitOfWork->persist($entity);
    }
    /**
     * Removes an entity instance.
     *
     * A removed entity will be removed from the database at or before transaction commit
     * or as a result of the flush operation.
     *
     * @param object $entity The entity instance to remove.
     *
     * @return void
     *
     * @throws ORMInvalidArgumentException
     */
    public function remove($entity)
    {
        if (!\is_object($entity)) {
            throw \MailPoetVendor\Doctrine\ORM\ORMInvalidArgumentException::invalidObject('EntityManager#remove()', $entity);
        }
        $this->errorIfClosed();
        $this->unitOfWork->remove($entity);
    }
    /**
     * Refreshes the persistent state of an entity from the database,
     * overriding any local changes that have not yet been persisted.
     *
     * @param object $entity The entity to refresh.
     *
     * @return void
     *
     * @throws ORMInvalidArgumentException
     */
    public function refresh($entity)
    {
        if (!\is_object($entity)) {
            throw \MailPoetVendor\Doctrine\ORM\ORMInvalidArgumentException::invalidObject('EntityManager#refresh()', $entity);
        }
        $this->errorIfClosed();
        $this->unitOfWork->refresh($entity);
    }
    /**
     * Detaches an entity from the EntityManager, causing a managed entity to
     * become detached.  Unflushed changes made to the entity if any
     * (including removal of the entity), will not be synchronized to the database.
     * Entities which previously referenced the detached entity will continue to
     * reference it.
     *
     * @param object $entity The entity to detach.
     *
     * @return void
     *
     * @throws ORMInvalidArgumentException
     */
    public function detach($entity)
    {
        if (!\is_object($entity)) {
            throw \MailPoetVendor\Doctrine\ORM\ORMInvalidArgumentException::invalidObject('EntityManager#detach()', $entity);
        }
        $this->unitOfWork->detach($entity);
    }
    /**
     * Merges the state of a detached entity into the persistence context
     * of this EntityManager and returns the managed copy of the entity.
     * The entity passed to merge will not become associated/managed with this EntityManager.
     *
     * @param object $entity The detached entity to merge into the persistence context.
     *
     * @return object The managed copy of the entity.
     *
     * @throws ORMInvalidArgumentException
     */
    public function merge($entity)
    {
        if (!\is_object($entity)) {
            throw \MailPoetVendor\Doctrine\ORM\ORMInvalidArgumentException::invalidObject('EntityManager#merge()', $entity);
        }
        $this->errorIfClosed();
        return $this->unitOfWork->merge($entity);
    }
    /**
     * {@inheritDoc}
     *
     * @todo Implementation need. This is necessary since $e2 = clone $e1; throws an E_FATAL when access anything on $e:
     * Fatal error: Maximum function nesting level of '100' reached, aborting!
     */
    public function copy($entity, $deep = \false)
    {
        throw new \BadMethodCallException("Not implemented.");
    }
    /**
     * {@inheritDoc}
     */
    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->unitOfWork->lock($entity, $lockMode, $lockVersion);
    }
    /**
     * Gets the repository for an entity class.
     *
     * @param string $entityName The name of the entity.
     *
     * @return \MailPoetVendor\Doctrine\ORM\EntityRepository The repository class.
     */
    public function getRepository($entityName)
    {
        return $this->repositoryFactory->getRepository($this, $entityName);
    }
    /**
     * Determines whether an entity instance is managed in this EntityManager.
     *
     * @param object $entity
     *
     * @return boolean TRUE if this EntityManager currently manages the given entity, FALSE otherwise.
     */
    public function contains($entity)
    {
        return $this->unitOfWork->isScheduledForInsert($entity) || $this->unitOfWork->isInIdentityMap($entity) && !$this->unitOfWork->isScheduledForDelete($entity);
    }
    /**
     * {@inheritDoc}
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }
    /**
     * {@inheritDoc}
     */
    public function getConfiguration()
    {
        return $this->config;
    }
    /**
     * Throws an exception if the EntityManager is closed or currently not active.
     *
     * @return void
     *
     * @throws ORMException If the EntityManager is closed.
     */
    private function errorIfClosed()
    {
        if ($this->closed) {
            throw \MailPoetVendor\Doctrine\ORM\ORMException::entityManagerClosed();
        }
    }
    /**
     * {@inheritDoc}
     */
    public function isOpen()
    {
        return !$this->closed;
    }
    /**
     * {@inheritDoc}
     */
    public function getUnitOfWork()
    {
        return $this->unitOfWork;
    }
    /**
     * {@inheritDoc}
     */
    public function getHydrator($hydrationMode)
    {
        return $this->newHydrator($hydrationMode);
    }
    /**
     * {@inheritDoc}
     */
    public function newHydrator($hydrationMode)
    {
        switch ($hydrationMode) {
            case \MailPoetVendor\Doctrine\ORM\Query::HYDRATE_OBJECT:
                return new \MailPoetVendor\Doctrine\ORM\Internal\Hydration\ObjectHydrator($this);
            case \MailPoetVendor\Doctrine\ORM\Query::HYDRATE_ARRAY:
                return new \MailPoetVendor\Doctrine\ORM\Internal\Hydration\ArrayHydrator($this);
            case \MailPoetVendor\Doctrine\ORM\Query::HYDRATE_SCALAR:
                return new \MailPoetVendor\Doctrine\ORM\Internal\Hydration\ScalarHydrator($this);
            case \MailPoetVendor\Doctrine\ORM\Query::HYDRATE_SINGLE_SCALAR:
                return new \MailPoetVendor\Doctrine\ORM\Internal\Hydration\SingleScalarHydrator($this);
            case \MailPoetVendor\Doctrine\ORM\Query::HYDRATE_SIMPLEOBJECT:
                return new \MailPoetVendor\Doctrine\ORM\Internal\Hydration\SimpleObjectHydrator($this);
            default:
                if (($class = $this->config->getCustomHydrationMode($hydrationMode)) !== null) {
                    return new $class($this);
                }
        }
        throw \MailPoetVendor\Doctrine\ORM\ORMException::invalidHydrationMode($hydrationMode);
    }
    /**
     * {@inheritDoc}
     */
    public function getProxyFactory()
    {
        return $this->proxyFactory;
    }
    /**
     * {@inheritDoc}
     */
    public function initializeObject($obj)
    {
        $this->unitOfWork->initializeObject($obj);
    }
    /**
     * Factory method to create EntityManager instances.
     *
     * @param mixed         $conn         An array with the connection parameters or an existing Connection instance.
     * @param Configuration $config       The Configuration instance to use.
     * @param EventManager  $eventManager The EventManager instance to use.
     *
     * @return EntityManager The created EntityManager.
     *
     * @throws \InvalidArgumentException
     * @throws ORMException
     */
    public static function create($conn, \MailPoetVendor\Doctrine\ORM\Configuration $config, \MailPoetVendor\Doctrine\Common\EventManager $eventManager = null)
    {
        if (!$config->getMetadataDriverImpl()) {
            throw \MailPoetVendor\Doctrine\ORM\ORMException::missingMappingDriverImpl();
        }
        switch (\true) {
            case \is_array($conn):
                $conn = \MailPoetVendor\Doctrine\DBAL\DriverManager::getConnection($conn, $config, $eventManager ?: new \MailPoetVendor\Doctrine\Common\EventManager());
                break;
            case $conn instanceof \MailPoetVendor\Doctrine\DBAL\Connection:
                if ($eventManager !== null && $conn->getEventManager() !== $eventManager) {
                    throw \MailPoetVendor\Doctrine\ORM\ORMException::mismatchedEventManager();
                }
                break;
            default:
                throw new \InvalidArgumentException("Invalid argument: " . $conn);
        }
        return new \MailPoetVendor\Doctrine\ORM\EntityManager($conn, $config, $conn->getEventManager());
    }
    /**
     * {@inheritDoc}
     */
    public function getFilters()
    {
        if (null === $this->filterCollection) {
            $this->filterCollection = new \MailPoetVendor\Doctrine\ORM\Query\FilterCollection($this);
        }
        return $this->filterCollection;
    }
    /**
     * {@inheritDoc}
     */
    public function isFiltersStateClean()
    {
        return null === $this->filterCollection || $this->filterCollection->isClean();
    }
    /**
     * {@inheritDoc}
     */
    public function hasFilters()
    {
        return null !== $this->filterCollection;
    }
}
