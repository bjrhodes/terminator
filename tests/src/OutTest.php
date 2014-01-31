<?php
namespace Terminator;

class OutTest extends \PHPUnit_Framework_TestCase
{
    protected $Object;

    public function setup()
    {
        $this->Object = new Out();
    }

    public function testPut()
    {
        $this->Object->put("Hello!");
        $this->assertEquals("Hello!", $this->Object->flush());
    }
    public function testPutDoesntMungeUpSpaces()
    {
        $this->Object->put("Hello, Bloke!");
        $this->assertEquals("Hello, Bloke!", $this->Object->flush());
    }
    public function testPutBreaksLongLinesAtWordBoundaries()
    {
        $this->Object->put("Hello! This line is going to look really annoying in a terminal without a line break.");
        $this->assertEquals("Hello! This line is going to look really annoying in a terminal without a line
break.", $this->Object->flush());
    }
    public function testPutBreaksLongLinesAtWordBoundariesWithTheRightLength()
    {
        $this->Object->put("ABCDEFGHI ABCDEFGHI ABCDEFGHI ABCDEFGHI ABCDEFGHI ABCDEFGHI ABCDEFGHI ABCDEFGHI ABC");
        $this->assertEquals("ABCDEFGHI ABCDEFGHI ABCDEFGHI ABCDEFGHI ABCDEFGHI ABCDEFGHI ABCDEFGHI ABCDEFGHI
ABC", $this->Object->flush());
        $this->Object->put("ABCDEFGHI ABCDEFGHI ABCDEFGHI ABCDEFGHI ABCDEFGHI ABCDEFGHI ABCDEFGHI ABCDEFGHIJ ABC");
        $this->assertEquals("ABCDEFGHI ABCDEFGHI ABCDEFGHI ABCDEFGHI ABCDEFGHI ABCDEFGHI ABCDEFGHI
ABCDEFGHIJ ABC", $this->Object->flush());
    }

    public function testPutBreaksLongStringsAtCharacterLimit()
    {
        $this->Object->put("ABCDEFGHIJABCDEFGHIJABCDEFGHIJABCDEFGHIJABCDEFGHIJABCDEFGHIJABCDEFGHIJABCDEFGHIJABCDEFGHIJ");
        $this->assertEquals("ABCDEFGHIJABCDEFGHIJABCDEFGHIJABCDEFGHIJABCDEFGHIJABCDEFGHIJABCDEFGHIJABCDEFGHIJ
ABCDEFGHIJ", $this->Object->flush());
    }
}
