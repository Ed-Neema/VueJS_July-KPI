<template>
    <input type="checkbox" :value="value" v-model="proxyChecked"
        class=" border-gray-300 text-primary-primarygreen shadow-sm focus:border-primary-primarygreen focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md">
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
    emits: ['update:checked'],

    props: {
        checked: {
            type: [Array, Boolean],
            default: false,
        },
        value: {
            default: null,
        },
    },

    computed: {
        proxyChecked: {
            get() {
                return this.checked;
            },

            set(val) {
                this.$emit("update:checked", val);
            },
        },
    },
})
</script>
