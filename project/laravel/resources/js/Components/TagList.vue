<template>
  <div class="tag-list">
    <ul>
        <draggable
            :list="tags"
            item-key="value"
            ghost-class="ghost"
            @change="finalList"
            :disabled="!isReorder"
        >
            <template #item="{ element, index }">
                <li class="tag" :key="element['key']">
                    <span v-if="isSelectable" class="title">{{ element[optionLable] }}</span>
                    <span v-else class="title">{{ element.value }}</span>
                    <button :disabled="disabled" class="delete-btn" @click="removeTag(index)">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="35" height="35"
                            fill="currentColor"
                            class="bi bi-x inline"
                            viewBox="-3 -7 32 32">
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                        </svg>
                    </button>
<!--                    <button :disabled="disabled" class="delete-btn" @click="removeTag(index)">-->
<!--                        X-->
<!--                    </button>-->
                </li>

            </template>
        </draggable>

      <li class="search-box" :disabled="disabled">
        <select
          v-if="isSelectable"
          @change="onSelectChange($event)"
          :class="styles"
          :disabled="disabled"
        >
          <option selected value="empty">{{ placeholderText }}</option>
          <option v-for="item in selectOptions" :key="item[optionId]" :value="item">
            {{ item[optionLable] }}
          </option>
        </select>

        <input
          v-else
          type="text"
          :placeholder="placeholderText"
          v-model="tag"
          @keyup="characterInput"
        />
      </li>
    </ul>
  </div>
</template>

<script>
import draggable from 'vuedraggable'

export default {
  name: "TagList",

  components: {
    draggable
  },
  model: {
    prop: "taglist",
    event: "input",
  },

  props: {
    field: {
      type: Object,
      required: true,
    },
    data: {
      type: [Array, String],
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    variation: {
      type: String,
      default: "default",
    },
  },

  emits: ["update:data"],

  data() {
    return {
      tag: "",
      tags: this.data
        ? this.field.options.isSelectable
          ? this.data
          : JSON.parse(this.data)
        : [],
      placeholderText: this.field.options.placeholder,
      isReorder: this.field.options.isReorder
        ? this.field.options.isReorder
        : false,
      isSelectable: this.field.options.isSelectable
        ? this.field.options.isSelectable
        : false,
      selectOptions:
        this.field.options.isSelectable && this.field.options.selectOptions
          ? this.field.options.selectOptions
          : [],
      optionId:
        this.field.options.isSelectable && this.field.options.optionId
          ? this.field.options.optionId
          : "",
      optionLable:
        this.field.options.isSelectable && this.field.options.optionLable
          ? this.field.options.optionLable
          : "",
    };
  },

  watch: {
    data: function (newData, oldData) {
      this.tags = newData
        ? this.field.options.isSelectable
          ? JSON.parse(JSON.stringify(newData))
          : JSON.parse(newData)
        : [];
    },
  },

  methods: {
    finalList: function () {
      this.$emit("update:data", this.tags);
    },
    onSelectChange(event) {
      if (event.target.selectedIndex - 1 >= 0) {
        let value = this.field.options.selectOptions[event.target.selectedIndex - 1];

        if (value != null && value != undefined) {
          if (this.tags.length > 0) {
            let id = this.optionId;
            var filteredOptions = this.tags.filter(function (elem) {
              if (elem[id] == value[id]) return elem;
            });
          } else {
            this.tags.push(value);
            this.tag = "";

            this.$emit("update:data", this.tags);
            //this.$emit("update:data", this.getSelectedIds(this.cloneArray(this.tags)));
          }
          if (filteredOptions && filteredOptions.length < 1) {
            this.tags.push(value);
            this.tag = "";
            //this.$emit("update:data", this.getSelectedIds(this.cloneArray(this.tags)));
            this.$emit("update:data", this.tags);
          }
        }
      }
    },

    characterInput(keyValue) {
      var savedInput = null;
      switch (keyValue.key) {
        case "Enter":
          savedInput = { id: this.tags.length, value: this.tag };
          break;
        case ",":
        case ";":
          savedInput = {
            id: this.tags.length,
            value: this.tag.substring(0, this.tag.length - 1),
          };
          break;
        default: // do nothing
      }
      if (savedInput != null) {
        if (this.tags.indexOf(savedInput) === -1) {
          this.tags.push(savedInput);
          this.tag = "";

          this.$emit("update:data", JSON.stringify(this.cloneArray(this.tags)));
        } else {
          this.tag = "";
        }
      }
    },

    removeTag(id) {
      this.tags.splice(id, 1);
      this.$emit(
        "update:data",
        this.isSelectable ? this.tags : JSON.stringify(this.cloneArray(this.tags))
      );
    },

    cloneArray(arr) {
      return arr.reduce(function (agg, val) {
        return agg.concat(val);
      }, []);
    },

    getSelectedIds(fields) {
      let optionId = this.optionId;
      let ids = fields.map(function (field) {
        return field[optionId];
      });

      return ids;
    },
  },

  computed: {
    styles: {
      get() {
        return "px-4 py-3 rounded-sm border border-primary-disabled text-primary-textDark focus:outline-none focus:ring-0 focus:ring-gray-200 focus:border-primary w-full";
      },
    },
  },
};
</script>
