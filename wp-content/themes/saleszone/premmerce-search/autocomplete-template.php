<?php if(!defined('WPINC')) die; ?>

<div style="display: none!important;" data-autocomplete-templates>

    <!-- Autocomplete list item template -->
    <a class="autocomplete autocomplete--item" href="#" data-autocomplete-template="item">
        <div class="autocomplete__product">
            <!-- Photo  -->
            <div class="autocomplete__product-photo" style="display: none;" data-autocomplete-product-photo>
                <div class="product-photo">
                    <span class="product-photo__item product-photo__item--xs">
                        <img class="product-photo__img" alt="No photo" data-autocomplete-product-img>
                    </span>
                </div>
            </div>

            <div class="autocomplete__product-info">
                <!-- Title -->
                <div class="autocomplete__product-title" data-autocomplete-product-name></div>
                <!-- Price -->
                <div class="autocomplete__product-price">
                    <div class="product-price product-price--sm product-price--bold" data-autocomplete-product-price>
                    </div>
                </div>
            </div>
        </div>
    </a>

    <!-- Autocomplete Show all result item template -->
    <div class="autocomplete autocomplete--item autocomplete__message autocomplete__message--show-all" data-autocomplete-template="allResult">
        <a href="#woocommerce-product-search-field" data-autocomplete-show-all-result>
            <?php esc_html_e('All search results', 'saleszone'); ?>
        </a>
    </div>

</div>