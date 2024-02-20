<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Login</title>
    </Head>

    <div class="authentication-reset-password d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col-12 col-lg-10 mx-auto">
                <div class="card">
                    <div class="col-lg-12 border-end">
                        <div class="card-body">
                            <form @submit.prevent="submit" class="row g-3">
                                <div class="p-5">
                                    <div style="text-align:center;" v-if="$page.props.setting && $page.props.setting.logo">
                                        <img v-bind:src="'/storage/upload_files/settings/' + $page.props.setting.logo" style="height:90px;"/>
                                    </div>
                                    <br>
                                    <h4 class="font-weight-bold">Login</h4>
                                    <p class="text-muted">Silakan login dengan email dan password yang sudah anda daftarkan.</p>
                                    <div class="mb-3 mt-0">
                                        <div v-if="$page.props.session.error" class="alert alert-danger border-0">
                                            <i class="fa fa-exclamation-triangle"></i>  <div v-html="$page.props.session.error"></div>
                                        </div>

                                        <div v-if="$page.props.session.success" class="alert alert-success border-0">
                                            <i class="fa fa-exclamation-triangle"></i> <div v-html="$page.props.session.success"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3 mt-0">
                                        <label class="form-label">{{ $page.props.setting.login_type == 3 ? 'Email / Username' : ($page.props.setting.login_type == 2 ? 'Username' : 'Email') }}</label>
                                        <input type="text" v-model="form.email" :class="{ 'is-invalid': errors.email }" class="form-control" :placeholder="$page.props.setting.login_type == 3 ? 'Email / Username' : ($page.props.setting.login_type == 2 ? 'Username' : 'Email')">
                                        <div v-if="errors.email" class="invalid-feedback">
                                            {{ errors.email }}
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-group">
                                            <input v-if="showPassword" type="text" v-model="form.password" :class="{ 'is-invalid': errors.password }" class="form-control" placeholder="Password">
                                            <input v-else type="password" v-model="form.password" :class="{ 'is-invalid': errors.password }" class="form-control" placeholder="Password">

                                            <span class="input-group-text" @click="toggleShow"><i :class="{ 'bx bx-show': showPassword, 'bx bx-hide': !showPassword }"></i></span>
                                            <div v-if="errors.password" class="invalid-feedback">
                                                {{ errors.password }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary">Login</button>
                                    </div>

                                    <div class="text-center">
                                        <br>
                                        <p class="text-muted">
                                            Belum punya akun ? <Link href="/register">Daftar disini</Link><br><br>
                                            Lupa Password ? <Link href="/user/forgot-password">Klik Disini</Link><br><br>
                                            <a :href="`https://wa.me/${$page.props.setting.whatsapp_number}?text=${encodeURI('Hallo, Admin. saya ingin bertanya....')}`" target="_blank">Klik Untuk Menghubungi Admin</a>
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
</template>

<script>
    //import layout
    import LayoutAuth from '../../Layouts/Auth.vue';

    // import Head form Inertia
    import { Head } from '@inertiajs/inertia-vue3';

    //import reactive
    import { reactive } from 'vue';

    import { ref } from 'vue';

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
            session: Object
        },

        setup() {
            const form = reactive({
                email: '',
                password: ''
            });

            const showPassword = ref(false);
            
            // submit method
            const submit = () => {
                // send data to server
                Inertia.post('/login', {
                    // data
                    email: form.email,
                    password: form.password,
                });
            }

            const toggleShow = () => {
                showPassword.value = !showPassword.value; // Update the value using .value with ref
            };

            // return form state and submit method
            return {
                form,
                showPassword,
                toggleShow, 
                submit,
            }
        }
    }
</script>
