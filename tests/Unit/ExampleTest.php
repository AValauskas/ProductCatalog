<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnitTests extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }
    public function testlogin()
    {
        $dbc = database();
        $sql="select * from person where username='admin' and password='admin'";
        $data = mysqli_query($dbc, $sql);
        $row = mysqli_fetch_assoc($data);
        $this->assertNotNull($row);
    }

    public function mainpagetesting()
    {
        $response = $this->call('GET', '/');

        $this->assertEquals(200, $response->status());
    }
    public function testlogins()
    {
        $this->assertDatabaseHas('person', ['username' => 'admin']);
    }





}
