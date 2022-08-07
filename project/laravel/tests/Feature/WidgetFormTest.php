<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Source;
use App\Models\Company;
use App\Models\EnquiryForm;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WidgetFormTest extends TestCase
{
    use RefreshDatabase;
    public function test_widget_form_can_be_rendered()
    {
        $this->actingAs($user = User::factory()->has(Company::factory())->create());
        $source = Source::factory()->create(['company_id' => $user->company->id]);
        $form = EnquiryForm::factory()->create(['company_id' => $user->company->id]);
        $response = $this->get('/form/widget/'.$form->id.'/'.$source->id);

        $response->assertStatus(200);
    }

    public function test_widget_form_cannot_be_rendered_without_form()
    {
        $this->actingAs($user = User::factory()->has(Company::factory())->create());
        $source = Source::factory()->create(['company_id' => $user->company->id]);
        $response = $this->get('/form/widget/1/'.$source->id);

        $response->assertStatus(404);
    }
}
