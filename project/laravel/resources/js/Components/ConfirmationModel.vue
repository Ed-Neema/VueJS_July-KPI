<template>
  <div
    :class="`inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-${color}-500`"
  >
    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
      <div class="sm:flex sm:items-start">
        <div
          :class="`mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-${color}-100 sm:mx-0 sm:h-10 sm:w-10`"
        >
          <div v-html="svg"></div>
        </div>
        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
          {{ header }}
          <div class="mt-2">
            <p class="text-sm text-gray-500">
              {{ message }}
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="flex items-center justify-center">
      <span class="pr-6">
        <Button @callback="confirm" :field="button" />
      </span>

      <span>
        <Button @callback="cancel" :field="button2" />
      </span>
    </div>
    <br />
  </div>
</template>

<script>
import Button from "@/Components/Button.vue";

export default {
  name: "ConfirmationModel",

  components: {
    Button,
  },

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

  emits: ["confirm", "cancel", "close"],

  data() {
    let button = {
      key: "button",
      label: "Confirm",
      placeholder: "",
      type: "Button",
      options: {
        color: this.color,
      },
    };

    let button2 = {
      key: "button2",
      label: "Cancel",
      placeholder: "",
      type: "Button",
      options: {
        color: this.color,
        variation: "outlined",
      },
    };

    return {
      button: button,
      button2: button2,
    };
  },

  methods: {
    confirm() {
      this.$emit("confirm");
    },
    cancel() {
      this.$emit("cancel");
    },
    close() {
      this.$emit("close");
    },
  },

  computed: {
    color: {
      get() {
        if (this.variation == "alert") {
          return "blue";
        }

        if (this.variation == "delete") {
          return "red";
        }
      },
    },
    svg: {
      get() {
        if (this.variation == "alert") {
          return `<svg class="h-8 w-8 text-blue-500"  fill="none" viewBox="0 0 24 24" stroke="blue">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
</svg>`;
        }

        if (this.variation == "delete") {
          return `<svg class="h-8 w-8 text-red-500"  fill="none" viewBox="0 0 24 24" stroke="red">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
</svg>`;
        }
      },
    },
  },
};
</script>
