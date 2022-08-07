<template>
  <select v-model="selectedItem" :class="styles" :disabled="disabled">
    <option value="empty">{{ emptyText }}</option>
    <option v-for="item in items" :key="item['key']" :value="item['key']">
      {{ item["label"] }}
    </option>
  </select>
</template>

<script>
export default {
  name: "Select",

  props: {
    field: {
      type: Object,
      required: true,
    },

    data: {
      type: [String, Number],
    },

    disabled: {
      type: Boolean,
      default: false,
    },

    variation: {
      type: String,
      default: "default",
    },
  },

  emits: ["update:data"],

  data() {
    return {
      options: this.field.options,
    };
  },

  computed: {
    items() {
      let items = [];
      for (var key in this.options.options) {
        items.push({
          key: key,
          label: this.options.options[key],
        });
      }

      return items;
    },

    selectedItem: {
      get() {
        let value = "empty";
        if (this.data != "" || this.data == 0) {
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

    emptyText: {
      get() {
        let value = this.field.options.emptyOptionText;
        if (!value) {
          value = "Please Select";
        }
        return value;
      },
    },

    styles: {
      get() {
        let baseClass = "leading-normal p-2.5 rounded-sm border-primary-disabled text-sm text-primary-textDark focus:outline-none focus:ring-0 focus:ring-gray-200 focus:border-primary w-full";

        if (this.variation == "default") {
          baseClass +=
            " focus:outline-none focus:ring-0 focus:ring-primary-200 focus:border-primary-primarygreen ";
        }

        if (this.variation == "custom-label") {
          baseClass +=
            " focus:outline-none focus:ring-0 focus:ring-primary-200 focus:border-primary-primarygreen ";
        }

        return baseClass;
      },
    },
  },
};
</script>
