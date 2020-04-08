<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Rules\ValidPassword;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NewPasswordTest extends TestCase
{
    use DatabaseTransactions;

    protected $_rule;

    protected function setUp() : void
    {
        parent::setUp();

        $this->_rule = new ValidPassword();
    }

    public function testMinLength()
    {
        $password = 'xyz';
        $this->assertFalse($this->_rule->passes('password', $password));
    }

    public function testHas1Number()
    {
        $password = 'xyzxyzxyz';
        $this->assertFalse($this->_rule->passes('password', $password));
    }

    public function testHasALowercase()
    {
        $password = 'XYZXYZXYZ1';
        $this->assertFalse($this->_rule->passes('password', $password));
    }

    public function testHasAnUppercase()
    {
        $password = 'xyzxyzxyz1';
        $this->assertFalse($this->_rule->passes('password', $password));
    }

    public function testHasASymbol()
    {
        $password = 'Xyzxyzxyz1';
        $this->assertFalse($this->_rule->passes('password', $password));
    }

    public function testEmpty()
    {
        $password = '   ';
        $this->assertFalse($this->_rule->passes('password', $password));
    }

    public function testBadSymbol()
    {
        $password = 'Xyzxyzxyz1`';
        $this->assertFalse($this->_rule->passes('password', $password));
    }

    public function testPerfect()
    {
        $password = 'Xyzxyzxyz1#';
        $this->assertTrue($this->_rule->passes('password', $password));
    }
}
