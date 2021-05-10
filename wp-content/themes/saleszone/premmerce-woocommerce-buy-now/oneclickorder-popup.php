<?php
if ( ! defined( 'WPINC' ) ) {
    die;
}

?>

<div class="modal modal--sm">

    <?php wc_get_template('../parts/modal/modal-header.php', array(
        'title' => __('One click order','saleszone')
    )) ?>

    <form class="form" method="post" action="<?php echo esc_attr($routeUrl); ?>" data-oneclick-order--ajax>

        <div class="modal__content">

            <?php if(isset($productId)) :?>
                <?php $query = new WP_Query(array(
                    'post_type' => array('product_variation', 'product'),
                    'post__in' => array($productId),
                    'posts_per_page' => 1
                )); ?>

                <?php while ($query->have_posts()) : ?>
                    <?php $query->the_post(); ?>
                    <div class="form__field">
                        <?php wc_get_template('content-product_thumb.php', array(
                                'modifiers' => 'product-thumb--lg'
                        )); ?>
                    </div>
                <?php endwhile; ?>

                <?php wp_reset_postdata(); ?>
            <?php endif; ?>

            <?php if($success): ?>
                <div class="" data-oneclick-order--success>
                    <div class="typo">
                        <?php esc_html_e('Thank you for your order! Our manager will contact you as soon as possible.', 'saleszone'); ?>
                    </div>
                </div>
            <?php else: ?>
                <!-- Name -->
                <?php

                if ($options['name']){
                    woocommerce_form_field('name',array(
                        'type' => 'text',
                        'class' => array('form__field'),
                        'label_class' => array('form__label'),
                        'input_class'=> array('form-control'),
                        'name' => 'name',
                        'autocomplete' => 'username',
                        'label' => __( 'Name', 'saleszone' ),
                        'required' => true,
                        'custom_attributes' => array('required' => 'required')
                    ), $userData && isset($userData['first_name']) ? $userData['first_name'] : '');
                }

                if ($options['email']){
                    woocommerce_form_field('email',array(
                        'type' => 'email',
                        'class' => array('form__field'),
                        'label_class' => array('form__label'),
                        'input_class'=> array('form-control'),
                        'name' => 'email',
                        'autocomplete' => 'email',
                        'label' => __( 'Email', 'saleszone' ),
                        'required' => true,
                        'custom_attributes' => array('required' => 'required')
                    ), $userData && isset($userData['email']) ? $userData['email'] : '');
                }

                if ($options['phone']){
                    woocommerce_form_field('phone',array(
                        'type' => 'text',
                        'class' => array('form__field'),
                        'label_class' => array('form__label'),
                        'input_class'=> array('form-control'),
                        'name' => 'phone',
                        'label' => __( 'Phone', 'saleszone' ),
                        'required' => true,
                        'custom_attributes' => array('required' => 'required')
                    ), $userData && isset($userData['phone']) ? $userData['phone'] : '');
                }

                if ($options['comment']){
                    woocommerce_form_field('comment',array(
                        'type' => 'textarea',
                        'class' => array('form__field'),
                        'label_class' => array('form__label'),
                        'input_class'=> array('form-control'),
                        'name' => 'comment',
                        'rows' => 3,
                        'label' => __( 'Your comment', 'saleszone' ),
                    ));
                }

                ?>
            <?php endif; ?>
        </div>

        <div class="modal__footer">
            <div class="modal__footer-row">

                <div class="modal__footer-btn hidden-xs">
                    <button class="btn btn-default" type="reset" data-oneclick-order--btn-close>
                        <?php esc_html_e('Close', 'saleszone'); ?>
                    </button>
                </div>

                <?php if(!$success) :?>
                    <div class="modal__footer-btn">
                        <input type="hidden" name="product_id" value="<?php echo esc_attr($productId); ?>">
                        <?php wp_nonce_field('wp_rest'); ?>
                        <button class="btn btn-primary" type="submit">
                            <?php esc_html_e('Place order', 'saleszone'); ?>
                        </button>
                    </div>
                <?php endif; ?>

            </div>
        </div>

    </form>

</div>