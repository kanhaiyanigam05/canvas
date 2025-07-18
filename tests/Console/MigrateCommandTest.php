<?php

namespace Kanhaiyanigam05\Tests\Console;

use Kanhaiyanigam05\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class MigrateCommandTest.
 *
 * @covers \Canvas\Console\MigrateCommand
 */
class MigrateCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testCanvasMigrationCommand(): void
    {
        $this->artisan('canvas:migrate')
             ->assertExitCode(0)
             ->expectsOutput('Migration complete.');
    }
}
