<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use App\Models\EnquiryField;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EnquityFieldsTest extends TestCase
{
    use RefreshDatabase;

    public function test_fields_screen_can_be_rendered()
    {
        $this->actingAs($user = User::factory()->has(Company::factory())->create());
        $response = $this->get('/enquiry_fields');

        $response->assertStatus(200);
    }

    public function test_fields_without_options_can_be_created()
    {
        $this->actingAs($user = User::factory()->has(Company::factory())->create());

        $response = $this->post('/enquiry_fields', [
            'name' => 'name',
            'label' => 'Name',
            'type' => EnquiryField::TYPE_TEXT_AREA,
            'field_data' => '',
            'is_compulsory' => true,
        ]);

        $response->assertRedirect(RouteServiceProvider::ENQUIRY_FIELDS);
    }

    public function test_fields_with_options_can_be_created()
    {
        $this->actingAs($user = User::factory()->has(Company::factory())->create());
        $response = $this->post('/enquiry_fields', [
            'name' => 'field 2',
            'label' => 'Name',
            'type' => EnquiryField::TYPE_SELECT,
            'field_data' => '[{"id" : "1", "value" : "Value 1"}, {"id" : "2", "value" : "Value 2"}]',
            'is_compulsory' => true,
        ]);

        $response->assertRedirect(RouteServiceProvider::ENQUIRY_FIELDS);
    }

    public function test_fields_can_be_updated()
    {
        $this->actingAs($user = User::factory()->has(Company::factory())->create());

        $newName = 'Test new name';
        $newType = EnquiryField::TYPE_TEXT_BOX;
        $newLabel = 'Test new label';
        $newIsCompulsory = '0';

        $field = EnquiryField::factory()->create();

        $response = $this->put('/enquiry_fields/'.$field->id, [
            'id' => $field->id,
            'name' => $newName,
            'label' => $newLabel,
            'type' => $newType,
            'is_compulsory' => $newIsCompulsory,
        ]);

        $updatedField = EnquiryField::find($field->id);

        $response->assertRedirect(RouteServiceProvider::ENQUIRY_FIELDS);
        $this->assertEquals($newName, $updatedField->fresh()->name);
        $this->assertEquals($newLabel, $updatedField->fresh()->label);
        $this->assertEquals($newType, $updatedField->fresh()->type);
        $this->assertEquals($newIsCompulsory, $updatedField->fresh()->is_compulsory);
    }

    public function test_fields_can_be_deleted()
    {
        $this->actingAs($user = User::factory()->has(Company::factory())->create());

        $field = EnquiryField::factory()->create();

        $response = $this->delete('/enquiry_fields/'.$field->id);

        $deletedField = EnquiryField::find($field->id);

        $this->assertTrue($deletedField === null);
        $response->assertRedirect(RouteServiceProvider::ENQUIRY_FIELDS);
    }
}
