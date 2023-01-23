<?php

namespace Tests\Feature\Api;

use App\Http\Resources\Api\UserResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user);
    }

    public function test_can_return_exact_user()
    {
        $resource = UserResource::make($this->user);
        $res = $this->get('/api/user')->assertStatus(200);

        $this->assertEquals(
            $resource->response()->getData(true)['data'],
            $res->decodeResponseJson()['data']
        );
    }

    public function test_user_logged_out()
    {
        $this->deleteJson('/api/user')->assertStatus(204);

        $this->refreshApplication();
        $this->getJson('/api/user')->assertUnauthorized();
    }
}
