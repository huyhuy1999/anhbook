<?php

namespace MailPoetVendor\Sabberworm\CSS;

use MailPoetVendor\Sabberworm\CSS\CSSList\CSSList;
use MailPoetVendor\Sabberworm\CSS\CSSList\Document;
use MailPoetVendor\Sabberworm\CSS\CSSList\KeyFrame;
use MailPoetVendor\Sabberworm\CSS\Parsing\SourceException;
use MailPoetVendor\Sabberworm\CSS\Property\AtRule;
use MailPoetVendor\Sabberworm\CSS\Property\Import;
use MailPoetVendor\Sabberworm\CSS\Property\Charset;
use MailPoetVendor\Sabberworm\CSS\Property\CSSNamespace;
use MailPoetVendor\Sabberworm\CSS\RuleSet\AtRuleSet;
use MailPoetVendor\Sabberworm\CSS\CSSList\AtRuleBlockList;
use MailPoetVendor\Sabberworm\CSS\RuleSet\DeclarationBlock;
use MailPoetVendor\Sabberworm\CSS\Value\CSSFunction;
use MailPoetVendor\Sabberworm\CSS\Value\CalcFunction;
use MailPoetVendor\Sabberworm\CSS\Value\RuleValueList;
use MailPoetVendor\Sabberworm\CSS\Value\CalcRuleValueList;
use MailPoetVendor\Sabberworm\CSS\Value\Size;
use MailPoetVendor\Sabberworm\CSS\Value\Color;
use MailPoetVendor\Sabberworm\CSS\Value\URL;
use MailPoetVendor\Sabberworm\CSS\Value\CSSString;
use MailPoetVendor\Sabberworm\CSS\Value\LineName;
use MailPoetVendor\Sabberworm\CSS\Rule\Rule;
use MailPoetVendor\Sabberworm\CSS\Parsing\UnexpectedTokenException;
use MailPoetVendor\Sabberworm\CSS\Comment\Comment;
/**
 * Parser class parses CSS from text into a data structure.
 */
