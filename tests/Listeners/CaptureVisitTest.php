<?php

namespace Kanhaiyanigam05\Tests\Listeners;

use Kanhaiyanigam05\Events\PostViewed;
use Kanhaiyanigam05\Listeners\CaptureVisit;
use Kanhaiyanigam05\Models\Post;
use Kanhaiyanigam05\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class CaptureVisitTest.
 *
 * @covers \Canvas\Listeners\CaptureVisit
 */
class CaptureVisitTest extends TestCase
{
    use RefreshDatabase;

    public function testInstantiation(): void
    {
        $post = factory(Post::class)->create();

        $event = new PostViewed($post);

        $listener = new CaptureVisit();

        $listener->handle($event);
        $listener->handle($event);

        $this->assertDatabaseHas('canvas_visits', [
            'post_id' => $post->id,
        ]);

        $this->assertCount(1, $post->visits);
    }

    public function testVisitsAreCountedByIpInSessionOncePerDay(): void
    {
        $post = factory(Post::class)->create();

        $event = new PostViewed($post);

        $listener = new CaptureVisit();

        $listener->handle($event);
        $listener->handle($event);

        $this->assertDatabaseHas('canvas_visits', [
            'post_id' => $post->id,
        ]);

        $this->assertCount(1, $post->visits);
    }
}
