<template>
    <!--start header -->
    <header>
        <div class="topbar d-flex align-items-center">
            <nav class="navbar navbar-expand">
                <div class="mobile-toggle-menu">
                    <i class='bx bx-menu'></i><span style="font-size:14pt;position: absolute;margin-top:6px;">Menu</span></div>
                <div class="top-menu ms-auto"></div>
                <div class="user-box dropdown ">
                    <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="/assets/images/user_icon.png" class="user-img" alt="user avatar">
                        <div class="user-info ps-3">
                            <p class="user-name mb-0">{{ $page.props.auth.user.name }}</p>
                            <p class="designattion mb-0">{{ $page.props.auth.user.email }} {{ $page.props.auth.user.username ? '(' + $page.props.auth.user.username + ')' : '' }}</p>
                            <p class="designattion mb-0"></p>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><Link class="dropdown-item" href="/logout" method="POST" as="button"><i class='bx bx-log-out-circle'></i><span>Logout</span></Link></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
</template>

<script>
    // import link
    import { Link } from '@inertiajs/inertia-vue3';

    export default {
        // register component
        components: {
            Link
        }
    }
</script>

<style>

</style>
