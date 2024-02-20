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

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body"> <!-- Change 'text-center' to 'text-end' -->
                    <form>
                        <div class="row">
                            <div class="col-md-5">
                                <label for="search">Kode Transaksi</label>
                                <input type="text" v-model="search" class="form-control form-control-sm" id="search" placeholder="Cari Berdasarkan Kode Transaksi....">
                            </div>

                            <div class="col-md-5">
                                <label for="transaction_status">Status Transaksi</label>
                                <select v-model="transaction_status" class="form-control form-control-sm" id="transaction_status">
                                    <option value="">[ Pilih Status ]</option>
                                    <option value="pending">Pending</option>
                                    <option value="paid">Paid</option>
                                    <option value="done">Done</option>
                                    <option value="failed">Failed</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="end_date">Action</label><br>
                                <button @click.prevent="handleSearch" class="btn btn-primary btn-sm me-2">
                                    <i class="bx bx-filter"></i>Filter
                                </button>

                                <Link href="/admin/account-balances" class="btn btn-danger btn-sm me-2">
                                    <i class="bx bx-refresh"></i>reset
                                </Link>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="my-1">Data Transaksi</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Transaksi</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Nama User</th>
                                    <th>Total Top Up</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(accountBalance, index) in accountBalances.data" :key="index">
                                    <td>{{ ++index + (accountBalances.current_page - 1) * accountBalances.per_page }}</td>
                                    <td>{{ accountBalance.code }}</td>
                                    <td>{{ accountBalance.created_at }}</td>
                                    <td>{{ accountBalance.user.name }}</td>
                                    <td>{{ formatPrice(accountBalance.top_up_balance) }}</td>
                                    <td>
                                        <span class="badge bg-warning" v-if="accountBalance.transaction_status == 'pending'">Pending</span>
                                        <span class="badge bg-primary" v-if="accountBalance.transaction_status == 'paid'">Paid</span>
                                        <span class="badge bg-danger" v-if="accountBalance.transaction_status == 'failed'">Failed</span>
                                        <span class="badge bg-success" v-if="accountBalance.transaction_status == 'done'">Done</span>
                                    </td>

                                    <td>
                                        <div class="d-flex order-actions">
                                            <Link :href="`/admin/account-balances/${accountBalance.id}`" style="margin:5px;"><i class='bx bx-grid-alt'></i></Link>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" colspan="9" v-if="!accountBalances.data.length">Data Tidak Tersedia</td>
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
    import LayoutAdmin from '../../../../Layouts/Layout.vue';

    //import component pagination
    import Pagination from '../../../../Components/Pagination.vue';

    // import Link
    import { Link } from '@inertiajs/inertia-vue3';

    // import Head from Inertia
    import {
        Head
    } from '@inertiajs/inertia-vue3';

    import { Inertia } from '@inertiajs/inertia';

    import {
            ref
        } from 'vue';

    export default {
        // layout
        layout: LayoutAdmin,

        //import ref from vue

        // register components
        components: {
            Link,
            Head,
            Pagination
        },
        setup() {
            const search = ref("" || (new URL(document.location)).searchParams.get('search'));
            const transaction_status = ref((new URL(document.location)).searchParams.get('transaction_status') || "");
            
            // define method search
            const handleSearch = () => {
                Inertia.get('/admin/account-balances', {
                    search: search.value,
                    transaction_status: transaction_status.value,
                })
            }

            return {
                search,
                transaction_status,
                handleSearch,
            }
        },

        // props
        props: {
            accountBalances: Object
        },
        methods: {
            formatPrice(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return 'Rp.' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            }
        }
    }
</script>
