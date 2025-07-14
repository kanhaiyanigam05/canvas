<?php

namespace Kanhaiyanigam05\Tests\Http\Controllers;

use Kanhaiyanigam05\Tests\TestCase;

/**
 * Class ViewControllerTest.
 *
 * @covers \Canvas\Http\Controllers\ViewController
 */
class ViewControllerTest extends TestCase
{
    /** @test */
    public function testScriptVariables(): void
    {
        $this->withoutMix();

        $this->actingAs($this->admin, 'canvas')
             ->get(config('canvas.path'))
             ->assertSuccessful()
             ->assertViewIs('canvas::layout')
             ->assertViewHas('jsVars')
             ->assertSee('canvas');
    }
}
