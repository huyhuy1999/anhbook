<?php

/**
 * Class Saleszone_admin_page
 *
 */
class Saleszone_admin_page
{
    private  $themeName ;
    public function __construct()
    {
        $theme = wp_get_theme();
        $this->themeName = $theme->get( 'Name' );
        $this->pageSlug = 'saleszone';
        add_action( 'admin_menu', array( $this, 'addMenuItems' ) );
        add_action( 'admin_init', array( $this, 'registerOptions' ) );
        add_action( 'wp_ajax_saleszone_imp', array( $this, 'ajaxPremmerceImport' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueueScript' ) );
        add_action( 'admin_notices', array( $this, 'renderAdminNotice' ) );
        add_action( 'wp_ajax_saleszone_notice_ignore', array( $this, 'premmerceNoticeIgnore' ) );
        add_action( 'wp_ajax_saleszone_task_state', array( $this, 'premmerceChangeTaskState' ) );
    }
    
    /**
     * Import page slug
     *
     * @var string
     */
    private  $pageSlug ;
    /**
     * Show Get started notice
     */
    public function renderAdminNotice()
    {
        $user = wp_get_current_user();
        $user_id = $user->ID;
        $theme_data = wp_get_theme();
        $meta_key = esc_html( $theme_data->get( 'TextDomain' ) ) . '_notice_ignore';
        // for debug -delete_user_meta($user_id, $meta_key);
        if ( !get_user_meta( $user_id, $meta_key ) && get_current_screen()->id !== 'appearance_page_' . $this->pageSlug ) {
            saleszone_get_template( 'functions/admin/views/notice.php', array(
                'themeName'       => $this->themeName,
                'themeVersion'    => $theme_data->Version,
                'themeTextDomain' => $theme_data->get( 'TextDomain' ),
            ) );
        }
    }
    
    public function premmerceChangeTaskState()
    {
        $user = wp_get_current_user();
        $user_id = $user->ID;
        $theme_data = wp_get_theme();
        $new_state = ( isset( $_GET['setState'] ) ? sanitize_text_field( wp_unslash( $_GET['setState'] ) ) : '' );
        $option_name = ( isset( $_GET['task'] ) ? sanitize_text_field( wp_unslash( $_GET['task'] ) ) : '' );
        $meta_key = esc_html( $theme_data->get( 'TextDomain' ) ) . '-' . $option_name;
        update_user_meta( $user_id, $meta_key, $new_state );
        die( esc_html( get_user_meta( $user_id, $meta_key, true ) ) );
    }
    
    public function premmerceNoticeIgnore()
    {
        $user = wp_get_current_user();
        $user_id = $user->ID;
        $theme_data = wp_get_theme();
        add_user_meta(
            $user_id,
            esc_html( $theme_data->get( 'TextDomain' ) ) . '_notice_ignore',
            'true',
            true
        );
        die;
    }
    
    /**
     * Add import page in WP Appearance menu
     */
    public function addMenuItems()
    {
        add_theme_page(
            $this->themeName,
            $this->themeName,
            'manage_options',
            $this->pageSlug,
            array( $this, 'renderThemePage' )
        );
    }
    
    public function registerOptions()
    {
        add_settings_section(
            'main_section',
            '',
            '',
            $this->pageSlug
        );
        add_settings_field(
            'demodataPreset',
            __( 'Select demodata preset', 'saleszone' ),
            array( $this, 'renderSelectDemodata' ),
            $this->pageSlug,
            'main_section'
        );
    }
    
    /**
     * Ajax handler for import
     */
    public function ajaxPremmerceImport()
    {
        
        if ( isset( $_POST['importLink'] ) ) {
            $jsonLink = esc_url( sanitize_text_field( wp_unslash( $_POST['importLink'] ) ) );
        } else {
            $jsonLink = null;
        }
        
        $imp = new SaleszoneImportTool();
        $imp->run( $jsonLink );
    }
    
    /**
     * Render Select with demodata presets on admin menu page
     *
     */
    public function renderSelectDemodata()
    {
        $theme_name = strtolower( wp_get_theme()->name );
        $presets = apply_filters( 'premmerce_demo_data_presets', array(
            'Demo en' => 'https://saleszone-free.premmerce.com/wp-content/uploads/demodata.json',
        ) );
        ?>
        <select name="importLink">
            <?php 
        foreach ( $presets as $presetName => $preset ) {
            ?>
                <option value="<?php 
            echo  esc_attr( $preset ) ;
            ?>"><?php 
            echo  esc_html( $presetName ) ;
            ?></option>
            <?php 
        }
        ?>
        </select>

        <?php 
    }
    
    /**
     * Shows main admin page
     */
    public function renderThemePage()
    {
        $current = $this->getCurrentTab();
        $data = array(
            'themeName'  => $this->themeName,
            'pageSlug'   => $this->pageSlug,
            'tabs'       => $this->getTabs(),
            'currentTab' => $current,
            'pageUrl'    => menu_page_url( $this->pageSlug, false ),
        );
        switch ( $current ) {
            case 'main':
                break;
            case 'import':
                break;
            case 'changelog':
                $changelog = $this->parse_changelog();
                if ( !empty($changelog) ) {
                    $data['changelog'] = wp_kses_post( $changelog );
                }
                break;
        }
        saleszone_get_template( 'functions/admin/views/main.php', $data );
    }
    
    /**
     * Add script on admin page
     */
    public function enqueueScript()
    {
        $theme = wp_get_theme( get_template() );
        $version = $theme->get( 'Version' );
        $uri = get_template_directory_uri();
        wp_enqueue_style(
            'premmerce-admin-global',
            $uri . '/functions/admin/assets/css/admin-global.css',
            array(),
            $version
        );
        wp_enqueue_script(
            'premmerce-admin',
            $uri . '/functions/admin/assets/js/admin.js',
            array( 'jquery' ),
            $version,
            true
        );
        wp_localize_script( 'premmerce-admin', 'PremmerceAdminLocalize', array(
            'confirmImport' => __( 'This action will delete all your posts, products, terms etc. Are you sure you want to continue?', 'saleszone' ),
            'importEnd'     => __( 'Import end', 'saleszone' ),
        ) );
        if ( $this->getCurrentTab() == 'main' ) {
            wp_enqueue_style(
                'premmerce-admin-wizard',
                $uri . '/functions/admin/assets/css/wizard.css',
                array(),
                $version
            );
        }
        // check is theme admin page
        
        if ( get_current_screen()->id === 'appearance_page_' . $this->pageSlug ) {
            wp_enqueue_style(
                'premmerce-admin',
                $uri . '/functions/admin/assets/css/admin.css',
                array(),
                $version
            );
            wp_enqueue_script( 'jquery-ui-progressbar' );
            wp_enqueue_style(
                'e2b-admin-ui-css',
                'http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/base/jquery-ui.css',
                false,
                "1.9.0",
                false
            );
        }
    
    }
    
    private function parse_changelog()
    {
        WP_Filesystem();
        global  $wp_filesystem ;
        $changelog = $wp_filesystem->get_contents( get_template_directory() . '/changelog.md' );
        if ( is_wp_error( $changelog ) ) {
            $changelog = '';
        }
        return $changelog;
    }
    
    private function getTabs()
    {
        $tabs['main'] = __( 'Getting started', 'saleszone' );
        $tabs['import'] = __( 'Install demo data', 'saleszone' );
        $tabs['changelog'] = __( 'Changelog', 'saleszone' );
        return $tabs;
    }
    
    /**
     * Tab from get parameter of default
     * @return string
     */
    private function getCurrentTab()
    {
        
        if ( isset( $_GET['tab'] ) ) {
            $tab = sanitize_text_field( wp_unslash( $_GET['tab'] ) );
            return $tab;
        }
        
        return 'main';
    }

}
new Saleszone_admin_page();