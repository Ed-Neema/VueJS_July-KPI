<template>
  <div class="">
    <div v-for="(group, index) in groups" :key="index">
      <span class="font-medium text-gray-700 leading-none select-none truncate">
        {{ group["label"] }}
      </span>
      <CheckBoxList
        :field="group"
        :data.sync="data[group.key]"
        @update:data="mapGroupValue(group, $event)"
      />
      <br />
    </div>
  </div>
</template>

<script>
import CheckBoxList from "@/Components/CheckBoxList.vue";

export default {
  name: "CheckBoxGroup",

  components: { CheckBoxList },

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
    groups() {
      let values = this.field.options.options;

      let groups = [];
      for (let key in values) {
        let item = {
          key: key,
          label: values[key].label,
          type: "CheckBoxList",
          haveOptions: true,
          options: {
            options: values[key].options,
          },
        };
        groups.push(item);
      }

      return groups;
    },
  },

  methods: {
    mapGroupValue(group, value) {
      this.data[group.key] = value;
      this.$emit("update:data", this.data);
    },
  },
};
</script>
