<template>
    <button :type="type"
        class="inline-flex items-center px-4 py-2 font-normal text-white  border border-transparent text-account tracking-wide focus:outline-none focus:ring focus:ring-gray-300 rounded-md disabled:bg-primary-disabledbutton disabled:text-primary-disabledbuttontext transition">
        <slot></slot>
    </button>
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        props: {
            type: {
                type: String,
                default: 'submit',
            },
        }
    })
</script>
