<template>
  <button :type="type" :disabled="disabled" :class="styles" @click="buttonClick()">
    {{ label }}
    <span v-if="icon" :class="iconClass"> + </span>
    <span v-if="customIcon">
      <FontAwesomeIcon :icon="iconObject" />
    </span>
  </button>
</template>

<script>
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faEye } from "@fortawesome/free-solid-svg-icons";

export default {
  name: "Button",

  components: {
    FontAwesomeIcon,
    faEye,
  },

  props: {
    field: {
      type: Object,
      required: true,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
  },

  emits: ["callback"],

  data() {
    return {
      variation: this.field.options.variation
        ? this.field.options.variation
        : "solid",
      label: this.field.label ? this.field.label : "",
      type: this.field.options.type ? this.field.options.type : "submit",
      icon: this.field.options.icon ? this.field.options.icon : false,
      customIcon: this.field.options.customIcon
        ? this.field.options.customIcon
        : false,
      color: this.field.options.color ? this.field.options.color : "primary",
      colorVariations: this.field.options.colorVariations
        ? this.field.options.colorVariations
        : " bg-red-500 hover:bg-red-300  active:bg-primary-pressedbutton active:border-primary-pressedbutton focus:bg-red-200 focus:border-red-200 "
    };
  },

  watch: {
    field: function (newField, oldField) {
      this.variation = newField.options.variation
        ? newField.options.variation
        : "solid";
      this.label = newField.label ? newField.label : "";
      this.type = newField.options.type ? newField.options.type : "submit";
      this.icon = newField.options.icon ? newField.options.icon : false;
      this.color = newField.options.color ? newField.options.color : "primary";
      this.colorVariations = newField.options.colorVariations
        ? newField.options.colorVariations
        : " bg-red-500 hover:bg-red-200 active:bg-primary-pressedbutton active:border-primary-pressedbutton focus:bg-red-200 focus:border-red-200";
    },
  },

  methods: {
    buttonClick() {
      this.$emit("callback");
    },
  },

  computed: {
    styles: {
      get() {
        let baseClass = "inline-flex items-center rounded font-bold py-4";

        if (this.icon) {
          baseClass += ` px-4`;
        } else if (this.customIcon) {
          baseClass += ` px-2`;
        } else {
          baseClass += ` px-12`;
        }

        if (this.variation == "solid") {
          baseClass += ` hidden sm:inline-flex text-white ml-5 font-medium rounded-lg text-sm px-5 py-2.5 text-center items-center mr-3`;

          if (this.color == "primary") {
            baseClass += ` border-red-200 hover:shadow focus:outline-none disabled:bg-gray-200 disabled:text-white disabled:shadow-none disabled:cursor-not-allowed disabled:border-gray-200 transition`;
          }
        }

        if (this.variation == "outlined") {
          baseClass += ` text-red-200 py-sm px-xl leading-none rounded border-2 disabled:bg-white transition duration-500 ease-in-out`;

          if (this.color == "primary") {
            baseClass += ` border-red-200 hover:shadow focus:outline-none disabled:text-primary-disabledbuttontext disabled:shadow-none disabled:cursor-not-allowed disabled:border-primary-disabledbutton transition`;
          }
        }

        if (this.variation == "ghost") {
          baseClass += ` outline-none hover:bg-${this.color}-500 text-${this.color}-700 focus:ring focus:ring-${this.color}-700 disabled:opacity-25 transition`;
        }

        baseClass += this.colorVariations;

        return baseClass;
      },
    },
    iconClass: {
      get() {
        return this.label == null ? "" : "pl-6";
      },
    },
    iconObject: {
      get() {
        if (this.customIcon == "eye") {
          return faEye;
        }
      },
    },
  },
};
</script>
