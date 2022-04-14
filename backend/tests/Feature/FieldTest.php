<?php

namespace Tests\Feature;

use App\Models\Field;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class FieldTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_fields()
    {
        $field = Field::factory()->create();
        $response = $this->getJson(route('fields.index'));
        $response->assertStatus(200);
        $response->assertJson(
            fn (
                AssertableJson $json
            ) => $json->whereType('data', 'array')->etc()
        );
        $response->assertSee([$field->title, $field->type]);
    }

    public function test_create_validation()
    {
        $response = $this->postJson(route('fields.store'));
        $response->assertStatus(422);
        $response->assertJson(
            fn (
                AssertableJson $json
            ) => $json->whereType('errors', 'array')->etc()
        );
    }

    public function test_create()
    {
        $field = Field::factory()->make();
        $response = $this->postJson(route('fields.store'), $field->toArray());
        $response->assertStatus(201);
        $this->assertDatabaseHas('fields', $field->toArray());
    }

    public function test_update_validation()
    {
        $field = Field::factory()->create();
        $response = $this->putJson(route('fields.update', $field->id));
        $response->assertStatus(422);
        $response->assertJson(
            fn (
                AssertableJson $json
            ) => $json->whereType('errors', 'array')->etc()
        );
    }

    public function test_update()
    {
        $field = Field::factory()->create();
        $field->title .= ' Updated';
        $response = $this->putJson(route('fields.update', $field->id), $field->toArray());
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'title' => $field->title
            ]
        ]);
        $this->assertDatabaseHas('fields', ['id' => $field->id, 'title' => $field->title]);
    }

    public function test_delete()
    {
        $field = Field::factory()->create();
        $response = $this->deleteJson(route('fields.destroy', $field->id));
        $response->assertStatus(200);
        $this->assertDatabaseMissing('fields', ['id' => $field->id]);
    }
}
