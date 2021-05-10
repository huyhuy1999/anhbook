<?php


//Text
function opstore_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

// Number
function opstore_sanitize_number( $input ) {
    $output = intval($input);
     return $output;
}

//Checkbox
function opstore_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}

// Number Float-val
function opstore_floatval( $input ) {
    $output = floatval( $input );
     return $output;
}


//switch option
function opstore_sanitize_switch_option( $input ) {
    $valid_keys = array(
            'show'  => esc_html__( 'Show', 'opstore' ),
            'hide'  => esc_html__( 'Hide', 'opstore' )
        );
    if ( array_key_exists( $input, $valid_keys ) ) {
        return $input;
    } else {
        return '';
    }
}

//breadcrumb sanitize
function opstore_sanitize_breadcrumb($input){
    $all_tags = array(
        'a'=>array(
            'href'=>array()
        )
     );
    return wp_kses($input,$all_tags);
    
}

//radio box sanitization function
function opstore_sanitize_radio( $input, $setting ){
 
    //input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
    $input = sanitize_key($input);

    //get the list of possible radio box options 
    $choices = $setting->manager->get_control( $setting->id )->choices;
                     
    //return input if valid or return default option
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
     
}

//header layout sanitize
function opstore_sanitize_header_layouts( $input ) {
    $valid_keys = array(
            'style1'    => OPSTORE_IMAGES.'header-2.png',
            'Style2'    => OPSTORE_IMAGES.'header-3.png',
        );
    if ( array_key_exists( $input, $valid_keys ) ) {
        return $input;
    } else {
        return '';
    }
}

//Check Top Header Layouts
function top_header_notification(){
    $theader_layout = get_theme_mod('opstore_topheader_type','info');
    if($theader_layout == 'notification'){
        return true;
    }
    return false;
}

function top_header_info(){
    $theader_layout = get_theme_mod('opstore_topheader_type','info');
    if($theader_layout == 'info'){
        return true;
    }
    return false;
}