<template>
  <input
    type="radio"
    v-model="picked"
    :checked="picked"
    :name="field.options.name"
    :class="styles"
  />
</template>

<script>
export default {
  name: "RadioBox",

  props: {
    field: {
      type: Object,
      required: true,
    },
    data: {
      type: [String, Number],
      required: true,
    },
  },

  emits: ["update:data"],

  computed: {
    picked: {
      get() {
        return this.data == this.field.key ? true : false;
      },
      set(picked) {
        this.$emit("update:data", this.field.key);
      },
    },
    styles: {
      get() {
        return "rounded h-6 w-6 border-primary-text border-2 text-primary shadow-sm focus:border-primary focus:ring-0";
      },
    },
  },
};
</script>
