<template>

    <Head title="Email Verification" />
    <!-- GENERAL CONTAINER -->
    <div class="grid grid-cols-2 w-full h-screen">
        <!-- FORM CONTAINER -->
        <div class="col-span-1 mt-10 pt-5 px-12">
            <!-- FORM -->
            <div class="flex items-center justify-center overflow-hidden">
                <form @submit.prevent="submit" class="w-4/5">
                    <h2 class=" text-2xl text-primary-secondarygrey font-bold">Verify your email</h2>
                    <p class="text-body text-primary-secondarygrey mb-6">Lorem ipsum dolor sit amet, consectetur
                        adipiscing
                        elit.</p>

                    <div class="mb-6 font-medium text-body text-primary-primarygreen" v-if="verificationLinkSent">
                        A new verification link has been sent to the email address you provided during registration.
                    </div>

                    <p class="text-body text-primary-secondarygrey mt-20">Didn't receive the email?
                    </p>

                    <div class="mt-2">
                        <!-- BUTTON -->
                        <jet-button class="bg-primary-primarygreen w-full mt-2 flex h-input align-center justify-center"
                            :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Resend email
                        </jet-button>

                        <!-- RESEND EMAIL -->
                        <div class="mt-2">
                            <Link :href="route('register')"
                                class="text-body text-primary-primarygreen font-bold mt-4 flex justify-center text-center">
                            Back to Sign Up
                            </Link>
                        </div>
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
import { Head, Link } from '@inertiajs/inertia-vue3';

export default defineComponent({
    components: {
        Head,
        JetAuthenticationCard,
        JetAuthenticationCardLogo,
        JetButton,
        Link,
    },

    props: {
        status: String
    },

    data() {
        return {
            form: this.$inertia.form()
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('verification.send'))
        },
    },

    computed: {
        verificationLinkSent() {
            return this.status === 'verification-link-sent';
        }
    }
})
</script>
