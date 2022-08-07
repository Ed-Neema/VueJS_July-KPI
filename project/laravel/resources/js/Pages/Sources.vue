<template>
  <div>
    <app-layout title="Dashboard">
      <div class="flex justify-between items-center">
        <h2 class="text-title font-bold text-red-500 leading-tight mt-8">
          Products
        </h2>
        <div class="">
          <Button
            :field="createButton"
            @callback="addRecord()"
            class="float-right"
          />
        </div>
      </div>
      <!-- table -->
      <div class="w-full mx-auto py-6">
        <Table
          :structure="structure"
          :records="records"
          :recordOptions="recordOptions"
          :searchOptions="searchOptions"
          @edit="editRecord"
          @delete="deleteRecord"
          @search="handleSearchOptions"
        />
      </div>
    </app-layout>
    <Form
      :formTitle="formTitle"
      :formSubtitle="formSubtitle"
      :closeConfirmation="closeConfirmation"
      :formErrors="formErrors"
      :visibility="isSlideInVisible"
      :structure="structure"
      :form="selectedForm"
      :actions="formActions"
      :recordOptions="recordOptions"
      @close="closeSlideIn"
      @delete="deleteRecord($event)"
      @save="save($event)"
    />
  </div>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import Table from "@/Components/Table.vue";
import Form from "@/Components/Form.vue";
import Button from "@/Components/Button.vue";
import { faEye } from "@fortawesome/free-solid-svg-icons";

export default defineComponent({
  props: {},

  data() {
    let createButton = {
      key: "button",
      label: "Add Product",
      placeholder: "",
      type: "Button",
      options: {},
    };
    let structure = [
      {
        key: "id",
        label: "Product id",
        placeholder: "",
        type: "TextField",
        haveOptions: false,
        options: [],
        showInForm: false,
        showInList: false,
        sortable: true,
        customMapping: false,
      },
      {
        key: "name",
        label: "Product Name",
        placeholder: "",
        type: "TextField",
        haveOptions: false,
        options: {},
        showInForm: true,
        showInList: true,
        sortable: true,
      },
      {
        key: "company",
        label: "Manufacturer",
        placeholder: "",
        type: "TextField",
        haveOptions: false,
        options: {},
        showInForm: true,
        showInList: true,
        sortable: true,
      },
      {
        key: "description",
        label: "Description",
        placeholder: "",
        type: "TextArea",
        haveOptions: false,
        options: {},
        showInForm: true,
        showInList: false,
        sortable: false,
      },
      {
        key: "price",
        label: "Price",
        placeholder: "",
        type: "TextField",
        haveOptions: false,
        options: {},
        showInForm: true,
        showInList: true,
        sortable: true,
      },
    ];
    let recordOptions = {
      permissions: {
        create: true,
        update: true,
        delete: true,
      },
      saveForm: true,
      deleteForm: true,
      recordIds: [],
    };
    let records = [    
    ];

    let searchOptions = {
      search: false,
      hidePagination: true,
      url: null,
      perPageCount: 10,
      sortOrder: "asc",
      sortOption: "",
      keyword: "",
      keywordOptions: ["name", "label"],
      filterOptions: {
        type: "",
      },
    };

    // form
    let formActions = {
      saveForm: true,
      saveButtonText: "",
      deleteForm: true,
      deleteButtonText: "",
    };
    let defaultForm = {
      id: "",
      name: "",
      is_compulsory: "1",
    };

    return {
      createButton: createButton,
      isSlideInVisible: false,
      structure: structure,
      recordOptions: recordOptions,
      searchOptions: searchOptions,
      records: records,
      formTitle: "",
      formSubtitle: "Please fill the field data",
      closeConfirmation: "",
      formErrors: [],
      editMode: false,
      formActions: formActions,
      defaultForm: defaultForm,
      selectedForm: JSON.parse(JSON.stringify(defaultForm)),
    };
  },
  mounted() {
    if (localStorage) {
      this.records = JSON.parse(localStorage.records);
    }
  },
  watch: {
    records: {
      handler(newRecords) {
        localStorage.records = JSON.stringify(newRecords);
      },
      deep: true,
    },
  },
  components: {
    AppLayout,
    Welcome,
    Table,
    faEye,
    Form,
    Button,
  },

  methods: {
    save: function (data) {
      let form = this.$inertia.form(data);
      console.log(data);
      console.log(form);
      console.log(this.selectedForm);
      console.log(this.defaultForm);

      // to edit
      if (this.editMode === true) {
        for (var i = 0; i < this.records.length; i++) {
          if (this.records[i].id === data.id) {
            this.records[i].name === data.name;
            this.records[i].company === data.company;
            this.records[i].description === data.description;
            this.records[i].price === data.price;

            this.selectedForm = JSON.parse(JSON.stringify(this.defaultForm));
            this.formErrors = {};
            this.closeSlideIn();
            this.editMode = false;
          }
        }
      } else {
        let new_id = Math.floor(Math.random() * 100) + 1;
        this.records.push({
          id: new_id,
          name: data.name,
          company: data.company,
          description: data.description,
          price: data.price,
        });
        console.log(this.records);
        this.selectedForm = JSON.parse(JSON.stringify(this.defaultForm));
        this.formErrors = {};
        this.closeSlideIn();
      }
    },

    closeSlideIn: function () {
      this.selectedForm = JSON.parse(JSON.stringify(this.defaultForm));
      this.isSlideInVisible = false;
    },
    // button function
    addRecord() {
      this.formTitle = "Add Product";
      this.closeConfirmation =
        "Are you sure you want to close the panel, without creating the field?";
      this.isSlideInVisible = true;
      this.selectedForm = JSON.parse(JSON.stringify(this.defaultForm));
      this.formActions.deleteForm = false;
      this.formActions.saveButtonText = "Add Product";
    },

    editRecord(record) {
      this.editMode = true;
      this.formTitle = "Edit Field";
      this.closeConfirmation =
        "Are you sure you want to close the panel, without updating field details?";
      this.selectedForm = record;
      this.isSlideInVisible = true;
      this.formActions.deleteForm = true;
      this.formActions.saveButtonText = "Update";
      this.formActions.deleteButtonText = "Delete Field";
    },
    deleteRecord: function (record) {
      console.log(record);
      console.log(record.id);
      for (var i = 0; i < this.records.length; i++) {
        if (this.records[i].id === record.id) {
          this.records.splice(i, 1);
        }
      }
    },
  },
});
</script>
