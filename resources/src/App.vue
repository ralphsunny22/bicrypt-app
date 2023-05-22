<template>
    <div>
        <page-header
            :configData="configData"
            :user="user"
            @walletConnectionUpdated="fetchData()"
        />
        <page-menu
            :configData="configData"
            :usermenuData="usermenuData"
            @tokenUpdated="fetchData()"
        />
        <div class="app-content content" :class="configData['pageClass']">
            <!-- BEGIN: Header-->
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>

            <div
                v-if="
                    configData['contentLayout'] !== 'default' &&
                    configData['contentLayout']
                "
                class="content-area-wrapper"
                :class="
                    configData['layoutWidth'] === 'boxed'
                        ? 'container-xxl p-0'
                        : ''
                "
            >
                <div :class="configData['sidebarPositionClass']">
                    <div class="sidebar"></div>
                </div>
                <div :class="configData['contentsidebarClass']">
                    <div class="content-wrapper">
                        <div class="content-body">
                            <keep-alive>
                                <router-view
                                    v-if="user !== null"
                                    :user="user"
                                    :kyc="kyc"
                                >
                                </router-view>
                            </keep-alive>
                        </div>
                    </div>
                </div>
            </div>
            <div
                v-else
                class="content-wrapper"
                :class="
                    configData['layoutWidth'] === 'boxed'
                        ? 'container-xxl p-0'
                        : ''
                "
            >
                <div class="content-body" id="content-body">
                    <Transition
                        type="animation"
                        name="zoom-fade"
                        mode="out-in"
                        :duration="300"
                    >
                        <keep-alive>
                            <router-view
                                v-if="user !== null"
                                :user="user"
                                :kyc="kyc"
                            >
                            </router-view>
                        </keep-alive>
                    </Transition>
                </div>
            </div>
        </div>
        <template v-if="popups != null">
            <template v-for="(popup, index) in popups">
                <Popup :key="index" :popup="popup"></Popup>
            </template>
        </template>
        <page-footer :configData="configData" />
    </div>
</template>

<script>
import DarkLight from "./ui/DarkLight.vue";
import PageFooter from "./ui/PageFooter.vue";
import PageHeader from "./ui/PageHeader.vue";
import PageMenu from "./ui/PageMenu.vue";
import SubMenu from "./ui/SubMenu.vue";
import Popup from "./components/Popup.vue";

