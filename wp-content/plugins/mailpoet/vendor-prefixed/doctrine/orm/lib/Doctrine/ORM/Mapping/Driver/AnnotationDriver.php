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
namespace MailPoetVendor\Doctrine\ORM\Mapping\Driver;

use MailPoetVendor\Doctrine\Common\Annotations\AnnotationReader;
use MailPoetVendor\Doctrine\ORM\Mapping\MappingException;
use MailPoetVendor\Doctrine\ORM\Mapping\JoinColumn;
use MailPoetVendor\Doctrine\ORM\Mapping\Column;
use MailPoetVendor\Doctrine\ORM\Mapping\Builder\EntityListenerBuilder;
use MailPoetVendor\Doctrine\Common\Persistence\Mapping\ClassMetadata;
use MailPoetVendor\Doctrine\Common\Persistence\Mapping\Driver\AnnotationDriver as AbstractAnnotationDriver;
use MailPoetVendor\Doctrine\ORM\Events;
/**
 * The AnnotationDriver reads the mapping metadata from docblock annotations.
 *
 * @since 2.0
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author Jonathan H. Wage <jonwage@gmail.com>
 * @author Roman Borschel <roman@code-factory.org>
 */
class AnnotationDriver extends \MailPoetVendor\Doctrine\Common\Persistence\Mapping\Driver\AnnotationDriver
{
    /**
     * {@inheritDoc}
     */
    protected $entityAnnotationClasses = array('MailPoetVendor\\Doctrine\\ORM\\Mapping\\Entity' => 1, 'MailPoetVendor\\Doctrine\\ORM\\Mapping\\MappedSuperclass' => 2);
    /**
     * {@inheritDoc}
     */
    public function loadMetadataForClass($className, \MailPoetVendor\Doctrine\Common\Persistence\Mapping\ClassMetadata $metadata)
    {
        /* @var $metadata \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadataInfo */
        $class = $metadata->getReflectionClass();
        if (!$class) {
            // this happens when running annotation driver in combination with
            // static reflection services. This is not the nicest fix
            $class = new \ReflectionClass($metadata->name);
        }
        $classAnnotations = $this->reader->getClassAnnotations($class);
        if ($classAnnotations) {
            foreach ($classAnnotations as $key => $annot) {
                if (!\is_numeric($key)) {
                    continue;
                }
                $classAnnotations[\get_class($annot)] = $annot;
            }
        }
        // Evaluate Entity annotation
        if (isset($classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\Entity'])) {
            $entityAnnot = $classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\Entity'];
            if ($entityAnnot->repositoryClass !== null) {
                $metadata->setCustomRepositoryClass($entityAnnot->repositoryClass);
            }
            if ($entityAnnot->readOnly) {
                $metadata->markReadOnly();
            }
        } else {
            if (isset($classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\MappedSuperclass'])) {
                $mappedSuperclassAnnot = $classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\MappedSuperclass'];
                $metadata->setCustomRepositoryClass($mappedSuperclassAnnot->repositoryClass);
                $metadata->isMappedSuperclass = \true;
            } else {
                if (isset($classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\Embeddable'])) {
                    $metadata->isEmbeddedClass = \true;
                } else {
                    throw \MailPoetVendor\Doctrine\ORM\Mapping\MappingException::classIsNotAValidEntityOrMappedSuperClass($className);
                }
            }
        }
        // Evaluate Table annotation
        if (isset($classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\Table'])) {
            $tableAnnot = $classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\Table'];
            $primaryTable = array('name' => $tableAnnot->name, 'schema' => $tableAnnot->schema);
            if ($tableAnnot->indexes !== null) {
                foreach ($tableAnnot->indexes as $indexAnnot) {
                    $index = array('columns' => $indexAnnot->columns);
                    if (!empty($indexAnnot->flags)) {
                        $index['flags'] = $indexAnnot->flags;
                    }
                    if (!empty($indexAnnot->options)) {
                        $index['options'] = $indexAnnot->options;
                    }
                    if (!empty($indexAnnot->name)) {
                        $primaryTable['indexes'][$indexAnnot->name] = $index;
                    } else {
                        $primaryTable['indexes'][] = $index;
                    }
                }
            }
            if ($tableAnnot->uniqueConstraints !== null) {
                foreach ($tableAnnot->uniqueConstraints as $uniqueConstraintAnnot) {
                    $uniqueConstraint = array('columns' => $uniqueConstraintAnnot->columns);
                    if (!empty($uniqueConstraintAnnot->options)) {
                        $uniqueConstraint['options'] = $uniqueConstraintAnnot->options;
                    }
                    if (!empty($uniqueConstraintAnnot->name)) {
                        $primaryTable['uniqueConstraints'][$uniqueConstraintAnnot->name] = $uniqueConstraint;
                    } else {
                        $primaryTable['uniqueConstraints'][] = $uniqueConstraint;
                    }
                }
            }
            if ($tableAnnot->options) {
                $primaryTable['options'] = $tableAnnot->options;
            }
            $metadata->setPrimaryTable($primaryTable);
        }
        // Evaluate @Cache annotation
        if (isset($classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\Cache'])) {
            $cacheAnnot = $classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\Cache'];
            $cacheMap = array('region' => $cacheAnnot->region, 'usage' => \constant('MailPoetVendor\\Doctrine\\ORM\\Mapping\\ClassMetadata::CACHE_USAGE_' . $cacheAnnot->usage));
            $metadata->enableCache($cacheMap);
        }
        // Evaluate NamedNativeQueries annotation
        if (isset($classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\NamedNativeQueries'])) {
            $namedNativeQueriesAnnot = $classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\NamedNativeQueries'];
            foreach ($namedNativeQueriesAnnot->value as $namedNativeQuery) {
                $metadata->addNamedNativeQuery(array('name' => $namedNativeQuery->name, 'query' => $namedNativeQuery->query, 'resultClass' => $namedNativeQuery->resultClass, 'resultSetMapping' => $namedNativeQuery->resultSetMapping));
            }
        }
        // Evaluate SqlResultSetMappings annotation
        if (isset($classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\SqlResultSetMappings'])) {
            $sqlResultSetMappingsAnnot = $classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\SqlResultSetMappings'];
            foreach ($sqlResultSetMappingsAnnot->value as $resultSetMapping) {
                $entities = array();
                $columns = array();
                foreach ($resultSetMapping->entities as $entityResultAnnot) {
                    $entityResult = array('fields' => array(), 'entityClass' => $entityResultAnnot->entityClass, 'discriminatorColumn' => $entityResultAnnot->discriminatorColumn);
                    foreach ($entityResultAnnot->fields as $fieldResultAnnot) {
                        $entityResult['fields'][] = array('name' => $fieldResultAnnot->name, 'column' => $fieldResultAnnot->column);
                    }
                    $entities[] = $entityResult;
                }
                foreach ($resultSetMapping->columns as $columnResultAnnot) {
                    $columns[] = array('name' => $columnResultAnnot->name);
                }
                $metadata->addSqlResultSetMapping(array('name' => $resultSetMapping->name, 'entities' => $entities, 'columns' => $columns));
            }
        }
        // Evaluate NamedQueries annotation
        if (isset($classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\NamedQueries'])) {
            $namedQueriesAnnot = $classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\NamedQueries'];
            if (!\is_array($namedQueriesAnnot->value)) {
                throw new \UnexpectedValueException("@NamedQueries should contain an array of @NamedQuery annotations.");
            }
            foreach ($namedQueriesAnnot->value as $namedQuery) {
                if (!$namedQuery instanceof \MailPoetVendor\Doctrine\ORM\Mapping\NamedQuery) {
                    throw new \UnexpectedValueException("@NamedQueries should contain an array of @NamedQuery annotations.");
                }
                $metadata->addNamedQuery(array('name' => $namedQuery->name, 'query' => $namedQuery->query));
            }
        }
        // Evaluate InheritanceType annotation
        if (isset($classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\InheritanceType'])) {
            $inheritanceTypeAnnot = $classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\InheritanceType'];
            $metadata->setInheritanceType(\constant('MailPoetVendor\\Doctrine\\ORM\\Mapping\\ClassMetadata::INHERITANCE_TYPE_' . $inheritanceTypeAnnot->value));
            if ($metadata->inheritanceType != \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata::INHERITANCE_TYPE_NONE) {
                // Evaluate DiscriminatorColumn annotation
                if (isset($classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\DiscriminatorColumn'])) {
                    $discrColumnAnnot = $classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\DiscriminatorColumn'];
                    $metadata->setDiscriminatorColumn(array('name' => $discrColumnAnnot->name, 'type' => $discrColumnAnnot->type, 'length' => $discrColumnAnnot->length, 'columnDefinition' => $discrColumnAnnot->columnDefinition));
                } else {
                    $metadata->setDiscriminatorColumn(array('name' => 'dtype', 'type' => 'string', 'length' => 255));
                }
                // Evaluate DiscriminatorMap annotation
                if (isset($classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\DiscriminatorMap'])) {
                    $discrMapAnnot = $classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\DiscriminatorMap'];
                    $metadata->setDiscriminatorMap($discrMapAnnot->value);
                }
            }
        }
        // Evaluate DoctrineChangeTrackingPolicy annotation
        if (isset($classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\ChangeTrackingPolicy'])) {
            $changeTrackingAnnot = $classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\ChangeTrackingPolicy'];
            $metadata->setChangeTrackingPolicy(\constant('MailPoetVendor\\Doctrine\\ORM\\Mapping\\ClassMetadata::CHANGETRACKING_' . $changeTrackingAnnot->value));
        }
        // Evaluate annotations on properties/fields
        /* @var $property \ReflectionProperty */
        foreach ($class->getProperties() as $property) {
            if ($metadata->isMappedSuperclass && !$property->isPrivate() || $metadata->isInheritedField($property->name) || $metadata->isInheritedAssociation($property->name) || $metadata->isInheritedEmbeddedClass($property->name)) {
                continue;
            }
            $mapping = array();
            $mapping['fieldName'] = $property->getName();
            // Check for JoinColumn/JoinColumns annotations
            $joinColumns = array();
            if ($joinColumnAnnot = $this->reader->getPropertyAnnotation($property, 'MailPoetVendor\\Doctrine\\ORM\\Mapping\\JoinColumn')) {
                $joinColumns[] = $this->joinColumnToArray($joinColumnAnnot);
            } else {
                if ($joinColumnsAnnot = $this->reader->getPropertyAnnotation($property, 'MailPoetVendor\\Doctrine\\ORM\\Mapping\\JoinColumns')) {
                    foreach ($joinColumnsAnnot->value as $joinColumn) {
                        $joinColumns[] = $this->joinColumnToArray($joinColumn);
                    }
                }
            }
            // Field can only be annotated with one of:
            // @Column, @OneToOne, @OneToMany, @ManyToOne, @ManyToMany
            if ($columnAnnot = $this->reader->getPropertyAnnotation($property, 'MailPoetVendor\\Doctrine\\ORM\\Mapping\\Column')) {
                if ($columnAnnot->type == null) {
                    throw \MailPoetVendor\Doctrine\ORM\Mapping\MappingException::propertyTypeIsRequired($className, $property->getName());
                }
                $mapping = $this->columnToArray($property->getName(), $columnAnnot);
                if ($idAnnot = $this->reader->getPropertyAnnotation($property, 'MailPoetVendor\\Doctrine\\ORM\\Mapping\\Id')) {
                    $mapping['id'] = \true;
                }
                if ($generatedValueAnnot = $this->reader->getPropertyAnnotation($property, 'MailPoetVendor\\Doctrine\\ORM\\Mapping\\GeneratedValue')) {
                    $metadata->setIdGeneratorType(\constant('MailPoetVendor\\Doctrine\\ORM\\Mapping\\ClassMetadata::GENERATOR_TYPE_' . $generatedValueAnnot->strategy));
                }
                if ($this->reader->getPropertyAnnotation($property, 'MailPoetVendor\\Doctrine\\ORM\\Mapping\\Version')) {
                    $metadata->setVersionMapping($mapping);
                }
                $metadata->mapField($mapping);
                // Check for SequenceGenerator/TableGenerator definition
                if ($seqGeneratorAnnot = $this->reader->getPropertyAnnotation($property, 'MailPoetVendor\\Doctrine\\ORM\\Mapping\\SequenceGenerator')) {
                    $metadata->setSequenceGeneratorDefinition(array('sequenceName' => $seqGeneratorAnnot->sequenceName, 'allocationSize' => $seqGeneratorAnnot->allocationSize, 'initialValue' => $seqGeneratorAnnot->initialValue));
                } else {
                    if ($this->reader->getPropertyAnnotation($property, 'MailPoetVendor\\Doctrine\\ORM\\Mapping\\TableGenerator')) {
                        throw \MailPoetVendor\Doctrine\ORM\Mapping\MappingException::tableIdGeneratorNotImplemented($className);
                    } else {
                        if ($customGeneratorAnnot = $this->reader->getPropertyAnnotation($property, 'MailPoetVendor\\Doctrine\\ORM\\Mapping\\CustomIdGenerator')) {
                            $metadata->setCustomGeneratorDefinition(array('class' => $customGeneratorAnnot->class));
                        }
                    }
                }
            } else {
                if ($oneToOneAnnot = $this->reader->getPropertyAnnotation($property, 'MailPoetVendor\\Doctrine\\ORM\\Mapping\\OneToOne')) {
                    if ($idAnnot = $this->reader->getPropertyAnnotation($property, 'MailPoetVendor\\Doctrine\\ORM\\Mapping\\Id')) {
                        $mapping['id'] = \true;
                    }
                    $mapping['targetEntity'] = $oneToOneAnnot->targetEntity;
                    $mapping['joinColumns'] = $joinColumns;
                    $mapping['mappedBy'] = $oneToOneAnnot->mappedBy;
                    $mapping['inversedBy'] = $oneToOneAnnot->inversedBy;
                    $mapping['cascade'] = $oneToOneAnnot->cascade;
                    $mapping['orphanRemoval'] = $oneToOneAnnot->orphanRemoval;
                    $mapping['fetch'] = $this->getFetchMode($className, $oneToOneAnnot->fetch);
                    $metadata->mapOneToOne($mapping);
                } else {
                    if ($oneToManyAnnot = $this->reader->getPropertyAnnotation($property, 'MailPoetVendor\\Doctrine\\ORM\\Mapping\\OneToMany')) {
                        $mapping['mappedBy'] = $oneToManyAnnot->mappedBy;
                        $mapping['targetEntity'] = $oneToManyAnnot->targetEntity;
                        $mapping['cascade'] = $oneToManyAnnot->cascade;
                        $mapping['indexBy'] = $oneToManyAnnot->indexBy;
                        $mapping['orphanRemoval'] = $oneToManyAnnot->orphanRemoval;
                        $mapping['fetch'] = $this->getFetchMode($className, $oneToManyAnnot->fetch);
                        if ($orderByAnnot = $this->reader->getPropertyAnnotation($property, 'MailPoetVendor\\Doctrine\\ORM\\Mapping\\OrderBy')) {
                            $mapping['orderBy'] = $orderByAnnot->value;
                        }
                        $metadata->mapOneToMany($mapping);
                    } else {
                        if ($manyToOneAnnot = $this->reader->getPropertyAnnotation($property, 'MailPoetVendor\\Doctrine\\ORM\\Mapping\\ManyToOne')) {
                            if ($idAnnot = $this->reader->getPropertyAnnotation($property, 'MailPoetVendor\\Doctrine\\ORM\\Mapping\\Id')) {
                                $mapping['id'] = \true;
                            }
                            $mapping['joinColumns'] = $joinColumns;
                            $mapping['cascade'] = $manyToOneAnnot->cascade;
                            $mapping['inversedBy'] = $manyToOneAnnot->inversedBy;
                            $mapping['targetEntity'] = $manyToOneAnnot->targetEntity;
                            $mapping['fetch'] = $this->getFetchMode($className, $manyToOneAnnot->fetch);
                            $metadata->mapManyToOne($mapping);
                        } else {
                            if ($manyToManyAnnot = $this->reader->getPropertyAnnotation($property, 'MailPoetVendor\\Doctrine\\ORM\\Mapping\\ManyToMany')) {
                                $joinTable = array();
                                if ($joinTableAnnot = $this->reader->getPropertyAnnotation($property, 'MailPoetVendor\\Doctrine\\ORM\\Mapping\\JoinTable')) {
                                    $joinTable = array('name' => $joinTableAnnot->name, 'schema' => $joinTableAnnot->schema);
                                    foreach ($joinTableAnnot->joinColumns as $joinColumn) {
                                        $joinTable['joinColumns'][] = $this->joinColumnToArray($joinColumn);
                                    }
                                    foreach ($joinTableAnnot->inverseJoinColumns as $joinColumn) {
                                        $joinTable['inverseJoinColumns'][] = $this->joinColumnToArray($joinColumn);
                                    }
                                }
                                $mapping['joinTable'] = $joinTable;
                                $mapping['targetEntity'] = $manyToManyAnnot->targetEntity;
                                $mapping['mappedBy'] = $manyToManyAnnot->mappedBy;
                                $mapping['inversedBy'] = $manyToManyAnnot->inversedBy;
                                $mapping['cascade'] = $manyToManyAnnot->cascade;
                                $mapping['indexBy'] = $manyToManyAnnot->indexBy;
                                $mapping['orphanRemoval'] = $manyToManyAnnot->orphanRemoval;
                                $mapping['fetch'] = $this->getFetchMode($className, $manyToManyAnnot->fetch);
                                if ($orderByAnnot = $this->reader->getPropertyAnnotation($property, 'MailPoetVendor\\Doctrine\\ORM\\Mapping\\OrderBy')) {
                                    $mapping['orderBy'] = $orderByAnnot->value;
                                }
                                $metadata->mapManyToMany($mapping);
                            } else {
                                if ($embeddedAnnot = $this->reader->getPropertyAnnotation($property, 'MailPoetVendor\\Doctrine\\ORM\\Mapping\\Embedded')) {
                                    $mapping['class'] = $embeddedAnnot->class;
                                    $mapping['columnPrefix'] = $embeddedAnnot->columnPrefix;
                                    $metadata->mapEmbedded($mapping);
                                }
                            }
                        }
                    }
                }
            }
            // Evaluate @Cache annotation
            if (($cacheAnnot = $this->reader->getPropertyAnnotation($property, 'MailPoetVendor\\Doctrine\\ORM\\Mapping\\Cache')) !== null) {
                $metadata->enableAssociationCache($mapping['fieldName'], array('usage' => \constant('MailPoetVendor\\Doctrine\\ORM\\Mapping\\ClassMetadata::CACHE_USAGE_' . $cacheAnnot->usage), 'region' => $cacheAnnot->region));
            }
        }
        // Evaluate AssociationOverrides annotation
        if (isset($classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\AssociationOverrides'])) {
            $associationOverridesAnnot = $classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\AssociationOverrides'];
            foreach ($associationOverridesAnnot->value as $associationOverride) {
                $override = array();
                $fieldName = $associationOverride->name;
                // Check for JoinColumn/JoinColumns annotations
                if ($associationOverride->joinColumns) {
                    $joinColumns = array();
                    foreach ($associationOverride->joinColumns as $joinColumn) {
                        $joinColumns[] = $this->joinColumnToArray($joinColumn);
                    }
                    $override['joinColumns'] = $joinColumns;
                }
                // Check for JoinTable annotations
                if ($associationOverride->joinTable) {
                    $joinTableAnnot = $associationOverride->joinTable;
                    $joinTable = array('name' => $joinTableAnnot->name, 'schema' => $joinTableAnnot->schema);
                    foreach ($joinTableAnnot->joinColumns as $joinColumn) {
                        $joinTable['joinColumns'][] = $this->joinColumnToArray($joinColumn);
                    }
                    foreach ($joinTableAnnot->inverseJoinColumns as $joinColumn) {
                        $joinTable['inverseJoinColumns'][] = $this->joinColumnToArray($joinColumn);
                    }
                    $override['joinTable'] = $joinTable;
                }
                $metadata->setAssociationOverride($fieldName, $override);
            }
        }
        // Evaluate AttributeOverrides annotation
        if (isset($classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\AttributeOverrides'])) {
            $attributeOverridesAnnot = $classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\AttributeOverrides'];
            foreach ($attributeOverridesAnnot->value as $attributeOverrideAnnot) {
                $attributeOverride = $this->columnToArray($attributeOverrideAnnot->name, $attributeOverrideAnnot->column);
                $metadata->setAttributeOverride($attributeOverrideAnnot->name, $attributeOverride);
            }
        }
        // Evaluate EntityListeners annotation
        if (isset($classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\EntityListeners'])) {
            $entityListenersAnnot = $classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\EntityListeners'];
            foreach ($entityListenersAnnot->value as $item) {
                $listenerClassName = $metadata->fullyQualifiedClassName($item);
                if (!\class_exists($listenerClassName)) {
                    throw \MailPoetVendor\Doctrine\ORM\Mapping\MappingException::entityListenerClassNotFound($listenerClassName, $className);
                }
                $hasMapping = \false;
                $listenerClass = new \ReflectionClass($listenerClassName);
                /* @var $method \ReflectionMethod */
                foreach ($listenerClass->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                    // find method callbacks.
                    $callbacks = $this->getMethodCallbacks($method);
                    $hasMapping = $hasMapping ?: !empty($callbacks);
                    foreach ($callbacks as $value) {
                        $metadata->addEntityListener($value[1], $listenerClassName, $value[0]);
                    }
                }
                // Evaluate the listener using naming convention.
                if (!$hasMapping) {
                    \MailPoetVendor\Doctrine\ORM\Mapping\Builder\EntityListenerBuilder::bindEntityListener($metadata, $listenerClassName);
                }
            }
        }
        // Evaluate @HasLifecycleCallbacks annotation
        if (isset($classAnnotations['MailPoetVendor\\Doctrine\\ORM\\Mapping\\HasLifecycleCallbacks'])) {
            /* @var $method \ReflectionMethod */
            foreach ($class->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                foreach ($this->getMethodCallbacks($method) as $value) {
                    $metadata->addLifecycleCallback($value[0], $value[1]);
                }
            }
        }
    }
    /**
     * Attempts to resolve the fetch mode.
     *
     * @param string $className The class name.
     * @param string $fetchMode The fetch mode.
     *
     * @return integer The fetch mode as defined in ClassMetadata.
     *
     * @throws MappingException If the fetch mode is not valid.
     */
    private function getFetchMode($className, $fetchMode)
    {
        if (!\defined('MailPoetVendor\\Doctrine\\ORM\\Mapping\\ClassMetadata::FETCH_' . $fetchMode)) {
            throw \MailPoetVendor\Doctrine\ORM\Mapping\MappingException::invalidFetchMode($className, $fetchMode);
        }
        return \constant('MailPoetVendor\\Doctrine\\ORM\\Mapping\\ClassMetadata::FETCH_' . $fetchMode);
    }
    /**
     * Parses the given method.
     *
     * @param \ReflectionMethod $method
     *
     * @return array
     */
    private function getMethodCallbacks(\ReflectionMethod $method)
    {
        $callbacks = array();
        $annotations = $this->reader->getMethodAnnotations($method);
        foreach ($annotations as $annot) {
            if ($annot instanceof \MailPoetVendor\Doctrine\ORM\Mapping\PrePersist) {
                $callbacks[] = array($method->name, \MailPoetVendor\Doctrine\ORM\Events::prePersist);
            }
            if ($annot instanceof \MailPoetVendor\Doctrine\ORM\Mapping\PostPersist) {
                $callbacks[] = array($method->name, \MailPoetVendor\Doctrine\ORM\Events::postPersist);
            }
            if ($annot instanceof \MailPoetVendor\Doctrine\ORM\Mapping\PreUpdate) {
                $callbacks[] = array($method->name, \MailPoetVendor\Doctrine\ORM\Events::preUpdate);
            }
            if ($annot instanceof \MailPoetVendor\Doctrine\ORM\Mapping\PostUpdate) {
                $callbacks[] = array($method->name, \MailPoetVendor\Doctrine\ORM\Events::postUpdate);
            }
            if ($annot instanceof \MailPoetVendor\Doctrine\ORM\Mapping\PreRemove) {
                $callbacks[] = array($method->name, \MailPoetVendor\Doctrine\ORM\Events::preRemove);
            }
            if ($annot instanceof \MailPoetVendor\Doctrine\ORM\Mapping\PostRemove) {
                $callbacks[] = array($method->name, \MailPoetVendor\Doctrine\ORM\Events::postRemove);
            }
            if ($annot instanceof \MailPoetVendor\Doctrine\ORM\Mapping\PostLoad) {
                $callbacks[] = array($method->name, \MailPoetVendor\Doctrine\ORM\Events::postLoad);
            }
            if ($annot instanceof \MailPoetVendor\Doctrine\ORM\Mapping\PreFlush) {
                $callbacks[] = array($method->name, \MailPoetVendor\Doctrine\ORM\Events::preFlush);
            }
        }
        return $callbacks;
    }
    /**
     * Parse the given JoinColumn as array
     *
     * @param JoinColumn $joinColumn
     * @return array
     */
    private function joinColumnToArray(\MailPoetVendor\Doctrine\ORM\Mapping\JoinColumn $joinColumn)
    {
        return array('name' => $joinColumn->name, 'unique' => $joinColumn->unique, 'nullable' => $joinColumn->nullable, 'onDelete' => $joinColumn->onDelete, 'columnDefinition' => $joinColumn->columnDefinition, 'referencedColumnName' => $joinColumn->referencedColumnName);
    }
    /**
     * Parse the given Column as array
     *
     * @param string $fieldName
     * @param Column $column
     *
     * @return array
     */
    private function columnToArray($fieldName, \MailPoetVendor\Doctrine\ORM\Mapping\Column $column)
    {
        $mapping = array('fieldName' => $fieldName, 'type' => $column->type, 'scale' => $column->scale, 'length' => $column->length, 'unique' => $column->unique, 'nullable' => $column->nullable, 'precision' => $column->precision);
        if ($column->options) {
            $mapping['options'] = $column->options;
        }
        if (isset($column->name)) {
            $mapping['columnName'] = $column->name;
        }
        if (isset($column->columnDefinition)) {
            $mapping['columnDefinition'] = $column->columnDefinition;
        }
        return $mapping;
    }
    /**
     * Factory method for the Annotation Driver.
     *
     * @param array|string          $paths
     * @param AnnotationReader|null $reader
     *
     * @return AnnotationDriver
     */
    public static function create($paths = array(), \MailPoetVendor\Doctrine\Common\Annotations\AnnotationReader $reader = null)
    {
        if ($reader == null) {
            $reader = new \MailPoetVendor\Doctrine\Common\Annotations\AnnotationReader();
        }
        return new self($reader, $paths);
    }
}
