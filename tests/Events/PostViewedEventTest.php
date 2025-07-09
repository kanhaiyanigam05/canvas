<?php

namespace Kanhaiyanigam05\Tests\Events;

use Kanhaiyanigam05\Events\PostViewed;
use Kanhaiyanigam05\Models\Post;
use Kanhaiyanigam05\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class PostViewedEventTest.
 *
 * @covers \Canvas\Events\PostViewed
 */
class PostViewedEventTest extends TestCase
{
    use RefreshDatabase;

    public function testInstantiation(): void
    {
        $post = factory(Post::class)->create();

        $event = new PostViewed($post);

        $this->assertInstanceOf(PostViewed::class, $event);
        $this->assertSame($post, $event->post);
    }
}
