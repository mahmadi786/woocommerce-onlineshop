<?php
function optionsframework_option_name() {
       $themename = get_option( 'stylesheet' );
       $themename = preg_replace( "/\W/", "_", strtolower( $themename ) );
       return $themename;
}
/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 */

function optionsframework_options() {

    $options = array();

    $options[] = array(
        'name' => __('Basic Options', 'burger'),
        'type' => 'heading');
        
    $options[] = array(
        'name' => __('Premium Features', 'burger'),
        'desc' => '<ul>
        
        <li>'.__('Upload Logo','burger').'</li>
        <li>'.__('Slider - Enable-disable and custom text + URL','burger').'</li>
        <li>'.__('Google Fonts','burger').'</li>
        <li>'.__('Color Pickers','burger').'</li>
        <li>'.__('Advanced burger Options','burger').'</li>
        <li>'.__('1-4 Widgetized Areas in Footer','burger').'</li>
        </ul>'.
        '<p>
        <a rel="nofollow" href="'.esc_url( __( 'http://www.ketchupthemes.com/burger-theme/', 'burger')).'" style="background:red; padding:10px 20px; color:#ffffff; margin-top:10px; text-decoration:none;">Update to Premium</a></p>',
        'type' => 'info');

    $options[] = array(
        'name' => __('Favicon Upload', 'burger'),
        'desc' => __('Upload Your Favicon icon here. Please upload a 16x16 icon.', 'burger'),
        'id' => 'favicon_upload',
        'type' => 'upload');
        
        $options[] = array(
        'name' => __('Address', 'burger'),
        'desc' => __('Write your address.', 'burger'),
        'id' => 'burger_address',
        'type' => 'text');
        
        $options[] = array(
        'name' => __('Phone', 'burger'),
        'desc' => __('Write your phone', 'burger'),
        'id' => 'burger_phone',
        'type' => 'text');
        
    $options[] = array(
        'name' => __('Footer Sidebars', 'burger'),
        'desc' => __('Select Footer Sidebars Number.', 'burger'),
        'id' => 'footer_sidebars_number',
        'std' => '1',
        'type' => 'radio',
        'options' => array('1'=>__('1','burger'),
                           '2'=>__('2','burger')
                           ));
    return $options;
}