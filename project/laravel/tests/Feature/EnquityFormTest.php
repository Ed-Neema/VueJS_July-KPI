<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\EnquiryForm;
use App\Models\EnquiryField;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EnquityFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_forms_screen_can_be_rendered()
    {
        $this->actingAs($user = User::factory()->has(Company::factory())->create());
        $response = $this->get('/enquiry_forms');

        $response->assertStatus(200);
    }

    public function test_forms_can_be_created()
    {
        $this->actingAs($user = User::factory()->has(Company::factory())->create());

        $field1 = EnquiryField::factory()->create();
        $field2 = EnquiryField::factory()->create();

        $response = $this->get('/enquiry_forms');
        $response2 = $this->post('/enquiry_forms', [
            'name' => 'name',
            'identifier' => 'identifier',
            'status' => EnquiryForm::STATUS_ACTIVE,
            'field_ids' => [$field1->id, $field2->id],
        ]);

        $response2->assertRedirect(RouteServiceProvider::ENQUIRY_FORMS);
    }

    public function test_forms_can_be_updated()
    {
        $this->actingAs($user = User::factory()->has(Company::factory())->create());

        $newField1 = EnquiryField::factory()->create();
        $newField2 = EnquiryField::factory()->create();

        $newName = 'Test new name';
        $newStatus = EnquiryForm::STATUS_INACTIVE;
        $newIdentifier = 'Test new identifier';
        $newFields = [$newField1->id, $newField2->id];

        $form = new EnquiryForm;
        $form->name = 'Form name';
        $form->company_id = 1;
        $form->identifier = 'Identifier';
        $form->status = EnquiryForm::STATUS_ACTIVE;
        $form->save();

        $field1 = EnquiryField::factory()->create();
        $field2 = EnquiryField::factory()->create();

        $fields = EnquiryField::find([$field1->id, $field2->id]);
        $form->enquiryFields()->attach($fields);

        $response = $this->put('/enquiry_forms/'.$form->id, [
            'name' => $newName,
            'identifier' => $newIdentifier,
            'status' => $newStatus,
            'fields' => $newFields,
        ]);

        $updatedForm = EnquiryForm::find($form->id);
        $updatedFieldIds = array_map(function ($field) {
            return $field['id'];
        }, $updatedForm->enquiryFields->toArray());

        $response->assertRedirect(RouteServiceProvider::ENQUIRY_FORMS);
        $this->assertEquals($newName, $updatedForm->fresh()->name);
        $this->assertEquals($newStatus, $updatedForm->fresh()->status);
        $this->assertEquals($newIdentifier, $updatedForm->fresh()->identifier);
    }

    public function test_forms_can_be_deleted()
    {
        $this->actingAs($user = User::factory()->has(Company::factory())->create());

        $form = EnquiryForm::factory()->create();

        $response = $this->delete('/enquiry_forms/'.$form->id);

        $deletedForm = EnquiryForm::find($form->id);

        $this->assertTrue($deletedForm === null);
        $response->assertRedirect(RouteServiceProvider::ENQUIRY_FORMS);
    }
}
