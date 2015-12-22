<?php

namespace Atrox\Test;

use Atrox\Haikunator;
use PHPUnit_Framework_TestCase as TestCase;

class HaikunatorTest extends TestCase
{

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

    public function testCustomNounsAndAdjectives()
    {
        Haikunator::$ADJECTIVES = ['red'];
        Haikunator::$NOUNS = ['reindeer'];
        $haikunate = Haikunator::haikunate();
        $this->assertRegExp("/(red)(-)(reindeer)(-)(\\d{4})$/i", $haikunate);
    }

    public function testEverythingInOne()
    {
        Haikunator::$ADJECTIVES = ['green'];
        Haikunator::$NOUNS = ['reindeer'];
        $haikunate = Haikunator::haikunate([
            "delimiter" => ".",
            "tokenLength" => 8,
            "tokenChars" => "l",
        ]);
        $this->assertRegExp("/(green)(\\.)(reindeer)(\\.)(llllllll)$/i", $haikunate);
    }

    public function testCanBeUsedAsCallable()
    {
        Haikunator::$ADJECTIVES = ['green'];
        Haikunator::$NOUNS = ['reindeer'];
        $haikunator = new Haikunator();
        $this->assertTrue(is_callable($haikunator));
        $params = [ 'tokenLength' => 0 ];
        $this->assertSame($haikunator($params), Haikunator::haikunate($params));
    }
}
