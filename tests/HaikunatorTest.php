<?php

namespace Atrox\Test;

use Atrox\Haikunator;
use PHPUnit\Framework\TestCase;

/**
 * Class HaikunatorTest
 *
 * @package Atrox\Test
 */
class HaikunatorTest extends TestCase
{
    private $nouns = [];

    private $adjectives = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->nouns = Haikunator::$NOUNS;
        $this->adjectives = Haikunator::$ADJECTIVES;
    }

    protected function tearDown(): void
    {
        Haikunator::$NOUNS = $this->nouns;
        Haikunator::$ADJECTIVES = $this->adjectives;

        parent::tearDown();
    }

    /**
     * @param array $params
     * @param       $regex
     *
     * @dataProvider paramsDataProvider
     */
    public function testHaikunate(array $params, $regex)
    {
        $haikunate = Haikunator::haikunate($params);
        $this->assertMatchesRegularExpression($regex, $haikunate);
    }

    /**
     * @return array
     */
    public function paramsDataProvider()
    {
        return [
            "default params"       => [[], "/((?:[a-z][a-z]+))(-)((?:[a-z][a-z]+))(-)(\\d{4})$/i"],
            "token with hex"       => [["tokenHex" => true], "/((?:[a-z][a-z]+))(-)((?:[a-z][a-z]+))(-)(.{4})$/i"],
            "tokenlength"          => [["tokenLength" => 9], "/((?:[a-z][a-z]+))(-)((?:[a-z][a-z]+))(-)(\\d{9})$/i"],
            "tokenlength with hex" => [["tokenLength" => 9, "tokenHex" => true], "/((?:[a-z][a-z]+))(-)((?:[a-z][a-z]+))(-)(.{9})$/i"],
            "delimiter"            => [["delimiter" => "."], "/((?:[a-z][a-z]+))(\\.)((?:[a-z][a-z]+))(\\.)(\\d+)$/i"],
            "drop delimiter"       => [["tokenLength" => 0], "/((?:[a-z][a-z]+))(-)((?:[a-z][a-z]+))$/i"],
            "space delimiter"      => [["delimiter" => " ", "tokenLength" => 0], "/((?:[a-z][a-z]+))( )((?:[a-z][a-z]+))$/i"],
            "one word"             => [["delimiter" => "", "tokenLength" => 0], "/((?:[a-z][a-z]+))$/i"],
            "custom tokenchars"    => [["tokenChars" => "A"], "/((?:[a-z][a-z]+))(-)((?:[a-z][a-z]+))(-)(AAAA)$/i"],
        ];
    }

    public function testCustomNounsAndAdjectives()
    {
        Haikunator::$ADJECTIVES = ['red'];
        Haikunator::$NOUNS = ['reindeer'];
        $haikunate = Haikunator::haikunate();

        $this->assertMatchesRegularExpression("/(red)(-)(reindeer)(-)(\\d{4})$/i", $haikunate);
    }

    public function testNounsMustNotContainDuplicates()
    {
        $nouns = Haikunator::$NOUNS;
        $this->assertEquals(count($nouns), count(array_flip($nouns)));
    }

    public function testAdjectivesMustNotContainDuplicates()
    {
        $adjectives = Haikunator::$ADJECTIVES;
        $this->assertEquals(count($adjectives), count(array_flip($adjectives)));
    }

    public function testEverythingInOne()
    {
        Haikunator::$ADJECTIVES = ['green'];
        Haikunator::$NOUNS = ['reindeer'];
        $haikunate = Haikunator::haikunate([
            "delimiter"   => ".",
            "tokenLength" => 8,
            "tokenChars"  => "l",
        ]);

        $this->assertMatchesRegularExpression("/(green)(\\.)(reindeer)(\\.)(llllllll)$/i", $haikunate);
    }

    public function testWontReturnSameForSubsequentCalls()
    {
        $haikunate = Haikunator::haikunate();
        $haikunate2 = Haikunator::haikunate();

        $this->assertNotEquals($haikunate, $haikunate2);
    }

    public function testCanBeUsedAsCallable()
    {
        Haikunator::$ADJECTIVES = ['green'];
        Haikunator::$NOUNS = ['reindeer'];
        $haikunator = new Haikunator();

        $this->assertTrue(is_callable($haikunator));

        $params = ['tokenLength' => 0];
        $this->assertSame($haikunator($params), Haikunator::haikunate($params));
    }
}
