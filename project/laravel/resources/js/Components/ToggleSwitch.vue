<template>
  <div class="flex items-center">
    <button type="button" :class="[enabled ? 'bg-primary-primarygreen' : 'bg-primary-secondarygrey']"
      class="relative inline-flex items-center flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-white"
      @click="toggleSwitch()">
      <span :class="enabled ? 'translate-x-5 bg-white' : 'translate-x-0 bg-white'"
        class="pointer-events-none inline-block h-5 w-5 rounded-full shadow transform ring-0 transition ease-in-out duration-200" />
    </button>
    <input type="text" hidden v-model="enabled" :id="id" />
    <label class="pl-2 text-primary-secondarygrey text-base"> {{ field.options.label }} {{ currentStatus }} </label>
  </div>
</template>

<script>
import Input from "../Jetstream/Input.vue";
export default {
  components: { Input },
  name: "ToggleSwitch",

  props: {
    data: {
      type: [String, Number],
      required: false,
    },

    field: {
      type: Object,
      required: false,
    },

    disabled: {
      type: Boolean,
      default: false,
    },
  },

  emits: ["update:data"],

  data() {
    return {
      id: Math.random() * 100,
    };
  },

  methods: {
    toggleSwitch() {
      if (!this.disabled) {
        let value = this.enabled ? 0 : 1;

        let el = document.getElementById(this.id);
        el.value = value;
        el.dispatchEvent(new Event("input"));
      }
    },
  },

  computed: {
    enabled: {
      get() {
        return this.data == 1 ? true : false;
      },
      set(selectedValue) {
        this.$emit("update:data", selectedValue);
      },
    },
    currentStatus: {
      get() {
        return this.field.options.options[this.data];
      },
    },
  },
};
</script>
