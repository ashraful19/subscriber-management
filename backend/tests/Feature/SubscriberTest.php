<?php

namespace Tests\Feature;

use App\Models\Field;
use App\Models\Subscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class SubscriberTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_subscribers()
    {
        $subscriber = Subscriber::factory()->create();
        $response = $this->getJson(route('subscribers.index'));
        $response->assertStatus(200);
        $response->assertJson(
            fn (
                AssertableJson $json
            ) => $json->whereType('data', 'array')->etc()
        );
        $response->assertSee([$subscriber->email, $subscriber->name]);
    }

    public function test_create_validation()
    {
        $response = $this->postJson(route('subscribers.store'));
        $response->assertStatus(422);
        $response->assertJson(
            fn (
                AssertableJson $json
            ) => $json->whereType('errors', 'array')->etc()
        );
    }

    public function test_create()
    {
        $subscriber = Subscriber::factory()->make();
        $fields = Field::factory()->count(5)->create();
        $subscriber->fields = $fields->keyBy('id')->map(fn ($item) => '');
        $response = $this->postJson(route('subscribers.store'), $subscriber->toArray());
        $response->assertStatus(201);
        $response->assertJsonCount($fields->count(), 'data.fields');
        $this->assertDatabaseHas('subscribers', Arr::except($subscriber->toArray(), 'fields'));
    }

    public function test_update_validation()
    {
        $subscriber = Subscriber::factory()->create();
        $response = $this->putJson(route('subscribers.update', $subscriber->id));
        $response->assertStatus(422);
        $response->assertJson(
            fn (
                AssertableJson $json
            ) => $json->whereType('errors', 'array')->etc()
        );
    }

    public function test_update()
    {
        $fields = Field::factory()->count(5)->create();
        $subscriber = Subscriber::factory()->hasAttached($fields)->create();
        $subscriber->name .= ' Updated';
        $subscriber->fields = $fields->keyBy('id')->map(fn ($item) => 'Updated');
        $response = $this->putJson(route('subscribers.update', $subscriber->id), $subscriber->toArray());
        $response->assertStatus(200);
        $response->assertJsonCount($fields->count(), 'data.fields');
        $response->assertJson([
            'data' => [
                'name' => $subscriber->name,
                'fields' => array_fill(0, 5, ['value' => 'Updated'])
            ]
        ]);
        $this->assertDatabaseHas('subscribers', ['id' => $subscriber->id, 'name' => $subscriber->name]);
    }

    public function test_delete()
    {
        $subscriber = Subscriber::factory()->create();
        $response = $this->deleteJson(route('subscribers.destroy', $subscriber->id));
        $response->assertStatus(200);
        $this->assertDatabaseMissing('subscribers', ['id' => $subscriber->id]);
    }
}
