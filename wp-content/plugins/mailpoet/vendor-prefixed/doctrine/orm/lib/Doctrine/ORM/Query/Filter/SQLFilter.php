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
namespace MailPoetVendor\Doctrine\ORM\Query\Filter;

use MailPoetVendor\Doctrine\ORM\EntityManagerInterface;
use MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata;
use MailPoetVendor\Doctrine\ORM\Query\ParameterTypeInferer;
/**
 * The base class that user defined filters should extend.
 *
 * Handles the setting and escaping of parameters.
 *
 * @author Alexander <iam.asm89@gmail.com>
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 * @abstract
 */
abstract class SQLFilter
{
    /**
     * The entity manager.
     *
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * Parameters for the filter.
     *
     * @var array
     */
    private $parameters = [];
    /**
     * Constructs the SQLFilter object.
     *
     * @param EntityManagerInterface $em The entity manager.
     */
    public final function __construct(\MailPoetVendor\Doctrine\ORM\EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * Sets a parameter that can be used by the filter.
     *
     * @param string      $name  Name of the parameter.
     * @param string      $value Value of the parameter.
     * @param string|null $type  The parameter type. If specified, the given value will be run through
     *                           the type conversion of this type. This is usually not needed for
     *                           strings and numeric types.
     *
     * @return SQLFilter The current SQL filter.
     */
    public final function setParameter($name, $value, $type = null)
    {
        if (null === $type) {
            $type = \MailPoetVendor\Doctrine\ORM\Query\ParameterTypeInferer::inferType($value);
        }
        $this->parameters[$name] = array('value' => $value, 'type' => $type);
        // Keep the parameters sorted for the hash
        \ksort($this->parameters);
        // The filter collection of the EM is now dirty
        $this->em->getFilters()->setFiltersStateDirty();
        return $this;
    }
    /**
     * Gets a parameter to use in a query.
     *
     * The function is responsible for the right output escaping to use the
     * value in a query.
     *
     * @param string $name Name of the parameter.
     *
     * @return string The SQL escaped parameter to use in a query.
     *
     * @throws \InvalidArgumentException
     */
    public final function getParameter($name)
    {
        if (!isset($this->parameters[$name])) {
            throw new \InvalidArgumentException("Parameter '" . $name . "' does not exist.");
        }
        return $this->em->getConnection()->quote($this->parameters[$name]['value'], $this->parameters[$name]['type']);
    }
    /**
     * Checks if a parameter was set for the filter.
     *
     * @param string $name Name of the parameter.
     *
     * @return boolean
     */
    public final function hasParameter($name)
    {
        if (!isset($this->parameters[$name])) {
            return \false;
        }
        return \true;
    }
    /**
     * Returns as string representation of the SQLFilter parameters (the state).
     *
     * @return string String representation of the SQLFilter.
     */
    public final function __toString()
    {
        return \serialize($this->parameters);
    }
    /**
     * Returns the database connection used by the entity manager
     *
     * @return \MailPoetVendor\Doctrine\DBAL\Connection
     */
    protected final function getConnection()
    {
        return $this->em->getConnection();
    }
    /**
     * Gets the SQL query part to add to a query.
     *
     * @param ClassMetaData $targetEntity
     * @param string        $targetTableAlias
     *
     * @return string The constraint SQL if there is available, empty string otherwise.
     */
    public abstract function addFilterConstraint(\MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $targetEntity, $targetTableAlias);
}
