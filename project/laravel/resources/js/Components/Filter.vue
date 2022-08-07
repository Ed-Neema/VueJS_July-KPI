<template>
  <div class="grid grid-cols-4 gap-4">
    <div v-for="field in fields" :key="field['key']" class="flex w-full justify-center align-middle">
      <div class="
            text-body
            text-primary-secondarygrey
            border-primary-disabled
            font-bold
            border border-r-0
            rounded-sm rounded-r-none
            p-2.5
            bg-secondary bg-opacity-5
          ">
        <span>{{ field.label }}</span>
      </div>
      <component v-if="field.type !== 'Calendar'" :is="field.filterType" :field="field" :hideFields="true"
        :placeholder="field.placeholder" :data.sync="filterOptions[field.key]"
        @update:data="setOptions(field.key, $event)" class="w-full rounded-sm rounded-l-none border-l-0" />
      <input v-if="field.type == 'Calendar'" type="date" v-model="filterOptions[field.key]"
        @change="onChange(field.key, $event)"
        class="w-full rounded-sm rounded-l-none border-l-0 border-primary-disabled">
    </div>
  </div>
</template>

<script>
import { defineComponent } from "vue";
import Select from "@/Components/Select.vue";
import CustomerData from "@/Components/CustomerData.vue";
import ToggleSwitch from "@/Components/ToggleSwitch.vue";

export default defineComponent({
  components: {
    Select,
    CustomerData,
    ToggleSwitch,
  },

  props: {
    structure: {
      type: Array,
      required: true,
    },
    filterOptions: {
      type: Object,
      required: true,
    },
  },

  data() {
    let fields = this.structure.filter((field) => {
      if (field.filterable) {
        field.filterType = field.type;
        if (field.type == "ToggleSwitch") {
          field.filterType = "Select";
        }

        return field;
      }
    });

    return {
      fields: fields,
    };
  },

  methods: {
    setOptions(key, value) {
      this.filterOptions[key] = value;
      this.$emit("update:data", this.filterOptions);
    },
    onChange(key, value) {
      this.$emit("update:data", this.filterOptions);
      this.$emit("search", this.searchOptions);
    }
  },

  emits: ["update:data", "search"],
});
</script>
