<?php

namespace Winklr\ACF;

// exit if accessed directly
if (! defined('ABSPATH')) {
    exit;
}

class AcfCountriesExtended
{
    
    // vars
    public $settings;
    
    /*
    *  __construct
    *
    *  This function will setup the class functionality
    *
    *  @type    function
    *  @date    17/02/2016
    *  @since   1.0.0
    *
    *  @param   void
    *  @return  void
    */
    
    public function __construct()
    {
        
        // settings
        // - these will be passed into the field class.
        $this->settings = array(
            'version'   => '1.0.0',
            'url'       => plugin_dir_url(__FILE__),
            'path'      => plugin_dir_path(__FILE__)
        );
        
        
        // include field
        add_action('acf/include_field_types', array($this, 'include_field')); // v5
    }
    
    /*
    *  include_field
    *
    *  This function will include the field type class
    *
    *  @type    function
    *  @date    17/02/2016
    *  @since   1.0.0
    *
    *  @param   $version (int) major ACF version. Defaults to false
    *  @return  void
    */
    
    public function include_field($version = 5)
    {

    // load textdomain
        load_plugin_textdomain('acf-countries-extended', false, plugin_basename(dirname(__FILE__)) . '/lang');
        
        // include
        include_once('fields/AcfCountryExtended.php');
    }
}
