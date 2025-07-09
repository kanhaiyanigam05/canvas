<?php

namespace Kanhaiyanigam05\Tests\Listeners;

use Kanhaiyanigam05\Events\PostViewed;
use Kanhaiyanigam05\Listeners\CaptureView;
use Kanhaiyanigam05\Models\Post;
use Kanhaiyanigam05\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class CaptureViewTest.
 *
 * @covers \Canvas\Listeners\CaptureView
 */
class CaptureViewTest extends TestCase
{
    use RefreshDatabase;

    public function testInstantiation(): void
    {
        $post = factory(Post::class)->create();

        $event = new PostViewed($post);

        $listener = new CaptureView();

        $listener->handle($event);

        $this->assertDatabaseHas('canvas_views', [
            'post_id' => $post->id,
        ]);

        $this->assertCount(1, $post->views);
    }

    public function testViewsAreCountedInSessionOncePerHour(): void
    {
        $post = factory(Post::class)->create();

        $event = new PostViewed($post);

        $listener = new CaptureView();

        $listener->handle($event);
        $listener->handle($event);

        $this->assertDatabaseHas('canvas_views', [
            'post_id' => $post->id,
        ]);

        $this->assertCount(1, $post->views);
    }
}
