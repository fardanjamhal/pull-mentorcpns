<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Setting</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Setting</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Setting</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="row">
                <div class="col-lg-9 col-md-12">
                    <div class="card border-top border-0 border-3 border-primary">
                        <div class="card-body">
                            <form @submit.prevent="submit" class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Nama Aplikasi</label>
                                    <input type="text" class="form-control" v-model="form.app_name" :class="{ 'is-invalid': errors.app_name }" placeholder="Nama Aplikasi">
                                    <div v-if="errors.app_name" class="invalid-feedback">
                                        {{ errors.app_name }}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Link</label>
                                    <input type="text" class="form-control" v-model="form.app_url" :class="{ 'is-invalid': errors.app_url }" placeholder="Link">
                                    <div v-if="errors.app_url" class="invalid-feedback">
                                        {{ errors.app_url }}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Nomor Whatsapp</label>
                                    <input type="text" class="form-control" v-model="form.whatsapp_number" :class="{ 'is-invalid': errors.whatsapp_number }" placeholder="Nomor Whatsapp">
                                    <div v-if="errors.whatsapp_number" class="invalid-feedback">
                                        {{ errors.whatsapp_number }}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Token Whatsapp (Untuk Notifikasi)</label>
                                    <input type="text" class="form-control" v-model="form.whatsapp_token" :class="{ 'is-invalid': errors.whatsapp_token }" placeholder="Token Whatsapp">
                                    <div v-if="errors.whatsapp_token" class="invalid-feedback">
                                        {{ errors.whatsapp_token }}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Alamat</label>
                                    <textarea class="form-control" v-model="form.address" :class="{ 'is-invalid': errors.address }" placeholder="Alamat" rows="5"></textarea>
                                    <div v-if="errors.address" class="invalid-feedback">
                                        {{ errors.address }}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Logo</label>
                                    <input type="file" class="form-control" @input="form.logo = $event.target.files[0]" :class="{ 'is-invalid': errors.logo }" placeholder="logo">
                                    <div v-if="errors.logo" class="invalid-feedback">
                                        {{ errors.logo }}
                                    </div>
                                    <br>
                                    <div v-if="setting.logo">
                                        <img  v-bind:src="'/storage/upload_files/settings/' + setting.logo" style="width:120px;"/>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-12">
                                    <label class="form-label">Nama Tertanda (Tanda Tangan)</label>
                                    <input type="text" class="form-control" v-model="form.signed_name" :class="{ 'is-invalid': errors.signed_name }" placeholder="Nama Tertanda">
                                    <div v-if="errors.signed_name" class="invalid-feedback">
                                        {{ errors.signed_name }}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Gambar Tanda Tangan</label>
                                    <input type="file" class="form-control" @input="form.signed_image = $event.target.files[0]" :class="{ 'is-invalid': errors.signed_image }" placeholder="signed_image">
                                    <div v-if="errors.signed_image" class="invalid-feedback">
                                        {{ errors.signed_image }}
                                    </div>
                                    <br>
                                    <div v-if="setting.signed_image">
                                        <img  v-bind:src="'/storage/upload_files/settings/' + setting.signed_image" style="width:120px;"/>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Aktifkan Verifikasi User</label>
                                    <select v-model="form.add_activation_user" :class="{ 'is-invalid': errors.add_activation_user }" class="form-select">
                                        <option value="">[ Pilih ]</option>
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                    <div v-if="errors.add_activation_user" class="invalid-feedback">
                                        {{ errors.add_activation_user }}
                                    </div>
                                </div>
                                <div class="col-12" >
                                    <label class="form-label">Tipe Pembelian Soal Try Out</label>
                                    <select v-model="form.purchase_type" :class="{ 'is-invalid': errors.purchase_type }" class="form-select">
                                        <option value="">[ Pilih ]</option>
                                        <option value="1">Pembelian Per Paket Soal</option>
                                        <option value="2">Pembelian Dengan Membership Bulanan</option>
                                        <option value="3">Pembelian Per Paket Soal & Membership Bulanan</option>
                                    </select>
                                    <div v-if="errors.purchase_type" class="invalid-feedback">
                                        {{ errors.purchase_type }}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Metode Pembayaran Yang Diaktifkan</label>
                                    <multiselect
                                        v-model="form.payment_methods"
                                        :options="paymentMethods"
                                        :multiple="true"
                                        label="description"
                                        :close-on-select="true"
                                        :allow-empty="true"
                                        track-by="code"
                                        placeholder="[ Pilih ]"
                                        :class="{ 'is-invalid': errors.payment_methods }"
                                    ></multiselect>
                                    <div v-if="errors.payment_methods" class="invalid-feedback">
                                        {{ errors.payment_methods }}
                                    </div>
                                </div>
                                <div class="col-12" >
                                    <label class="form-label">Akses Login</label>
                                    <select v-model="form.login_type" :class="{ 'is-invalid': errors.login_type }" class="form-select">
                                        <option value="">[ Pilih ]</option>
                                        <option value="1">Email</option>
                                        <option value="2">Username</option>
                                        <option value="3">Email dan Username</option>
                                    </select>
                                    <div v-if="errors.login_type" class="invalid-feedback">
                                        {{ errors.login_type }}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-sm px-5">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12">
                    <div class="card border-top border-0 border-3 border-primary">
                        <div class="card-header text-center">
                            <h6>QR Code Link</h6>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <qrcode-vue :value="setting.app_url" level="H"/>
                                <p class="fw-bold mt-3">{{ setting.app_url }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->
</template>

<script>
    //import layout admin
    import LayoutAdmin from '../../../Layouts/Layout.vue';

    // import Link
    import { Link } from '@inertiajs/inertia-vue3';

    //import reactive
    import { reactive } from 'vue';

    // import Swal
    import Swal from 'sweetalert2';

    import axios from 'axios';

    // import Head from Inertia
    import {
        Head
    } from '@inertiajs/inertia-vue3';

    import Multiselect from '@suadelabs/vue3-multiselect'

    import { Inertia } from '@inertiajs/inertia';

    import QrcodeVue from 'qrcode.vue'

    export default {
        // layout
        layout: LayoutAdmin,

        // register components
        components: {
            Link,
            Head,
            Multiselect,
            QrcodeVue,
        },

        //props
        props: {
            errors: Object,
            setting: Object,
            paymentMethods: Object
        },

        // initialization composition API
        setup(props) {
            const form = reactive({
                app_name: props.setting.app_name,
                app_url: props.setting.app_url,
                whatsapp_number: props.setting.whatsapp_number,
                whatsapp_token: props.setting.whatsapp_token,
                logo: props.setting.logo,
                signed_name: props.setting.signed_name,
                signed_image: props.setting.signed_image,
                address: props.setting.address,
                add_activation_user: props.setting.add_activation_user ?? '',
                purchase_type: props.setting.purchase_type ?? '',
                payment_methods: props.setting.payment_methods ?? '',
                login_type: props.setting.login_type ?? '',
            });

            // submit method
            const submit = () => {
                // send data to server
                Inertia.post(`/admin/settings`, {
                    forceFormData: true,
                    // data
                    app_name: form.app_name,
                    app_url: form.app_url,
                    whatsapp_number: form.whatsapp_number,
                    whatsapp_token: form.whatsapp_token,
                    signed_name: form.signed_name,
                    signed_image: form.signed_image,
                    logo: form.logo,
                    address: form.address,
                    add_activation_user: form.add_activation_user,
                    purchase_type: form.purchase_type,
                    payment_methods: form.payment_methods,
                    login_type: form.login_type
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Setting Berhasil Diupdate!.',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1000
                        });
                    },
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

<style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css"></style>