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
namespace MailPoetVendor\Doctrine\ORM\Persisters;

use MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata;
use MailPoetVendor\Doctrine\Common\Collections\Expr\ExpressionVisitor;
use MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison;
use MailPoetVendor\Doctrine\Common\Collections\Expr\Value;
use MailPoetVendor\Doctrine\Common\Collections\Expr\CompositeExpression;
use MailPoetVendor\Doctrine\ORM\Persisters\Entity\BasicEntityPersister;
/**
 * Visit Expressions and generate SQL WHERE conditions from them.
 *
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 * @since 2.3
 */
class SqlExpressionVisitor extends \MailPoetVendor\Doctrine\Common\Collections\Expr\ExpressionVisitor
{
    /**
     * @var \MailPoetVendor\Doctrine\ORM\Persisters\Entity\BasicEntityPersister
     */
    private $persister;
    /**
     * @var \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata
     */
    private $classMetadata;
    /**
     * @param \MailPoetVendor\Doctrine\ORM\Persisters\Entity\BasicEntityPersister $persister
     * @param \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata                  $classMetadata
     */
    public function __construct(\MailPoetVendor\Doctrine\ORM\Persisters\Entity\BasicEntityPersister $persister, \MailPoetVendor\Doctrine\ORM\Mapping\ClassMetadata $classMetadata)
    {
        $this->persister = $persister;
        $this->classMetadata = $classMetadata;
    }
    /**
     * Converts a comparison expression into the target query language output.
     *
     * @param \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison $comparison
     *
     * @return mixed
     */
    public function walkComparison(\MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison $comparison)
    {
        $field = $comparison->getField();
        $value = $comparison->getValue()->getValue();
        // shortcut for walkValue()
        if (isset($this->classMetadata->associationMappings[$field]) && $value !== null && !\is_object($value) && !\in_array($comparison->getOperator(), array(\MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::IN, \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::NIN))) {
            throw \MailPoetVendor\Doctrine\ORM\Persisters\PersisterException::matchingAssocationFieldRequiresObject($this->classMetadata->name, $field);
        }
        return $this->persister->getSelectConditionStatementSQL($field, $value, null, $comparison->getOperator());
    }
    /**
     * Converts a composite expression into the target query language output.
     *
     * @param \MailPoetVendor\Doctrine\Common\Collections\Expr\CompositeExpression $expr
     *
     * @return mixed
     *
     * @throws \RuntimeException
     */
    public function walkCompositeExpression(\MailPoetVendor\Doctrine\Common\Collections\Expr\CompositeExpression $expr)
    {
        $expressionList = array();
        foreach ($expr->getExpressionList() as $child) {
            $expressionList[] = $this->dispatch($child);
        }
        switch ($expr->getType()) {
            case \MailPoetVendor\Doctrine\Common\Collections\Expr\CompositeExpression::TYPE_AND:
                return '(' . \implode(' AND ', $expressionList) . ')';
            case \MailPoetVendor\Doctrine\Common\Collections\Expr\CompositeExpression::TYPE_OR:
                return '(' . \implode(' OR ', $expressionList) . ')';
            default:
                throw new \RuntimeException("Unknown composite " . $expr->getType());
        }
    }
    /**
     * Converts a value expression into the target query language part.
     *
     * @param \MailPoetVendor\Doctrine\Common\Collections\Expr\Value $value
     *
     * @return mixed
     */
    public function walkValue(\MailPoetVendor\Doctrine\Common\Collections\Expr\Value $value)
    {
        return '?';
    }
}
