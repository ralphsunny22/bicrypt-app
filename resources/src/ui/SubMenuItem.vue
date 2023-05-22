<template>
    <ul class="menu-content">
        <template v-for="submenu in menu">
            <li
                :class="[
                    submenu.url === pathname ? 'active' : '',
                    showSub && checkSub(submenu.url) ? 'open' : '',
                    checkSub(submenu.url) ? 'has-sub' : '',
                ]"
                :key="submenu.url"
            >
                <template v-if="submenu.url">
                    <router-link
                        :to="'../../..' + submenu.url"
                        class="d-flex align-items-center"
                        :target="submenu.newTab ? '_blank' : '_self'"
                    >
                        <i :class="'bi bi-' + submenu.icon"></i>
                        <span class="submenu-title text-truncate">{{
                            $t(submenu.name)
                        }}</span>
                    </router-link>
                </template>
                <template v-else>
                    <a
                        href="javascript:void(0)"
                        class="d-flex align-items-center"
                        :target="submenu.newTab ? '_blank' : '_self'"
                        @click="showSub = !showSub"
                    >
                        <i :class="'bi bi-' + submenu.icon"></i>
                        <span class="submenu-title text-truncate">{{
                            $t(submenu.name)
                        }}</span>
                    </a>
                </template>
                <side-menu-item :menu="submenu.submenu" />
            </li>
        </template>
    </ul>
</template>

<script>
// component
export default {
    name: "side-menu-item",
    props: ["menu", "pathname"],

    // component list
    components: {},
    // component data
    data() {
        return {
            showSub: false,
        };
    },

    // custom methods
    methods: {
        checkSub(sub) {
            if (!sub) {
                return true;
            }
        },
    },

    // on component created
    created() {},

    // on component destroyed
    destroyed() {},
};
</script>
