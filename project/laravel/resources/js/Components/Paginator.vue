<template>
  <div
    class="grid grid-flow-col auto-cols-max items-center justify-between mt-5 text-primary-secondarygrey font-semibold text-subtitle">
    <p class="">
      Showing
      <span class="font-semibold">{{ from }}</span>
      to
      <span class="font-semibold">{{ to }}</span>
      of
      <span class="font-semibold">{{ total }}</span>
      results
    </p>
    <div class="flex items-center justify-between space-x-4 w-auto">
      <div class="grid grid-flow-col auto-cols-max items-stretch place-content-center space-x-3">
        <div class="place-self-center">Per Page</div>
        <Select class="leading-none inline" :field="countSelectField" :data.sync="perPageCount"
          @update:data="handleCountClick($event)" />
      </div>
      <nav class="relative z-0 inline-flex rounded-md space-x-2" aria-label="Pagination">
        <button v-for="link in links" :key="link"
          class="relative inline-flex rounded-sm items-center text-body font-semibold text-gray-700 focus:outline-none h-8 w-8"
          :class="{
            'bg-primary-primarygreen': link.active,
            'text-white': link.active,
            'shadow': link.active,
            'cursor-not-allowed': link.url === null,
            'px-3 py-1': isPageNumber(link.label),
          }" preserve-state preserve-scroll type="button" :disabled="link.url === null"
          @click="handleButtonClick(link)">
          <svg v-if="isPrevious(link.label)"
            class="h-8 w-8 p-1 text-primary-primarygreen rounded-sm bg-primary-primarygreen bg-opacity-10"
            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd"
              d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
              clip-rule="evenodd" />
          </svg>
          <svg v-else-if="isNext(link.label)"
            class="h-8 w-8 p-1 text-primary-primarygreen rounded-sm bg-primary-primarygreen bg-opacity-10"
            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd"
              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
              clip-rule="evenodd" />
          </svg>
          <span v-else>{{ link.label }}</span>
        </button>
      </nav>
    </div>
  </div>
</template>

<script>
import Select from "@/Components/Select.vue";
export default {
  name: "Paginator",

  components: {
    Select,
  },

  props: {
    links: {
      type: Array,
      required: true,
    },

    from: {
      type: Number,
      required: true,
    },

    to: {
      type: Number,
      required: true,
    },

    total: {
      type: Number,
      required: true,
    },

    perPageCount: {
      type: [String, Number],
      required: true,
    },

    handlePageClick: {
      type: Function,
      default: null,
    },
  },

  emits: ["changePage", "changeCount"],

  data() {
    let countSelectField = {
      key: "count",
      options: {
        options: {
          10: "10",
          50: "50",
          100: "100",
        },
      },
    };

    return {
      countSelectField: countSelectField,
    };
  },

  methods: {
    isPrevious(label) {
      return label.includes("Previous");
    },

    isNext(label) {
      return label.includes("Next");
    },

    isPageNumber(label) {
      return !label.includes("Next") && !label.includes("Previous");
    },

    handleButtonClick(link) {
      this.$emit("changePage", link);
    },

    handleCountClick(value) {
      this.$emit("changeCount", value);
    },
  },
};
</script>
