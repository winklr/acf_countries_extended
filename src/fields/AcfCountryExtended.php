<?php

namespace Winklr\ACF\fields;

require __DIR__ . "/../../vendor/autoload.php";

// exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// check if class already exists
if (class_exists('AcfCountryExtended')) {
    return;
}

use acf_field;
use Winklr\ACF\Countries;

class AcfCountryExtended extends acf_field
{

  /*
*  __construct
*
*  This function will setup the field type data
*
*  @param   settings (array) plugin settings (url, path, version) as a reference for later use with assets
*  @return  n/a
*/

    public function __construct($settings)
    {
        $this->name = 'countries_extended';
        $this->label = __('Countries Extended', 'acf-countries-extended');
        $this->category = 'choice';
        $this->defaults = array(
        'multiple' => 0,
        'allow_null' => 0,
        'choices' => [],
        'default_value' => '',
        'ui' => 1,
        'placeholder' => __('Select a country', 'acf-countries-extended'),
        'return_format' => 'label'
        );

        $this->settings = $settings;

        // do not delete!
        parent::__construct();
    }

    public function render_field_settings($field)
    {

    // try to get choices from db, fallback to all countries
        $choices = acf_get_array($field['choices']);

        // encode choices (convert from array)
        $field['choices'] = !empty($choices) ? acf_encode_choices($choices) :  acf_encode_choices($this->get_countries());
        $field['default_value'] = acf_encode_choices($field['default_value'], false);

        // choices
        acf_render_field_setting(
            $field,
            [
            'label' => __('Choices', 'acf'),
            'instructions' => __('List of countries in \'KEY : Name\' format (e.g. DE : Germany).
        Each entry is to be placed on its own line. The default list includes all countries, 
        but the list can be modified by removing entries manually to fit one\'s needs.
        To revert the list to default remove all entries and hit *save*', 'acf-country-extended'),
            'name' => 'choices',
            'type' => 'textarea'
            ]
        );

        // Placeholder
        acf_render_field_setting(
            $field,
            [
            'label' => __('Placeholder Text', 'acf-country-extended'),
            'instructions' => __('Appears within the input', 'acf-country-extended'),
            'type' => 'text',
            'name' => 'placeholder',
            ]
        );

        // default_value
        acf_render_field_setting(
            $field,
            [
            'label' => __('Default Value', 'acf'),
            'instructions' => __('Enter each default value on a new line', 'acf'),
            'name' => 'default_value',
            'type' => 'textarea'
            ]
        );

        // allow_null
        acf_render_field_setting(
            $field,
            [
            'label' => __('Allow Null?', 'acf'),
            'instructions' => '',
            'name' => 'allow_null',
            'type' => 'true_false',
            'ui' => 1,
            ]
        );

        // multiple
        acf_render_field_setting(
            $field,
            [
            'label' => __('Select multiple values?', 'acf'),
            'instructions' => '',
            'name' => 'multiple',
            'type' => 'true_false',
            'ui' => 1,
            ]
        );

        // ui
        acf_render_field_setting(
            $field,
            [
            'label' => __('Stylised UI', 'acf'),
            'instructions' => '',
            'name' => 'ui',
            'type' => 'true_false',
            'ui' => 1,
            'wrapper' => [
            'class' => 'hidden',
            ],
            ]
        );

        // return_format
        acf_render_field_setting(
            $field,
            [
            'label' => __('Return Format', 'acf'),
            'instructions' => __('Specify the value returned', 'acf'),
            'type' => 'select',
            'name' => 'return_format',
            'choices' => [
            'array' => __('Country code and name', 'acf-country-extended'),
            'value' => __('Country code', 'acf-country-extended'),
            'label' => __('Country name', 'acf-country-extended'),
            'object' => __('Country object', 'acf-country-extended')
            ],
            ]
        );
    }

    public function render_field($field)
    {
        $field['choices'] = acf_get_array($field['choices']);
        $field['ajax'] = 0;

        if ($field['value'] && is_array($field['value'])) {
            $field['value'] = array_map('strtoupper', $field['value']);
        }

        acf_get_field_type('select')->render_field($field);
    }

    public function input_admin_enqueue_scripts()
    {

    // vars
        $url = $this->settings['url'];
        $version = $this->settings['version'];

        acf_get_field_type('select')->input_admin_enqueue_scripts();

        // register & include JS
        wp_register_script('acf-countries-extended', "{$url}assets/dist/input.js", array('acf-input'), $version);
        wp_enqueue_script('acf-countries-extended');


        // register & include CSS
        wp_register_style('acf-countries-extended', "{$url}assets/dist/input.css", array('acf-input'), $version);
        wp_enqueue_style('acf-countries-extended');
    }

    /*
*  load_value()
*
*  This filter is applied to the $value after it is loaded from the db
*
*  @param   $value (mixed) the value found in the database
*  @param   $post_id (mixed) the $post_id from which the value was loaded
*  @param   $field (array) the field array holding all the field options
*  @return  $value
*/

    public function load_value($value, $post_id, $field)
    {
        return acf_get_field_type('select')->load_value($value, $post_id, $field);
    }


    /*
*  update_value()
*
*  This filter is applied to the $value before it is saved in the db
*
*  @param   $value (mixed) the value found in the database
*  @param   $post_id (mixed) the $post_id from which the value was loaded
*  @param   $field (array) the field array holding all the field options
*  @return  $value
*/

    public function update_value($value, $post_id, $field)
    {
        return acf_get_field_type('select')->update_value($value, $post_id, $field);
    }

    /*
*  format_value()
*
*  This filter is applied to the $value after it is loaded from the db and before it is returned to the template
*
*  @param   $value (mixed) the value which was loaded from the database
*  @param   $post_id (mixed) the $post_id from which the value was loaded
*  @param   $field (array) the field array holding all the field options
*
*  @return  $value (mixed) the modified value
*/

    public function format_value($value, $post_id, $field)
    {

    // bail early if no value
        if (empty($value)) {
            return $value;
        }

        // if return_type is 'object', convert value(s) to country objects
        if ($field['return_format'] === 'object') {
            $isoCountries = array_merge([], is_array($value) ? $value : [$value]);

            $countries = collect($isoCountries)
            ->map(function ($iso) {
                return Countries::getInstance()->getCountryByIso2($iso);
            })
            ->all();

            return $countries;
        } else {
            $field['choices'] = acf_get_array($field['choices']);

            return acf_get_field_type('select')->format_value($value, $post_id, $field);
        }
    }

    /*
*  validate_value()
*
*  This filter is used to perform validation on the value prior to saving.
*  All values are validated regardless of the field's required setting. This allows you to validate and return
*  messages to the user if the value is not correct
*
*  @param   $valid (boolean) validation status based on the value and the field's required setting
*  @param   $value (mixed) the $_POST value
*  @param   $field (array) the field array holding all the field options
*  @param   $input (string) the corresponding input name for $_POST value
*  @return  $valid
*/

    public function validate_value($valid, $value, $field, $input)
    {
        $instance = Countries::getInstance();

        $allValid = collect((array)$value)
        ->every(function ($iso) use ($instance) {
            return $instance->getCountryByIso2($iso);
        });

        if (!$allValid) {
            $valid = sprintf(_n('%s is not a valid country code', '%s are not valid country codes', count($value), 'acf-country-extended'), implode(', ', $value));
        }

        return $valid;
    }

    /*
*  update_field()
*
*  This filter is applied to the $field before it is saved to the database
*
*  @param   $field (array) the field array holding all the field options
*  @return  $field
*/

    public function update_field($field)
    {
        return acf_get_field_type('select')->update_field($field);
    }

    /**
     * Get countries
     *
     * @return array
     */
    private function get_countries()
    {
        $wp_locale = get_locale();

        $countries = Countries::getInstance();

        return apply_filters('acf/countries_extended', $countries->getList($wp_locale));
    }
}

// initialize
new AcfCountryExtended($this->settings);
