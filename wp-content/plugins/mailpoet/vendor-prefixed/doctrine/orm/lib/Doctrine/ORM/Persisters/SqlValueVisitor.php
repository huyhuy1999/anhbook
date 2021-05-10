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

use MailPoetVendor\Doctrine\Common\Collections\Expr\ExpressionVisitor;
use MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison;
use MailPoetVendor\Doctrine\Common\Collections\Expr\Value;
use MailPoetVendor\Doctrine\Common\Collections\Expr\CompositeExpression;
/**
 * Extract the values from a criteria/expression
 *
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 */
class SqlValueVisitor extends \MailPoetVendor\Doctrine\Common\Collections\Expr\ExpressionVisitor
{
    /**
     * @var array
     */
    private $values = array();
    /**
     * @var array
     */
    private $types = array();
    /**
     * Converts a comparison expression into the target query language output.
     *
     * @param \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison $comparison
     *
     * @return mixed
     */
    public function walkComparison(\MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison $comparison)
    {
        $value = $this->getValueFromComparison($comparison);
        $field = $comparison->getField();
        $operator = $comparison->getOperator();
        if (($operator === \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::EQ || $operator === \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::IS) && $value === null) {
            return;
        } else {
            if ($operator === \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::NEQ && $value === null) {
                return;
            }
        }
        $this->values[] = $value;
        $this->types[] = array($field, $value, $operator);
    }
    /**
     * Converts a composite expression into the target query language output.
     *
     * @param \MailPoetVendor\Doctrine\Common\Collections\Expr\CompositeExpression $expr
     *
     * @return mixed
     */
    public function walkCompositeExpression(\MailPoetVendor\Doctrine\Common\Collections\Expr\CompositeExpression $expr)
    {
        foreach ($expr->getExpressionList() as $child) {
            $this->dispatch($child);
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
        return;
    }
    /**
     * Returns the Parameters and Types necessary for matching the last visited expression.
     *
     * @return array
     */
    public function getParamsAndTypes()
    {
        return array($this->values, $this->types);
    }
    /**
     * Returns the value from a Comparison. In case of a CONTAINS comparison,
     * the value is wrapped in %-signs, because it will be used in a LIKE clause.
     *
     * @param \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison $comparison
     * @return mixed
     */
    protected function getValueFromComparison(\MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison $comparison)
    {
        $value = $comparison->getValue()->getValue();
        return $comparison->getOperator() == \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison::CONTAINS ? "%{$value}%" : $value;
    }
}
