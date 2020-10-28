<?php

/*
Plugin Name: Advanced Custom Fields: ACF Countries Extended
Plugin URI: https://github.com/winklr/acf_countries_extended
Description: SHORT_DESCRIPTION
Version: 1.0.0
Author: Martin Winkler
Author URI:
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

use Winklr\ACF\AcfCountriesExtended;

// exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// check if class already exists
if (!class_exists('Winklr\ACF\AcfCountriesExtended')) {
    require "src/acf-countries-extended.php";

    new AcfCountriesExtended();
}
