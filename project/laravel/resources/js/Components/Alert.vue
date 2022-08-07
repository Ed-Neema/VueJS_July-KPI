<template>
  <div :class="styles" role="alert">
    <div v-html="svg"></div>
    <p class="font-bold">{{ header }}</p>
    <p>{{ message }}.</p>
  </div>
</template>

<script>
export default {
  name: "Alert",

  props: {
    header: {
      type: String,
    },
    message: {
      type: String,
    },
    variation: {
      type: String,
      default: "success",
    },
  },

  computed: {
    styles: {
      get() {
        let baseClass = "border-l-4 text-black-700 p-4";

        if (this.variation == "success") {
          baseClass += " bg-green-100  border-green-500";
        }

        if (this.variation == "error") {
          baseClass += " bg-red-100  border-red-500";
        }

        if (this.variation == "warning") {
          baseClass += " bg-yellow-100  border-yellow-500";
        }

        if (this.variation == "info") {
          baseClass += " bg-blue-100 border-blue-500";
        }

        return baseClass;
      },
    },
    svg: {
      get() {
        if (this.variation == "success") {
          return `<svg class="h-8 w-8 text-green-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
</svg>`;
        }

        if (this.variation == "error") {
          return `<svg class="h-8 w-8 text-red-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
</svg>`;
        }

        if (this.variation == "warning") {
          return `<svg class="h-8 w-8 text-orange-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
</svg>`;
        }

        if (this.variation == "info") {
          return `<svg class="h-8 w-8 text-blue-500"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
</svg>`;
        }
      },
    },
  },
};
</script>
