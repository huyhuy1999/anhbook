<?php

namespace MailPoetVendor\Sabberworm\CSS\Property;

use MailPoetVendor\Sabberworm\CSS\Renderable;
use MailPoetVendor\Sabberworm\CSS\Comment\Commentable;
interface AtRule extends \MailPoetVendor\Sabberworm\CSS\Renderable, \MailPoetVendor\Sabberworm\CSS\Comment\Commentable
{
    const BLOCK_RULES = 'media/document/supports/region-style/font-feature-values';
    // Since there are more set rules than block rules, we’re whitelisting the block rules and have anything else be treated as a set rule.
    const SET_RULES = 'font-face/counter-style/page/swash/styleset/annotation';
    //…and more font-specific ones (to be used inside font-feature-values)
    public function atRuleName();
    public function atRuleArgs();
}