class Parser
{
    private $sText;
    private $aText;
    private $iCurrentPosition;
    private $oParserSettings;
    private $sCharset;
    private $iLength;
    private $blockRules;
    private $aSizeUnits;
    private $iLineNo;
    /**
     * Parser constructor.
     * Note that that iLineNo starts from 1 and not 0
     *
     * @param $sText
     * @param Settings|null $oParserSettings
     * @param int $iLineNo
     */
    public function __construct($sText, \MailPoetVendor\Sabberworm\CSS\Settings $oParserSettings = null, $iLineNo = 1)
    {
        $this->sText = $sText;
        $this->iCurrentPosition = 0;
        $this->iLineNo = $iLineNo;
        if ($oParserSettings === null) {
            $oParserSettings = \MailPoetVendor\Sabberworm\CSS\Settings::create();
        }
        $this->oParserSettings = $oParserSettings;
        $this->blockRules = \explode('/', \MailPoetVendor\Sabberworm\CSS\Property\AtRule::BLOCK_RULES);
        foreach (\explode('/', \MailPoetVendor\Sabberworm\CSS\Value\Size::ABSOLUTE_SIZE_UNITS . '/' . \MailPoetVendor\Sabberworm\CSS\Value\Size::RELATIVE_SIZE_UNITS . '/' . \MailPoetVendor\Sabberworm\CSS\Value\Size::NON_SIZE_UNITS) as $val) {
            $iSize = \strlen($val);
            if (!isset($this->aSizeUnits[$iSize])) {
                $this->aSizeUnits[$iSize] = array();
            }
            $this->aSizeUnits[$iSize][\strtolower($val)] = $val;
        }
        \ksort($this->aSizeUnits, \SORT_NUMERIC);
    }
    public function setCharset($sCharset)
    {
        $this->sCharset = $sCharset;
        $this->aText = $this->strsplit($this->sText);
        $this->iLength = \count($this->aText);
    }
    public function getCharset()
    {
        return $this->sCharset;
    }
    public function parse()
    {
        $this->setCharset($this->oParserSettings->sDefaultCharset);
        $oResult = new \MailPoetVendor\Sabberworm\CSS\CSSList\Document($this->iLineNo);
        $this->parseDocument($oResult);
        return $oResult;
    }
    private function parseDocument(\MailPoetVendor\Sabberworm\CSS\CSSList\Document $oDocument)
    {
        $this->parseList($oDocument, \true);
    }
    private function parseList(\MailPoetVendor\Sabberworm\CSS\CSSList\CSSList $oList, $bIsRoot = \false)
    {
        while (!$this->isEnd()) {
            $comments = $this->consumeWhiteSpace();
            $oListItem = null;
            if ($this->oParserSettings->bLenientParsing) {
                try {
                    $oListItem = $this->parseListItem($oList, $bIsRoot);
                } catch (\MailPoetVendor\Sabberworm\CSS\Parsing\UnexpectedTokenException $e) {
                    $oListItem = \false;
                }
            } else {
                $oListItem = $this->parseListItem($oList, $bIsRoot);
            }
            if ($oListItem === null) {
                // List parsing finished
                return;
            }
            if ($oListItem) {
                $oListItem->setComments($comments);
                $oList->append($oListItem);
            }
            $this->consumeWhiteSpace();
        }
        if (!$bIsRoot) {
            throw new \MailPoetVendor\Sabberworm\CSS\Parsing\SourceException("Unexpected end of document", $this->iLineNo);
        }
    }
    private function parseListItem(\MailPoetVendor\Sabberworm\CSS\CSSList\CSSList $oList, $bIsRoot = \false)
    {
        if ($this->comes('@')) {
            $oAtRule = $this->parseAtRule();
            if ($oAtRule instanceof \MailPoetVendor\Sabberworm\CSS\Property\Charset) {
                if (!$bIsRoot) {
                    throw new \MailPoetVendor\Sabberworm\CSS\Parsing\UnexpectedTokenException('@charset may only occur in root document', '', 'custom', $this->iLineNo);
                }
                if (\count($oList->getContents()) > 0) {
                    throw new \MailPoetVendor\Sabberworm\CSS\Parsing\UnexpectedTokenException('@charset must be the first parseable token in a document', '', 'custom', $this->iLineNo);
                }
                $this->setCharset($oAtRule->getCharset()->getString());
            }
            return $oAtRule;
        } else {
            if ($this->comes('}')) {
                $this->consume('}');
                if ($bIsRoot) {
                    if ($this->oParserSettings->bLenientParsing) {
                        while ($this->comes('}')) {
                            $this->consume('}');
                        }
                        return $this->parseSelector();
                    } else {
                        throw new \MailPoetVendor\Sabberworm\CSS\Parsing\SourceException("Unopened {", $this->iLineNo);
                    }
                } else {
                    return null;
                }
            } else {
                return $this->parseSelector();
            }
        }
    }
    private function parseAtRule()
    {
        $this->consume('@');
        $sIdentifier = $this->parseIdentifier(\false);
        $iIdentifierLineNum = $this->iLineNo;
        $this->consumeWhiteSpace();
        if ($sIdentifier === 'import') {
            $oLocation = $this->parseURLValue();
            $this->consumeWhiteSpace();
            $sMediaQuery = null;
            if (!$this->comes(';')) {
                $sMediaQuery = $this->consumeUntil(';');
            }
            $this->consume(';');
            return new \MailPoetVendor\Sabberworm\CSS\Property\Import($oLocation, $sMediaQuery, $iIdentifierLineNum);
        } else {
            if ($sIdentifier === 'charset') {
                $sCharset = $this->parseStringValue();
                $this->consumeWhiteSpace();
                $this->consume(';');
                return new \MailPoetVendor\Sabberworm\CSS\Property\Charset($sCharset, $iIdentifierLineNum);
            } else {
                if ($this->identifierIs($sIdentifier, 'keyframes')) {
                    $oResult = new \MailPoetVendor\Sabberworm\CSS\CSSList\KeyFrame($iIdentifierLineNum);
                    $oResult->setVendorKeyFrame($sIdentifier);
                    $oResult->setAnimationName(\trim($this->consumeUntil('{', \false, \true)));
                    $this->parseList($oResult);
                    return $oResult;
                } else {
                    if ($sIdentifier === 'namespace') {
                        $sPrefix = null;
                        $mUrl = $this->parsePrimitiveValue();
                        if (!$this->comes(';')) {
                            $sPrefix = $mUrl;
                            $mUrl = $this->parsePrimitiveValue();
                        }
                        $this->consume(';');
                        if ($sPrefix !== null && !\is_string($sPrefix)) {
                            throw new \MailPoetVendor\Sabberworm\CSS\Parsing\UnexpectedTokenException('Wrong namespace prefix', $sPrefix, 'custom', $iIdentifierLineNum);
                        }
                        if (!($mUrl instanceof \MailPoetVendor\Sabberworm\CSS\Value\CSSString || $mUrl instanceof \MailPoetVendor\Sabberworm\CSS\Value\URL)) {
                            throw new \MailPoetVendor\Sabberworm\CSS\Parsing\UnexpectedTokenException('Wrong namespace url of invalid type', $mUrl, 'custom', $iIdentifierLineNum);
                        }
                        return new \MailPoetVendor\Sabberworm\CSS\Property\CSSNamespace($mUrl, $sPrefix, $iIdentifierLineNum);
                    } else {
                        //Unknown other at rule (font-face or such)
                        $sArgs = \trim($this->consumeUntil('{', \false, \true));
                        $bUseRuleSet = \true;
                        foreach ($this->blockRules as $sBlockRuleName) {
                            if ($this->identifierIs($sIdentifier, $sBlockRuleName)) {
                                $bUseRuleSet = \false;
                                break;
                            }
                        }
                        if ($bUseRuleSet) {
                            $oAtRule = new \MailPoetVendor\Sabberworm\CSS\RuleSet\AtRuleSet($sIdentifier, $sArgs, $iIdentifierLineNum);
                            $this->parseRuleSet($oAtRule);
                        } else {
                            $oAtRule = new \MailPoetVendor\Sabberworm\CSS\CSSList\AtRuleBlockList($sIdentifier, $sArgs, $iIdentifierLineNum);
                            $this->parseList($oAtRule);
                        }
                        return $oAtRule;
                    }
                }
            }
        }
    }
    private function parseIdentifier($bAllowFunctions = \true, $bIgnoreCase = \true)
    {
        $sResult = $this->parseCharacter(\true);
        if ($sResult === null) {
            throw new \MailPoetVendor\Sabberworm\CSS\Parsing\UnexpectedTokenException($sResult, $this->peek(5), 'identifier', $this->iLineNo);
        }
        $sCharacter = null;
        while (($sCharacter = $this->parseCharacter(\true)) !== null) {
            $sResult .= $sCharacter;
        }
        if ($bIgnoreCase) {
            $sResult = $this->strtolower($sResult);
        }
        if ($bAllowFunctions && $this->comes('(')) {
            $this->consume('(');
            $aArguments = $this->parseValue(array('=', ' ', ','));
            $sResult = new \MailPoetVendor\Sabberworm\CSS\Value\CSSFunction($sResult, $aArguments, ',', $this->iLineNo);
            $this->consume(')');
        }
        return $sResult;
    }
    private function parseStringValue()
    {
        $sBegin = $this->peek();
        $sQuote = null;
        if ($sBegin === "'") {
            $sQuote = "'";
        } else {
            if ($sBegin === '"') {
                $sQuote = '"';
            }
        }
        if ($sQuote !== null) {
            $this->consume($sQuote);
        }
        $sResult = "";
        $sContent = null;
        if ($sQuote === null) {
            //Unquoted strings end in whitespace or with braces, brackets, parentheses
            while (!\preg_match('/[\\s{}()<>\\[\\]]/isu', $this->peek())) {
                $sResult .= $this->parseCharacter(\false);
            }
        } else {
            while (!$this->comes($sQuote)) {
                $sContent = $this->parseCharacter(\false);
                if ($sContent === null) {
                    throw new \MailPoetVendor\Sabberworm\CSS\Parsing\SourceException("Non-well-formed quoted string {$this->peek(3)}", $this->iLineNo);
                }
                $sResult .= $sContent;
            }
            $this->consume($sQuote);
        }
        return new \MailPoetVendor\Sabberworm\CSS\Value\CSSString($sResult, $this->iLineNo);
    }
    private function parseCharacter($bIsForIdentifier)
    {
        if ($this->peek() === '\\') {
            if ($bIsForIdentifier && $this->oParserSettings->bLenientParsing && ($this->comes('\\0') || $this->comes('\\9'))) {
                // Non-strings can contain \0 or \9 which is an IE hack supported in lenient parsing.
                return null;
            }
            $this->consume('\\');
            if ($this->comes('\\n') || $this->comes('\\r')) {
                return '';
            }
            if (\preg_match('/[0-9a-fA-F]/Su', $this->peek()) === 0) {
                return $this->consume(1);
            }
            $sUnicode = $this->consumeExpression('/^[0-9a-fA-F]{1,6}/u', 6);
            if ($this->strlen($sUnicode) < 6) {
                //Consume whitespace after incomplete unicode escape
                if (\preg_match('/\\s/isSu', $this->peek())) {
                    if ($this->comes('MailPoetVendor\\r\\n')) {
                        $this->consume(2);
                    } else {
                        $this->consume(1);
                    }
                }
            }
            $iUnicode = \intval($sUnicode, 16);
            $sUtf32 = "";
            for ($i = 0; $i < 4; ++$i) {
                $sUtf32 .= \chr($iUnicode & 0xff);
                $iUnicode = $iUnicode >> 8;
            }
            return \iconv('utf-32le', $this->sCharset, $sUtf32);
        }
        if ($bIsForIdentifier) {
            $peek = \ord($this->peek());
            // Ranges: a-z A-Z 0-9 - _
            if ($peek >= 97 && $peek <= 122 || $peek >= 65 && $peek <= 90 || $peek >= 48 && $peek <= 57 || $peek === 45 || $peek === 95 || $peek > 0xa1) {
                return $this->consume(1);
            }
        } else {
            return $this->consume(1);
        }
        return null;
    }
    private function parseSelector()
    {
        $aComments = array();
        $oResult = new \MailPoetVendor\Sabberworm\CSS\RuleSet\DeclarationBlock($this->iLineNo);
        $oResult->setSelector($this->consumeUntil('{', \false, \true, $aComments));
        $oResult->setComments($aComments);
        $this->parseRuleSet($oResult);
        return $oResult;
    }
    private function parseRuleSet($oRuleSet)
    {
        while ($this->comes(';')) {
            $this->consume(';');
        }
        while (!$this->comes('}')) {
            $oRule = null;
            if ($this->oParserSettings->bLenientParsing) {
                try {
                    $oRule = $this->parseRule();
                } catch (\MailPoetVendor\Sabberworm\CSS\Parsing\UnexpectedTokenException $e) {
                    try {
                        $sConsume = $this->consumeUntil(array("\n", ";", '}'), \true);
                        // We need to “unfind” the matches to the end of the ruleSet as this will be matched later
                        if ($this->streql(\substr($sConsume, -1), '}')) {
                            --$this->iCurrentPosition;
                        } else {
                            while ($this->comes(';')) {
                                $this->consume(';');
                            }
                        }
                    } catch (\MailPoetVendor\Sabberworm\CSS\Parsing\UnexpectedTokenException $e) {
                        // We’ve reached the end of the document. Just close the RuleSet.
                        return;
                    }
                }
            } else {
                $oRule = $this->parseRule();
            }
            if ($oRule) {
                $oRuleSet->addRule($oRule);
            }
        }
        $this->consume('}');
    }
    private function parseRule()
    {
        $aComments = $this->consumeWhiteSpace();
        $oRule = new \MailPoetVendor\Sabberworm\CSS\Rule\Rule($this->parseIdentifier(), $this->iLineNo);
        $oRule->setComments($aComments);
        $oRule->addComments($this->consumeWhiteSpace());
        $this->consume(':');
        $oValue = $this->parseValue(self::listDelimiterForRule($oRule->getRule()));
        $oRule->setValue($oValue);
        if ($this->oParserSettings->bLenientParsing) {
            while ($this->comes('\\')) {
                $this->consume('\\');
                $oRule->addIeHack($this->consume());
                $this->consumeWhiteSpace();
            }
        }
        $this->consumeWhiteSpace();
        if ($this->comes('!')) {
            $this->consume('!');
            $this->consumeWhiteSpace();
            $this->consume('important');
            $oRule->setIsImportant(\true);
        }
        $this->consumeWhiteSpace();
        while ($this->comes(';')) {
            $this->consume(';');
        }
        $this->consumeWhiteSpace();
        return $oRule;
    }
    private function parseValue($aListDelimiters)
    {
        $aStack = array();
        $this->consumeWhiteSpace();
        //Build a list of delimiters and parsed values
        while (!($this->comes('}') || $this->comes(';') || $this->comes('!') || $this->comes(')') || $this->comes('\\'))) {
            if (\count($aStack) > 0) {
                $bFoundDelimiter = \false;
                foreach ($aListDelimiters as $sDelimiter) {
                    if ($this->comes($sDelimiter)) {
                        \array_push($aStack, $this->consume($sDelimiter));
                        $this->consumeWhiteSpace();
                        $bFoundDelimiter = \true;
                        break;
                    }
                }
                if (!$bFoundDelimiter) {
                    //Whitespace was the list delimiter
                    \array_push($aStack, ' ');
                }
            }
            \array_push($aStack, $this->parsePrimitiveValue());
            $this->consumeWhiteSpace();
        }
        //Convert the list to list objects
        foreach ($aListDelimiters as $sDelimiter) {
            if (\count($aStack) === 1) {
                return $aStack[0];
            }
            $iStartPosition = null;
            while (($iStartPosition = \array_search($sDelimiter, $aStack, \true)) !== \false) {
                $iLength = 2;
                //Number of elements to be joined
                for ($i = $iStartPosition + 2; $i < \count($aStack); $i += 2, ++$iLength) {
                    if ($sDelimiter !== $aStack[$i]) {
                        break;
                    }
                }
                $oList = new \MailPoetVendor\Sabberworm\CSS\Value\RuleValueList($sDelimiter, $this->iLineNo);
                for ($i = $iStartPosition - 1; $i - $iStartPosition + 1 < $iLength * 2; $i += 2) {
                    $oList->addListComponent($aStack[$i]);
                }
                \array_splice($aStack, $iStartPosition - 1, $iLength * 2 - 1, array($oList));
            }
        }
        return $aStack[0];
    }
    private static function listDelimiterForRule($sRule)
    {
        if (\preg_match('/^font($|-)/', $sRule)) {
            return array(',', '/', ' ');
        }
        return array(',', ' ', '/');
    }
    private function parsePrimitiveValue()
    {
        $oValue = null;
        $this->consumeWhiteSpace();
        if (\is_numeric($this->peek()) || $this->comes('-.') && \is_numeric($this->peek(1, 2)) || ($this->comes('-') || $this->comes('.')) && \is_numeric($this->peek(1, 1))) {
            $oValue = $this->parseNumericValue();
        } else {
            if ($this->comes('#') || $this->comes('rgb', \true) || $this->comes('hsl', \true)) {
                $oValue = $this->parseColorValue();
            } else {
                if ($this->comes('url', \true)) {
                    $oValue = $this->parseURLValue();
                } else {
                    if ($this->comes('calc', \true) || $this->comes('-webkit-calc', \true) || $this->comes('-moz-calc', \true)) {
                        $oValue = $this->parseCalcValue();
                    } else {
                        if ($this->comes("'") || $this->comes('"')) {
                            $oValue = $this->parseStringValue();
                        } else {
                            if ($this->comes("progid:") && $this->oParserSettings->bLenientParsing) {
                                $oValue = $this->parseMicrosoftFilter();
                            } else {
                                if ($this->comes("[")) {
                                    $oValue = $this->parseLineNameValue();
                                } else {
                                    $oValue = $this->parseIdentifier(\true, \false);
                                }
                            }
                        }
                    }
                }
            }
        }
        $this->consumeWhiteSpace();
        return $oValue;
    }
    private function parseNumericValue($bForColor = \false)
    {
        $sSize = '';
        if ($this->comes('-')) {
            $sSize .= $this->consume('-');
        }
        while (\is_numeric($this->peek()) || $this->comes('.')) {
            if ($this->comes('.')) {
                $sSize .= $this->consume('.');
            } else {
                $sSize .= $this->consume(1);
            }
        }
        $sUnit = null;
        foreach ($this->aSizeUnits as $iLength => &$aValues) {
            $sKey = \strtolower($this->peek($iLength));
            if (\array_key_exists($sKey, $aValues)) {
                if (($sUnit = $aValues[$sKey]) !== null) {
                    $this->consume($iLength);
                    break;
                }
            }
        }
        return new \MailPoetVendor\Sabberworm\CSS\Value\Size(\floatval($sSize), $sUnit, $bForColor, $this->iLineNo);
    }
    private function parseLineNameValue()
    {
        $this->consume('[');
        $this->consumeWhiteSpace();
        $aNames = array();
        do {
            if ($this->oParserSettings->bLenientParsing) {
                try {
                    $aNames[] = $this->parseIdentifier(\false, \true);
                } catch (\MailPoetVendor\Sabberworm\CSS\Parsing\UnexpectedTokenException $e) {
                }
            } else {
                $aNames[] = $this->parseIdentifier(\false, \true);
            }
            $this->consumeWhiteSpace();
        } while (!$this->comes(']'));
        $this->consume(']');
        return new \MailPoetVendor\Sabberworm\CSS\Value\LineName($aNames, $this->iLineNo);
    }
    private function parseColorValue()
    {
        $aColor = array();
        if ($this->comes('#')) {
            $this->consume('#');
            $sValue = $this->parseIdentifier(\false);
            if ($this->strlen($sValue) === 3) {
                $sValue = $sValue[0] . $sValue[0] . $sValue[1] . $sValue[1] . $sValue[2] . $sValue[2];
            }
            $aColor = array('r' => new \MailPoetVendor\Sabberworm\CSS\Value\Size(\intval($sValue[0] . $sValue[1], 16), null, \true, $this->iLineNo), 'g' => new \MailPoetVendor\Sabberworm\CSS\Value\Size(\intval($sValue[2] . $sValue[3], 16), null, \true, $this->iLineNo), 'b' => new \MailPoetVendor\Sabberworm\CSS\Value\Size(\intval($sValue[4] . $sValue[5], 16), null, \true, $this->iLineNo));
        } else {
            $sColorMode = $this->parseIdentifier(\false);
            $this->consumeWhiteSpace();
            $this->consume('(');
            $iLength = $this->strlen($sColorMode);
            for ($i = 0; $i < $iLength; ++$i) {
                $this->consumeWhiteSpace();
                $aColor[$sColorMode[$i]] = $this->parseNumericValue(\true);
                $this->consumeWhiteSpace();
                if ($i < $iLength - 1) {
                    $this->consume(',');
                }
            }
            $this->consume(')');
        }
        return new \MailPoetVendor\Sabberworm\CSS\Value\Color($aColor, $this->iLineNo);
    }
    private function parseMicrosoftFilter()
    {
        $sFunction = $this->consumeUntil('(', \false, \true);
        $aArguments = $this->parseValue(array(',', '='));
        return new \MailPoetVendor\Sabberworm\CSS\Value\CSSFunction($sFunction, $aArguments, ',', $this->iLineNo);
    }
    private function parseURLValue()
    {
        $bUseUrl = $this->comes('url', \true);
        if ($bUseUrl) {
            $this->consume('url');
            $this->consumeWhiteSpace();
            $this->consume('(');
        }
        $this->consumeWhiteSpace();
        $oResult = new \MailPoetVendor\Sabberworm\CSS\Value\URL($this->parseStringValue(), $this->iLineNo);
        if ($bUseUrl) {
            $this->consumeWhiteSpace();
            $this->consume(')');
        }
        return $oResult;
    }
    private function parseCalcValue()
    {
        $aOperators = array('+', '-', '*', '/', '(', ')');
        $sFunction = \trim($this->consumeUntil('(', \false, \true));
        $oCalcList = new \MailPoetVendor\Sabberworm\CSS\Value\CalcRuleValueList($this->iLineNo);
        $oList = new \MailPoetVendor\Sabberworm\CSS\Value\RuleValueList(',', $this->iLineNo);
        $iNestingLevel = 0;
        $iLastComponentType = \NULL;
        while (!$this->comes(')') || $iNestingLevel > 0) {
            $this->consumeWhiteSpace();
            if (\in_array($this->peek(), $aOperators)) {
                if ($this->comes('-') || $this->comes('+')) {
                    if ($this->peek(1, -1) != ' ' || !($this->comes('- ') || $this->comes('+ '))) {
                        throw new \MailPoetVendor\Sabberworm\CSS\Parsing\UnexpectedTokenException(" {$this->peek()} ", $this->peek(1, -1) . $this->peek(2), 'literal', $this->iLineNo);
                    }
                } else {
                    if ($this->comes('(')) {
                        $iNestingLevel++;
                    } else {
                        if ($this->comes(')')) {
                            $iNestingLevel--;
                        }
                    }
                }
                $oCalcList->addListComponent($this->consume(1));
                $iLastComponentType = \MailPoetVendor\Sabberworm\CSS\Value\CalcFunction::T_OPERATOR;
            } else {
                $oVal = $this->parsePrimitiveValue();
                if ($iLastComponentType == \MailPoetVendor\Sabberworm\CSS\Value\CalcFunction::T_OPERAND) {
                    throw new \MailPoetVendor\Sabberworm\CSS\Parsing\UnexpectedTokenException(\sprintf('Next token was expected to be an operand of type %s. Instead "%s" was found.', \implode(', ', $aOperators), $oVal), '', 'custom', $this->iLineNo);
                }
                $oCalcList->addListComponent($oVal);
                $iLastComponentType = \MailPoetVendor\Sabberworm\CSS\Value\CalcFunction::T_OPERAND;
            }
        }
        $oList->addListComponent($oCalcList);
        $this->consume(')');
        return new \MailPoetVendor\Sabberworm\CSS\Value\CalcFunction($sFunction, $oList, ',', $this->iLineNo);
    }
    /**
     * Tests an identifier for a given value. Since identifiers are all keywords, they can be vendor-prefixed. We need to check for these versions too.
     */
    private function identifierIs($sIdentifier, $sMatch)
    {
        return \strcasecmp($sIdentifier, $sMatch) === 0 ?: \preg_match("/^(-\\w+-)?{$sMatch}\$/i", $sIdentifier) === 1;
    }
    private function comes($sString, $bCaseInsensitive = \false)
    {
        $sPeek = $this->peek(\strlen($sString));
        return $sPeek == '' ? \false : $this->streql($sPeek, $sString, $bCaseInsensitive);
    }
    private function peek($iLength = 1, $iOffset = 0)
    {
        $iOffset += $this->iCurrentPosition;
        if ($iOffset >= $this->iLength) {
            return '';
        }
        return $this->substr($iOffset, $iLength);
    }
    private function consume($mValue = 1)
    {
        if (\is_string($mValue)) {
            $iLineCount = \substr_count($mValue, "\n");
            $iLength = $this->strlen($mValue);
            if (!$this->streql($this->substr($this->iCurrentPosition, $iLength), $mValue)) {
                throw new \MailPoetVendor\Sabberworm\CSS\Parsing\UnexpectedTokenException($mValue, $this->peek(\max($iLength, 5)), $this->iLineNo);
            }
            $this->iLineNo += $iLineCount;
            $this->iCurrentPosition += $this->strlen($mValue);
            return $mValue;
        } else {
            if ($this->iCurrentPosition + $mValue > $this->iLength) {
                throw new \MailPoetVendor\Sabberworm\CSS\Parsing\UnexpectedTokenException($mValue, $this->peek(5), 'count', $this->iLineNo);
            }
            $sResult = $this->substr($this->iCurrentPosition, $mValue);
            $iLineCount = \substr_count($sResult, "\n");
            $this->iLineNo += $iLineCount;
            $this->iCurrentPosition += $mValue;
            return $sResult;
        }
    }
    private function consumeExpression($mExpression, $iMaxLength = null)
    {
        $aMatches = null;
        $sInput = $iMaxLength !== null ? $this->peek($iMaxLength) : $this->inputLeft();
        if (\preg_match($mExpression, $sInput, $aMatches, \PREG_OFFSET_CAPTURE) === 1) {
            return $this->consume($aMatches[0][0]);
        }
        throw new \MailPoetVendor\Sabberworm\CSS\Parsing\UnexpectedTokenException($mExpression, $this->peek(5), 'expression', $this->iLineNo);
    }
    private function consumeWhiteSpace()
    {
        $comments = array();
        do {
            while (\preg_match('/\\s/isSu', $this->peek()) === 1) {
                $this->consume(1);
            }
            if ($this->oParserSettings->bLenientParsing) {
                try {
                    $oComment = $this->consumeComment();
                } catch (\MailPoetVendor\Sabberworm\CSS\Parsing\UnexpectedTokenException $e) {
                    // When we can’t find the end of a comment, we assume the document is finished.
                    $this->iCurrentPosition = $this->iLength;
                    return;
                }
            } else {
                $oComment = $this->consumeComment();
            }
            if ($oComment !== \false) {
                $comments[] = $oComment;
            }
        } while ($oComment !== \false);
        return $comments;
    }
    /**
     * @return false|Comment
     */
    private function consumeComment()
    {
        $mComment = \false;
        if ($this->comes('/*')) {
            $iLineNo = $this->iLineNo;
            $this->consume(1);
            $mComment = '';
            while (($char = $this->consume(1)) !== '') {
                $mComment .= $char;
                if ($this->comes('*/')) {
                    $this->consume(2);
                    break;
                }
            }
        }
        if ($mComment !== \false) {
            // We skip the * which was included in the comment.
            return new \MailPoetVendor\Sabberworm\CSS\Comment\Comment(\substr($mComment, 1), $iLineNo);
        }
        return $mComment;
    }
    private function isEnd()
    {
        return $this->iCurrentPosition >= $this->iLength;
    }
    private function consumeUntil($aEnd, $bIncludeEnd = \false, $consumeEnd = \false, array &$comments = array())
    {
        $aEnd = \is_array($aEnd) ? $aEnd : array($aEnd);
        $out = '';
        $start = $this->iCurrentPosition;
        while (($char = $this->consume(1)) !== '') {
            if (\in_array($char, $aEnd)) {
                if ($bIncludeEnd) {
                    $out .= $char;
                } elseif (!$consumeEnd) {
                    $this->iCurrentPosition -= $this->strlen($char);
                }
                return $out;
            }
            $out .= $char;
            if ($comment = $this->consumeComment()) {
                $comments[] = $comment;
            }
        }
        $this->iCurrentPosition = $start;
        throw new \MailPoetVendor\Sabberworm\CSS\Parsing\UnexpectedTokenException('One of ("' . \implode('","', $aEnd) . '")', $this->peek(5), 'search', $this->iLineNo);
    }
    private function inputLeft()
    {
        return $this->substr($this->iCurrentPosition, -1);
    }
    private function substr($iStart, $iLength)
    {
        if ($iLength < 0) {
            $iLength = $this->iLength - $iStart + $iLength;
        }
        if ($iStart + $iLength > $this->iLength) {
            $iLength = $this->iLength - $iStart;
        }
        $sResult = '';
        while ($iLength > 0) {
            $sResult .= $this->aText[$iStart];
            $iStart++;
            $iLength--;
        }
        return $sResult;
    }
    private function strlen($sString)
    {
        if ($this->oParserSettings->bMultibyteSupport) {
            return \mb_strlen($sString, $this->sCharset);
        } else {
            return \strlen($sString);
        }
    }
    private function streql($sString1, $sString2, $bCaseInsensitive = \true)
    {
        if ($bCaseInsensitive) {
            return $this->strtolower($sString1) === $this->strtolower($sString2);
        } else {
            return $sString1 === $sString2;
        }
    }
    private function strtolower($sString)
    {
        if ($this->oParserSettings->bMultibyteSupport) {
            return \mb_strtolower($sString, $this->sCharset);
        } else {
            return \strtolower($sString);
        }
    }
    private function strsplit($sString)
    {
        if ($this->oParserSettings->bMultibyteSupport) {
            if ($this->streql($this->sCharset, 'utf-8')) {
                return \preg_split('//u', $sString, null, \PREG_SPLIT_NO_EMPTY);
            } else {
                $iLength = \mb_strlen($sString, $this->sCharset);
                $aResult = array();
                for ($i = 0; $i < $iLength; ++$i) {
                    $aResult[] = \mb_substr($sString, $i, 1, $this->sCharset);
                }
                return $aResult;
            }
        } else {
            if ($sString === '') {
                return array();
            } else {
                return \str_split($sString);
            }
        }
    }
    private function strpos($sString, $sNeedle, $iOffset)
    {
        if ($this->oParserSettings->bMultibyteSupport) {
            return \mb_strpos($sString, $sNeedle, $iOffset, $this->sCharset);
        } else {
            return \strpos($sString, $sNeedle, $iOffset);
        }
    }
}
