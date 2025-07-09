<?php

namespace Kanhaiyanigam05\Tests\Models;

use Kanhaiyanigam05\Models\Post;
use Kanhaiyanigam05\Models\View;
use Kanhaiyanigam05\Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ViewTest.
 *
 * @covers \Canvas\Models\View
 */
class ViewTest extends TestCase
{
    use RefreshDatabase;

    public function testPostRelationship(): void
    {
        $post = factory(Post::class)->create();

        $view = factory(View::class)->create([
            'post_id' => $post->id,
        ]);

        $post->views()->saveMany([$view]);

        $this->assertInstanceOf(BelongsTo::class, $view->post());
        $this->assertInstanceOf(Post::class, $view->post()->first());
    }
}
