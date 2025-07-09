<?php

namespace Kanhaiyanigam05\Tests\Models;

use Kanhaiyanigam05\Models\Post;
use Kanhaiyanigam05\Models\Visit;
use Kanhaiyanigam05\Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class VisitTest.
 *
 * @covers \Canvas\Models\Visit
 */
class VisitTest extends TestCase
{
    use RefreshDatabase;

    public function testPostRelationship(): void
    {
        $post = factory(Post::class)->create();

        $visit = factory(Visit::class)->create([
            'post_id' => $post->id,
        ]);

        $post->visits()->saveMany([$visit]);

        $this->assertInstanceOf(BelongsTo::class, $visit->post());
        $this->assertInstanceOf(Post::class, $visit->post()->first());
    }
}
