<?php


namespace Tests;

use Winklr\ACF\Country;
use PHPUnit\Framework\TestCase;

class CountryTest extends TestCase
{
    private $country = null;
  
    protected function setUp(): void
    {
        parent::setUp();
    
        $this->country = new Country(json_decode(file_get_contents(__DIR__ . '/fixtures/belgium_raw.json')));
    }

    public function testGetName()
    {
        $this->assertEquals('Belgien', $this->country->getName('deu'));
        $this->assertEquals('Belgien', $this->country->getName('DEU'));
        $this->assertEquals('Belgium', $this->country->getName());
        $this->assertEquals('Belgium', $this->country->getName('abc'));
    }

    public function testGetNativeName()
    {
        $this->assertEquals('Belgien', $this->country->nativeName);
    }
}
