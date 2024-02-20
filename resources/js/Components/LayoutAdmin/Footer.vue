<template>
    <div class="overlay toggle-icon"></div>
    <footer class="page-footer">
        <p class="mb-0 text-center">© {{ new Date().getFullYear() }} All Right Reserved {{ $page.props.setting.app_name ?? 'Isi Setting Terlebih Dahulu' }}</p>
    </footer>
</template>

<script>
    export default {

    }
</script>
