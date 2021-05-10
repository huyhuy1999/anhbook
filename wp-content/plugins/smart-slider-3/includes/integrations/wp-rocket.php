<?php

class NextendSmartSliderWPRocket {

    public function __construct() {

        add_action('init', array(
            $this,
            'init'
        ));
    }

    public function init() {
        if (function_exists('rocket_cdn_enqueue')) {
            N2Pluggable::addFilter('n2_style_loader_src', array(
                $this,
                'filterSrcCDN'
            ));

            N2Pluggable::addFilter('n2_script_loader_src', array(
                $this,
                'filterSrcCDN'
            ));
        }
    }

    public function filterSrcCDN($src) {
        return rocket_cdn_enqueue($src);
    }
}

new NextendSmartSliderWPRocket();