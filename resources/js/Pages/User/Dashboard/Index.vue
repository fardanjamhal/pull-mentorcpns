<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Dashboard</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <div v-if="$page.props.setting.purchase_type != 1" class="row row-cols-1 row-cols-md-2 row-cols-xl-4" v-for="(totalDataInCategory, index) in totalDataInCategories" :key="index">
                

                        <div v-if="$page.props.voucherCategories.length > 1">
                            <Link href="/user/exam-groups" class="menu-clicked">
                               Try Out
					        </Link>
                        </div>
                        <div v-else v-for="(category, index) in $page.props.voucherCategories" :key="index">
                            <Link :href="`/user/exam-groups/${category.id}/lesson-categories`" class="menu-clicked">
                            <div class="col">
                                <div class="card radius-10 border-start border-0 border-3 border-danger bg-danger bg-gradient">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <!-- <p class="mb-0 text-white">Try Out {{ totalDataInCategory.name }}</p> -->
                                                <p class="mb-0 text-white">Try Out CPNS & PPPK</p>
                                                <h6 class="my-1 text-white">{{ totalDataInCategory.exam_group_count }} Try Out</h6>
                                            </div>
                                            <div class="text-danger ms-auto font-35"><i class='bx bx-file' style="color: white;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </Link>
                        </div>

                        <div v-if="$page.props.voucherCategories.length > 1">
                            <Link href="/user/categories" class="menu-clicked">
                               Latihan Soal
					        </Link>
                        </div>
                        <div v-else v-for="(category, index) in $page.props.voucherCategories" :key="index">
                            <Link :href="`/user/categories/${category.id}/lesson-categories`" class="menu-clicked">
                                <div class="col">
                                    <div class="card radius-10 border-start border-0 border-3 border-primary bg-primary bg-gradient">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <!-- <p class="mb-0 text-white">Latihan Soal {{ totalDataInCategory.name }}</p> -->
                                                    <p class="mb-0 text-white">Latihan Soal CPNS & PPPK</p>
                                                    <h6 class="my-1 text-white">{{ totalDataInCategory.exam_count }} Soal</h6>
                                                </div>
                                                <div class="text-primary ms-auto font-35"><i class='bx bx-file' style="color: white;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                            </Link>
                        </div>

                        <div>
                        <Link href="/user/modules" class="menu-clicked">
                            <div class="col">
                                <div class="card radius-10 border-start border-0 border-3 border-warning bg-warning bg-gradient">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <!-- <p class="mb-0 text-white">Modul {{ totalDataInCategory.name }}</p> -->
                                                <p class="mb-0 text-white">Modul CPNS & PPPK</p>
                                                <h6 class="my-1 text-white">{{ totalDataInCategory.module_count }} Modul</h6>
                                            </div>
                                            <div class="text-warning ms-auto font-35"><i class='bx bx-book' style="color: white;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </Link>
                        </div>

                        <div>
                        <Link href="/user/video-modules" class="menu-clicked">
                            <div class="col">
                                <div class="card radius-10 border-start border-0 border-3 border-success bg-success bg-gradient">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <!-- <p class="mb-0 text-white">Video Belajar {{ totalDataInCategory.name }}</p> -->
                                                <p class="mb-0 text-white">Video Belajar CPNS & PPPK</p>
                                                <!-- <h6 class="my-1 text-white">{{ totalDataInCategory.video_module_count }}</h6> -->
                                                <h6 class="my-1 text-white">8 Video</h6>
                                            </div>
                                            <div class="text-success ms-auto font-35"><i class='bx bx-video' style="color: white;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </Link>
                        </div>

            </div>

            <!-- <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4" v-if="transactions && $page.props.auth.user.member_type == 2">
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
            </div> -->

            <div class="card radius-10 border-start border-0 border-3 border-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-3">Pemberitahuan</h6>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Perihal</th>
                                    <!-- <th>Lihat Pemberitahuan</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="!announcementSummaries.length">
                                    <td colspan="7" align="center">Data Pemberitahuan kosong</td>
                                </tr>
                                <tr v-for="(announcementSummary, index) in announcementSummaries" :key="index">
                                    <td>{{ ++index }}</td>
                                    <!-- <td>{{ announcementSummary.title }}</td> -->
                                    <td>
                                        <Link :href="`/user/announcements/${announcementSummary.id}`" class="ms-2">{{ announcementSummary.title }}</Link>
                                    </td>
                                    <!-- <td>
                                        <div class="d-flex order-actions">
                                            <Link :href="`/user/announcements/${announcementSummary.id}`" class="ms-2"><i class='bx bx-grid-alt'></i></Link>
                                        </div>
                                    </td> -->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card radius-10 border-start border-0 border-3 border-danger" v-if="transactions && $page.props.auth.user.member_type == 2">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-3">Riwayat Transaksi</h6>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Transaksi</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Total Pembayaran</th>
                                    <!-- <th>Metode Pembayaran</th> -->
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="!transactions.data.length">
                                    <td colspan="8" align="center">Belum ada transaksi</td>
                                </tr>
                                <tr v-for="(transaction, index) in transactions.data" :key="index">
                                    <td>{{ ++index + (transactions.current_page - 1) * transactions.per_page }}</td>
                                    <td>{{ transaction.code }}</td>
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
                                            <Link :href="`/user/transactions/${transaction.id}`"><i class='bx bx-grid-alt'></i></Link>
                                        </div>
                                    </td>
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
    import LayoutUser from '../../../Layouts/Layout.vue';

    // import Link
    import { Link } from '@inertiajs/inertia-vue3';

    // import Head from Inertia
    import {
        Head
    } from '@inertiajs/inertia-vue3';

    export default {
        // layout
        layout: LayoutUser,
        // register components
        components: {
            Head,
            Link,
        },
        // props
        props: {
            totalTransactionPending: Object,
            totalTransactionPaid: Object,
            totalTransactionDone: Object,
            totalTransactionFailed: Object,
            transactions: Object,
            gradeSummaries: Object,
            announcementSummaries: Object,
            totalDataInCategories: Object,
        },
        methods: {
            formatPrice(value) {
                let val = (value/1).toFixed().replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            }
        }
    }
</script>
