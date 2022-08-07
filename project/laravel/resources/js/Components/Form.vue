<template>
  <div class="fixed z-50 inset-0 overflow-hidden" v-bind:class="{ hidden: !visibility }">
    <div class="absolute inset-0 overflow-hidden">
      <div class="absolute inset-0 bg-black bg-opacity-25 transition-opacity" aria-hidden="true"></div>
      <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
        <div class="relative w-screen max-w-screen-sm">
          <div class="absolute top-0 left-0 -ml-8 pt-4 pr-2 flex sm:-ml-10 sm:pr-4">
            <button type="button"
              class="rounded-md text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
              @click="closeSlide()">
              <span class="sr-only">Close panel</span>
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>

          <div class="h-full flex flex-col bg-white shadow-xl overflow-y-scroll">
            <div class="sticky top-0 z-50 bg-primary-sidepanelbg p-6">
              <h2 class="text-2xl font-bold text-red-500" id="slide-over-title">
                {{ formTitle }}
              </h2>
              <h4 class="text-body font-normal text-red-300" id="slide-over-title">
                {{ formSubtitle }}
              </h4>
              <button v-if="scheduledUpdate" @click="showScheduledUpdate()"
                class="text-base font-normal text-primary-secondarygrey" id="slide-over-title">
                You have a scheduled update for this record.
              </button>
            </div>

            <div class="mt-6 relative flex-1 px-4 sm:px-6">
              <div v-for="field in fields" :key="field['key']">
                <div v-if="showField(field)" class="flex flex-col space-y-2 pt-4">
                  <label for="label" class="text-primary-secondarygrey font-normal text-base">{{ field.label }}</label>

                  <div v-if="field.type !== 'Table'">
                    <component :is="field.type" :field="field" :disabled="disableField(field)"
                      :placeholder="field.placeholder" :errors="getFieldError(field)" :data.sync="form[field.key]"
                      @update:data="form[field.key] = $event" @onChange:data="observeChanges(field, $event)"
                      @callback="fieldCallback(field.callback)" />
                  </div>

                  <div v-else>
                    <Table :structure="field.options.structure" :records="form[field.key]"
                      :recordOptions="field.options.recordOptions" :searchOptions="field.options.searchOptions"
                      @edit="field.options.edit" @delete="field.options.delete" />
                  </div>

                  <InputError :message="getFieldError(field)" />
                </div>
              </div>

              <div class="flex flex-col space-y-2 pt-4 mt-4" v-if="actions.deleteForm == true">
                <AlertStripe v-if="allowAction('delete')" :header="actions.deleteButtonText" :message="''"
                  :variation="'delete'" @callback="deleteData(form)"
                  class="bg-secondary bg-opacity-5 text-left font-bold text-error border-0 cursor-pointer" />
              </div>

              <div class="flex sticky bottom-0 z-50 bg-primary-lightBg p-2 justify-center"
                v-if="actions.saveForm == true">
                <Button v-if="allowAction('save')" :field="getSaveButtonObject()" :disabled="isDisabled"
                  @callback="saveData(form)" class="self-center mx-auto my-4" />
              </div>
              <div class="flex sticky bottom-0 z-50 bg-primary-lightBg p-2 justify-center"
                v-if="actions.customButton == true">
                <Button v-if="allowAction('custom')" :field="getCustomButtonObject()" :disabled="isDisabled"
                  @callback="customAction(form)" class="self-center mx-auto my-4" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent } from "vue";
import TextField from "@/Components/TextField.vue";
import Email from "@/Components/Email.vue";
import Password from "@/Components/Password.vue";
import Select from "@/Components/Select.vue";
import InputError from "@/Components/InputError.vue";
import ToggleSwitch from "@/Components/ToggleSwitch.vue";
import CheckBoxGroup from "@/Components/CheckBoxGroup.vue";
import CheckBox from "@/Components/CheckBox.vue";
import CheckBoxList from "@/Components/CheckBoxList.vue";
import RadioBoxList from "@/Components/RadioBoxList.vue";
import Button from "@/Components/Button.vue";
import Table from "@/Components/Table.vue";
import CustomerData from "@/Components/CustomerData.vue";
import Calendar from "@/Components/Calendar.vue";
import AlertStripe from "@/Components/AlertStripe.vue";
import TextArea from "@/Components/TextArea.vue";
import TagList from "@/Components/TagList.vue";

