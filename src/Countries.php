<?php

namespace Winklr\ACF;

class Countries
{
    private static $instance = null;

    private $countries = [];

    // Returns the singleton instance of this class
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    // Private constructor, so class can't be instantiated elsewhere (Singleton pattern)
    private function __construct()
    {
        $raw_countries = json_decode(file_get_contents(__DIR__ . '/data/countries.json'));
        $this->countries = $this->formatCountries($raw_countries);
    }

    // Private __clone method, so instance can't be cloned
    private function __clone()
    {
    }

    // Private __sleep method, so instance can't be serialized
    private function __sleep()
    {
    }

    // Private __wakeup method, so instance can't be unserialized
    private function __wakeup()
    {
    }

    /*
     * formatCountries()
     *
     * Helper function for filtering and formatting countries
     *
     * @param $countries 'raw' countries data structure
     * @return array {
     *  @type Country filtered and sorted countries list
     * }
     */
    protected function formatCountries($countries)
    {
        return is_array($countries)
        ? collect($countries)
        ->filter(function ($country) {
            return $country->independent;
        })
        ->map(function ($country) {
            return new Country($country);
        })
        ->sortBy(function ($country) {
            return $country->name;
        })
        ->all()
        : [];
    }

    public function getCountries()
    {
        return $this->countries;
    }

    /*
     * getList()
     *
     * return array(key => value) list of countries.
     * If $locale (e.g. en_US) is provided, this function tries to get country names
     * for the given $locale with fallback to english name.
     *
     * @param string $locale Optional. Provide locale (e.g. 'de_DE') to get country names in that language
     * @return array {
     *  @type Country
     * }
     */
    public function getList($locale = false)
    {
        $languageIso3 = $this->localeToIso3($locale);

        return collect($this->countries)
        ->flatMap(function (Country $country) use ($languageIso3) {
            return array($country->isoCodeAlpha2 => $country->getName($languageIso3));
        })
        ->all();
    }

    /*
     * getCountryByIso2()
     *
     * get Country by its iso2 Code (e.g. 'en')
     *
     * @param string $isoCode iso code in isoAlpha2 format (e.g. 'de')
     * @return Country
     */
    public function getCountryByIso2($isoCode)
    {
        return collect($this->countries)
        ->first(function ($country) use ($isoCode) {
            return strtolower($country->isoCodeAlpha2) === strtolower($isoCode);
        });
    }

    /*
     * getCountryByIso3()
     *
     * get iso3 by given locale (e.g. 'de_DE' => 'deu')
     *
     * @param string $locale (e.g. 'de_DE'
     * @return string (e.g. 'deu')
     */
    public function localeToIso3($locale)
    {
        $iso2 = $this->localeToIso2($locale);

        return $this->getCountryByIso2($iso2)->isoCodeAlpha3;
    }

    /*
     * getCountryByIso2()
     *
     * get iso2 by given locale (e.g. 'de_DE' => 'de')
     *
     * @param string $locale (e.g. 'de_DE'
     * @return string (e.g. 'de')
     */
    public function localeToIso2($locale)
    {
        $matches = [];
        return preg_match('/^([a-z]{2})_([A-Z]{2})$/', $locale, $matches) ? $matches[1] : false;
    }
}
