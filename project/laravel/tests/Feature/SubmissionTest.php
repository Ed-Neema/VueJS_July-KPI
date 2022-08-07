<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Source;
use App\Models\Company;
use App\Models\Submission;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_submissions_screen_can_be_rendered()
    {
        $this->actingAs($user = User::factory()->has(Company::factory())->create());
        $response = $this->get('/submissions');

        $response->assertStatus(200);
    }

    public function test_submissions_screen_can_be_rendered_with_data()
    {
        $this->actingAs($user = User::factory()->has(Company::factory())->create());

        Submission::factory()->create();
        Submission::factory()->create();
        Submission::factory()->create();

        $response = $this->get('/submissions');

        $response->assertStatus(200);
    }

    public function test_submissions_can_be_deleted()
    {
        $this->actingAs($user = User::factory()->has(Company::factory())->create());
        $submission = Submission::factory()->create();

        $response = $this->delete('/submissions/'.$submission->id);

        $deletedSubmission = Submission::find($submission->id);

        $this->assertTrue($deletedSubmission === null);
        $response->assertRedirect(RouteServiceProvider::SUBMISSIONS);
    }

    public function test_submissions_source_can_be_access_after_source_deleted()
    {
        $this->actingAs(User::factory()->has(Company::factory())->create());
        $source = Source::factory()->create();

        $submission = Submission::factory()->create([
            'source_id' => $source->id,
        ]);

        $this->delete('/sources/'.$source->id);
        $this->assertSoftDeleted($source);

        $deletedSource = Source::withTrashed()->find($source->id);
        $this->assertEquals($submission->source->id, $deletedSource->id);
    }
}