export default defineComponent({
  components: {
    TextField,
    Email,
    Password,
    Select,
    InputError,
    ToggleSwitch,
    CheckBoxGroup,
    CheckBoxList,
    CheckBox,
    RadioBoxList,
    Button,
    Table,
    CustomerData,
    Calendar,
    AlertStripe,
    TextArea,
    TagList,
  },

  props: {
    formTitle: {
      type: String,
      required: true,
    },
    formSubtitle: {
      type: String,
    },
    closeConfirmation: {
      type: [String, Boolean],
    },
    scheduledUpdate: {
      type: Boolean,
    },
    formErrors: {
      type: Object,
    },
    visibility: {
      type: Boolean,
      required: true,
    },
    structure: {
      type: Array,
      required: true,
    },
    form: {
      type: Object,
      required: true,
    },
    actions: {
      type: Object,
      required: true,
    },
    recordOptions: {
      type: Object,
      required: true,
    },
    formWidth: {
      type: String,
      default: "sm",
    },
  },

  data() {
    let fields = this.structure.filter((field) => {
      if (field.showInForm) {
        return field;
      }
    });

    const defaultForm = JSON.parse(JSON.stringify(this.form));
    return {
      fields: fields,
      defaultForm: defaultForm,
    };
  },

  watch: {
    form: function (newForm, oldForm) {
      this.defaultForm = JSON.parse(JSON.stringify(newForm));
    },
    formWidth: function (newWidth, oldWidth) {
      this.width = newWidth;
    },
  },

  emits: ["close", "save", "delete", "custom", "scheduledUpdate"],

  methods: {
    closeSlide() {
      let showConfirmation = this.enableForm;

      let valid = false;
      if (showConfirmation && this.closeConfirmation) {
        if (!this.compareArrays(this.form, this.defaultForm)) {
          if (confirm(this.closeConfirmation)) {
            valid = true;
          }
        } else {
          valid = true;
        }
      } else {
        valid = true;
      }

      if (valid) {
        this.$emit("close");
      }
    },

    saveData(data) {
      this.$emit("save", data);
    },

    customAction(data) {
      this.$emit("custom", data);
    },

    showScheduledUpdate() {
      this.$emit("scheduledUpdate");
    },

    deleteData(data) {
      this.$emit("delete", data);
    },

    fieldCallback(fieldCallback) {
      fieldCallback();
    },

    compareArrays(form, defaultForm) {
      return JSON.stringify(form) === JSON.stringify(defaultForm);
    },

    getFieldError(field) {
      if (this.formErrors) {
        let key = field.key;
        if (field.validateKey) {
          key = field.validateKey;
        }
        return this.formErrors[key];
      }
      return "";
    },

    allowAction(type) {
      let valid = true;

      if (type == "save") {
        valid = this.enableForm;

        if (this.recordOptions.saveForm) {
          if (this.recordOptions.recordIds.indexOf(this.form.id) !== -1) {
            valid = false;
          }
        }
      }

      if (type == "delete") {
        if (this.checkPermission("delete")) {
          if (this.recordOptions.deleteForm) {
            if (this.recordOptions.recordIds.indexOf(this.form.id) !== -1) {
              valid = false;
            }
          }
        } else {
          valid = false;
        }
      }

      return valid;
    },

    getSaveButtonObject() {
      let button = {
        key: "button",
        label: this.actions.saveButtonText,
        placeholder: "",
        type: "Button",
        options: {},
      };

      return button;
    },

    getCustomButtonObject() {
      let button = {
        key: "button",
        label: this.actions.customButtonText,
        placeholder: "",
        type: "Button",
        options: {},
      };

      return button;
    },

    checkFormType() {
      if (this.form.hasOwnProperty("created_at")) {
        return "update";
      }
      return "create";
    },

    checkPermission(type) {
      if (!this.recordOptions.permissions[type]) {
        return false;
      }

      return true;
    },

    showField(field) {
      if (field.triggerCondition) {
        let fieldTrigger = field.triggerCondition;
        let item = fieldTrigger(this.form, field);
        return item;
      }
      return true;
    },

    disableField(field) {
      let disable = false;

      if (!this.enableForm) {
        disable = true;
      }

      if (field.disabled) {
        disable = true;
      }

      if (field.disabledCondition) {
        let conditionResponse = field.disabledCondition;
        conditionResponse = conditionResponse(this.form);
        if (conditionResponse) {
          disable = true;
        }
      }
      return disable;
    },

    observeChanges(field, event){
      if(field.onChange){
        field.onChange(event);
      }
    }
  },

  computed: {
    isDisabled() {
      if (this.compareArrays(this.form, this.defaultForm)) {
        return true;
      }
      return false;
    },

    enableForm() {
      let formType = this.checkFormType();
      return this.checkPermission(formType);
    },

    formClass: {
      get() {
        let formClass = "relative w-screen max-w-screen-" + this.formWidth;
        return formClass;
      },
    },
  },
});
</script>
