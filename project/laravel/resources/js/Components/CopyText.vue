<template>
  <Button :field="button" @callback="copyText" />
</template>

<script>
import Button from "./Button.vue";
export default {
  components: { Button },
  name: "CopyText",

  props: {
    data: {
      type: String,
      default: "",
    },
  },

  data() {
    let button = {
      key: "button",
      label: "Copy",
      placeholder: "",
      type: "Button",
      options: {
        type: "button",
      },
    };

    return {
      button: button,
    };
  },

  methods: {
    async copyText() {
      navigator.clipboard.writeText(this.data);
    },
  },
};
</script>
