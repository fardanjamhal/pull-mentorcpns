<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Aktivasi Voucher</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Transaksi</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Aktivasi Voucher</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <div v-if="$page.props.session.error" class="alert alert-danger border-0">
                        <i class="fa fa-exclamation-triangle"></i><div v-html="$page.props.session.error"></div>
                    </div>

                    <div v-if="$page.props.session.success" class="alert alert-success border-0">
                        <i class="fa fa-exclamation-triangle"></i><div v-html="$page.props.session.success"></div>
                    </div>

                    <div class="input-group">
                        <input type="text" class="form-control" v-model="form.token" placeholder="Masukan Token...."/>
                        <button class="btn btn-primary" @click.prevent="submitToken()" type="button">Aktivasi</button>
                    </div>
                </div>
            </div>

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <h6 class="card-title">Riwayat Aktivasi Voucher</h6><br>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Voucher</th>
                                    <th>Nama Voucher</th>
                                    <th>Lama Periode</th>
                                    <th>Tipe Akses</th>
                                    <th>Expired Voucher</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="!voucherActivations.data.length">
                                    <td colspan="7" align="center">Belum ada data riwayat aktivasi</td>
                                </tr>
                                <tr v-for="(voucherActivation, index) in voucherActivations.data" :key="index">
                                    <td>{{ ++index + (voucherActivations.current_page - 1) * voucherActivations.per_page }}</td>
                                    <td>{{ voucherActivation.voucher_code }}</td>
                                    <td>{{ voucherActivation.voucher_name }}</td>
                                    <td>{{ voucherActivation.voucher_active_period }} {{ voucherActivation.voucher_type }}</td>
                                    <td>
                                        <span class="badge bg-danger" v-if="voucherActivation.voucher_access_type == 'basic_member'">Basic Member</span>
                                        <span class="badge bg-primary" v-if="voucherActivation.voucher_access_type == 'standard_member'">Standard Member</span>
                                        <span class="badge bg-warning" v-if="voucherActivation.voucher_access_type == 'premium_member'">Premium Member</span>
                                    </td>
                                    <td>{{ voucherActivation.voucher_expired_date ? voucherActivation.voucher_expired_date : '-' }}</td>
                                    <td>
                                        <span class="badge bg-success" v-if="voucherActivation.is_expired == false">Active</span>
                                        <span class="badge bg-danger" v-if="voucherActivation.is_expired == true">Expired</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <Pagination :links="voucherActivations.links" align="end" />

                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->
</template>

<script>
    //import layout user
    import LayoutUser from '../../../../Layouts/Layout.vue';

    //import component pagination
    import Pagination from '../../../../Components/Pagination.vue';

    // import Link
    import { Link } from '@inertiajs/inertia-vue3';

    //import sweet alert2
    import Swal from 'sweetalert2';

    //import reactive
    import { reactive } from 'vue';

    // import Head from Inertia
    import {
        Head
    } from '@inertiajs/inertia-vue3';

    import { Inertia } from '@inertiajs/inertia';

    export default {
        // layout
        layout: LayoutUser,

        // register components
        components: {
            Link,
            Head,
            Pagination
        },

        // props
        props: {
            voucherActivations: Object
        },
        setup() {

            const form = reactive({
                token: '',
            });

            const submitToken = (() => {
                Swal.fire({
                    title: 'Perhatian !',
                    text: "Apakah anda yakin akan mengaktifkan token ini ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Aktivasi Voucher'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        Inertia.post('/user/voucher-activations', {
                            token: form.token,
                        });

                        form.token = '';
                    }
                })

            });

            return {
                submitToken,
                form
            }
        },
    }
</script>
