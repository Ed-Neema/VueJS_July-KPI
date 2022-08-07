<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Source;
use App\Models\Company;
use App\Models\Submission;
use App\Models\EnquiryForm;
use App\Models\EnquiryField;
use Laravel\Jetstream\Features;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteAccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_accounts_can_be_deleted()
    {
        if (! Features::hasAccountDeletionFeatures()) {
            return $this->markTestSkipped('Account deletion is not enabled.');
        }

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
        $this->post($url, $body);

        $this->delete('/user', [
            'password' => 'password',
        ]);

        $deletedField = EnquiryField::find($fields[0]->id);
        $deletedSubmission = Submission::find(1);
        $deletedCompany = Company::find(1);
        $deletedSource = Source::find(1);

        $this->assertModelMissing($form);
        $this->assertTrue($deletedField === null);
        $this->assertTrue($deletedSubmission === null);
        $this->assertTrue($deletedCompany === null);
        $this->assertTrue($deletedSource === null);
        $this->assertModelMissing($user);
    }

    public function test_correct_password_must_be_provided_before_account_can_be_deleted()
    {
        if (! Features::hasAccountDeletionFeatures()) {
            return $this->markTestSkipped('Account deletion is not enabled.');
        }

        $this->actingAs($user = User::factory()->create());

        $response = $this->delete('/user', [
            'password' => 'wrong-password',
        ]);

        $this->assertNotNull($user->fresh());
    }
}
