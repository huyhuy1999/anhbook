<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Opstore_Products_Sale extends Widget_Base {

   public function get_title() {
      return esc_html__( 'Opstore Sale Products', 'opstore' );
   }

   public function get_icon() {
      return 'eicon-woocommerce';
   }
   public function get_categories() {
      return [ 'opstore-elements' ];
   }
   public function get_name() {
      return 'opstore-products-sale';
   }

    public function get_script_depends() {
        return [
            'opstore-el-js',
        ];
    }

   protected function _register_controls() {

      $this->start_controls_section(
         'opstore_sections_list',
         [
            'label' => esc_html__( 'Display Settings', 'opstore' )
         ]
      ); 

      $this->add_control(
         'per_page',
         [
         'label' => esc_html__( 'No. of Product', 'opstore' ),
         'type' => Controls_Manager::NUMBER,
         'label_block' => true,
         'default' => 6
         ]
      );


      $this->end_controls_section();

      $this->start_controls_section(
         'opstore_products_styles',
         [
            'label' => esc_html__( 'Colors & Typography', 'opstore' ),
            'tab' => Controls_Manager::TAB_STYLE
         ]
      );
      $this->add_control(
         'opstore_block_title_style',
         [
            'label' => esc_html__( 'Block Title Styles', 'opstore' ),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
         ]
      );   
      $this->add_control(
         'product_title_color',
         [
            'label' => esc_html__( 'Block Title Color', 'opstore' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#2e2e2d',
            'selectors' => [
               '{{WRAPPER}} h2.woocommerce-loop-product__title a' => 'color: {{VALUE}}',
            ]

         ]
      );

      $this->add_control(
         'product_hover_color',
         [
            'label' => esc_html__( 'Title Hover Color', 'opstore' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#89c350',
            'selectors' => [
               '{{WRAPPER}} h2.woocommerce-loop-product__title a:hover' => 'color: {{VALUE}}',
            ]

         ]
      );

      $this->add_group_control(
         Group_Control_Typography::get_type(),
         [
            'name' => 'product_title_typo',
            'label' => esc_html__( 'Title Typography', 'opstore' ),
            'selector' => '{{WRAPPER}} h2.woocommerce-loop-product__title',
         ]
      );  
      $this->add_control(
         'opstore_sale_tag_style',
         [
            'label' => esc_html__( 'Sale Tag Styles', 'opstore' ),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
         ]
      ); 
      $this->add_control(
         'sale_tag_bg_color',
         [
            'label' => esc_html__( 'Background Color', 'opstore' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#89c350',
            'selectors' => [
               '{{WRAPPER}} ul.products li.product .onsale' => 'background-color: {{VALUE}}',
            ]

         ]
      );  
      $this->add_control(
         'sale_tag_color',
         [
            'label' => esc_html__( 'Text Color', 'opstore' ),
            'type' => Controls_Manager::COLOR,
            'default' => '#fff',
            'selectors' => [
               '{{WRAPPER}} ul.products li.product .onsale' => 'color: {{VALUE}}',
            ]

         ]
      );      
      $this->end_controls_section();
   }

   protected function render( ) {
      
      wp_enqueue_script('wpopea-el-countdown-js');
      // get our input from the widget settings.
      $settings = $this->get_settings();

        $per_page = $settings['per_page'];

        wc_reset_loop();
        global $woocommerce_loop;



          $args = array(
              'post_type'      => 'product',
              'posts_per_page' => $per_page,
              'meta_query'     => array(                        
                      array( // Simple products type
                          'key'           => '_sale_price_dates_to',
                          'value'         => 0,
                          'compare'       => '>',
                          'type'          => 'numeric'
                      )
                  )
           
          );

        $mquery = new \WP_Query( $args );
        if( $mquery->have_posts() ):

              ?>
              <ul class="products opstore-sale-slide" >
              <?php
              while( $mquery->have_posts() ): $mquery->the_post();
                 ?>
                 <li <?php post_class(); ?> >
                  <?php do_action( 'woocommerce_before_shop_loop_item' );?>
                  <figure>
                    <?php

                    do_action( 'opstore_loop_before_thumbnail' );

                    do_action( 'woocommerce_before_shop_loop_item_title' );
                    ?>
                  </figure>
                   <a class="product-title" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
                      <?php woocommerce_template_loop_product_title(); ?>
                   </a>
                    <?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>   
                    <?php opstore_stock_info();?>
                    <?php opstore_sales_countdown();?>
                    <div class="btn">
                      <a href="<?php the_permalink();?>"><?php echo esc_html__('View Details','opstore');?></a>
                    </div>
                 </li>
                 <?php
              endwhile;
           echo '</ul>';
           
        endif;

        wc_reset_loop();
        wp_reset_postdata();


   }

   protected function content_template() {}

   public function render_plain_content( $instance = [] ) {}

}

Plugin::instance()->widgets_manager->register_widget_type( new Widget_Opstore_Products_Sale() );