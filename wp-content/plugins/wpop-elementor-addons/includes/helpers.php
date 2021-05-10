<?php
namespace Elementor;

function wpopea_elementor_init(){
    Plugin::instance()->elements_manager->add_category(
        'opstore-elements',
        [
            'title'  => esc_html__('WPOP Elements','wpopea'),
            'icon' => 'font'
        ],
        1
    );
}
add_action('elementor/init','Elementor\wpopea_elementor_init');

trait WPOPEACommonFunctions {

    /**
     * For Exclude Option
     */
    public function wpopea_query_controls( ) {

      $this->start_controls_section(
         'wpop_query_settings',
         [
            'label' => esc_html__( 'Query Settings', 'wpopea' )
         ]
      ); 

      $this->add_control(
         'post_type',
         [
            'label' => esc_html__( 'Post Type', 'wpopea' ),
            'type' => Controls_Manager::SELECT,
            'options' => [
                       'latest'   => esc_html__('Latest','wpopea'),
                       'category'     => esc_html__('Category','wpopea'),
            ],
            'default' => 'latest'
         ]
      );

      $this->add_control(
         'category',
         [
         'label' => esc_html__( 'Categories', 'wpopea' ),
         'type' => Controls_Manager::SELECT2,
         'multiple' => true,
         'label_block' => true,
         'options' => get_post_type_categories('category'),
         'condition' => [
            'post_type' => 'category'
          ]
         ]
      );

      $this->add_control(
         'per_page',
         [
            'label' => esc_html__( 'No. of Posts', 'wpopea' ),
            'type' => Controls_Manager::NUMBER,
            'default' => 3
         ]
      );

      $this->add_control(
         'offset',
         [
            'label' => esc_html__( 'No. of Offset', 'wpopea' ),
            'type' => Controls_Manager::NUMBER,
            'default' => 0,
         ]
      );

      $this->add_control(
         'columns',
         [
            'label' => esc_html__( 'No. of Column', 'wpopea' ),
            'type' => Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 4,
            'default' => 3,
         ]
      );

        $this->add_control(
            'order',
            [
                'label'             => esc_html__( 'Order', 'wpopea' ),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                   'DESC'           => esc_html__( 'Descending', 'wpopea' ),
                   'ASC'       => esc_html__( 'Ascending', 'wpopea' ),
                ],
                'default'           => 'DESC',
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'             => esc_html__( 'Order By', 'wpopea' ),
                'type'              => Controls_Manager::SELECT,
                'options'           => get_post_orderby_options(),
                'default'           => 'date',
            ]
        );


        $this->add_control('show_excerpt',
            [
                'label'         => esc_html__('Show Excerpt', 'wpopea'),
                'type'          => Controls_Manager::SWITCHER,
                'return_value'  => 'true',
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label' => __( 'Excerpt Length', 'wpopea' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '10',
                'condition' => [
                    'show_excerpt' => 'true',
                ],
            ]
        );

      $this->add_control(
         'readmore_text',
         [
            'label' => esc_html__( 'Read More Text', 'wpopea' ),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__( 'Read More', 'wpopea' ),
            'condition' => [
                'show_excerpt' => 'true',
            ],
         ]
      );

      $this->end_controls_section();
    }

    /**
     * Slider Settings
     */
    public function wpopea_slider_controls( ) {

        $this->start_controls_section(
         'uad_slider_section',
         [
            'label' => esc_html__( 'Slider Settings', 'wpopea' ),
            'condition' => ['display_style' => 'carousel']
         ]
        ); 

        $this->add_responsive_control(
         'slide_no',
         [
         'label' => esc_html__( 'Slide to Show', 'wpopea' ),
         'type' => Controls_Manager::NUMBER,
         'label_block' => true,
         'min' => 1,
         'max' => 10,
         'default' => 3,
         ]
        );
        $this->add_responsive_control(
         'slide_item',
         [
         'label' => esc_html__( 'No. of Item to Slide', 'wpopea' ),
         'type' => Controls_Manager::NUMBER,
         'label_block' => true,
         'min' => 1,
         'max' => 10,
         'default' => 1
         ]
        );
        $this->add_control(
        'auto_slide',
        [
          'label' => esc_html__( 'Auto Slide', 'wpopea' ),
          'type' => Controls_Manager::SWITCHER,
          'default' => 'true',
          'return_value' => 'true',
        ]
        );
        $this->add_control(
          'show_pager',
          [
            'label' => esc_html__( 'Show Pager', 'wpopea' ),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'true',
            'return_value' => 'true',
          ]
        );
        $this->add_control(
          'show_arrow',
          [
            'label' => esc_html__( 'Show Arrow', 'wpopea' ),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'true',
            'return_value' => 'true',
          ]
        );
        $this->add_control(
          'infinite_slide',
          [
            'label' => esc_html__( 'Infinite Slide', 'wpopea' ),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'true',
            'return_value' => 'true',
          ]
        );
        $this->end_controls_section();
    }
}