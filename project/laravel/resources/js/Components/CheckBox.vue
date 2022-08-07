<template>
  <jet-checkbox
    v-model="checked"
    :value="data"
    :class="styles"
    type="checkbox"
    :checked="checked"
  />
</template>

<script>
import JetCheckbox from "@/Jetstream/Checkbox";

export default {
  name: "CheckBox",

  components: { JetCheckbox },

  props: {
    field: {
      type: Object,
      required: true,
    },

    data: {
      type: [String, Number, Boolean],
    },
  },

  emits: ["update:data"],

  computed: {
    checked: {
      get() {
        return this.data;
      },
      set(checked) {
        this.$emit("update:data", checked);
      },
    },
    styles: {
      get() {
        return "mr-2 text-primary disabled:opacity-50 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-primary";
      },
    },
  },
};
</script>
