<template>
  <div class="relative">
    <input
      class="px-4 py-3 rounded-sm border-primary-disabled text-primary-textDark focus:outline-none focus:ring-0 focus:ring-primary-200 focus:border-primary w-full"
      v-model="selectedValue"
      :disabled="disabled"
      :type="type"
      :id="id"
    />
    <Button
      v-if="field.options.showHide"
      :field="showHideButton"
      :disabled="disabled"
      @callback="showPassword()"
      class="absolute right-0 p-0"
    />
    <Button
      v-if="field.options.generate"
      :field="generateButton"
      :disabled="disabled"
      @callback="generatePassword()"
      class="absolute right-0 p-0"
    />
    <CopyText v-if="field.options.copyText" :data="selectedValue" :disabled="disabled" />
  </div>
</template>

<script>
import CopyText from "@/Components/CopyText.vue";
import Button from "@/Components/Button.vue";

export default {
  name: "Password",

  components: {
    CopyText,
    Button,
  },

  props: {
    field: {
      type: Object,
    },
    data: {
      type: String,
      default: "",
    },
    disabled: {
      type: Boolean,
      default: false,
    },
  },

  emits: ["update:data"],

  data() {
    let showHideButton = {
      key: "show_hide",
      label: "",
      placeholder: "",
      type: "Button",
      options: {
        customIcon: "eye",
        variation: "ghost",
        type: "button",
      },
    };

    let generateButton = {
      key: "generate",
      label: "Generate",
      placeholder: "",
      type: "Button",
      options: {
        variation: "outlined",
        type: "button",
      },
    };

    return {
      type: "password",
      showHideButton: showHideButton,
      generateButton: generateButton,
      id: Math.random() * 100,
    };
  },

  methods: {
    showPassword() {
      if (this.type === "password") {
        this.type = "text";
      } else {
        this.type = "password";
      }
    },

    generatePassword() {
      let CharacterSet =
        "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789![]{}()%&*$#^<>~@|";
      let password = "";
      for (let i = 0; i < 12; i++) {
        password += CharacterSet.charAt(Math.floor(Math.random() * CharacterSet.length));
      }

      let el = document.getElementById(this.id);
      el.value = password;
      el.dispatchEvent(new Event("input"));
    },
  },

  computed: {
    selectedValue: {
      get() {
        return this.data;
      },
      set(selectedValue) {
        this.$emit("update:data", selectedValue);
      },
    },
  },
};
</script>
