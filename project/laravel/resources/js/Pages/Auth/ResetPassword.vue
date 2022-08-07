<template>

    <Head title="Reset Password" />
    <!-- GENERAL CONTAINER -->
    <div class="grid grid-cols-2 w-full h-screen">
        <!-- FORM CONTAINER -->
        <div class="col-span-1 mt-10 pt-5 px-12">
            <div class="flex items-center justify-center overflow-hidden">
                <form @submit.prevent="submit" class="w-4/5">
                    <h2 class="text-2xl text-primary-secondarygrey font-bold">Set new password</h2>
                    <p class="text-body text-primary-secondarygrey mb-6">Lorem ipsum dolor sit amet.</p>
                    <jet-validation-errors class="mb-4 mt-2" />
                    <!-- EMAIL -->
                    <div>
                        <jet-label for="email" value="Email" class="text-primary-secondarygrey text-body" />
                        <jet-input id="email" type="email" placeholder="Enter your email"
                            class="mt-1 block w-full mr-2 text-primary-secondarygrey text-body  h-input focus:border-primary-primarygreen" v-model="form.email"
                            required autofocus />
                    </div>
                    <!-- NEW PASSWORD -->
                    <div class="mt-4">
                        <jet-label for="password" value="Password" class="text-primary-secondarygrey text-body" />
                        <jet-input id="password" type="password"
                            class="mt-1 block w-full text-primary-secondarygrey text-body h-input focus:border-primary-primarygreen"
                            placeholder="Atleast 8 characters" v-model="form.password" required
                            autocomplete="new-password" />
                    </div>
                    <!-- CONFIRM NEW PASSWORD -->
                    <div class="mt-4">
                        <jet-label for="password_confirmation" value="Confirm Password"
                            class="text-primary-secondarygrey text-body" />
                        <div class="mt-1 relative w-full">
                            <jet-input id="password_confirmation" type="password"
                                class="mt-1 block mr-2 w-full text-primary-secondarygrey text-body h-input focus:border-primary-primarygreen"
                                placeholder="Atleast 8 characters" v-model="form.password_confirmation" required
                                autocomplete="new-password" />
                            <img src="./img/lock.png" class="w-6 h-6 absolute right-2 inset-y-0 mt-2" alt="">
                        </div>
                    </div>
                    <!-- RESET BUTTON -->
                    <div class="mt-2">
                        <jet-button class="bg-primary-primarygreen w-full mt-10 flex align-center h-input justify-center"
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
import { defineComponent } from 'vue';
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
        email: String,
        token: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                token: this.token,
                email: this.email,
                password: '',
                password_confirmation: '',
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('password.update'), {
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            })
        }
    }
})
</script>