export default {
    // component list
    components: {
        SubMenu,
        DarkLight,
        PageFooter,
        PageHeader,
        PageMenu,
        Popup,
    },
    // component data
    data() {
        return {
            mainComp: "",
            usermenuData: usermenuData,
            configData: configData,
            user: null,
            kyc: null,
            popups: null,
        };
    },
    // custom methods
    methods: {
        fetchData() {
            this.$http.post("/user/fetch/data").then((response) => {
                (this.kyc = response.data.kyc),
                    (this.popups = response.data.popups),
                    (this.user = response.data.user);
            });
        },
        goBack() {
            window.history.length > 1
                ? this.$router.go(-1)
                : this.$router.push("/");
        },
    },

    watch: {
        async $route(to, from) {
            if (to.path == "/" || window.location.hash.substring(1) == "/")
                if (plat.dashboard.default_page == "trading") {
                    this.$router.push(
                        "/trade/" + plat.trading.first_trade_page
                    );
                } else if (plat.dashboard.default_page == "binary") {
                    this.$router.push("/binary");
                } else if (plat.dashboard.default_page == "bot") {
                    this.$router.push("/bot");
                } else if (plat.dashboard.default_page == "ico") {
                    this.$router.push("/ico");
                } else if (plat.dashboard.default_page == "mlm") {
                    this.$router.push("/network");
                } else if (plat.dashboard.default_page == "forex") {
                    this.$router.push("/forex");
                } else if (plat.dashboard.default_page == "staking") {
                    this.$router.push("/staking");
                } else if (plat.dashboard.default_page == "knowledge") {
                    this.$router.push("/knowledge");
                }
        },
    },
    created() {
        this.fetchData();
        if (plat.trading.binary_status == 1) {
            const Binary = () => import("./Pages/binary/Binary.vue");
            const BinaryTrading = () =>
                import("./Pages/binary/BinaryTrading.vue");
            const PracticeContracts = () =>
                import("./Pages/binary/logs/Practice.vue");
            const TradeContracts = () =>
                import("./Pages/binary/logs/Trade.vue");
            const ContractPreview = () =>
                import("./Pages/binary/logs/Preview.vue");
            this.$router.addRoute({
                path: "/binary",
                component: Binary,
                meta: { title: "Binary Dashboard" },
            });
            this.$router.addRoute({
                path: "/binary/:type/:symbol/:currency",
                component: BinaryTrading,
                meta: { title: "Binary Trading" },
            });
            this.$router.addRoute({
                path: "/binary/practice/contracts",
                component: PracticeContracts,
                meta: { title: "Binary Practice Logs" },
            });
            this.$router.addRoute({
                path: "/binary/trade/contracts",
                component: TradeContracts,
                meta: { title: "Binary Trading Logs" },
            });
            this.$router.addRoute({
                path: "/binary/contract/view/:type/:id",
                component: ContractPreview,
                meta: { title: "Binary Contract Preview" },
            });
        }
        if (ext.botTrader == 1) {
            const Bots = () => import("./Pages/bot/Bots.vue");
            const BotTradePage = () => import("./Pages/bot/BotTradePage.vue");
            this.$router.addRoute({
                path: "/bot",
                component: Bots,
                meta: { title: "Bots Dashboard" },
            });
            this.$router.addRoute({
                path: "/bot/:symbol/:currency",
                component: BotTradePage,
                meta: { title: "Bot Trader" },
            });
        }
        if (ext.ico == 1) {
            const ICO = () => import("./Pages/ico/ICO.vue");
            const ICODetails = () => import("./Pages/ico/ICODetails.vue");
            this.$router.addRoute({
                path: "/ico",
                component: ICO,
                meta: { title: "Token Offers" },
            });
            this.$router.addRoute({
                path: "/ico/:symbol",
                component: ICODetails,
                meta: { title: "Offer Details" },
            });
        }
        if (ext.mlm == 1) {
            const Network = () => import("./Pages/Network.vue");
            this.$router.addRoute({
                path: "/network",
                component: Network,
                meta: { title: "My Network" },
            });
        }
        if (ext.forex == 1) {
            const Forex = () => import("./Pages/Forex/Forex.vue");
            const ForexTrading = () => import("./Pages/Forex/Trading.vue");
            this.$router.addRoute({
                path: "/forex",
                component: Forex,
                meta: { title: "Forex Dashboard" },
            });
            this.$router.addRoute({
                path: "/forex/trade",
                component: ForexTrading,
                meta: { title: "Forex Trading" },
            });
        }
        if (ext.staking == 1) {
            const Staking = () => import("./Pages/staking/Staking.vue");
            const StakingLogs = () => import("./Pages/staking/StakingLogs.vue");
            this.$router.addRoute({
                path: "/staking",
                component: Staking,
                meta: { title: "Staking Dashboard" },
            });
            this.$router.addRoute({
                path: "/staking/logs",
                component: StakingLogs,
                meta: { title: "Staking Logs" },
            });
        }
        if (ext.builder == 1) {
            const PageBuilder = () => import("./Pages/builder/PageBuilder.vue");
            this.$router.addRoute({
                path: "/page/:slug",
                component: PageBuilder,
            });
        }
        if (ext.eco == 1) {
            const EcoTrading = () => import("./Pages/EcoTrading.vue");
            this.$router.addRoute({
                path: "/trade/:symbol-:currency",
                component: EcoTrading,
                meta: { title: "Trading", type: "eco" },
            });
        }
        if (ext.p2p == 1) {
            const P2P = () => import("./Pages/p2p/p2p.vue");
            this.$router.addRoute({
                path: "/p2p",
                component: P2P,
                meta: { title: "Peer To Peer Dashboard" },
            });
        }
        if (ext.knowledge == 1) {
            const KnowledgeBase = () => import("./Pages/knowledge/Index.vue");
            this.$router.addRoute({
                path: "/knowledge",
                component: KnowledgeBase,
                meta: { title: "Knowledge Base" },
            });
            const Categories = () => import("./Pages/knowledge/Categories.vue");
            this.$router.addRoute({
                path: "/knowledge/categories/:slug/:id",
                component: Categories,
                meta: { title: "Categories" },
            });
            const Tags = () => import("./Pages/knowledge/Tags.vue");
            this.$router.addRoute({
                path: "/knowledge/tags/:slug/:id",
                component: Tags,
                meta: { title: "Tags" },
            });
            const Article = () => import("./Pages/knowledge/Article.vue");
            this.$router.addRoute({
                path: "/knowledge/articles/:slug/:id",
                component: Article,
                meta: { title: "Article" },
            });
            const Faq = () => import("./Pages/knowledge/Faq.vue");
            this.$router.addRoute({
                path: "/knowledge/faq",
                component: Faq,
                meta: { title: "Faq" },
            });
            const FaqSearch = () => import("./Pages/knowledge/FaqSearch.vue");
            this.$router.addRoute({
                path: "/knowledge/faq/:search",
                component: FaqSearch,
                meta: { title: "Search Faq" },
            });
        }
    },
    // on component mounted
    mounted() {},

    // on component destroyed
    destroyed() {},
};
</script>
<style lang="scss">
// ///////////////////////////////////////////////
// Zoom Fade
// ///////////////////////////////////////////////
.zoom-fade-enter-active,
.zoom-fade-leave-active {
    transition: transform 0.35s, opacity 0.28s ease-in-out;
}

