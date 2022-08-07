<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Source;
use App\Models\Company;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_source_screen_can_be_rendered()
    {
        $this->actingAs($user = User::factory()->has(Company::factory())->create());
        $response = $this->get('/sources');

        $response->assertStatus(200);
    }

    public function test_source_can_be_created()
    {
        $this->actingAs($user = User::factory()->has(Company::factory())->create());

        $response = $this->post('/sources', [
            'name' => 'Test Source',
            'type' => 0,
            'domain' => 'Test Domain',
            'status' => 1,
        ]);

        $response->assertRedirect(RouteServiceProvider::SOURCE);
    }

    public function test_source_information_can_be_updated()
    {
        $this->actingAs($user = User::factory()->create());

        $newName = 'Test new name';
        $newType = Source::TYPE_WEB;
        $newDomain = 'Test new domain';
        $newStatus = Source::STATUS_ACTIVE;
        $company = Company::factory()->create();

        $source = Source::factory()->create([
            'name' => 'name',
            'company_id' => $company->id,
            'type' => Source::TYPE_MOBILE,
            'domain' => 'domain',
            'status' => Source::STATUS_INACTIVE,
        ]);

        $response = $this->put('/sources/'.$source->id, [
            'name' => $newName,
            'type' => $newType,
            'domain' => $newDomain,
            'status' => $newStatus,
        ]);

        $updatedSource = Source::find($source->id);

        $response->assertRedirect(RouteServiceProvider::SOURCE);
        $this->assertEquals($company->id, $updatedSource->fresh()->company_id);
        $this->assertEquals($newName, $updatedSource->fresh()->name);
        $this->assertEquals($newType, $updatedSource->fresh()->type);
        $this->assertEquals($newDomain, $updatedSource->fresh()->domain);
        $this->assertEquals($newStatus, $updatedSource->fresh()->status);
    }

    public function test_source_information_can_be_deleted()
    {
        $this->actingAs($user = User::factory()->create());

        $source = Source::factory()->create();

        $response = $this->delete('/sources/'.$source->id);

        $deletedSource = Source::find($source->id);

        $this->assertTrue($deletedSource === null);
        $response->assertRedirect(RouteServiceProvider::SOURCE);
    }
}
