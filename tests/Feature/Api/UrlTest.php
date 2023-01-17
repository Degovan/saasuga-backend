<?php

namespace Tests\Feature\Api;

use App\Http\Resources\Api\UrlResource;
use App\Models\Url;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrlTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_can_return_all_urls()
    {
        Url::factory(16)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user)
            ->getJson(route('api.urls.index'))
            ->assertStatus(200)
            ->assertJsonCount(15, 'data.urls');

        $this->actingAs($this->user)
            ->getJson(route('api.urls.index', ['page' => 2]))
            ->assertStatus(200)
            ->assertJsonCount(1, 'data.urls');
    }

    public function test_can_create_new_url()
    {
        $url = Url::factory()->make(['user_id' => $this->user->id]);

        $this->actingAs($this->user)
            ->postJson(route('api.urls.store'), $url->toArray())
            ->assertStatus(201);

        $this->assertDatabaseHas('urls', $url->getAttributes())
            ->assertDatabaseCount('urls', 1);
    }

    public function test_can_get_url_detail()
    {
        $url = Url::factory()->create(['user_id' => $this->user->id]);
        $resource = UrlResource::make($url);

        $res = $this->actingAs($this->user)
            ->getJson(route('api.urls.show', $url))
            ->assertStatus(200);

        $this->assertEquals(
            $res->decodeResponseJson()['data'],
            $resource->response()->getData(true)['data'],
        );
    }

    public function test_can_edit_url()
    {
        $url = Url::factory()->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user)
            ->putJSON(route('api.urls.update', $url), ['keyword' => 'kwd'])
            ->assertStatus(204);

        $this->assertEquals(Url::find($url->id)->keyword, 'kwd');
    }

    public function test_can_delete_url()
    {
        $url = Url::factory()->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user)
            ->deleteJSON(route('api.urls.destroy', $url))
            ->assertStatus(204);

        $this->assertDatabaseMissing('urls', $url->getAttributes());
        $this->assertDatabaseCount('urls', 0);
    }
}
