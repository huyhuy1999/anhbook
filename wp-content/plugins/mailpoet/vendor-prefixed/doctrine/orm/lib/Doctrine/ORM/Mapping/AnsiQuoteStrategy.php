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
namespace MailPoetVendor\Doctrine\ORM\Mapping;

use MailPoetVendor\Doctrine\DBAL\Platforms\AbstractPlatform;
/**
 * ANSI compliant quote strategy, this strategy does not apply any quote.
 * To use this strategy all mapped tables and columns should be ANSI compliant.
 * 
 * @since   2.5
 * @author  Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class AnsiQuoteStrategy implements \MailPoetVendor\Doctrine\ORM\Mapping\QuoteStrategy
{
    /**
     * {@inheritdoc}
     */
    public function getColumnName($fieldName, \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $class, \MailPoetVendor\Doctrine\DBAL\Platforms\AbstractPlatform $platform)
    {
        return $class->fieldMappings[$fieldName]['columnName'];
    }
    /**
     * {@inheritdoc}
     */
    public function getTableName(\MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $class, \MailPoetVendor\Doctrine\DBAL\Platforms\AbstractPlatform $platform)
    {
        return $class->table['name'];
    }
    /**
     * {@inheritdoc}
     */
    public function getSequenceName(array $definition, \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $class, \MailPoetVendor\Doctrine\DBAL\Platforms\AbstractPlatform $platform)
    {
        return $definition['sequenceName'];
    }
    /**
     * {@inheritdoc}
     */
    public function getJoinColumnName(array $joinColumn, \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $class, \MailPoetVendor\Doctrine\DBAL\Platforms\AbstractPlatform $platform)
    {
        return $joinColumn['name'];
    }
    /**
     * {@inheritdoc}
     */
    public function getReferencedJoinColumnName(array $joinColumn, \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $class, \MailPoetVendor\Doctrine\DBAL\Platforms\AbstractPlatform $platform)
    {
        return $joinColumn['referencedColumnName'];
    }
    /**
     * {@inheritdoc}
     */
    public function getJoinTableName(array $association, \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $class, \MailPoetVendor\Doctrine\DBAL\Platforms\AbstractPlatform $platform)
    {
        return $association['joinTable']['name'];
    }
    /**
     * {@inheritdoc}
     */
    public function getIdentifierColumnNames(\MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $class, \MailPoetVendor\Doctrine\DBAL\Platforms\AbstractPlatform $platform)
    {
        return $class->identifier;
    }
    /**
     * {@inheritdoc}
     */
    public function getColumnAlias($columnName, $counter, \MailPoetVendor\Doctrine\DBAL\Platforms\AbstractPlatform $platform, \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $class = null)
    {
        return $platform->getSQLResultCasing($columnName . '_' . $counter);
    }
}
