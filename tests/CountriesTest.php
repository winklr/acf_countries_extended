<?php

namespace Tests;

use Winklr\ACF\Countries;
use PHPUnit\Framework\TestCase;

class CountriesTest extends TestCase
{
    public $instance = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->instance = Countries::getInstance();
    }

    public function testGetInstance()
    {
        $this->assertIsArray($this->instance->getCountries());

        $germany = collect($this->instance->getCountries())
          ->first(function ($country) {
              return $country->name === 'Germany';
          });
        $this->assertEquals('Germany', $germany->name);
    }

    public function testGetList()
    {
        $list = $this->instance->getList();
        $this->assertEquals('Germany', $list['DE']);

        $list = $this->instance->getList('fr_FR');
        $this->assertEquals('Allemagne', $list['DE']);
    }

    public function testGetCountryByIso2()
    {
        $germany = $this->instance->getCountryByIso2('de');

        $expected = json_decode(file_get_contents(__DIR__ . '/fixtures/germany.json'));

        $this->assertEquals($expected->name, $germany->name);
        $this->assertEquals($expected->nativeName, $germany->nativeName);
        $this->assertEquals($expected->officialName, $germany->officialName);
        $this->assertEquals($expected->topLevelDomains, $germany->topLevelDomains);
        $this->assertEquals($expected->currencies, $germany->currencies);
        $this->assertEquals($expected->isoCodeAlpha2, $germany->isoCodeAlpha2);
    }

    public function testLocaleToIso2()
    {
        $this->assertEquals('de', $this->instance->localeToIso2('de_DE'));
    }

    public function testLocaleToIso3()
    {
        $this->assertEquals('FRA', $this->instance->localeToIso3('fr_FR'));
    }
}
