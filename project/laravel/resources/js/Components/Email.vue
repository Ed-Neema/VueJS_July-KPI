<template>
  <input
    class="px-4 py-3 rounded-sm border-primary-disabled text-primary-textDark focus:outline-none focus:ring-0 focus:ring-primary-200 focus:border-primary w-full"
    v-model="selectedValue"
    type="email"
  />
</template>

<script>
export default {
  name: "Email",

  props: {
    data: {
      type: String,
      required: true,
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
  },
};
</script>
