<template>

    <Head title="Register" />
    <!-- GENERAL CONTAINER -->
    <div class="grid grid-cols-2 w-full h-screen">
        <!-- FORM CONTAINER -->
        <div class="col-span-1 mt-10 pt-5 px-12">
            <div class="flex items-center justify-center overflow-hidden">
                <form @submit.prevent="submit" class="w-4/5">
                    <h2 class="text-2xl text-primary-secondarygrey font-bold">Create an account</h2>
                    <p class="text-body text-primary-secondarygrey mb-6">Lorem ipsum dolor sit amet.</p>
                    <!-- ERRORS -->
                    <jet-validation-errors class="mb-4" />
                    <!-- NAME -->
                    <div>
                        <jet-label for="name" value="Name" class="text-primary-secondarygrey text-body" />
                        <jet-input id="name" type="text"
                            class="mt-1 block w-full mr-2 text-primary-secondarygrey text-body h-input focus:border-primary-primarygreen" v-model="form.name"
                            required autofocus autocomplete="name" placeholder="Enter your name" />
                    </div>
                    <!-- COMPANY NAME -->
                    <div class="mt-2">
                        <jet-label for="company" value="Company" class="text-primary-secondarygrey text-body" />
                        <jet-input id="company" type="text"
                            class="mt-1 block w-full text-primary-secondarygrey text-body h-input focus:border-primary-primarygreen" v-model="form.company"
                            required autofocus autocomplete="company" placeholder="Enter your company name" />
                    </div>
                    <!-- EMAIL -->
                    <div class="mt-2">
                        <jet-label for="email" value="Email" class="text-primary-secondarygrey text-body" />
                        <jet-input id="email" type="email"
                            class="mt-1 block w-full text-primary-secondarygrey text-body h-input focus:border-primary-primarygreen" v-model="form.email" required
                            placeholder="Enter your email" />
                    </div>
                    <!-- PASSWORD -->
                    <div class="mt-2">
                        <jet-label for="password" value="Password" class="text-primary-secondarygrey text-body" />
                        <jet-input id="password" type="password"
                            class="mt-1 block w-full text-primary-secondarygrey text-body h-input focus:border-primary-primarygreen" v-model="form.password"
                            required autocomplete="new-password" placeholder="Enter your password" />
                    </div>
                    <!-- CONFIRM PASSWORD -->
                    <div class="mt-2">
                        <jet-label for="password_confirmation" value="Confirm Password"
                            class="text-primary-secondarygrey text-body" />

                        <div class="mt-1 relative w-full">
                            <jet-input id="password_confirmation" type="password"
                                class="mt-1 block mr-2 w-full text-primary-secondarygrey text-body h-input focus:border-primary-primarygreen"
                                v-model="form.password_confirmation" required autocomplete="new-password"
                                placeholder="Confirm your password" />
                            <img src="./img/lock.png" class="w-6 h-6 absolute right-2 inset-y-0 mt-2" alt="">
                        </div>
                    </div>
                    <!-- TERMS AND CONDITIONS-->
                    <div class="flex items-center justify-between mt-4">
                        <div class="mr-auto">
                            <jet-label for="terms" class="flex items-center">
                                <div class="flex">
                                    <jet-checkbox name="terms" id="terms" v-model:checked="form.terms" />

                                    <p class="text-primary-secondarygrey text-body ml-2 cursor-pointer">
                                        I agree to the <a target="_blank" class="text-primary-primarygreen">Terms of
                                            Service</a>
                                        and
                                        <a target="_blank" class="text-primary-primarygreen">Privacy
                                            Policy</a>
                                    </p>
                                </div>
                            </jet-label>
                        </div>
                    </div>
                    <div class="mt-2">
                        <!-- SIGN UP BUTTON -->
                        <jet-button class="bg-primary-primarygreen w-full mt-2 flex align-center justify-center h-input"
                            :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Sign Up
                        </jet-button>
                    </div>
                    <!-- OTHER SIGN IN OPTIONS -->
                    <div class="mt-2 flex justify-between w-full">
                        <!-- google sign in -->
                        <div class="flex items-center align-center justify-center mr-auto">

                            <a href="#" class="bg-primary-othersignin rounded-sm flex px-socialloginx py-2.5">
                                <img src="./img/google.png" class="w-6 h-6 mr-2" />
                                <p class="text-primary-othersignintext text-body font-bold">Sign in with Google
                                </p>
                            </a>
                        </div>
                        <!-- facebook sign in -->
                        <div class="flex items-center align-center justify-center ml-auto">

                            <a href="#" class="bg-primary-othersignin rounded-sm flex px-socialloginx py-2.5 ">
                                <img src="./img/facebook.png" class="w-6 h-6 mr-2" />
                                <p class="text-primary-othersignintext text-body font-bold ">Sign in with Facebook
                                </p>
                            </a>
                        </div>
                    </div>
                    <!-- ALREADY REGISTERED -->
                    <div class="mt-2">
                        <Link :href="route('login')"
                            class="text-body text-primary-secondarygrey mt-2 flex justify-center text-center">
                        <p>Already have an account? <span class="text-primary-primarygreen">Sign in</span></p>
                        </Link>
                    </div>
                </form>
            </div>
        </div>

        <!-- INFO CONTAINER -->
        <div class="bg-primary-primarygreen col-span-1 overflow-hidden">

            <div class="mt-32 pf-4 ml-8">
                <p class="text-4xl text-white text-extrabold px-8 mb-5">Lorem ipsum dolor sit amet.</p>

                <p class="text-white text-body mt-2 px-8">Lorem ipsum dolor sit, amet consectetur adipisicing elit.
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

    data() {
        return {
            form: this.$inertia.form({
                name: '',
                company: '',
                email: '',
                password: '',
                password_confirmation: '',
                terms: false,
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('register'), {
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            })
        }
    }
})
</script>
