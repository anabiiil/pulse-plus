<?php
namespace Tests\Feature;
use App\Models\Admin;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class ItemTest extends TestCase
{
    use RefreshDatabase;
    private function actingAsAdmin(): Admin
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin');
        return $admin;
    }
    public function test_guest_cannot_access_items_endpoints(): void
    {
        $this->getJson('/dashboard/items')->assertStatus(401);
    }
    public function test_admin_can_list_items(): void
    {
        $this->withoutMiddleware();
        $this->actingAsAdmin();
        Item::factory()->count(3)->create();
        $response = $this->getJson('/dashboard/items');
        $response->assertOk()
            ->assertJsonStructure(['data' => [['id', 'uuid', 'name', 'status', 'created_at']]]);
    }
    public function test_admin_can_create_item_without_name(): void
    {
        $this->withoutMiddleware();
        $this->actingAsAdmin();
        $response = $this->postJson('/dashboard/items', ['status' => 1]);
        $response->assertStatus(201)
            ->assertJsonPath('data.name', null)
            ->assertJsonPath('data.status', true);
        $this->assertDatabaseCount('items', 1);
        $this->assertNotNull(Item::first()->uuid);
    }
    public function test_admin_can_create_item_with_name(): void
    {
        $this->withoutMiddleware();
        $this->actingAsAdmin();
        $response = $this->postJson('/dashboard/items', ['name' => 'Test Item', 'status' => 1]);
        $response->assertStatus(201)
            ->assertJsonPath('data.name', 'Test Item');
    }
    public function test_uuid_is_auto_generated_on_creation(): void
    {
        $this->withoutMiddleware();
        $this->actingAsAdmin();
        $this->postJson('/dashboard/items', ['name' => 'Auto UUID']);
        $item = Item::first();
        $this->assertNotNull($item->uuid);
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/',
            $item->uuid
        );
    }
    public function test_admin_can_show_item(): void
    {
        $this->withoutMiddleware();
        $this->actingAsAdmin();
        $item = Item::factory()->create();
        $response = $this->getJson("/dashboard/items/{$item->id}");
        $response->assertOk()
            ->assertJsonPath('data.id', $item->id)
            ->assertJsonPath('data.uuid', $item->uuid);
    }
    public function test_show_returns_404_for_nonexistent_item(): void
    {
        $this->withoutMiddleware();
        $this->actingAsAdmin();
        $this->getJson('/dashboard/items/999')->assertNotFound();
    }
    public function test_admin_can_update_item(): void
    {
        $this->withoutMiddleware();
        $this->actingAsAdmin();
        $item = Item::factory()->create(['name' => 'Old Name', 'status' => true]);
        $response = $this->putJson("/dashboard/items/{$item->id}", ['name' => 'New Name', 'status' => 0]);
        $response->assertOk()
            ->assertJsonPath('data.name', 'New Name')
            ->assertJsonPath('data.status', false);
    }
    public function test_update_does_not_change_uuid(): void
    {
        $this->withoutMiddleware();
        $this->actingAsAdmin();
        $item = Item::factory()->create();
        $originalUuid = $item->uuid;
        $this->putJson("/dashboard/items/{$item->id}", ['name' => 'Changed']);
        $this->assertEquals($originalUuid, $item->fresh()->uuid);
    }
    public function test_admin_can_delete_item(): void
    {
        $this->withoutMiddleware();
        $this->actingAsAdmin();
        $item = Item::factory()->create();
        $this->deleteJson("/dashboard/items/{$item->id}")->assertOk();
        $this->assertDatabaseMissing('items', ['id' => $item->id]);
    }
    public function test_name_validation_max_length(): void
    {
        $this->withoutMiddleware();
        $this->actingAsAdmin();
        $response = $this->postJson('/dashboard/items', ['name' => str_repeat('a', 256)]);
        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }
}
