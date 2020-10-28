/******/ (function (modules) {
 // webpackBootstrap
/******/    // The module cache
/******/    var installedModules = {};
/******/
/******/    // The require function
/******/    function __webpack_require__(moduleId)
    {
/******/
/******/        // Check if module is in cache
/******/        if (installedModules[moduleId]) {
/******/            return installedModules[moduleId].exports;
/******/        }
/******/        // Create a new module (and put it into the cache)
/******/        var module = installedModules[moduleId] = {
/******/            i: moduleId,
/******/            l: false,
/******/            exports: {}
/******/        };
/******/
/******/        // Execute the module function
/******/        modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/        // Flag the module as loaded
/******/        module.l = true;
/******/
/******/        // Return the exports of the module
/******/        return module.exports;
/******/    }
/******/
/******/
/******/    // expose the modules object (__webpack_modules__)
/******/    __webpack_require__.m = modules;
/******/
/******/    // expose the module cache
/******/    __webpack_require__.c = installedModules;
/******/
/******/    // define getter function for harmony exports
/******/    __webpack_require__.d = function (exports, name, getter) {
/******/        if (!__webpack_require__.o(exports, name)) {
/******/            Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/        }
/******/    };
/******/
/******/    // define __esModule on exports
/******/    __webpack_require__.r = function (exports) {
/******/        if (typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/            Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/        }
/******/        Object.defineProperty(exports, '__esModule', { value: true });
/******/    };
/******/
/******/    // create a fake namespace object
/******/    // mode & 1: value is a module id, require it
/******/    // mode & 2: merge all properties of value into the ns
/******/    // mode & 4: return value when already ns object
/******/    // mode & 8|1: behave like require
/******/    __webpack_require__.t = function (value, mode) {
/******/        if (mode & 1) {
        value = __webpack_require__(value);
}
/******/        if (mode & 8) {
    return value;
}
/******/        if ((mode & 4) && typeof value === 'object' && value && value.__esModule) {
    return value;
}
/******/        var ns = Object.create(null);
/******/        __webpack_require__.r(ns);
/******/        Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/        if (mode & 2 && typeof value != 'string') {
    for (var key in value) {
        __webpack_require__.d(ns, key, function (key) {
            return value[key]; }.bind(null, key));
    }
}
/******/        return ns;
/******/    };
/******/
/******/    // getDefaultExport function for compatibility with non-harmony modules
/******/    __webpack_require__.n = function (module) {
/******/        var getter = module && module.__esModule ?
/******/            function getDefault()
    {
        return module['default']; } :
/******/            function getModuleExports()
{
    return module; };
/******/        __webpack_require__.d(getter, 'a', getter);
/******/        return getter;
/******/    };
/******/
/******/    // Object.prototype.hasOwnProperty.call
/******/    __webpack_require__.o = function (object, property) {
    return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/    // __webpack_public_path__
/******/    __webpack_require__.p = "/";
/******/
/******/
/******/    // Load entry module and return exports
/******/    return __webpack_require__(__webpack_require__.s = 0);
/******/ })({

    /***/ "./node_modules/compare-versions/index.js":
    /*!************************************************!*\
    !*** ./node_modules/compare-versions/index.js ***!
    \************************************************/
    /*! no static exports found */
    /***/ (function (module, exports, __webpack_require__) {

        var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/* global define */
        (function (root, factory) {
          /* istanbul ignore next */
            if (true) {
                !(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
                __WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
                (__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
                __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
            } else {
            }
        }(this, function () {

            var semver = /^v?(?:\d+)(\.(?:[x*]|\d+)(\.(?:[x*]|\d+)(\.(?:[x*]|\d+))?(?:-[\da-z\-]+(?:\.[\da-z\-]+)*)?(?:\+[\da-z\-]+(?:\.[\da-z\-]+)*)?)?)?$/i;

            function indexOrEnd(str, q)
            {
                return str.indexOf(q) === -1 ? str.length : str.indexOf(q);
            }

            function split(v)
            {
                var c = v.replace(/^v/, '').replace(/\+.*$/, '');
                var patchIndex = indexOrEnd(c, '-');
                var arr = c.substring(0, patchIndex).split('.');
                arr.push(c.substring(patchIndex + 1));
                return arr;
            }

            function tryParse(v)
            {
                return isNaN(Number(v)) ? v : Number(v);
            }

            function validate(version)
            {
                if (typeof version !== 'string') {
                    throw new TypeError('Invalid argument expected string');
                }
                if (!semver.test(version)) {
                    throw new Error('Invalid argument not valid semver (\''+version+'\' received)');
                }
            }

            function compareVersions(v1, v2)
            {
                [v1, v2].forEach(validate);

                var s1 = split(v1);
                var s2 = split(v2);

                for (var i = 0; i < Math.max(s1.length - 1, s2.length - 1); i++) {
                    var n1 = parseInt(s1[i] || 0, 10);
                    var n2 = parseInt(s2[i] || 0, 10);

                    if (n1 > n2) {
                        return 1;
                    }
                    if (n2 > n1) {
                        return -1;
                    }
                }

                var sp1 = s1[s1.length - 1];
                var sp2 = s2[s2.length - 1];

                if (sp1 && sp2) {
                    var p1 = sp1.split('.').map(tryParse);
                    var p2 = sp2.split('.').map(tryParse);

                    for (i = 0; i < Math.max(p1.length, p2.length); i++) {
                        if (p1[i] === undefined || typeof p2[i] === 'string' && typeof p1[i] === 'number') {
                            return -1;
                        }
                        if (p2[i] === undefined || typeof p1[i] === 'string' && typeof p2[i] === 'number') {
                            return 1;
                        }

                        if (p1[i] > p2[i]) {
                            return 1;
                        }
                        if (p2[i] > p1[i]) {
                            return -1;
                        }
                    }
                } else if (sp1 || sp2) {
                    return sp1 ? -1 : 1;
                }

                return 0;
            }

            var allowedOperators = [
            '>',
            '>=',
            '=',
            '<',
            '<='
            ];

            var operatorResMap = {
                '>': [1],
                '>=': [0, 1],
                '=': [0],
                '<=': [-1, 0],
                '<': [-1]
            };

            function validateOperator(op)
            {
                if (typeof op !== 'string') {
                    throw new TypeError('Invalid operator type, expected string but got ' + typeof op);
                }
                if (allowedOperators.indexOf(op) === -1) {
                    throw new TypeError('Invalid operator, expected one of ' + allowedOperators.join('|'));
                }
            }

            compareVersions.validate = function (version) {
                return typeof version === 'string' && semver.test(version);
            }

            compareVersions.compare = function (v1, v2, operator) {
              // Validate operator
                validateOperator(operator);

              // since result of compareVersions can only be -1 or 0 or 1
              // a simple map can be used to replace switch
                var res = compareVersions(v1, v2);
                return operatorResMap[operator].indexOf(res) > -1;
            }

            return compareVersions;
        }));


    /***/ }),

    /***/ "./src/assets/css/input.scss":
    /*!***********************************!*\
    !*** ./src/assets/css/input.scss ***!
    \***********************************/
    /*! no static exports found */
    /***/ (function (module, exports) {

    // removed by extract-text-webpack-plugin

    /***/ }),

    /***/ "./src/assets/js/input.js":
    /*!********************************!*\
    !*** ./src/assets/js/input.js ***!
    \********************************/
    /*! no static exports found */
    /***/ (function (module, exports, __webpack_require__) {

        var compareVersions = __webpack_require__(/*! compare-versions */ "./node_modules/compare-versions/index.js");

        (function ($, undefined) {
          // Needed for conditional logic
            var Field = acf.models.SelectField.extend({
                type: 'countries_extended'
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
                console.log('State: ', state);

                if (!state.id) {
                    return state.text;
                }

                return '<span class="acf-country-flag-icon famfamfam-flags ' + state.id.toLowerCase() + '"></span> <span class="acf-country-flag-name">' + state.text + '</span>';
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

                return $('<span class="acf-country-flag-icon famfamfam-flags ' + state.id.toLowerCase() + '"></span> <span class="acf-country-flag-name">' + state.text + '</span>');
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


            acf.addFilter('select2_args', function (args, $select, settings, field, instance) {
                if (instance.data.field.get('type') !== 'countries_extended') {
                    return args;
                }

                console.log('Field: ', field);
                console.log('Instance: ', instance);
                console.log('Settings: ', settings);
                console.log('Select: ', $select);
                console.log('Args: ', args);
                var templates = {};

                if (compareVersions.compare(acf.get('acf_version'), '5.8.12', '>=')) {
                    templates = {
                        templateResult: format_country_esc,
                        templateSelection: format_country_esc
                    };
                } else {
                    templates = {
                        templateResult: format_country,
                        templateSelection: format_country
                    };
                } // Select2 version


                $.extend(args, templates);
                return args;
            });
        })(jQuery);

    /***/ }),

    /***/ 0:
    /*!******************************************************************!*\
    !*** multi ./src/assets/js/input.js ./src/assets/css/input.scss ***!
    \******************************************************************/
    /*! no static exports found */
    /***/ (function (module, exports, __webpack_require__) {

        __webpack_require__(/*! /Users/mwinkler/git/acf_countries_extended/src/assets/js/input.js */"./src/assets/js/input.js");
        module.exports = __webpack_require__(/*! /Users/mwinkler/git/acf_countries_extended/src/assets/css/input.scss */"./src/assets/css/input.scss");


    /***/ })

/******/ });