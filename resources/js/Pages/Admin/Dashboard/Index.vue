<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Data Kategori</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">

            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                <div class="col">
                    <div class="card radius-10 bg-primary bg-gradient">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-white">Total Siswa</p>
                                    <h4 class="my-1 text-white">{{ totalStudent }}</h4>
                                </div>
                                <div class="text-white ms-auto font-35"><i class='bx bxs-group'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 bg-danger bg-gradient">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-white">Total Akun Aktif</p>
                                    <h4 class="my-1 text-white">{{ totalStudentActive }}</h4>
                                </div>
                                <div class="text-white ms-auto font-35"><i class='bx bxs-group'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 bg-warning bg-gradient">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-dark">Total Akun Non-Aktif</p>
                                    <h4 class="text-dark my-1">{{ totalStudentNonActive }}</h4>
                                </div>
                                <div class="text-dark ms-auto font-35"><i class='bx bx-user-pin'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 bg-success bg-gradient">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-white">Total Siswa Menjadi Member</p>
                                    <h4 class="my-1 text-white">{{ totalStudentMember }}</h4>
                                </div>
                                <div class="text-white ms-auto font-35"><i class='bx bx-comment-detail'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->

            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-3 border-info">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Transakasi Hari Ini</p>
                                    <h4 class="my-1 text-info">{{ totalTransactionToday }}</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i class='bx bxs-cart'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-3 border-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Transaksi Bulan Ini</p>
                                    <h4 class="my-1 text-success">{{ totalTransactionMonthly }}</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class='bx bxs-bar-chart-alt-2' ></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-3 border-danger">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Transaksi Tahun Ini</p>
                                    <h4 class="my-1 text-danger">{{ totalTransactionYearly }}</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto"><i class='bx bxs-wallet'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-3 border-warning">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Pemasukan Bulan Ini</p>
                                    <h4 class="my-1 text-warning">0</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto"><i class='bx bxs-group'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end row-->

            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-3 border-warning">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Transaksi Pending</p>
                                    <h4 class="my-1">{{ totalTransactionPending }}</h4>
                                </div>
                                <div class="widgets-icons bg-light-warning text-warning ms-auto"><i class="bx bxs-wallet"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-3 border-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Transaksi Dibayar</p>
                                    <h4 class="my-1">{{ totalTransactionPaid }}</h4>
                                </div>
                                <div class="widgets-icons bg-light-success text-success ms-auto"><i class="bx bxs-wallet"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-3 border-danger">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Transaksi Failed</p>
                                    <h4 class="my-1">{{ totalTransactionFailed }}</h4>
                                </div>
                                <div class="widgets-icons bg-light-danger text-danger ms-auto"><i class="bx bxs-wallet"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-3 border-primary">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Transaksi Selesai</p>
                                    <h4 class="my-1">{{ totalTransactionDone }}</h4>
                                </div>
                                <div class="widgets-icons bg-light-primary text-primary ms-auto"><i class="bx bxs-wallet"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->

            <!-- <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <div>
                        <apexchart :width="chart.width" :height="chart.height" :type="chart.type" :options="chart.options" :series="chart.series"></apexchart>
                    </div>
                </div>
            </div> -->

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-3">Transaksi Bulan Ini</h6>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Transaksi</th>
                                    <th>User</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Total Pembayaran</th>
                                    <!-- <th>Metode Pembayaran</th> -->
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(transaction, index) in transactions.data" :key="index">
                                    <td>{{ ++index + (transactions.current_page - 1) * transactions.per_page }}</td>
                                    <td>{{ transaction.code }}</td>
                                    <td>{{ transaction.user.name }}</td>
                                    <td>{{ transaction.description }}</td>
                                    <td>{{ transaction.created_at }}</td>
                                    <td>{{ formatPrice(transaction.total_payment) }}</td>
                                    <!-- <td>{{ transaction.payment_method == 'account_balance' ? 'Saldo Akun' : ''}}</td> -->
                                    <td>
                                        <span class="badge bg-warning" v-if="transaction.transaction_status == 'pending'">Pending</span>
                                        <span class="badge bg-primary" v-if="transaction.transaction_status == 'paid'">Paid</span>
                                        <span class="badge bg-danger" v-if="transaction.transaction_status == 'failed'">Failed</span>
                                        <span class="badge bg-success" v-if="transaction.transaction_status == 'done'">Done</span>
                                    </td>
                                    <td>
                                        <div class="d-flex order-actions">
                                            <Link :href="`/admin/transactions/${transaction.id}`" style="margin:5px;"><i class='bx bx-grid-alt'></i></Link>
                                            <Link :href="`/admin/transactions/${transaction.id}/invoice`" style="margin:5px;"><i class='bx bx-credit-card-front'></i></Link>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" colspan="9" v-if="!transactions.data.length">Data Tidak Tersedia</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <Pagination :links="transactions.links" align="end" />

                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->
</template>

<script>
    //import layout admin
    import LayoutAdmin from '../../../Layouts/Layout.vue';

    // import Head from Inertia
    import {
        Head
    } from '@inertiajs/inertia-vue3';

    //import component pagination
    import Pagination from '../../../Components/Pagination.vue';

    // import Link
    import { Link } from '@inertiajs/inertia-vue3';

    export default {
        // layout
        layout: LayoutAdmin,
        // register components
        components: {
            Head,
            Pagination,
            Link
        },
        props: {
            totalStudent: String,
            totalStudentActive: String,
            totalStudentNonActive: String,
            totalStudentMember: String,

            totalTransactionToday: String,
            totalTransactionMonthly: String,
            totalTransactionYearly: String,

            totalTransactionPending: String,
            totalTransactionPaid: String,
            totalTransactionDone: String,
            totalTransactionFailed: String,

            transactions: Object,

            // chart: Object
        },
        methods: {
            formatPrice(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return 'Rp.' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            }
        }
    }
</script>
