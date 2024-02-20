<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Data Transaksi</title>
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
                            <li class="breadcrumb-item active" aria-current="page">Data Transaksi</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body"> <!-- Change 'text-center' to 'text-end' -->
                    <form>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="search">Kode Transaksi</label>
                                <input type="text" v-model="search" class="form-control form-control-sm" id="search" placeholder="Cari Berdasarkan Kode Transaksi....">
                            </div>

                            <div class="col-md-2">
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
                                <label for="start_date">Tanggal Mulai</label>
                                <input type="date" class="form-control form-control-sm" v-model="start_date" id="start_date">
                            </div>

                            <div class="col-md-2">
                                <label for="end_date">Tanggal Akhir</label>
                                <input type="date" class="form-control form-control-sm" v-model="end_date" id="end_date">
                            </div>
                            <div class="col-md-3">
                                <label for="end_date">Action</label><br>
                                <button @click.prevent="handleSearch" class="btn btn-primary btn-sm me-2">
                                    <i class="bx bx-filter"></i>Filter
                                </button>

                                <Link href="/admin/transactions" class="btn btn-danger btn-sm me-2">
                                    <i class="bx bx-refresh"></i>reset
                                </Link>

                                <a target="_blank" @click.prevent="exportTransaction" class="btn btn-success btn-sm">
                                    <i class="bx bxs-file"></i>  Export
                                </a>
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
                                    <th>User</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Total Pembayaran</th>
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
                                    <td>
                                        <span class="badge bg-warning" v-if="transaction.transaction_status == 'pending'">Pending</span>
                                        <span class="badge bg-primary" v-if="transaction.transaction_status == 'paid'">Paid</span>
                                        <span class="badge bg-danger" v-if="transaction.transaction_status == 'failed'">Failed</span>
                                        <span class="badge bg-success" v-if="transaction.transaction_status == 'done'">Done</span>
                                    </td>
                                    <td>
                                        <div class="d-flex order-actions">
                                            <Link :href="`/admin/transactions/${transaction.id}`" class="ms-1"><i class='bx bx-grid-alt'></i></Link>
                                            <Link :href="`/admin/transactions/${transaction.id}/invoice`" class="ms-1"><i class='bx bx-credit-card-front'></i></Link>
                                            <a href="#" @click.prevent="destroy(transaction.id)" class="ms-1"><i class="bx bxs-trash"></i></a>
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
    
    import Swal from 'sweetalert2';

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
            const start_date = ref("" || (new URL(document.location)).searchParams.get('start_date'));
            const end_date = ref("" || (new URL(document.location)).searchParams.get('end_date'));

            // define method search
            const handleSearch = () => {
                Inertia.get('/admin/transactions', {
                    search: search.value,
                    transaction_status: transaction_status.value,
                    start_date: start_date.value,
                    end_date: end_date.value,
                })
            }

            const exportTransaction = () => {
                const searchParams = new URLSearchParams();
                searchParams.append('search', search.value);
                searchParams.append('transaction_status', transaction_status.value);
                searchParams.append('start_date', start_date.value);
                searchParams.append('end_date', end_date.value);
                
                const exportUrl = '/admin/transactions/export?' + searchParams.toString();
                window.open(exportUrl, '_blank');
            }

            const destroy = (id) => {
                Swal.fire({
                    title: 'Apakah Anda yakin ?',
                    text: "Pastikan bahwa transaksi ini tidak terkait dengan pembelian voucher atau paket soal. Menghapusnya dapat menyebabkan akses soal dan voucher siswa terhapus.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus Transaksi'
                })
                .then((result) => {
                    if (result.isConfirmed) {

                        Inertia.delete(`/admin/transactions/${id}`);

                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Transaksi Berhasil Dihapus!.',
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false,
                        });
                    }
                })
            }

            return {
                search,
                transaction_status,
                start_date,
                end_date,
                destroy,
                handleSearch,
                exportTransaction
            }
        },

        // props
        props: {
            transactions: Object
        },
        methods: {
            formatPrice(value) {
                let val = (value/1).toFixed(2).replace('.', ',')
                return 'Rp.' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            }
        }
    }
</script>
