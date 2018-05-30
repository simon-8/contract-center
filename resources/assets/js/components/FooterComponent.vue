<template>
    <footer class="container">
        <div class="site-footer" role="contentinfo">
            <div class="copyright pull-left mobile-block">
                © {{ new Date().getFullYear() }}
                <span title="Simon">Simon</span>
                <a href="javascript:window.scrollTo(0,0)" class="pull-right hidden-md hidden-lg">TOP</a>
            </div>

            <ul class="site-footer-links pull-right hidden-sm hidden-xs">
                <li>
                    <a href="javascript:window.scrollTo(0,0)">TOP</a>
                </li>
            </ul>
            <router-link to="" target="_blank" aria-label="view source code">
                <span class="mega-octicon octicon-mark-github" title="GitHub"></span>
            </router-link>
            <ul class="site-footer-links mobile-hidden">

                <li v-for="item of footerButton">
                    <router-link :to="item.href" :title="item.name" :target="item.target">{{ item.name }}</router-link>
                </li>
                <li>
                    <router-link to="">
                        <span class="octicon octicon-rss" style="color:orange;"></span>
                    </router-link>
                </li>
            </ul>

        </div>
    </footer>
</template>

<script>
    export default {
        name: "FooterComponent",
        data() {
            return {
                footerButton: [
                    { name: "首页", href: "", target: true },
                    { name: "分类", href: "", target: true },
                    { name: "维基", href: "", target: true },
                    { name: "链接", href: "", target: true },
                    { name: "关于", href: "", target: true }
                ]
            }
        },
        methods: {
        },
        watch: {

        }
    }
</script>

<style scoped>
    /* footer */

    .site-footer {
        position: relative;
        margin-top: 40px;
        padding-top: 40px;
        padding-bottom: 40px;
        font-size: 12px;
        line-height: 1.5;
        color: #777;
        border-top: 1px solid #eee
    }

    .site-footer .copyright {
        padding-right: 20px
    }

    .site-footer:after {
        clear: both
    }

    .site-footer .octicon-mark-github {
        position: absolute;
        top: 38px;
        left: 50%;
        height: 24px;
        width: 24px;
        margin-left: -12px;
        font-size: 24px;
        color: #ccc
    }

    .site-footer .octicon-mark-github:hover {
        color: #bbb
    }

    .site-footer-links {
        margin: 0;
        list-style: none
    }

    .site-footer-links li {
        display: inline-block;
        line-height: 16px
    }

    .site-footer-links li+li {
        margin-left: 10px
    }
</style>