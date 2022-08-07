<template>
  <jet-dropdown align="left" width="48">
    <template #trigger>
      <span class="inline-flex rounded-md">
        <button type="button" :disabled="disabled" :class="triggerClass">
          {{ label }}

          <svg
            class="ml-2 -mr-0.5 h-4 w-4"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
              clip-rule="evenodd"
            />
          </svg>
        </button>
      </span>
    </template>

    <template #content>
      <button
        :class="contentButtonClass"
        v-for="item in options"
        :key="item.label"
        @click="buttonClick(item)"
      >
        {{ item.label }}
      </button>
    </template>
  </jet-dropdown>
</template>

<script>
import JetDropdown from "@/Jetstream/Dropdown.vue";

export default {
  components: { JetDropdown },
  name: "DropdownButton",

  props: {
    label: {
      type: String,
      required: true,
    },
    options: {
      type: Object,
      required: true,
    },
    variation: {
      type: String,
      default: "solid",
    },
    disabled: {
      type: Boolean,
      default: false,
    },
  },

  emits: ["buttonClick"],

  data() {
    return {
      open: false,
    };
  },

  methods: {
    buttonClick(item) {
      let functionName = item.functionName;
      functionName();
    },
  },

  computed: {
    triggerClass: {
      get() {
        let baseClass =
          "inline-flex items-center rounded font-bold py-4";

        if (this.variation == "solid") {
          baseClass +=
            "bg-primary hover:bg-primary-dark border-2 border-primary hover:shadow active:bg-primary-dark active:border-primary-dark focus:outline-none focus:bg-primary-dark focus:border-primary-dark disabled:bg-primary-disabled disabled:text-primary-disabledText disabled:shadow-none disabled:cursor-not-allowed disabled:border-primary-disabled transition";
        }

        if (this.variation == "outlined") {
          baseClass +=
            " bg-transparent hover:bg-blue-500 text-blue-blue hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-700 disabled:opacity-25 transition";
        }

        if (this.variation == "ghost") {
          baseClass +=
            " border-none outline-none hover:bg-blue-500 text-blue-700 focus:ring focus:ring-blue-700 disabled:opacity-25 transition";
        }

        return baseClass;
      },
    },
    contentButtonClass: {
      get() {
        let baseClass = "block px-4 py-2 text-xs text-gray-400 ";

        if (this.variation == "solid") {
          baseClass +=
            "  bg-blue-200 border border-blue-200 text-blue-700 py-3 px-4 pr-8 focus:outline-none focus:bg-white focus:border-blue-500";
        }

        if (this.variation == "outlined") {
          baseClass +=
            " bg-transparent hover:bg-blue-500 text-blue-blue hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-700 disabled:opacity-25 transition";
        }

        if (this.variation == "ghost") {
          baseClass +=
            " border-none outline-none hover:bg-blue-500 text-blue-700 focus:ring focus:ring-blue-700 disabled:opacity-25 transition";
        }

        return baseClass;
      },
    },
  },
};
</script>
