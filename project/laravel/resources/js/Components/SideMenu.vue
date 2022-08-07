<template>
  <aside class="pt-10 sm:h-full w-16 h-12 fixed top-16 bg-primary text-white">
    <ul class="text-center flex flex-row sm:flex-col w-full">
      <div v-for="item in list" :key="item['title']">
        <li class="flex-1 sm:w-full" :title="item['title']" v-if="checkPermission(item)">
          <Link
            :href="route(item['route'])"
            :active="route().current(item['route'])"
            class="h-full w-full hover:bg-primary-dark block px-1 py-4 text-2xl leading-none active:bg-green-700"
          >
            <FontAwesomeIcon :icon="item['icon']" />
            <div class="clear-both menu-label text-xs">{{ item["title"] }}</div>
          </Link>
        </li>
      </div>
    </ul>
  </aside>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faBars } from "@fortawesome/free-solid-svg-icons";
import { faChartLine } from "@fortawesome/free-solid-svg-icons";
import { faUsers } from "@fortawesome/free-solid-svg-icons";
import { faFileInvoice } from "@fortawesome/free-solid-svg-icons";
import { faSitemap } from "@fortawesome/free-solid-svg-icons";
import { faUserCog } from "@fortawesome/free-solid-svg-icons";
import { faShoppingBasket } from "@fortawesome/free-solid-svg-icons";
import { faHistory } from "@fortawesome/free-solid-svg-icons";
import { faCog } from "@fortawesome/free-solid-svg-icons";
import { faTimes } from "@fortawesome/free-solid-svg-icons";

export default {
  name: "SideMenu",

  components: {
    Link,
    FontAwesomeIcon,
  },

  data() {
    let list = [
      {
        title: "Dashboard",
        route: "dashboard",
        icon: faChartLine,
      },
      {
        title: "Customers",
        section: "manage_customers",
        permission: "read_customers",
        route: "customers.index",
        icon: faUsers,
      },
      {
        title: "Plans",
        section: "manage_plans",
        permission: "read_plans",
        route: "plans.index",
        icon: faFileInvoice,
      },
      {
        title: "Roles",
        section: "manage_roles",
        permission: "read_roles",
        route: "roles.index",
        icon: faSitemap,
      },
      {
        title: "Users",
        section: "manage_users",
        permission: "read_users",
        route: "users.index",
        icon: faUserCog,
      },
      {
        title: "Orders",
        section: "manage_orders",
        permission: "read_orders",
        route: "orders.index",
        icon: faShoppingBasket,
      },
      {
        title: "Settings",
        section: "manage_settings",
        permission: "read_settings",
        route: "settings.index",
        icon: faCog,
      },
      {
        title: "Activity Logs",
        section: "manage_logs",
        permission: "read_logs",
        route: "logs.index",
        icon: faHistory,
      },
    ];

    return {
      list: list,
      faBars: faBars,
      faChartLine: faChartLine,
      faUsers: faUsers,
      faFileInvoice: faFileInvoice,
      faSitemap: faSitemap,
      faUserCog: faUserCog,
      faShoppingBasket: faShoppingBasket,
      faCog: faCog,
      faHistory: faHistory,
      faTimes: faTimes,
    };
  },

  methods: {
    checkPermission(item) {
      if (item.section) {
        if (this.$page.props.loggedUserPermissions[item.section]) {
          return this.$page.props.loggedUserPermissions[item.section][item.permission];
        }
        return false;
      }
      return true;
    },
  },
};
</script>
