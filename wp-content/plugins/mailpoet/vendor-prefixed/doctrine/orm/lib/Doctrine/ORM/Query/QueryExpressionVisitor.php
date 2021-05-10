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
namespace MailPoetVendor\Doctrine\ORM\Query;

use MailPoetVendor\Doctrine\Common\Collections\ArrayCollection;
use MailPoetVendor\Doctrine\Common\Collections\Expr\ExpressionVisitor;
use MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison;
use MailPoetVendor\Doctrine\Common\Collections\Expr\CompositeExpression;
use MailPoetVendor\Doctrine\Common\Collections\Expr\Value;
/**
 * Converts Collection expressions to Query expressions.
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @since 2.4
 */
class QueryExpressionVisitor extends \MailPoetVendor\Doctrine\Common\Collections\Expr\ExpressionVisitor
{
    /**
     * @var array
     */
    private static $operatorMap = array(\MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::GT => \MailPoetVendor\Doctrine\ORM\Query\Expr\Comparison::GT, \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::GTE => \MailPoetVendor\Doctrine\ORM\Query\Expr\Comparison::GTE, \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::LT => \MailPoetVendor\Doctrine\ORM\Query\Expr\Comparison::LT, \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::LTE => \MailPoetVendor\Doctrine\ORM\Query\Expr\Comparison::LTE);
    /**
     * @var array
     */
    private $queryAliases;
    /**
     * @var Expr
     */
    private $expr;
    /**
     * @var array
     */
    private $parameters = array();
    /**
     * Constructor
     *
     * @param array $queryAliases
     */
    public function __construct($queryAliases)
    {
        $this->queryAliases = $queryAliases;
        $this->expr = new \MailPoetVendor\Doctrine\ORM\Query\Expr();
    }
    /**
     * Gets bound parameters.
     * Filled after {@link dispach()}.
     *
     * @return \MailPoetVendor\Doctrine\Common\Collections\Collection
     */
    public function getParameters()
    {
        return new \MailPoetVendor\Doctrine\Common\Collections\ArrayCollection($this->parameters);
    }
    /**
     * Clears parameters.
     *
     * @return void
     */
    public function clearParameters()
    {
        $this->parameters = array();
    }
    /**
     * Converts Criteria expression to Query one based on static map.
     *
     * @param string $criteriaOperator
     *
     * @return string|null
     */
    private static function convertComparisonOperator($criteriaOperator)
    {
        return isset(self::$operatorMap[$criteriaOperator]) ? self::$operatorMap[$criteriaOperator] : null;
    }
    /**
     * {@inheritDoc}
     */
    public function walkCompositeExpression(\MailPoetVendor\Doctrine\Common\Collections\Expr\CompositeExpression $expr)
    {
        $expressionList = array();
        foreach ($expr->getExpressionList() as $child) {
            $expressionList[] = $this->dispatch($child);
        }
        switch ($expr->getType()) {
            case \MailPoetVendor\Doctrine\Common\Collections\Expr\CompositeExpression::TYPE_AND:
                return new \MailPoetVendor\Doctrine\ORM\Query\Expr\Andx($expressionList);
            case \MailPoetVendor\Doctrine\Common\Collections\Expr\CompositeExpression::TYPE_OR:
                return new \MailPoetVendor\Doctrine\ORM\Query\Expr\Orx($expressionList);
            default:
                throw new \RuntimeException("Unknown composite " . $expr->getType());
        }
    }
    /**
     * {@inheritDoc}
     */
    public function walkComparison(\MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison $comparison)
    {
        if (!isset($this->queryAliases[0])) {
            throw new \MailPoetVendor\Doctrine\ORM\Query\QueryException('No aliases are set before invoking walkComparison().');
        }
        $field = $this->queryAliases[0] . '.' . $comparison->getField();
        foreach ($this->queryAliases as $alias) {
            if (\strpos($comparison->getField() . '.', $alias . '.') === 0) {
                $field = $comparison->getField();
                break;
            }
        }
        $parameterName = \str_replace('.', '_', $comparison->getField());
        foreach ($this->parameters as $parameter) {
            if ($parameter->getName() === $parameterName) {
                $parameterName .= '_' . \count($this->parameters);
                break;
            }
        }
        $parameter = new \MailPoetVendor\Doctrine\ORM\Query\Parameter($parameterName, $this->walkValue($comparison->getValue()));
        $placeholder = ':' . $parameterName;
        switch ($comparison->getOperator()) {
            case \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::IN:
                $this->parameters[] = $parameter;
                return $this->expr->in($field, $placeholder);
            case \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::NIN:
                $this->parameters[] = $parameter;
                return $this->expr->notIn($field, $placeholder);
            case \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::EQ:
            case \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::IS:
                if ($this->walkValue($comparison->getValue()) === null) {
                    return $this->expr->isNull($field);
                }
                $this->parameters[] = $parameter;
                return $this->expr->eq($field, $placeholder);
            case \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::NEQ:
                if ($this->walkValue($comparison->getValue()) === null) {
                    return $this->expr->isNotNull($field);
                }
                $this->parameters[] = $parameter;
                return $this->expr->neq($field, $placeholder);
            case \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::CONTAINS:
                $parameter->setValue('%' . $parameter->getValue() . '%', $parameter->getType());
                $this->parameters[] = $parameter;
                return $this->expr->like($field, $placeholder);
            default:
                $operator = self::convertComparisonOperator($comparison->getOperator());
                if ($operator) {
                    $this->parameters[] = $parameter;
                    return new \MailPoetVendor\Doctrine\ORM\Query\Expr\Comparison($field, $operator, $placeholder);
                }
                throw new \RuntimeException("Unknown comparison operator: " . $comparison->getOperator());
        }
    }
    /**
     * {@inheritDoc}
     */
    public function walkValue(\MailPoetVendor\Doctrine\Common\Collections\Expr\Value $value)
    {
        return $value->getValue();
    }
}
