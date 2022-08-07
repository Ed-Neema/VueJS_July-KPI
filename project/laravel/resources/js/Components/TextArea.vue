<template>
  <textarea v-model="selectedValue" :class="styles" rows="4" />
</template>

<script>
export default {
  name: "TextArea",

  props: {
    data: {
      type: String,
    },
  },

  emits: ["update:data"],

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
        return "px-4 py-3 rounded-sm border border-primary-disabled text-primary-textDark focus:outline-none focus:ring-0 focus:ring-red-200 focus:border-red-200 w-full";
      },
    },
  },
};
</script>
