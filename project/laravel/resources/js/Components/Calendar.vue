<template>
  <input :class="styles" v-model="selectedValue" type="date" :min="minValue" />
</template>

<script>
export default {
  name: "Calendar",

  props: {
    data: {
      type: String,
    },
  },

  emits: ["update:data"],

  data() {
    let current = new Date();
    let date =
      current.getFullYear() + "-" + (current.getMonth() + 1) + "-" + current.getDate();

    return {
      minValue: date,
    };
  },

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
        return "px-4 py-3 rounded-sm border text-primary-textDark focus:outline-none focus:ring-0 focus:ring-gray-200 focus:border-primary w-full";
      },
    },
  },
};
</script>