.zoom-fade-enter {
    transform: scale(0.97);
    opacity: 0;
}

.zoom-fade-leave-to {
    transform: scale(1.03);
    opacity: 0;
}

// ///////////////////////////////////////////////
// Fade Regular
// ///////////////////////////////////////////////
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.28s ease-in-out;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}

// ///////////////////////////////////////////////
// Page Slide
// ///////////////////////////////////////////////
.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: opacity 0.35s, transform 0.4s;
}

.slide-fade-enter {
    opacity: 0;
    transform: translateX(-30%);
}

.slide-fade-leave-to {
    opacity: 0;
    transform: translateX(30%);
}

// ///////////////////////////////////////////////
// Zoom Out
// ///////////////////////////////////////////////
.zoom-out-enter-active,
.zoom-out-leave-active {
    transition: opacity 0.35s ease-in-out, transform 0.45s ease-out;
}

.zoom-out-enter,
.zoom-out-leave-to {
    opacity: 0;
    transform: scale(0);
}

// ///////////////////////////////////////////////
// Fade Bottom
// ///////////////////////////////////////////////

// Speed: 1x
.fade-bottom-enter-active,
.fade-bottom-leave-active {
    transition: opacity 0.3s, transform 0.35s;
}

.fade-bottom-enter {
    opacity: 0;
    transform: translateY(-8%);
}

.fade-bottom-leave-to {
    opacity: 0;
    transform: translateY(8%);
}

// Speed: 2x
.fade-bottom-2x-enter-active,
.fade-bottom-2x-leave-active {
    transition: opacity 0.2s, transform 0.25s;
}

.fade-bottom-2x-enter {
    opacity: 0;
    transform: translateY(-4%);
}

.fade-bottom-2x-leave-to {
    opacity: 0;
    transform: translateY(4%);
}

// ///////////////////////////////////////////////
// Fade Top
// ///////////////////////////////////////////////

// Speed: 1x
.fade-top-enter-active,
.fade-top-leave-active {
    transition: opacity 0.3s, transform 0.35s;
}

.fade-top-enter {
    opacity: 0;
    transform: translateY(8%);
}

.fade-top-leave-to {
    opacity: 0;
    transform: translateY(-8%);
}

// Speed: 2x
.fade-top-2x-enter-active,
.fade-top-2x-leave-active {
    transition: opacity 0.2s, transform 0.25s;
}

.fade-top-2x-enter {
    opacity: 0;
    transform: translateY(4%);
}

.fade-top-2x-leave-to {
    opacity: 0;
    transform: translateY(-4%);
}

///////////////////////////////////////////////////////////
// transition-group : list;
///////////////////////////////////////////////////////////
.list-leave-active {
    position: absolute;
}

.list-enter,
.list-leave-to {
    opacity: 0;
    transform: translateX(30px);
}

///////////////////////////////////////////////////////////
// transition-group : list-enter-up;
///////////////////////////////////////////////////////////
.list-enter-up-leave-active {
    transition: none !important;
}

.list-enter-up-enter {
    opacity: 0;
    transform: translateY(30px);
}
</style>
