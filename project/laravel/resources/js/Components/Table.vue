<template>
  <div>
    <div class="bg-white rounded-lg shadow-md">
      <div v-if="searchOptions.search || searchOptions.filterOptions.length"
        class="items-start grid grid-cols-4 gap-4 p-4">
        <div v-if="searchOptions.search" class="relative">
          <div class="
                    absolute
                    inset-y-0
                    left-0
                    pl-3
                    flex
                    items-center
                    pointer-events-none
                  ">
            <SearchIcon/>
          </div>
          <TextField :data.sync="searchOptions.keyword" :id="searchId" :placeholder="'Search'"
            @update:data="handleSearchKeyword" class="pl-10 p-2" />
          <div v-if="showOptions">
            <button @click="clearSearch" class="absolute right-2 top-4 text-error">
              <FontAwesomeIcon :icon="faTimes" />
            </button>
            {{ records.total }} search results found
          </div>
        </div>
        <Filter v-if="searchOptions.filterOptions" :structure="structure" :filterOptions="searchOptions.filterOptions"
          @update:data="handleFilterOptions" class="col-span-3" />
      </div>
      <table class="table-fixed w-full">
        <thead class="bg-red-400 border-b border-b-primary-disabledbutton">
          <tr>
            <th class="px-4 py-4 text-left text-body font-bold  text-white capitalize tracking-wide"
              v-for="column in columns" :key="column['key']">
              {{ column.label }}
              <button v-if="column.sortable" @click="handleSortOptions(column)">
                <FontAwesomeIcon :icon="faSort" />
              </button>
            </th>
            <th v-if="!this.recordOptions.hideActions"
              class="p-4 text-body text-white capitalize font-bold tracking-wider text-center">
              Action
            </th>
          </tr>
        </thead>
        <tbody>
          <TableRow v-for="row in recordsData" :key="row['identifier']" :columns="columns" :row="row"
            :recordOptions="recordOptions" @edit="$emit('edit', row)" @delete="$emit('delete', row)"
            @custom="$emit('custom', row)" />
          <td v-if="!recordsData.length" :colspan="columns.length + (this.recordOptions.hideActions ? 0 : 1)"
            class="p-4 text-sm font-normal text-primary-secondarygrey text-center">
            No records at the moment.
          </td>
        </tbody>
      </table>
    </div>
    <div v-if="showPagination">
      <Paginator :links="records.links" :from="records.from" :to="records.to" :total="records.total"
        :perPageCount="searchOptions.perPageCount" @changePage="handlePageClick" @changeCount="handlePageCountChange" />
    </div>
  </div>
</template>
<script>
import { defineComponent } from "vue";
import TextField from "@/Components/TextField.vue";
import TableRow from "./TableRow.vue";
import Filter from "@/Components/Filter.vue";
import Paginator from "@/Components/Paginator.vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faTimes } from "@fortawesome/free-solid-svg-icons";
import { faSort } from "@fortawesome/free-solid-svg-icons";
import SearchIcon from "@/Components/Icons/SearchIcon.vue";

export default defineComponent({
  components: {
    TableRow,
    Filter,
    Paginator,
    TextField,
    FontAwesomeIcon,
    faTimes,
    faSort,
    SearchIcon
  },

  props: {
    structure: {
      type: Array,
      required: true,
    },
    records: {
      type: Object,
      required: true,
    },
    recordOptions: {
      type: Object,
      required: true,
    },
    searchOptions: {
      type: Object,
      required: false,
    },
  },

  data() {
    let recordsData = this.searchOptions.hidePagination
      ? this.records
      : this.records.data;

    let columns = this.structure.filter((column) => {
      if (column.showInList) {
        return column;
      }
    });

    return {
      recordsData: recordsData,
      faSort: faSort,
      faTimes: faTimes,
      columns: columns,
      searchId: Math.random() * 100,
    };
  },

  watch: {
    records: function (newRecords, oldErrors) {
      this.recordsData = this.searchOptions.hidePagination ? newRecords : newRecords.data;
    },
  },

  emits: ["edit", "delete", "sort", "search", "custom"],

  methods: {
    clearSearch() {
      let el = document.getElementById(this.searchId);
      el.value = "";
      el.dispatchEvent(new Event("input"));
    },

    handlePageClick(link) {
      this.searchOptions.url = link;
      this.$emit("search", this.searchOptions);
    },

    handlePageCountChange(count) {
      this.searchOptions.url = null;
      this.searchOptions.perPageCount = count;
      this.$emit("search", this.searchOptions);
    },

    handleSortOptions(sortOption) {
      let sortOrder = "asc";
      if (this.searchOptions.sortOption == sortOption.key) {
        sortOrder = this.searchOptions.sortOrder == "asc" ? "desc" : "asc";
      }

      this.searchOptions.url = null;
      this.searchOptions.sortOption = sortOption.key;
      this.searchOptions.sortOrder = sortOrder;
      this.$emit("search", this.searchOptions);
    },

    handleSearchKeyword(keyword) {
      this.searchOptions.url = null;
      this.searchOptions.keyword = keyword;
      this.$emit("search", this.searchOptions);
    },

    handleFilterOptions(filterOptions) {
      this.searchOptions.url = null;
      this.searchOptions.filterOptions = filterOptions;
      this.$emit("search", this.searchOptions);
    },
  },

  computed: {
    showOptions: {
      get() {
        return this.searchOptions.keyword == "" ? false : true;
      },
    },
    showPagination: {
      get() {
        return this.searchOptions.hidePagination ? false : this.recordsData.length;
      },
    },
    hideActions: {
      get() {
        hideActions;
        return this.recordOptions.hideActions;
      },
    },
  },
});
</script>
