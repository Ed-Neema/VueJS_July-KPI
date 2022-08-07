<template>
  <div>
    <app-layout title="Dashboard">
      <div class="flex justify-between flex-col items-center mb-16">
        <h2 class="text-title font-bold text-red-500 leading-tight mt-8 mb-8">
          Products
        </h2>
        <!-- Product display -->

        <div class="grid grid-cols-3 gap-4">
          <div
            v-for="(record, index) in records"
            :key="index"
            class="flex flex-col rounded-md shadow-lg bg-red-50"
          >
            <img src="../Components/img/no-image.png" class="w-full h-64" />
            <div class="font-semibold text-red-300 text-base mt-3 px-6">
              {{ record.name }}
            </div>
            <div class="font-normal text-gray-400 text-base mt-3 px-6 h-32 overflow-hidden">
              {{ record.description }}
            </div>
            <div class="w-full flex justify-between items-center mt-3 px-6 mb-2">
              <div class="text-gray-400 font-semibold">Product by {{ record.company }}</div>
              <div
                class="
                  bg-red-400
                  text-white
                  font-semibold
                  rounded-xl
                  px-4
                  py-2
                  flex
                  justify-center
                  items-center
                "
              >
                ${{ record.price }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </app-layout>
  </div>
</template>

<script>
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import { faEye } from "@fortawesome/free-solid-svg-icons";

export default defineComponent({
  props: {},

  data() {
    let records = [];

    return {
      records: records,
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
    faEye,
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
