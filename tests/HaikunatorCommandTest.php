<?php
/**
 * @license See the file LICENSE for copying permission
 */

namespace Atrox\Test;

use Atrox\Haikunator;
use Atrox\HaikunatorCommand;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\Console\Adapter\AdapterInterface;
use ZF\Console\Route;

class HaikunatorCommandTest extends TestCase
{
    /**
     * @var HaikunatorCommand
     */
    private $command;

    /**
     * @var Haikunator|MockObject
     */
    private $haikunator;

    /**
     * @var Route|MockObject
     */
    private $route;

    /**
     * @var AdapterInterface|MockObject
     */
    private $console;

    protected function setUp()
    {
        $this->haikunator = $this->getMock(Haikunator::class);
        $this->route      = $this->getMock(Route::class, [], [], '', false);
        $this->console    = $this->getMock(AdapterInterface::class);

        $this->command = new HaikunatorCommand($this->haikunator);
    }

    public function testConstructorLazilyCreatesHaikunator()
    {
        $command = new HaikunatorCommand();

        $propRefl = new \ReflectionProperty($command, 'haikunator');
        $propRefl->setAccessible(true);
        $this->assertInstanceOf(Haikunator::class, $propRefl->getValue($command));
    }

    public function testFilterOutNullOptions()
    {
        $this->route->expects($this->any())->method('getMatchedParam')->willReturn(null);

        $this->haikunator->expects($this->atLeastOnce())->method('__invoke')->with($this->isEmpty());

        $this->command->__invoke($this->route, $this->console);
    }

    /**
     * @param array $params
     * @param array $expectedParams
     *
     * @dataProvider paramsDataProvider
     */
    public function testRouteParameters($params, array $expectedParams)
    {
        $map = [];
        foreach ($params as $name => $value) {
            $map[] = [ $name, null, $value ];
        }
        $this->route->expects($this->any())->method('getMatchedParam')->willReturnMap($map);

        $this->haikunator->expects($this->atLeastOnce())->method('__invoke')->with($expectedParams);

        $this->command->__invoke($this->route, $this->console);
    }

    public function paramsDataProvider()
    {
        return [
            [ [ 'token-length' => 10 ], [ 'tokenLength' => 10 ] ],
            [ [ 'token-hex' => true, 'x' => false ], [ 'tokenHex' => true ]],
            [ [ 'token-hex' => false, 'x' => true ], [ 'tokenHex' => true ]],
            [ [ 'token-hex' => false, 'x' => false ], [ ] ],
            [ [ 'token-chars' => 'foobar' ], [ 'tokenChars' => 'foobar' ] ],
            [ [ 'delimiter' => '.' ], [ 'delimiter' => '.' ] ],
        ];
    }

    /**
     * @dataProvider staticParamDataProvider
     */
    public function testStaticParams($name, array $value)
    {
        $map = [ [ $name, null, $value ] ];
        $this->route->expects($this->any())->method('getMatchedParam')->willReturnMap($map);

        $this->command->__invoke($this->route, $this->console);

        $this->assertEquals($value, Haikunator::${strtoupper($name)});
    }

    public function staticParamDataProvider()
    {
        return [
            [ 'nouns',  ['foo', 'bar', 'baz'] ],
            [ 'adjectives',  ['foo', 'bar', 'baz'] ],
        ];
    }
}
