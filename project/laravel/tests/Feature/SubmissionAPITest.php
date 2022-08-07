<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Source;
use App\Models\Company;
use App\Models\EnquiryForm;
use App\Models\EnquiryField;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubmissionAPITest extends TestCase
{
    use RefreshDatabase;
    public function test_user_cannot_submit_submissions_without_a_valid_form()
    {
        $this->actingAs($user = User::factory()->has(Company::factory())->create());
        $source = Source::factory()->create(['company_id' => $user->company->id]);

        $fields = EnquiryField::factory()->count(3)->create(['company_id' => $user->company->id]);
        $form = EnquiryForm::factory()->create(['company_id' => $user->company->id]);
        $form->enquiryFields()->attach($fields);

        $wrongFormId = $form->id + 1;

        while (true) {
            if (! EnquiryForm::where('id', $wrongFormId)->exists()) {
                break;
            } else {
                $wrongFormId++;
            }
        }

        $url = '/api/enquiry/submit/'.$wrongFormId.'/'.$source->id;

        $body = ['company_id' => $user->company->id,
                'data' =>  json_encode([]), ];

        $completeResponse = $this->post($url, $body);

        $completeResponse->assertStatus(401);
    }

    public function test_user_cannot_submit_submissions_without_data()
    {
        $this->actingAs($user = User::factory()->has(Company::factory())->create());
        $source = Source::factory()->create(['company_id' => $user->company->id]);

        $fields = EnquiryField::factory()->count(3)->create(['company_id' => $user->company->id]);
        $form = EnquiryForm::factory()->create(['company_id' => $user->company->id]);
        $form->enquiryFields()->attach($fields);
        $url = '/api/enquiry/submit/'.$form->id.'/'.$source->id;
        $data = json_encode([]);

        $body = ['company_id' => $user->company->id,
                'data' =>  $data, ];

        $completeResponse = $this->post($url, $body);

        $completeResponse->assertStatus(400);
    }

    public function test_user_cannot_submit_submissions_with_invalid_data()
    {
        $this->actingAs($user = User::factory()->has(Company::factory())->create());
        $source = Source::factory()->create(['company_id' => $user->company->id]);

        $fields = EnquiryField::factory()->count(3)->create(['company_id' => $user->company->id]);
        $form = EnquiryForm::factory()->create(['company_id' => $user->company->id]);
        $form->enquiryFields()->attach($fields);
        $url = '/api/enquiry/submit/'.$form->id.'/'.$source->id;
        $data = [];

        foreach ($fields as $field) {
            $data[$field->id] = 'value'; // invalid parameter
        }

        $body = ['company_id' => $user->company->id,
                'data' =>  json_encode($data), ];

        $completeResponse = $this->post($url, $body);

        $completeResponse->assertStatus(400);
    }

    public function test_user_can_submit_submissions()
    {
        $this->actingAs($user = User::factory()->has(Company::factory())->create());
        $source = Source::factory()->create(['company_id' => $user->company->id]);

        $fields = EnquiryField::factory()->count(3)->create(['company_id' => $user->company->id]);
        $form = EnquiryForm::factory()->create(['company_id' => $user->company->id]);
        $form->enquiryFields()->attach($fields);
        $url = '/api/enquiry/submit/'.$form->id.'/'.$source->id;
        $data = [];

        foreach ($fields as $field) {
            $data[$field->name] = 'value';
        }

        $body = ['company_id' => $user->company->id,
                'data' =>  json_encode($data), ];

        $completeResponse = $this->post($url, $body);

        $completeResponse->assertStatus(201);
    }

    public function test_user_can_send_additional_data_with_valid_form_data()
    {
        $this->actingAs($user = User::factory()->has(Company::factory())->create());
        $source = Source::factory()->create(['company_id' => $user->company->id]);

        $fieldIds = [];
        for ($index = 0; $index < 4; $index++) {
            array_push(
                $fieldIds,
                EnquiryField::factory()->create([
                    'company_id' => $user->company->id,
                    'is_compulsory' => $index % 2,
                ])->id
            );
        }

        $fields = EnquiryField::find($fieldIds);
        $form = EnquiryForm::factory()->create(['company_id' => $user->company->id]);
        $form->enquiryFields()->attach($fields);
        $url = '/api/enquiry/submit/'.$form->id.'/'.$source->id;
        $data = [];

        foreach ($fields as $field) {
            $data[$field->name] = 'value';
            $data[$field->name.$field->label] = 'value';
        }

        $body = ['company_id' => $user->company->id,
                'data' =>  json_encode($data), ];

        $completeResponse = $this->post($url, $body);

        $completeResponse->assertStatus(201);
    }

    public function test_user_should_fill_required_fields()
    {
        $this->actingAs($user = User::factory()->has(Company::factory())->create());
        $source = Source::factory()->create(['company_id' => $user->company->id]);

        $fieldIds = [];
        for ($index = 0; $index < 4; $index++) {
            array_push(
                $fieldIds,
                EnquiryField::factory()->create([
                    'company_id' => $user->company->id,
                    'is_compulsory' => $index % 2,
                ])->id
            );
        }

        $fields = EnquiryField::find($fieldIds);
        $form = EnquiryForm::factory()->create(['company_id' => $user->company->id]);
        $form->enquiryFields()->attach($fields);
        $url = '/api/enquiry/submit/'.$form->id.'/'.$source->id;
        $data = [];

        foreach ($fields as $field) {
            if ($field->is_compulsory == 1) {
                $data[$field->name] = '';
            }
        }

        $body = ['company_id' => $user->company->id,
                'data' =>  json_encode($data), ];

        $inCompleteResponse = $this->post($url, $body);

        $data = [];

        foreach ($fields as $field) {
            if ($field->is_compulsory == 1) {
                $data[$field->name] = 'value';
            }
        }

        $body = ['company_id' => $user->company->id,
                'data' =>  json_encode($data), ];

        $completeResponse = $this->post($url, $body);

        $data = [];

        foreach ($fields as $field) {
            if ($field->is_compulsory == 0) {
                $data[$field->name] = 'value';
            }
        }

        $body = ['company_id' => $user->company->id,
                'data' =>  json_encode($data), ];

        $inCompleteResponse2 = $this->post($url, $body);

        $completeResponse->assertStatus(201);
        $inCompleteResponse->assertStatus(400);
        $inCompleteResponse2->assertStatus(400);
    }

    public function test_user_will_get_valid_parameter_validation_errors()
    {
        $this->actingAs($user = User::factory()->has(Company::factory())->create());
        $source = Source::factory()->create(['company_id' => $user->company->id]);

        $fieldIds = [];
        for ($index = 0; $index < 6; $index++) {
            array_push(
                $fieldIds,
                EnquiryField::factory()->create([
                    'company_id' => $user->company->id,
                    'is_compulsory' => $index % 2,
                ])->id
            );
        }

        $fields = EnquiryField::find($fieldIds);
        $form = EnquiryForm::factory()->create(['company_id' => $user->company->id]);
        $form->enquiryFields()->attach($fields);
        $url = '/api/enquiry/submit/'.$form->id.'/'.$source->id;
        $data = [];
        $requiredNames = [];

        foreach ($fields as $field) {
            if ($field->is_compulsory == 1) {
                $data[$field->name] = '';
                array_push($requiredNames, $field->label);
            }
        }

        $body = ['company_id' => $user->company->id,
                'data' =>  json_encode($data), ];

        $inCompleteResponse = $this->post($url, $body)->assertStatus(400);

        $matchingMessageCount = 0;

        foreach (json_decode($inCompleteResponse->getContent())->message as $message) {
            foreach ($requiredNames as $name) {
                if (strpos($message, $name)) {
                    $matchingMessageCount++;
                    break;
                }
            }
        }

        $this->assertEquals($matchingMessageCount, count($requiredNames));
    }
}
