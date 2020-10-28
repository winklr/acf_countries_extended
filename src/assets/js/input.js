var compareVersions = require('compare-versions');

(function ($, undefined) {
    // Needed for conditional logic
    var Field = acf.models.SelectField.extend({
        type: 'countries_extended',
    });

    acf.registerFieldType(Field);
    acf.registerConditionForFieldType('contains', 'countries_extended');
    acf.registerConditionForFieldType('selectEqualTo', 'countries_extended');
    acf.registerConditionForFieldType('selectNotEqualTo', 'countries_extended');

    /**
     * Format country (Select2 v4)
     *
     * ACF >= 5.8.12
     *
     * @param  {object} state
     * @return {jQuery}
     */
    function format_country_esc(state)
    {
        if (!state.id) {
            return state.text;
        }

        return (
            '<span class="acf-country-flag-icon famfamfam-flags ' +
            state.id.toLowerCase() +
            '"></span> <span class="acf-country-flag-name">' +
            state.text +
            '</span>'
        );
    }

    /**
     * Format country (Select2 v4)
     *
     * ACF < 5.8.12
     *
     * @param  {object} state
     * @return {jQuery}
     */
    function format_country(state)
    {
        console.log('State: ', state);
        if (!state.id) {
            return state.text;
        }

        return $(
            '<span class="acf-country-flag-icon famfamfam-flags ' +
            state.id.toLowerCase() +
            '"></span> <span class="acf-country-flag-name">' +
            state.text +
            '</span>'
        );
    }

    /**
     * Country args for select2
     *
     * @param  {object} args
     * @param  {jQuery} $select
     * @param  {object} settings
     * @param  {jQuery} field
     * @param  {object} instance
     * @return {object}
     */
    acf.addFilter('select2_args', function (
        args,
        $select,
        settings,
        field,
        instance
    ) {

        if (instance.data.field.get('type') !== 'countries_extended') {
            return args;
        }

        var templates = {};
        if (compareVersions.compare(acf.get('acf_version'), '5.8.12', '>=')) {
            templates = {
                templateResult: format_country_esc,
                templateSelection: format_country_esc,
            };
        } else {
            templates = {
                templateResult: format_country,
                templateSelection: format_country,
            };
        }

        // Select2 version
        $.extend(args, templates);
        return args;
    });
})(jQuery);
