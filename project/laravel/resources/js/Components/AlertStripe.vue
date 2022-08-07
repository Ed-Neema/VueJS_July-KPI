<template>
  <div :class="styles" @click="buttonClick()">
    <div slot="avatar">
      <div v-html="svg"></div>
    </div>
    <div class="py-2">
      {{ header }}
      <div class="text-sm font-base">
        {{ message }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "AlertStripe",

  props: {
    header: {
      type: String,
    },
    message: {
      type: String,
    },
    variation: {
      type: String,
      default: "alert",
    },
  },

  emits: ["callback"],

  methods: {
    buttonClick() {
      this.$emit("callback");
    },
  },

  computed: {
    styles: {
      get() {
        let baseClass =
          "flex items-center m-1 font-medium py-1 px-2 bg-white rounded-md  cursor-pointer";

        if (this.variation == "alert") {
          baseClass += " text-blue-100 bg-blue-700 border-blue-700";
        }

        if (this.variation == "delete") {
          baseClass += "text-error text-bold bg-red-700 cursor-pointer";
        }

        return baseClass;
      },
    },
    svg: {
      get() {
        if (this.variation == "delete") {
          return `<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 bg-error bg-opacity-10 p-1 rounded-full mr-2" viewBox="0 0 20 20" fill="red">
  <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
</svg>`;
        }
      },
    },
  },
};
</script>
