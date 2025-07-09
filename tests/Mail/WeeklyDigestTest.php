<?php

namespace Kanhaiyanigam05\Tests\Mail;

use Kanhaiyanigam05\Mail\WeeklyDigest;
use Kanhaiyanigam05\Models\Post;
use Kanhaiyanigam05\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class WeeklyDigestTest.
 *
 * @covers \Canvas\Mail\WeeklyDigest
 */
class WeeklyDigestTest extends TestCase
{
    use RefreshDatabase;

    public function testInstantiation(): void
    {
        $data = [
            'posts' => Post::all()->toArray(),
            'totals' => [
                'views' => Post::all()->sum('views_count'),
                'visits' => Post::all()->sum('visits_count'),
            ],
            'startDate' => now()->format('M j'),
            'endDate' => now()->addWeek()->format('M j'),
            'locale' => config('app.locale'),
        ];

        $mailable = new WeeklyDigest($data);

        $this->assertInstanceOf(WeeklyDigest::class, $mailable->build());
    }
}
