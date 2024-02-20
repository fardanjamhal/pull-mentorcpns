<template>
    <div class="wrapper">
        <!-- content -->
        <slot />

        <Footer/>

    </div>
</template>

<script>
    // import header
    import Header from '../Components/LayoutUser/Header.vue';
    // import footer
    import Footer from '../Components/LayoutUser/Footer.vue';

    export default {
        // register components
        components: {
            Header,
            // Footer
        }
    }
</script>


