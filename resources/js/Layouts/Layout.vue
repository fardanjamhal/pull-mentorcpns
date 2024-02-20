<template>
    <div class="wrapper" :class="{ toggled : isToggleActive }">
        <!-- sidebar -->
        <Sidebar/>
        <!-- header -->
        <Header/>
        <!-- content -->
        <slot />

        <Footer/>
    </div>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3';

    // import navbar
    import Sidebar from '../Components/LayoutAdmin/Sidebar.vue';
    // import header
    import Header from '../Components/LayoutAdmin/Header.vue';
    // import footer
    import Footer from '../Components/LayoutAdmin/Footer.vue';

    export default {
        // register components
        components: {
            Link,
            Sidebar,
            Header,
            Footer
        },
        mounted() {
            $("#menu").metisMenu();

            $(".mobile-toggle-menu").on("click", function() {
                $(".wrapper").addClass("toggled")
            });

            $(".menu-clicked").on("click", function() {
                $(".wrapper").removeClass("toggled")
            });

            $(".toggle-icon").click(function() {
                $(".wrapper").hasClass("toggled") ? ($(".wrapper").removeClass("toggled"), $(".sidebar-wrapper").unbind("hover")) : ($(".wrapper").addClass("toggled"), $(".sidebar-wrapper").hover(function() {
                    $(".wrapper").addClass("sidebar-hovered")
                }, function() {
                    $(".wrapper").removeClass("sidebar-hovered")
                }))
            });
        }
    }
</script>

<style>
::-webkit-scrollbar {
        width: 10px;
    }

    ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(200,200,200,1);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        border-radius: 10px;
        background-color:#fff;
        -webkit-box-shadow: inset 0 0 6px rgba(90,90,90,0.7);
    }
</style>


