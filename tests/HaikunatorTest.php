<?php

use Atrox\Haikunator\Haikunator;

class HaikunatorTest extends PHPUnit_Framework_TestCase {

    public function testHaikunator()
    {
        $haikunator = Haikunator::haikunate();
        $this->assertRegExp("/((?:[a-z][a-z]+))(-)((?:[a-z][a-z]+))(-)(\\d{4})$/i", $haikunator);
    }

    public function testDefaultUse()
    {
        $haikunate = Haikunator::haikunate();
        $this->assertRegExp("/((?:[a-z][a-z]+))(-)((?:[a-z][a-z]+))(-)(\\d{4})$/i", $haikunate);
    }

    public function testHexUse()
    {
        $haikunate = Haikunator::haikunate(["tokenHex" => true]);
        $this->assertRegExp("/((?:[a-z][a-z]+))(-)((?:[a-z][a-z]+))(-)(.{4})$/i", $haikunate);
    }

    public function test9DigitsUse()
    {
        $haikunate = Haikunator::haikunate(["tokenLength" => 9]);
        $this->assertRegExp("/((?:[a-z][a-z]+))(-)((?:[a-z][a-z]+))(-)(\\d{9})$/i", $haikunate);
    }

    public function test9DigitsAsHexUse()
    {
        $haikunate = Haikunator::haikunate(["tokenLength" => 9, "tokenHex" => true]);
        $this->assertRegExp("/((?:[a-z][a-z]+))(-)((?:[a-z][a-z]+))(-)(.{9})$/i", $haikunate);
    }

    public function testWontReturnSameForSubsequentCalls()
    {
        $haikunate = Haikunator::haikunate();
        $haikunate2 = Haikunator::haikunate();
        $this->assertNotEquals($haikunate, $haikunate2);
    }

    public function testDropsToken()
    {
        $haikunate = Haikunator::haikunate(["tokenLength" => 0]);
        $this->assertRegExp("/((?:[a-z][a-z]+))(-)((?:[a-z][a-z]+))$/i", $haikunate);
    }

    public function testPermitsOptionalDelimiter()
    {
        $haikunate = Haikunator::haikunate(["delimiter" => "."]);
        $this->assertRegExp("/((?:[a-z][a-z]+))(\\.)((?:[a-z][a-z]+))(\\.)(\\d+)$/i", $haikunate);
    }

    public function testSpaceDelimiterAndNoToken()
    {
        $haikunate = Haikunator::haikunate(["delimiter" => " ", "tokenLength" => 0]);
        $this->assertRegExp("/((?:[a-z][a-z]+))( )((?:[a-z][a-z]+))$/i", $haikunate);
    }

    public function testOneSingleWord()
    {
        $haikunate = Haikunator::haikunate(["delimiter" => "", "tokenLength" => 0]);
        $this->assertRegExp("/((?:[a-z][a-z]+))$/i", $haikunate);
    }

    public function testCustomChars()
    {
        $haikunate = Haikunator::haikunate(["tokenChars" => "A"]);
        $this->assertRegExp("/((?:[a-z][a-z]+))(-)((?:[a-z][a-z]+))(-)(AAAA)$/i", $haikunate);
    }

}