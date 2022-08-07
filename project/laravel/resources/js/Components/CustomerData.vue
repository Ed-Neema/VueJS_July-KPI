<template>
  <div>
    <select v-if="hideSelect" v-model="selectedItem" :class="styles">
      <option value="empty">{{ emptyText }}</option>
      <option v-for="item in items" :key="item['key']" :value="item['key']">
        {{ item["label"] }}
      </option>
    </select>
    <div v-if="!hideFields && selectedCustomer">
      <div v-for="field in fields" :key="field['key']">
        <div class="grid grid-cols-2">
          <div class="px-4 py-2 font-semibold">{{ field.label }}</div>
          <div class="px-4 py-2">{{ selectedCustomer[field.key] }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "CustomerData",

  props: {
    field: {
      type: Object,
      required: true,
    },

    data: {
      type: [String, Number],
    },

    variation: {
      type: String,
      default: "default",
    },

    hideFields: {
      type: Boolean,
      default: false,
    },
  },

  emits: ["update:data"],

  data() {
    return {
      options: this.field.options,
      fields: this.field.options.fields,
    };
  },

  computed: {
    items() {
      let items = [];
      for (var customer in this.options.options) {
        customer = this.options.options[customer];
        if (this.field.options.filterBy) {
          let filterFunction = this.field.options.filterBy;
          let filterOptions = filterFunction();
          if (filterOptions) {
            if (customer[filterOptions.key] == filterOptions.value) {
              items.push({
                key: customer.id,
                label: customer.firstname + " " + customer.lastname,
              });
            }
          }
        } else {
          items.push({
            key: customer.id,
            label: customer.firstname + " " + customer.lastname,
          });
        }
      }

      return items;
    },

    selectedItem: {
      get() {
        let value = "empty";
        if (this.data && this.data != "") {
          value = this.data;
        }

        return value;
      },
      set(selectedItem) {
        if (selectedItem == "empty") {
          selectedItem = "";
        }

        this.$emit("update:data", selectedItem);
      },
    },

    selectedCustomer() {
      let details = null;
      if (this.selectedItem) {
        this.options.options;
        let customer = this.options.options.filter((customer) => {
          if (customer.id == this.selectedItem) {
            return customer;
          }
        });

        details = customer[0];
      }

      return details;
    },

    emptyText: {
      get() {
        let value = this.field.options.emptyOptionText;
        if (!value) {
          value = "Please Select";
        }
        return value;
      },
    },

    hideSelect: {
      get() {
        if (this.hideFields) {
          return true;
        }

        let functionName = this.field.options.hideSelect;
        if (functionName) {
          return functionName();
        }
        return false;
      },
    },

    styles: {
      get() {
        let baseClass = "border-gray-300 text-sm rounded-md shadow-sm";

        if (this.variation == "default") {
          baseClass +=
            " focus:border-gray-400 focus:ring-1 focus:ring-gray-500 focus:ring-opacity-50";
        }

        if (this.variation == "custom-label") {
          baseClass +=
            " focus:border-gray-400 focus:ring-1 focus:ring-gray-500 focus:ring-opacity-50";
        }

        return baseClass;
      },
    },
  },
};
</script>
