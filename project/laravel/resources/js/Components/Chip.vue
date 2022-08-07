<template>
  <span :class="styles">
    <span :class="textStyles">
      {{ label }}
    </span>
  </span>
</template>

<script>
export default {
  name: "Chip",

  props: {
    label: {
      type: String,
    },
    variation: {
      type: String,
      default: "default",
    },
  },

  computed: {
    styles: {
      get() {
        let baseClass =
          "flex justify-center items-center m-1 font-medium py-1 px-2 bg-white rounded-full";

        if (this.variation == "default") {
          baseClass += " text-blue-700 bg-blue-100 border border-blue-300";
        }

        if (this.variation == "progress") {
          baseClass += " text-yellow-700 bg-yellow-100 border border-yellow-300";
        }

        if (this.variation == "active") {
          baseClass += " text-green-700 bg-green-100 border border-green-300";
        }

        if (this.variation == "inactive") {
          baseClass += " text-grey-700 bg-grey-100 border border-grey-300";
        }

        return baseClass;
      },
    },
    textStyles: {
      get() {
        return "text-xs font-normal leading-none max-w-full flex-initial";
      },
    },
  },
};
</script>
