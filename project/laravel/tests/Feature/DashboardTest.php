<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\Submission;
use Inertia\Testing\Assert;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_screen_can_be_rendered()
    {
        $user = User::factory()->has(Company::factory())->create();
        $this->actingAs($user);
        $response = $this->get('/dashboard');

        $response->assertStatus(200);
    }

    public function test_dashboard_screen_can_be_rendered_with_submissions_data()
    {
        $company = Company::factory()->create();
        $user = User::find($company->user_id);

        $this->actingAs($user);

        Submission::factory(15)->create(['company_id' => $company->id]);

        $response = $this->get('/dashboard');
        $response->assertOk();

        $response->assertInertia(
            fn (Assert $page) => $page
            ->url('/dashboard')
            ->component('Dashboard')
            ->has(
                'submissions',
                10,
                fn (Assert $page) => $page
                ->whereAll([
                    'company_id' => strval($company->id),
                ])
                ->etc()
            )
        );
    }

    public function test_dashboard_screen_only_shows_logged_user_records()
    {
        $company = Company::factory()->create();
        $user = User::find($company->user_id);

        $this->actingAs($user);
        Submission::factory(10)->create(['company_id' => $company->id]);

        $company2 = Company::factory()->create();
        $user2 = User::find($company2->user_id);

        $this->actingAs($user2);
        Submission::factory(10)->create(['company_id' => $company2->id]);

        $this->actingAs($user);

        $response = $this->get('/dashboard');
        $response->assertOk();

        $response->assertInertia(
            fn (Assert $page) => $page
            ->url('/dashboard')
            ->component('Dashboard')
            ->has(
                'submissions',
                10,
                fn (Assert $page) => $page
                ->whereAll([
                    'company_id' => strval($company->id),
                ])
                ->etc()
            )
        );
    }
}
