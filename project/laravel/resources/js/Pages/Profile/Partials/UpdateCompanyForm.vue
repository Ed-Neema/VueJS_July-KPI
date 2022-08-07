<template>
    <jet-form-section @submitted="updateCompanyDetails">
        <template #title>
            <div class="text-primary-secondarydisabled font-semibold text-subtitle">
                Company Information
            </div>
        </template>

        <template #description>
            <div class="text-primary-secondarygrey font-semibold text-subtitle">
                Update your company information.
            </div>
        </template>

        <template #form>
            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="company_name" value="Name"
                    class="text-primary-secondarygrey font-normal text-body mb-2" />
                <jet-input id="company_name" type="text"
                    class="mt-1 block w-full text-primary-secondarygrey font-normal text-body"
                    v-model="form.company_name" autocomplete="company_name" />
                <jet-input-error :message="form.errors.company_name" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
import { defineComponent } from 'vue'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetFormSection from '@/Jetstream/FormSection.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'

export default defineComponent({
    components: {
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
    },
    props: ['company'],

    data() {
        return {
            form: this.$inertia.form({
                company_name: this.company.name,
            }),
        }
    },

    methods: {
        updateCompanyDetails() {
            this.form.put(route('user-company.update'), {
                errorBag: 'updateCompany',
                preserveScroll: true,
                onSuccess: () => this.closeModal(),
                onError: () => {
                    if (this.form.errors.company) {
                        this.$refs.company.focus()
                    }
                }
            })
        },
    },
})
</script>
