<template>

    <Head title="Forgot Password" />
    <!-- GENERAL CONTAINER -->
    <div class="grid grid-cols-2 w-full h-screen">
        <!-- FORM CONTAINER -->
        <div class="col-span-1 mt-10 pt-8 px-12">
            <div class="flex items-center justify-center overflow-hidden">
                <form @submit.prevent="submit" class="w-4/5">
                    <h2 class="text-2xl text-primary-secondarygrey font-bold">Forgot Password</h2>
                    <p class="text-body text-primary-secondarygrey mb-6">Lorem ipsum dolor sit amet, consectetur
                        adipiscing
                        elit.</p>
                    <div v-if="status" class="mb-4 font-medium text-body text-primary-primarygreen">
                        {{ status }}
                    </div>
                    <jet-validation-errors class="mb-4" />
                    <!-- EMAIL -->
                    <div>
                        <jet-label for="email" value="Email" class="text-primary-secondarygrey text-body font-normal" />
                        <jet-input id="email" type="email"
                            class="mt-1 block w-full mr-2 text-primary-secondarygrey text-body h-input focus:border-primary-primarygreen" v-model="form.email"
                            required autofocus />
                    </div>
                    <!-- BUTTON -->
                    <div class="mt-2">
                        <jet-button
                            class="bg-primary-primarygreen w-full mt-10 h-input flex align-center justify-center font-bold"
                            :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Reset Password
                        </jet-button>
                    </div>
                    <!-- BACK TO SIGN IN -->
                    <Link :href="route('login')" class="text-body mt-3 flex justify-center text-center">
                    <span class="text-primary-primarygreen font-bold">Back to Sign in</span>
                    </Link>
                </form>
            </div>
        </div>
        <!-- INFO CONTAINER -->
        <div class="bg-primary-primarygreen col-span-1 overflow-hidden">
            <div class="mt-32 pf-4 ml-8">
                <p class="text-4xl text-white text-extrabold px-8 mb-5">Lorem ipsum dolor sit amet.</p>
                <p class="text-white text-body mt-2 px-8">Lorem ipsum dolor sit, amet consectetur adipisicing
                    elit.
                    Debitis
                    maiores in beatae nihil atque fuga illo corrupti, vel voluptates nisi.</p>
                <p class="text-white text-body mt-2 px-8">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Est,
                    iure. Ipsum dicta quam vero perspiciatis culpa, magnam pariatur, adipisci accusamus libero
                    optio, officia unde qui? Facilis fuga esse laboriosam ea?</p>
            </div>
            <!-- CIRCLES -->
            <div class="relative h-screen">
                <div
                    class="w-circlewidth h-circleheight absolute bottom-[calc(80vh-98%)] right-96 z-10 rounded-full bg-primary-circleone">
                </div>
                <div
                    class="w-circlewidth h-circleheight absolute bottom-[calc(80vh-98%)] z-20 rounded-full bg-primary-circletwo">
                </div>
                <div
                    class="w-circlewidth h-circleheight absolute bottom-[calc(80vh-98%)] left-96 z-0 rounded-full bg-primary-circlethree">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'

export default defineComponent({
    components: {
        Head,
        JetAuthenticationCard,
        JetAuthenticationCardLogo,
        JetButton,
        JetInput,
        JetLabel,
        JetValidationErrors,
        Link
    },

    props: {
        status: String
    },

    data() {
        return {
            form: this.$inertia.form({
                email: ''
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('password.email'))
        }
    }
})
</script>
