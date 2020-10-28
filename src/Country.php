<?php

namespace Winklr\ACF;

class Country
{
    public $name;
    public $nativeName;
    public $officialName;
    public $topLevelDomains;
    public $isoCodeAlpha2;
    public $isoCodeAlpha3;
    public $isoCodeNumeric;
    public $languages;
    public $translations;
    public $currencies;
    public $callingCodes;
    public $capital;
    public $region;
    public $subregion;
    public $latitude;
    public $longitude;
    public $areaInKilometres;
    public $flag;

    public function __construct($data)
    {
        $this->name = $data->name->common;
        $this->nativeName = $this->getNativeName($data);
        $this->officialName = $data->name->official;
        $this->topLevelDomains = $data->tld;
        $this->isoCodeAlpha2 = $data->cca2;
        $this->isoCodeAlpha3 = $data->cca3;
        $this->isoCodeNumeric = $data->ccn3;
        $this->languages = $data->languages;
        $this->translations = $data->translations;
        $this->currencies = $data->currencies;
        $this->callingCodes = $data->idd;
        $this->capital = $data->capital;
        $this->region = $data->region;
        $this->subregion = $data->subregion;
        $this->latitude = $data->latlng[0];
        $this->longitude = $data->latlng[1];
        $this->areaInKilometres = $data->area;
        $this->flag = $data->flag;
    }

    // return country name in native language
    /*
     * getNativeName()
     *
     * gets country's native name. Takes first, if multiple native names are available.
     */
    public function getNativeName($data)
    {
        return collect($data->name->native)
        ->first()->common;
    }

    /*
     * getTranslatedName()
     *
     * get country name translated to language defined by iso3 code (e.g. 'fra')
     *
     * @param $iso3 iso3 code (e.g. 'fra').
    */
    protected function getTranslatedName($iso3)
    {
        $iso3 = strtolower($iso3);
        return isset($this->translations->$iso3) ? $this->translations->$iso3->common : false;
    }

    /*
     * getName()
     *
     * 'name' accessor function.
     *
     * @param optional $translateIso3 Provide iso3 code to get country name in that name instead (if available).
    */
    public function getName($translateIso3 = false)
    {
        if ($translateIso3) {
            $translation = $this->getTranslatedName($translateIso3);
            return $translation ? $translation : $this->name;
        }

        return $this->name;
    }
}
