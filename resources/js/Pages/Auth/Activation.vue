<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Activation</title>
    </Head>

    <div class="authentication-reset-password d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col-12 col-lg-10 mx-auto">
                <div class="card">
                    <div class="row g-0">
                        <div class="col-lg-12 border-end">
                            <div class="card-body">

                                <form @submit.prevent="submit" class="row g-3">
                                    <div class="p-5">
                                        <h4 class="mt-5 font-weight-bold">Aktivasi Akun</h4>
                                        <p class="text-muted">Pastikan data dibawah ini adalah nama dan email anda.</p>
                                        <div class="mb-3 mt-0">
                                            <div v-if="$page.props.session.error" class="alert alert-danger border-0">
                                                <i class="fa fa-exclamation-triangle"></i>  {{ $page.props.session.error }}
                                            </div>

                                            <div v-if="$page.props.session.success" class="alert alert-success border-0">
                                                <i class="fa fa-exclamation-triangle"></i>  {{ $page.props.session.success }}
                                            </div>
                                        </div>
                                        <div class="mb-3 mt-0">
                                            <label class="form-label">Nama</label>
                                            <p>{{ $props.user.name }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <p>{{ $props.user.email }}</p>
                                        </div>
                                        <div class="d-grid gap-2">
                                            <br>
                                            <Link :href="`/user/${user.id}/activation/actived`" class="btn btn-primary">Klik Untuk Mengaktifkan Akun</Link>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    //import layout
    import LayoutAuth from '../../Layouts/Auth.vue';

    // import Head form Inertia
    import { Head } from '@inertiajs/inertia-vue3';
    
    // import link
    import { Link } from '@inertiajs/inertia-vue3';

    export default {
        // layout
        layout: LayoutAuth,

        components: {
            Head,
            Link
        },

        //props
        props: {
            errors: Object,
            session: Object,
            user: Object,
        },
    }
</script>
