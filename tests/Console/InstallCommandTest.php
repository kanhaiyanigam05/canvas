<?php

namespace Kanhaiyanigam05\Tests\Console;

use Kanhaiyanigam05\Models\User;
use Kanhaiyanigam05\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class InstallCommandTest.
 *
 * @covers \Kanhaiyanigam05\Console\InstallCommand
 */
class InstallCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testCanvasInstallationCommand(): void
    {
        $this->artisan('canvas:install')
             ->assertExitCode(0)
             ->expectsOutput('Installation complete.');

        $this->assertDatabaseHas('canvas_users', [
            'email' => 'email@example.com',
            'role' => User::ADMIN,
        ]);
    }
}
