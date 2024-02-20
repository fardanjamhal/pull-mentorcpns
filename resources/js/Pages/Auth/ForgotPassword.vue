<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Forgot Password</title>
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
                                        <h3 class="">Reset Password</h3>
                                        <p>Sudah memiliki akun ? <Link href="/login">Login disini</Link></p>
                                        <p class="text-muted">Pastikan nomor handphone yang dimasukan adalah nomor handphone yang telah didaftarkan.</p>
                                        <div class="mb-3 mt-0">
                                            <div v-if="$page.props.session.error" class="alert alert-danger border-0">
                                                <i class="fa fa-exclamation-triangle"></i>  <div v-html="$page.props.session.error"></div>
                                            </div>

                                            <div v-if="$page.props.session.success" class="alert alert-success border-0">
                                                <i class="fa fa-exclamation-triangle"></i>  {{ $page.props.session.success }}
                                            </div>
                                        </div>
                                        <div class="mb-3 mt-0">
                                            <label class="form-label">Nomor Hp (WA)</label>
                                            <input type="text" v-model="form.phone_number" :class="{ 'is-invalid': errors.phone_number }" class="form-control" placeholder="Contoh: 081212126043">
                                            <div v-if="errors.phone_number" class="invalid-feedback">
                                                {{ errors.phone_number }}
                                            </div>
                                        </div>
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary">Kirim Perubahan Password</button>
                                        </div>

                                        <div class="text-center">
                                            <br>
                                            <p class="text-muted">
                                                Nomor tidak terdaftar, <a :href="`https://wa.me/${$page.props.setting.whatsapp_number}?text=${encodeURI('Hallo, Admin saya sudah daftar dan ingin reset password, ketika konfirmasi nomor tidak terdaftar, berikut data saya untuk perbaikan:\n\nNama:\nEmail:\nNomor Handphone Aktif:\n\n terimakasih.')}`" target="_blank">klik disini</a> untuk perbaikan
                                            </p>
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

    //import reactive
    import { reactive } from 'vue';

    // import link
    import { Link } from '@inertiajs/inertia-vue3';

    //import inertia adapter
    import { Inertia } from '@inertiajs/inertia';

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

        setup() {
            const form = reactive({
                phone_number: '',
            });

            // submit method
            const submit = () => {
                // send data to server
                Inertia.post('/user/forgot-password', {
                    // data
                    phone_number: form.phone_number,
                });
            }

            // return form state and submit method
            return {
                form,
                submit,
            }
        }
    }
</script>
