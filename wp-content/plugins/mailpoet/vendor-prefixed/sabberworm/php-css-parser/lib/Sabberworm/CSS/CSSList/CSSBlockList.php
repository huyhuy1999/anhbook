<?php

namespace MailPoetVendor\Sabberworm\CSS\CSSList;

use MailPoetVendor\Sabberworm\CSS\RuleSet\DeclarationBlock;
use MailPoetVendor\Sabberworm\CSS\RuleSet\RuleSet;
use MailPoetVendor\Sabberworm\CSS\Property\Selector;
use MailPoetVendor\Sabberworm\CSS\Rule\Rule;
use MailPoetVendor\Sabberworm\CSS\Value\ValueList;
use MailPoetVendor\Sabberworm\CSS\Value\CSSFunction;
/**
 * A CSSBlockList is a CSSList whose DeclarationBlocks are guaranteed to contain valid declaration blocks or at-rules.
 * Most CSSLists conform to this category but some at-rules (such as @keyframes) do not.
 */
abstract class CSSBlockList extends \MailPoetVendor\Sabberworm\CSS\CSSList\CSSList
{
    public function __construct($iLineNo = 0)
    {
        parent::__construct($iLineNo);
    }
    protected function allDeclarationBlocks(&$aResult)
    {
        foreach ($this->aContents as $mContent) {
            if ($mContent instanceof \MailPoetVendor\Sabberworm\CSS\RuleSet\DeclarationBlock) {
                $aResult[] = $mContent;
            } else {
                if ($mContent instanceof \MailPoetVendor\Sabberworm\CSS\CSSList\CSSBlockList) {
                    $mContent->allDeclarationBlocks($aResult);
                }
            }
        }
    }
    protected function allRuleSets(&$aResult)
    {
        foreach ($this->aContents as $mContent) {
            if ($mContent instanceof \MailPoetVendor\Sabberworm\CSS\RuleSet\RuleSet) {
                $aResult[] = $mContent;
            } else {
                if ($mContent instanceof \MailPoetVendor\Sabberworm\CSS\CSSList\CSSBlockList) {
                    $mContent->allRuleSets($aResult);
                }
            }
        }
    }
    protected function allValues($oElement, &$aResult, $sSearchString = null, $bSearchInFunctionArguments = \false)
    {
        if ($oElement instanceof \MailPoetVendor\Sabberworm\CSS\CSSList\CSSBlockList) {
            foreach ($oElement->getContents() as $oContent) {
                $this->allValues($oContent, $aResult, $sSearchString, $bSearchInFunctionArguments);
            }
        } else {
            if ($oElement instanceof \MailPoetVendor\Sabberworm\CSS\RuleSet\RuleSet) {
                foreach ($oElement->getRules($sSearchString) as $oRule) {
                    $this->allValues($oRule, $aResult, $sSearchString, $bSearchInFunctionArguments);
                }
            } else {
                if ($oElement instanceof \MailPoetVendor\Sabberworm\CSS\Rule\Rule) {
                    $this->allValues($oElement->getValue(), $aResult, $sSearchString, $bSearchInFunctionArguments);
                } else {
                    if ($oElement instanceof \MailPoetVendor\Sabberworm\CSS\Value\ValueList) {
                        if ($bSearchInFunctionArguments || !$oElement instanceof \MailPoetVendor\Sabberworm\CSS\Value\CSSFunction) {
                            foreach ($oElement->getListComponents() as $mComponent) {
                                $this->allValues($mComponent, $aResult, $sSearchString, $bSearchInFunctionArguments);
                            }
                        }
                    } else {
                        //Non-List Value or CSSString (CSS identifier)
                        $aResult[] = $oElement;
                    }
                }
            }
        }
    }
    protected function allSelectors(&$aResult, $sSpecificitySearch = null)
    {
        $aDeclarationBlocks = array();
        $this->allDeclarationBlocks($aDeclarationBlocks);
        foreach ($aDeclarationBlocks as $oBlock) {
            foreach ($oBlock->getSelectors() as $oSelector) {
                if ($sSpecificitySearch === null) {
                    $aResult[] = $oSelector;
                } else {
                    $sComparison = "\$bRes = {$oSelector->getSpecificity()} {$sSpecificitySearch};";
                    eval($sComparison);
                    if ($bRes) {
                        $aResult[] = $oSelector;
                    }
                }
            }
        }
    }
}
