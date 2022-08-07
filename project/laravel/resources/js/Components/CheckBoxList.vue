<template>
  <div class="grid grid-cols-1 gap-2">
    <label v-for="(item, index) in items" :key="index" class="flex items-start">
      <CheckBox
        :field="item"
        :data.sync="data[item.key]"
        @update:data="handleCheckChange(item, $event)"
      />

      <span class="font-medium text-gray-700 leading-none select-none"> </span>
      {{ item.label }}
      <br />
    </label>
  </div>
</template>

<script>
import CheckBox from "@/Components/CheckBox.vue";

export default {
  name: "CheckBoxList",

  components: { CheckBox },

  props: {
    field: {
      type: Object,
      required: true,
    },

    data: {
      type: [Object, String, Number],
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
          type: "CheckBox",
          haveOptions: false,
          options: {},
        };
        items.push(item);
      }

      return items;
    },
  },

  methods: {
    handleCheckChange(item, value) {
      this.data[item.key] = value;
      this.$emit("update:data", this.data);
    },
  },
};
</script>
