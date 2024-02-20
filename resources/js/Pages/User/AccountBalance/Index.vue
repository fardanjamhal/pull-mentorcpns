<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Data Top Up Saldo</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Top Up Saldo</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Data Top Up Saldo</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card">
                <div class="card-header bg-primary">
                    <h5 class="mb-0 text-white">
                        Saldo Sekarang
                    </h5>
                </div>
                <div class="card-body">
                    <h3>Rp. {{ formatPrice($page.props.auth.user.account_balance) }}</h3>
                </div>
            </div>

            <form @submit.prevent="submit">
                <div class="card border-top border-0 border-3 border-primary">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Pilih Nominal To Up
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                <input value="10000" type="radio" class="btn-check" name="options-outlined" id="primary-outlined-1" autocomplete="off" @click="clickBalance(10000)">
                                <label class="btn btn-outline-primary w-100" for="primary-outlined-1">Rp. 10.000</label>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                <input value="30000" type="radio" class="btn-check" name="options-outlined" id="primary-outlined-2" autocomplete="off" @click="clickBalance(30000)">
                                <label class="btn btn-outline-primary w-100" for="primary-outlined-2">Rp. 30.000</label>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                <input value="50000" type="radio" class="btn-check" name="options-outlined" id="primary-outlined-3" autocomplete="off" @click="clickBalance(50000)">
                                <label class="btn btn-outline-primary w-100" for="primary-outlined-3">Rp. 50.000</label>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                <input value="100000" type="radio" class="btn-check" name="options-outlined" id="primary-outlined-4" autocomplete="off" @click="clickBalance(100000)">
                                <label class="btn btn-outline-primary w-100" for="primary-outlined-4">Rp. 100.000</label>
                            </div>
                        </div>
                    </div>
                    <h5 class="mb-0 px-3">
                        Atau Input Nominal Manual
                    </h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">Rp.</span>
                                    <input type="number" class="form-control form-control-lg" placeholder="Nominal Top Up" v-model="form.top_up_balance" :class="{ 'is-invalid': errors.top_up_balance }">
                                    <div v-if="errors.top_up_balance" class="invalid-feedback">
                                        {{ errors.top_up_balance }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                
                                <h6 class="mt-3">Silakan lakukan pembayaran melalui rekening berikut ini</h6>
                                <br>
                                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-3">
                                    <div class="col" v-for="bank in banks">
                                        <div class="card border-bottom border-3 border-0">
                                            <div style="height:75px;">
                                                <center>
                                                    <img  v-bind:src="'/storage/upload_files/banks/' + bank.image" style="width:125px; margin-top:20px;"/>
                                                </center>
                                            </div>
                                            <div class="card-body">
                                                <center>
                                                    <h5 class="card-title">{{ bank.bank_name }}</h5>
                                                    <p class="card-text">{{ bank.rekening_number }}</p>
                                                    <p class="card-text"><b>{{ bank.rekening_name }}</b></p>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary px-5 mt-3">Top Up Saldo Sekarang</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-3">Riwayat Top Up Saldo</h6>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-success">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Transaksi</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Total Top Up</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td align="center" colspan="4" v-if="!accountBalances.data.length">Data Top Up Saldo kosong</td>
                                </tr>
                                <tr v-for="(accountBalance, index) in accountBalances.data" :key="index">
                                    <td>
                                        {{ ++index + (accountBalances.current_page - 1) * accountBalances.per_page }}
                                    </td>
                                    <td>{{ accountBalance.code }}</td>
                                    <td>{{ accountBalance.created_at }}</td>
                                    <td>Rp. {{ formatPrice(accountBalance.top_up_balance) }}</td>
                                    <td>
                                        <span class="badge bg-warning" v-if="accountBalance.transaction_status == 'pending'">Pending</span>
                                        <span class="badge bg-primary" v-if="accountBalance.transaction_status == 'paid'">Paid</span>
                                        <span class="badge bg-danger" v-if="accountBalance.transaction_status == 'failed'">Failed</span>
                                        <span class="badge bg-success" v-if="accountBalance.transaction_status == 'done'">Done</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <Pagination :links="accountBalances.links" align="end" />

                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->
</template>

<script>
    //import layout user
    import LayoutUser from '../../../Layouts/Layout.vue';

    //import component pagination
    import Pagination from '../../../Components/Pagination.vue';

    // import Link
    import { Link } from '@inertiajs/inertia-vue3';

    //import reactive
    import { reactive } from 'vue';

    import { Inertia } from '@inertiajs/inertia';

    // import Swal
    import Swal from 'sweetalert2';

    // import Head from Inertia
    import {
        Head
    } from '@inertiajs/inertia-vue3';

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
            accountBalances: Object,
            errors: Object,
            banks: Object
        },
        setup() {
            const form = reactive({
                top_up_balance: '',
            });

            const clickBalance = (value) => {
                form.top_up_balance = value;
            }

            // submit method
            const submit = () => {
                // send data to server
                Inertia.post('/user/account-balances', {
                    // data
                    top_up_balance: form.top_up_balance,
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Top Up Berhasil Disimpan, Silakan Lakukan Konfirmasi Pembayaran.',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 4000
                        });

                        form.top_up_balance = '';
                    },
                });
            }

            // return form state and submit method
            return {
                form,
                submit,
                clickBalance
            }
        },

        methods: {
            formatPrice(value) {
                let val = (value/1).toFixed().replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            }
        }
    }
</script>
