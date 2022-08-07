<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_name_validation()
    {
        $this->actingAs($user = User::factory()->create());

        Company::factory()->create([
            'user_id' => $user->id,
            'name' => 'Test Company',
            'status' => Company::STATUS_ACTIVE,
        ]);

        $response = $this->put('/company/update', [
            'user_id' => $user->id,
            'company_name' => '',
        ]);

        $response->assertSessionHasErrors();
    }

    public function test_company_information_can_be_updated()
    {
        $this->actingAs($user = User::factory()->create());

        Company::factory()->create([
            'user_id' => $user->id,
            'name' => 'Test Company',
            'status' => Company::STATUS_ACTIVE,
        ]);

        $this->put('/company/update', [
            'user_id' => $user->id,
            'company_name' => 'New Company',
        ]);

        $this->assertEquals('New Company', $user->fresh()->company->name);
    }
}
