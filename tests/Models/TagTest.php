<?php

namespace Kanhaiyanigam05\Tests\Models;

use Kanhaiyanigam05\Models\Post;
use Kanhaiyanigam05\Models\Tag;
use Kanhaiyanigam05\Models\User;
use Kanhaiyanigam05\Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class TagTest.
 *
 * @covers \Canvas\Models\Tag
 */
class TagTest extends TestCase
{
    use RefreshDatabase;

    public function testTagsCanShareTheSameSlugWithUniqueUsers(): void
    {
        $data = [
            'name' => 'A new tag',
            'slug' => 'a-new-tag',
        ];

        $primaryTag = factory(Tag::class)->create([
            'user_id' => $this->admin->id,
        ]);
        $response = $this->actingAs($this->admin, 'canvas')->postJson("/canvas/api/tags/{$primaryTag->id}", $data);

        $this->assertDatabaseHas('canvas_tags', [
            'id' => $response->original['id'],
            'slug' => $response->original['slug'],
            'user_id' => $response->original['user_id'],
        ]);

        $secondaryAdmin = factory(User::class)->create([
            'role' => User::ADMIN,
        ]);
        $secondaryTag = factory(Tag::class)->create([
            'user_id' => $secondaryAdmin->id,
        ]);

        $response = $this->actingAs($secondaryAdmin, 'canvas')->postJson("/canvas/api/tags/{$secondaryTag->id}", $data);

        $this->assertDatabaseHas('canvas_tags', [
            'id' => $response->original['id'],
            'slug' => $response->original['slug'],
            'user_id' => $response->original['user_id'],
        ]);
    }

    public function testPostsRelationship(): void
    {
        $tag = factory(Tag::class)->create();
        $post = factory(Post::class)->create();

        $post->tags()->sync($tag);

        $this->assertCount(1, $post->tags);
        $this->assertInstanceOf(BelongsToMany::class, $tag->posts());
        $this->assertInstanceOf(Post::class, $tag->posts->first());
    }

    public function testUserRelationship(): void
    {
        $tag = factory(Tag::class)->create();

        $this->assertInstanceOf(BelongsTo::class, $tag->user());
        $this->assertInstanceOf(User::class, $tag->user);
    }

    public function testDetachPostsOnDelete(): void
    {
        $tag = factory(Tag::class)->create();
        $post = factory(Post::class)->create();

        $tag->posts()->sync([$post->id]);

        $tag->delete();

        $this->assertEquals(0, $tag->posts->count());
        $this->assertDatabaseMissing('canvas_posts_tags', [
            'post_id' => $post->id,
            'tag_id' => $tag->id,
        ]);
    }
}
