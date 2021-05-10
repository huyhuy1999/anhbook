<?php

/**
 * HTML list of main catalog nav menu items.
 */
class WalkerCatalogCards extends Walker_Nav_Menu
{
    /**
     * Starts the list before the elements are added.
     *
     * @since 3.0.0
     *
     * @see Walker::start_lvl()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of menu item. Used for padding.
     * @param stdClass $args An object of wp_nav_menu() arguments.
     */
    public function start_lvl(&$output, $depth = 0, $args = array())
    {

    }

    /**
     * Starts the element output.
     *
     * @since 3.0.0
     * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
     *
     * @see Walker::start_el()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param WP_Post $item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param stdClass $args An object of wp_nav_menu() arguments.
     * @param int $id Current item ID.
     */
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        /**
         * List Element
         */

        // Image
        $field_image = '';
        if(function_exists('get_field')){
            $field_image = get_field('image', $item->ID);
        }

        //Link attributes
        $link = ! empty( $item->url ) ? 'href="'.esc_attr($item->url).'"' : '';
        $target = !empty($item->target) ? ' target="'.esc_attr($item->target).'"' : '';
        $title = !empty($item->attr_title) ? ' title="'.esc_attr($item->attr_title).'"' : '';
        $rel = !empty($item->xfn) ? ' rel="'.esc_attr($item->xfn).'"' : '';

        $link_attributes = $link . $target . $title .$rel;

        $title = apply_filters('the_title', $item->title, $item->ID);

        $block_name = esc_attr(apply_filters('premmerce-catalog-cards-item-block-class','catalog-section'));

        ob_start();
        ?>

            <li class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <a class="<?php echo esc_attr($block_name); ?>" <?php echo $link_attributes; ?>>
                    <div class="<?php echo esc_attr($block_name); ?>__image">
                        <?php if($field_image) :?>
                            <img src="<?php echo esc_url($field_image['url']); ?>" alt="<?php echo esc_attr($title); ?>" class="<?php echo esc_attr($block_name); ?>__img">
                            <?php else: ?>
                            <?php $nophoto_url = get_template_directory_uri() . '/public/img/nophoto.jpg'; ?>
                            <img src="<?php echo esc_url($nophoto_url); ?>" alt="<?php echo esc_attr($title); ?>" class="<?php echo esc_attr($block_name); ?>__img">
                        <?php endif; ?>
                    </div>
                    <div class="<?php echo esc_attr($block_name); ?>__caption">
                        <?php echo esc_html($title); ?>
                    </div>
                </a>
            </li>

        <?php
        $item_output = ob_get_clean();
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    /**
     * Ends the element output, if needed.
     *
     * @since 3.0.0
     *
     * @see Walker::end_el()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param WP_Post $item Page data object. Not used.
     * @param int $depth Depth of page. Not Used.
     * @param stdClass $args An object of wp_nav_menu() arguments.
     */
    public function end_el(&$output, $item, $depth = 0, $args = array())
    {

    }

    /**
     * Ends the list of after the elements are added.
     *
     * @since 3.0.0
     *
     * @see Walker::end_lvl()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int $depth Depth of menu item. Used for padding.
     * @param stdClass $args An object of wp_nav_menu() arguments.
     */
    public function end_lvl(&$output, $depth = 0, $args = array())
    {

    }
}