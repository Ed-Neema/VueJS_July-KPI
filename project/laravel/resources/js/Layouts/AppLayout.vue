<template>
  <div>
    <Head :title="title" />

    <!-- Header -->
    <nav class="bg-white border-b border-gray-200 shadow-md fixed z-30 w-full">
      <div class="px-3 py-3 lg:px-5 lg:pl-3 h-24 flex items-center">
        <div class="flex items-center justify-between w-full">
          <div class="flex items-center">
            <a
              href="{{'dashboard'|page }}"
              class="text-xl font-bold flex items-center lg:ml-2.5"
            >
              <img
                src="../Components/img/logo.png"
                class="h-16 mr-2 w-16"
                alt="Logo"
              />
            </a>
          </div>

          <div class="flex items-center">
            <button
              @click="logout()"
              class="
                hidden
                sm:inline-flex
                ml-5
                text-white
                bg-red-400
                hover:bg-red-700
                focus:ring-4 focus:ring-red-200
                font-medium
                rounded-lg
                text-sm
                px-5
                py-2.5
                text-center
                items-center
                mr-3
              "
            >
              Logout
            </button>
          </div>
        </div>
      </div>
    </nav>

    <div class="flex overflow-hidden bg-white pt-28">
      <div
        id="main-content"
        class="h-full w-full bg-gray-50 relative overflow-y-auto lg:ml-64"
      >
        <!-- Sidebar -->
        <aside
          id="sidebar"
          class="
            fixed
            z-20
            h-full
            top-0
            left-0
            pt-16
            flex
            lg:flex
            flex-shrink-0 flex-col
            w-64
            transition-width
            duration-75
          "
          aria-label="Sidebar"
        >
          <div
            class="
              relative
              flex-1 flex flex-col
              min-h-0
              border-r border-gray-200
              bg-white
              pt-0
            "
          >
            <div class="flex-1 flex flex-col pt-16 pb-4 overflow-y-auto">
              <div class="flex-1 px-3 bg-white divide-y space-y-1">
                <ul class="space-y-2 pb-2">
                  <li>
                    <Link
                      :href="route('dashboard')"
                      :active="route().current('dashboard')"
                      class="
                        text-body text-primary-secondarygrey
                        font-normal
                        rounded-lg
                        flex
                        items-center
                        p-2
                        hover:bg-gray-100
                        group
                      "
                    >
                      <svg
                        class="
                          w-6
                          h-6
                          text-primary-secondarygrey
                          group-hover:text-red-50
                          transition
                          duration-75
                        "
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                        <path
                          d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"
                        ></path>
                      </svg>
                      <span class="ml-3">Dashboard</span>
                    </Link>
                  </li>
                  <li>
                    <Link
                      :href="route('sources.index')"
                      :active="route().current('sources.index')"
                      class="
                        text-body text-primary-secondarygrey
                        font-normal
                        rounded-lg
                        flex
                        items-center
                        p-2
                        hover:bg-gray-100
                        group
                      "
                    >
                      <svg
                        class="
                          w-6
                          h-6
                          text-primary-secondarygrey
                          flex-shrink-0
                          group-hover:text-gray-900
                          transition
                          duration-75
                        "
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H5zm-1 9v-1h5v2H5a1 1 0 01-1-1zm7 1h4a1 1 0 001-1v-1h-5v2zm0-4h5V8h-5v2zM9 8H4v2h5V8z"
                          clip-rule="evenodd"
                        ></path>
                      </svg>
                      <span class="ml-3">Manage Products</span>
                    </Link>
                  </li>                 
                </ul> 
                <div class="space-y-2  pt-2">
                  <a
                    :href="route('profile.show')"
                    :active="route().current('profile.show')"
                    class="
                      text-body text-primary-secondarygrey
                      font-normal
                      rounded-lg
                      hover:bg-gray-100
                      group
                      transition
                      duration-75
                      flex
                      items-center
                      p-2
                    "
                  >
                    <svg
                      class="
                        w-6
                        h-6
                        text-primary-secondarygrey
                        flex-shrink-0
                        group-hover:text-gray-900
                        transition
                        duration-75
                      "
                      fill="currentColor"
                      viewBox="0 -2 15 20"
                      xmlns="http://www.w3.org/2000/svg"
                    >
                      <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                      <path
                        fill-rule="evenodd"
                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"
                      />
                    </svg>
                    <span class="ml-3">My Account</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </aside>

        <!-- Content -->
        <main>
          <div class="pt-6 px-4">
            <slot></slot>
          </div>
        </main>

        <!-- Footer -->
        <footer
          class="
            bg-white
            md:flex md:items-center md:justify-between
            shadow
            rounded-lg
            p-4
            md:p-6
            xl:p-8
            my-6
            mx-4
          "
        >
          <ul class="flex items-center flex-wrap mb-6 md:mb-0">
            <li>
              <a
                href="#"
                target="_blank"
                class="
                  text-sm
                  font-normal
                  text-gray-500
                  hover:underline
                  mr-4
                  md:mr-6
                "
                >Website</a
              >
            </li>
            <li>
              <a
                href="#"
                target="_blank"
                class="text-sm font-normal text-gray-500 hover:underline"
                >Contact</a
              >
            </li>
          </ul>
          <div class="flex sm:justify-center space-x-6">
            <a
              href="#"
              target="_blank"
              class="text-gray-500 hover:text-gray-900"
            >
              <svg
                class="h-5 w-5"
                fill="currentColor"
                viewBox="0 0 24 24"
                aria-hidden="true"
              >
                <path
                  fill-rule="evenodd"
                  d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                  clip-rule="evenodd"
                />
              </svg>
            </a>
            <a
              href="#"
              target="_blank"
              class="text-gray-500 hover:text-gray-900"
            >
              <svg
                class="h-5 w-5"
                fill="currentColor"
                viewBox="0 0 24 24"
                aria-hidden="true"
              >
                <path
                  fill-rule="evenodd"
                  d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                  clip-rule="evenodd"
                />
              </svg>
            </a>
            <a
              href="#"
              target="_blank"
              class="text-gray-500 hover:text-gray-900"
            >
              <svg
                class="h-5 w-5"
                fill="currentColor"
                viewBox="0 0 24 24"
                aria-hidden="true"
              >
                <path
                  d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"
                />
              </svg>
            </a>
          </div>
          <p class="text-center text-sm text-gray-500">LG Perfumes</p>
        </footer>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent } from "vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import Logo from "@/Components/Logo.vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faBars } from "@fortawesome/free-solid-svg-icons";
import { faChartLine } from "@fortawesome/free-solid-svg-icons";

export default defineComponent({
  props: {
    title: String,
  },

  components: {
    Head,
    Link,
    Logo,
    FontAwesomeIcon,
  },

  data() {
    return {     
      faBars: faBars,
      faChartLine: faChartLine,
    };
  },

  methods: {
    logout() {
      this.$inertia.post(route("logout"));
    },
  },
});
</script>
