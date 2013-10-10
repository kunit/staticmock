<?php
namespace StaticMock;

class MockTest extends \PHPUnit_Framework_TestCase
{

    public function testMock()
    {
        $mock = \StaticMock::mock('StaticMock\Car');
        $mock->shouldReceive('boo');
        $p = new Person();
        $p->drive();
        $this->assertEquals(1, $mock->getCalledCount());
    }

    public function testMockCreation()
    {
        $mock = \StaticMock::mock('StaticMock\Car');
        $mock->shouldReceive('boo')->times(1);
        $p = new Person();
        $p->drive();
    }

    public function testArgs()
    {
        $mock = \StaticMock::mock('StaticMock\Car');
        $mock->shouldReceive('beep');

        $p = new Person();
        $p->warn(5);
        $this->assertEquals(1, $mock->getCalledCount());
        $this->assertEquals(array(5), $mock->getPassedArguments());
    }

    public function testAssertions()
    {
        $mock = \StaticMock::mock('StaticMock\Car');
        $mock->shouldReceive('beep')->times(1)->with(5)->andReturn('ban!');
        $p = new Person();
        $expected = $p->warn(5);
        $this->assertEquals('ban!', $expected);
    }

    public function testOnce()
    {
        $mock = \StaticMock::mock('StaticMock\Car');
        $mock->shouldReceive('beep')->with(5)->once()->andReturn('ban!');
        $p = new Person();
        $expected = $p->warn(5);
        $this->assertEquals('ban!', $expected);
    }

    public function testTwice()
    {
        $mock = \StaticMock::mock('StaticMock\Car');
        $mock->shouldReceive('beep')->with(5)->twice()->andReturn('ban!');
        $p = new Person();
        $expected = $p->warn(5);
        $expected = $p->warn(5);
        $this->assertEquals('ban!', $expected);
    }

    public function testCalledAssertionThrowsExceptionWhenFailed()
    {
        $mock = \StaticMock::mock('\StaticMock\Car');
        $mock->shouldReceive('beep')->times(2)->with(5);

        $this->setExpectedException('\StaticMock\Exception\AssertionFailedException');
        $p = new Person();
        $p->warn(5);
    }

    public function testPassedArgsAssertionThrowsExceptionWhenFailed()
    {
        $mock = \StaticMock::mock('StaticMock\Car');
        $mock->shouldReceive('beep')->times(1)->with(5);
        $this->setExpectedException('\StaticMock\Exception\AssertionFailedException');
        $p = new Person();
        $p->warn(4);
    }

    public function testAndReturn()
    {
        $mock = \StaticMock::mock('StaticMock\Car');
        $mock->shouldReceive('beep')->times(1)->andReturn('BEEP!');
        $p = new Person();
        $this->assertEquals('BEEP!', $p->warn(5));
    }

    public function testAndReturnWithAnonymousFunction()
    {
        $mock = \StaticMock::mock('StaticMock\Car');
        $mock->shouldReceive('beep')->times(1)->andReturn(function ($x) { return $x * 3; });

        $p = new Person();
        $actual = $p->warn(5);
        $this->assertEquals(15, $actual);
    }

    public function testWhenMethodNotFound()
    {
        $mock = \StaticMock::mock('StaticMock\Car');
        $this->setExpectedException('\StaticMock\Exception\MethodNotFoundException');
        $mock->shouldReceive('beeep');
    }

}
