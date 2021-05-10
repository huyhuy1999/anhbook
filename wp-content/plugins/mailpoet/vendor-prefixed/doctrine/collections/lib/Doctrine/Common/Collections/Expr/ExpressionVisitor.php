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
namespace MailPoetVendor\Doctrine\Common\Collections\Expr;

/**
 * An Expression visitor walks a graph of expressions and turns them into a
 * query for the underlying implementation.
 *
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 */
abstract class ExpressionVisitor
{
    /**
     * Converts a comparison expression into the target query language output.
     *
     * @param Comparison $comparison
     *
     * @return mixed
     */
    public abstract function walkComparison(\MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison $comparison);
    /**
     * Converts a value expression into the target query language part.
     *
     * @param Value $value
     *
     * @return mixed
     */
    public abstract function walkValue(\MailPoetVendor\Doctrine\Common\Collections\Expr\Value $value);
    /**
     * Converts a composite expression into the target query language output.
     *
     * @param CompositeExpression $expr
     *
     * @return mixed
     */
    public abstract function walkCompositeExpression(\MailPoetVendor\Doctrine\Common\Collections\Expr\CompositeExpression $expr);
    /**
     * Dispatches walking an expression to the appropriate handler.
     *
     * @param Expression $expr
     *
     * @return mixed
     *
     * @throws \RuntimeException
     */
    public function dispatch(\MailPoetVendor\Doctrine\Common\Collections\Expr\Expression $expr)
    {
        switch (\true) {
            case $expr instanceof \MailPoetVendor\Doctrine\Common\Collections\Expr\Comparison:
                return $this->walkComparison($expr);
            case $expr instanceof \MailPoetVendor\Doctrine\Common\Collections\Expr\Value:
                return $this->walkValue($expr);
            case $expr instanceof \MailPoetVendor\Doctrine\Common\Collections\Expr\CompositeExpression:
                return $this->walkCompositeExpression($expr);
            default:
                throw new \RuntimeException("Unknown Expression " . \get_class($expr));
        }
    }
}
