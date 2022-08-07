<template>
  <div class="grid grid-cols-1 gap-2">
    <label v-for="(item, index) in items" :key="index" class="flex items-start">
      <RadioBox
        :field="item"
        :data.sync="data"
        @update:data="handleButtonChange($event)"
      />

      <span class="font-medium text-gray-700 leading-none select-none"> </span>
      {{ item.label }}
      <br />
    </label>
  </div>
</template>

<script>
import RadioBox from "@/Components/RadioBox.vue";

export default {
  name: "RadioBoxList",

  components: { RadioBox },

  props: {
    field: {
      type: Object,
      required: true,
    },

    data: {
      type: [String, Number],
      required: true,
    },
  },

  emits: ["update:data"],

  data() {
    return {
      options: this.field.options,
    };
  },

  computed: {
    items() {
      let values = this.field.options.options;

      let items = [];
      for (let key in values) {
        let item = {
          key: values[key].key,
          label: values[key].label,
          type: "RadioBox",
          haveOptions: true,
          options: {
            name: this.field.key,
          },
        };
        items.push(item);
      }

      return items;
    },
  },

  methods: {
    handleButtonChange(value) {
      this.$emit("update:data", value);
    },
  },
};
</script>
