<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Pembelian Voucher</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Voucher</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Pembelian Voucher</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="row">
                <div class="col-lg-12">
                    <div v-if="$page.props.session.failed" class="alert alert-danger border-0">
                        <div v-html="$page.props.session.failed"></div>
                    </div>
                    <div v-if="$page.props.session.error" class="alert alert-danger border-0">
                        <div v-html="$page.props.session.error"></div>
                    </div>
                    <div v-if="$page.props.session.success" class="alert alert-success border-0">
                        <div v-html="$page.props.session.success"></div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <form @submit.prevent="submit">
                        <div class="card border-top border-0 border-3 border-primary">
                            <div class="card-header">
                                <div class="d-lg-flex align-items-center">
                                    <h6>Detail Pembelian Voucher</h6>
                                    <div class="ms-auto">
                                        <Link :href="`/user/transactions/${transaction.id}`" class="btn btn-primary btn-sm">Kembali</Link>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Kode Transaksi</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" :value="transaction.code" readonly> 
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Nama Pengirim Transfer</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" v-model="form.rekening_name" :class="{ 'is-invalid': errors.rekening_name }" placeholder="Nama Pengirim Transfer">
                                        <div v-if="errors.rekening_name" class="invalid-feedback">
                                            {{ errors.rekening_name }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Di Transfer Ke Rekening</label>
                                    <div class="col-sm-9">
                                        <select v-model="form.bank_id" :class="{ 'is-invalid': errors.bank_id }" class="form-select">
                                            <option value="">[ Pilih ]</option>
                                            <option v-for="(bank, index) in banks" :key="index" :value="bank.id">
                                                {{ bank.bank_name }} - {{ bank.rekening_name }} - {{ bank.rekening_number }}
                                            </option>
                                        </select>
                                        <div v-if="errors.bank_id" class="invalid-feedback">
                                            {{ errors.bank_id }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Tanggal Transfer</label>
                                    <div class="col-sm-9">
                                        <input type="date" class="form-control" v-model="form.transfer_date" :class="{ 'is-invalid': errors.transfer_date }" placeholder="Tanggal Transfer">
                                        <div v-if="errors.transfer_date" class="invalid-feedback">
                                            {{ errors.transfer_date }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Jumlah Transfer</label>
                                    <div class="col-sm-9">
                                        <input type="number" class="form-control" v-model="form.total_payment" :class="{ 'is-invalid': errors.total_payment }" placeholder="Jumlah Transfer">
                                        <div v-if="errors.total_payment" class="invalid-feedback">
                                            {{ errors.total_payment }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Bukti Transfer</label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control" @input="form.file = $event.target.files[0]" :class="{ 'is-invalid': errors.file }" placeholder="file">
                                        <div v-if="errors.file" class="invalid-feedback">
                                            {{ errors.file }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-9">
                                        <div class="d-md-flex d-grid align-items-center gap-3">
                                            <button class="btn btn-primary btn-sm px-4">Konfirmasi Pembayaran</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!--end row-->
        </div>
    </div>
    <!--end page wrapper -->
</template>

<script>
    //import layout admin
    import LayoutAdmin from '../../../../Layouts/Layout.vue';

    // import Link
    import { Link } from '@inertiajs/inertia-vue3';

    //import reactive
    import { reactive } from 'vue';

    // import Head from Inertia
    import {
        Head
    } from '@inertiajs/inertia-vue3';

    // import Swal
    import Swal from 'sweetalert2';

    import { Inertia } from '@inertiajs/inertia';

    export default {
        // layout
        layout: LayoutAdmin,

        // register components
        components: {
            Link,
            Head,
        },

        //props
        props: {
            errors: Object,
            transaction: Object,
            banks: Object,
        },
        setup(props) {
            const form = reactive({
                bank_id: '',
                rekening_name: '',
                transfer_date: '',
                total_payment: '',
                file: '',
            });

            // submit method
            const submit = () => {
                // send data to server
                Inertia.post(`/user/transactions/${props.transaction.id}/payment-confirmations`, {
                    forceFormData: true,
                    bank_id: form.bank_id,
                    rekening_name: form.rekening_name,
                    transfer_date: form.transfer_date,
                    total_payment: form.total_payment,
                    file: form.file,
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Konfirmasi Pembayaran Berhasil.',
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
        },
    }
</script>
