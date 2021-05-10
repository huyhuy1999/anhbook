<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<div class="pc-product-shipping">
    <div class="pc-product-shipping__row">
        <div class="pc-product-shipping__header">
            <div class="pc-product-shipping__ico">
                <div class="fa fa-credit-card" aria-hidden="true"></div>
            </div>
            <div class="pc-product-shipping__title">Payment methods</div>
            <div class="pc-product-shipping__tooltip">
                <div class="tooltip">
                    <div class="fa fa-info-circle" aria-hidden="true"></div>
                    <div class="tooltip__drop tooltip__drop--rtl">
                        <div class="tooltip__desc tooltip__desc--md">
                            <div class="typo">
                                <dl>
                                    <dt>Direct bank transfer</dt>
                                    <dd>Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.</dd>
                                </dl>
                                <dl>
                                    <dt>Check payments</dt>
                                    <dd>Please send a check to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</dd>
                                </dl>
                                <dl>
                                    <dt>Cash on delivery</dt>
                                    <dd>Pay with cash upon delivery.</dd>
                                </dl>
                                <dl>
                                    <dt>PayPal</dt>
                                    <dd>You can pay with your credit card if you don't have a PayPal account.</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ul class="pc-product-shipping__list">
            <li class="pc-product-shipping__item">Direct bank transfer</li>
            <li class="pc-product-shipping__item">Check payments</li>
            <li class="pc-product-shipping__item">Cash on delivery</li>
            <li class="pc-product-shipping__item">PayPal</li>
        </ul>
    </div>
    <div class="pc-product-shipping__row">
        <div class="pc-product-shipping__header">
            <div class="pc-product-shipping__ico">
                <div class="fa fa-truck" aria-hidden="true"></div>
            </div>
            <div class="pc-product-shipping__title">Shipping methods</div>
            <div class="pc-product-shipping__tooltip">
                <div class="tooltip">
                    <div class="fa fa-info-circle" aria-hidden="true"></div>
                    <div class="tooltip__drop tooltip__drop--rtl">
                        <div class="tooltip__desc tooltip__desc--md">
                            <div class="typo">
                                <dl>
                                    <dt>Flat rate</dt>
                                    <dd>Lets you charge a fixed rate for shipping</dd>
                                </dl>
                                <dl>
                                    <dt>Free shipping</dt>
                                    <dd>Can be triggered with minimum spends of 200$</dd>
                                </dl>
                                <dl>
                                    <dt>Local pickup</dt>
                                    <dd>Allow customers to pick up orders themselves. By default, when using local pickup store base taxes will apply regardless of customer address.</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ul class="pc-product-shipping__list">
            <li class="pc-product-shipping__item">Flat rate</li>
            <li class="pc-product-shipping__item">Free shipping</li>
            <li class="pc-product-shipping__item">Local pickup</li>
        </ul>
    </div>
</div>