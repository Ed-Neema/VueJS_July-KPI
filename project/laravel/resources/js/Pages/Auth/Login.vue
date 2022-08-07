<template class="font-sans w-full">

    <Head title="Log in" />
    <!-- GENERAL CONTAINER -->
    <div class="grid grid-cols-2 w-full h-screen">
        <!-- FORM CONTAINER -->
        <div class="col-span-1 mt-16 pt-5 px-12">
            <div class="flex items-center justify-center overflow-hidden">
                <form @submit.prevent="submit" class="w-4/5">
                    <h2 class="text-2xl text-primary-secondarygrey font-bold">Welcome Back!</h2>
                    <p class="text-body text-primary-secondarygrey mb-6">Lorem ipsum dolor sit amet.</p>
                    <jet-validation-errors class="mb-4 mt-2" />
                    <div v-if="status" class="mb-4 mt-2 font-medium text-body w-full text-green-600">
                        {{ status }}
                    </div>
                    <!-- EMAIL -->
                    <div>
                        <jet-label for="email" value="Email" class="text-primary-secondarygrey text-body" />
                        <jet-input id="email" type="email" placeholder="Enter your email"
                            class="mt-1 block w-full h-input mr-2 text-primary-secondarygrey text-body focus:border-primary-primarygreen"
                            v-model="form.email" required autofocus />
                    </div>
                    <!-- PASSWORD -->
                    <div class="mt-4">
                        <jet-label for="password" value="Password" class="text-primary-secondarygrey text-body" />
                        <div class="mt-1 relative w-full">
                            <jet-input id="password" type="password"
                                class="mt-1 block mr-2 w-full text-primary-secondarygrey text-body h-input focus:border-primary-primarygreen"
                                placeholder="Enter your password" v-model="form.password" required
                                autocomplete="current-password" />

                            <img src="./img/lock.png" class="w-6 h-6 absolute right-2 inset-y-0 mt-2" alt="">
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <!-- REMEMBER ME CHECKBOX -->
                        <div class="mr-auto">
                            <label class="flex items-center">
                                <jet-checkbox name="remember" v-model:checked="form.remember" />
                                <span class="text-primary-secondarygrey text-body ml-2 cursor-pointer ">Remember
                                    me</span>
                            </label>
                        </div>
                        <!-- FORGOT PASSWORD -->
                        <div class="ml-auto">
                            <Link v-if="canResetPassword" :href="route('password.request')"
                                class="text-body text-primary-secondarygrey flex items-center font-semibold">
                            Forgot password?
                            </Link>
                        </div>
                    </div>
                    <!-- SIGN IN BUTTON -->                    
                    <jet-button
                        class="bg-primary-primarygreen w-full mt-10 flex align-center justify-center font-bold h-input"
                        :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Sign in
                    </jet-button>
                    <!-- OTHER SIGN IN OPTIONS -->
                    <div class="mt-2 grid gap-4 grid-cols-2">
                        <!-- google sign in -->
                        <div
                            class="col-span-1 flex items-center rounded-sm bg-primary-othersignin align-center justify-center">
                            <a href="#" class="flex py-2.5">
                                <img src="./img/google.png" class="w-6 h-6 mr-2" />
                                <p class="text-primary-othersignintext text-body font-bold">Sign in with Google </p>
                            </a>
                        </div>
                        <!-- facebook sign in -->
                        <div
                            class="col-span-1 flex items-center rounded-sm bg-primary-othersignin align-center justify-center">
                            <a href="#" class="flex py-2.5">
                                <img src="./img/facebook.png" class="w-6 h-6 mr-2" />
                                <p class="text-primary-othersignintext text-body font-bold ">Sign in with Facebook
                                </p>
                            </a>
                        </div>
                    </div>
                    <div class="text-body text-primary-secondarygrey mt-8 flex justify-center text-center">
                        <p>Don't have an account? </p>
                        <Link :href="route('register')" class="">
                        <span class="text-primary-primarygreen ml-1"> Sign up</span>
                        </Link>
                    </div>
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
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetCheckbox from '@/Jetstream/Checkbox.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default defineComponent({
    components: {
        Head,
        JetAuthenticationCard,
        JetAuthenticationCardLogo,
        JetButton,
        JetInput,
        JetCheckbox,
        JetLabel,
        JetValidationErrors,
        Link,
    },

    props: {
        canResetPassword: Boolean,
        status: String
    },

    data() {
        return {
            form: this.$inertia.form({
                email: '',
                password: '',
                remember: false
            })
        }
    },

    methods: {
        submit() {
            this.form
                .transform(data => ({
                    ...data,
                    remember: this.form.remember ? 'on' : ''
                }))
                .post(this.route('login'), {
                    onFinish: () => this.form.reset('password'),
                })
        }
    }
})
</script>
