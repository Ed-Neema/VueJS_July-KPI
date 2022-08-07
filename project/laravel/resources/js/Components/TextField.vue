<template>
  <input :class="styles" v-model="selectedValue" :readonly="disabled" @input="onChange" type="text" />
</template>

<script>
export default {
  name: "TextField",

  props: {
    data: {
      type: String,
      required: false,
    },
    variation: {
      type: String,
      default: "default",
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    errors: {
      type: String,
      default: "",
    },
  },

  data() {
    let fieldStyles = this.styles;

    return {
      fieldStyles: fieldStyles,
    };
  },

  watch: {
    errors: function (newErrors, oldErrors) {
      this.fieldStyles = this.styles;
    },
  },

  emits: ["update:data", "onChange:data"],

  computed: {
    selectedValue: {
      get() {
        return this.data;
      },
      set(selectedValue) {
        this.$emit("update:data", selectedValue);
      },
    },
    styles: {
      get() {
        let baseClass =
          "h-input rounded-sm border-red-200 text-primary-secondarygrey focus:outline-none focus:ring-0 focus:ring-red-200 focus:border-red-200 w-full text-base";

        if (this.errors != "") {
          baseClass += " border-primary-error";
        }

        return baseClass;
      },
    },
  },

  methods: {
    onChange: function () {
      this.$emit("onChange:data", this.selectedValue);
    }
  }
};
</script>
