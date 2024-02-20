<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Detail Transaksi</title>
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
                            <li class="breadcrumb-item active" aria-current="page">Detail Transaksi</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center">
                        <div class="ms-auto">
                            <Link href="/admin/transactions" class="btn btn-primary btn-sm mt-2 mt-lg-0">Kembali</Link>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <form @submit.prevent="submit">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <th colspan="3">Biodata</th>
                                    </tr>
                                    <tr>
                                        <td width="300px">Nama Lengkap</td>
                                        <td width="20px">:</td>
                                        <td>{{ transaction.user.name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>:</td>
                                        <td>{{ transaction.user.email ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Provinsi</td>
                                        <td>:</td>
                                        <td>{{ transaction.user.student && transaction.user.student.province ? transaction.user.student.province.name : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kota/Kab</td>
                                        <td>:</td>
                                        <td>{{ transaction.user.student && transaction.user.student.city ? transaction.user.student.city.name : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kecamatan</td>
                                        <td>:</td>
                                        <td>{{ transaction.user.student && transaction.user.student.district ? transaction.user.student.district.name : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Desa/Kelurahan</td>
                                        <td>:</td>
                                        <td>{{ transaction.user.student && transaction.user.student.village ? transaction.user.student.village.name : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Telepon (Whatsapp)</td>
                                        <td>:</td>
                                        <td>{{ transaction.user.student && transaction.user.student.phone_number ? transaction.user.student.phone_number : '-' }}</td>
                                    </tr>
                                </tbody>

                                <tbody>
                                    <tr>
                                        <th colspan="3">Detail Transaksi</th>
                                    </tr>
                                    <tr>
                                        <td>Kode Transaksi</td>
                                        <td>:</td>
                                        <td>{{ transaction.code }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Tansaksi</td>
                                        <td>:</td>
                                        <td>{{ transaction.created_at }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kategori Peminatan</td>
                                        <td>:</td>
                                        <td><span class="badge bg-primary">{{ transaction.category.name }}</span></td>
                                    </tr>
                                    <tr>
                                        <td>Deskripsi Transaksi</td>
                                        <td>:</td>
                                        <td>{{ transaction.description }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kategori Member</td>
                                        <td>:</td>
                                        <td>
                                            <div class="col-sm-9">
                                                <span v-if="transaction.member_categories" v-for="member_categories in transaction.member_categories" class="badge bg-success m-1">
                                                    {{  member_categories  }}
                                                </span>
                                                <span v-else class="badge bg-success">Untuk Seluruh Kategori Member</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Metode Pembayaran</td>
                                        <td>:</td>
                                        <td>
                                            <span v-if="transaction.payment_method == 'account_balance'">Saldo Akun</span>
                                            <span v-if="transaction.payment_method == 'manual_transfer'">Transfer Manual (Konfirmasi Pembayaran)</span>
                                            <span v-if="transaction.payment_method == 'automatic_transfer_midtrans'">Transfer Otomatis</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total Transaksi</td>
                                        <td>:</td>
                                        <td>{{ formatPrice(transaction.total_payment) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Status Transaksi</td>
                                        <td>:</td>
                                        <td>
                                            <span class="fw-bold" v-if="transaction.transaction_status == 'pending'">Pending - Belum melakukan pembayaran</span>
                                            <span class="fw-bold" v-if="transaction.transaction_status == 'paid'">Telah melakukan pembayaran</span>
                                            <span class="fw-bold" v-if="transaction.transaction_status == 'failed'">Transaksi Gagal</span>
                                            <span class="fw-bold" v-if="transaction.transaction_status == 'done'">Transaksi Selesai</span>
                                            <span class="fw-bold" v-if="transaction.transaction_status == 'expired'">Transaksi Kadaluarsa</span>
                                        </td>
                                    </tr>
                                </tbody>

                                <tbody v-if="transaction.payment_method == 'manual_transfer' && transaction.payment_confirmation">
                                    <tr>
                                        <th colspan="3">Data Konfirmasi Pembayaran</th>
                                    </tr>
                                    <tr>
                                        <td>Nama Pengirim Transfer</td>
                                        <td>:</td>
                                        <td>{{ transaction.payment_confirmation.rekening_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Di Transfer Ke Rekening</td>
                                        <td>:</td>
                                        <td>{{ transaction.payment_confirmation.bank.bank_name + ' - ' + transaction.payment_confirmation.bank.rekening_number + ' - ' + transaction.payment_confirmation.bank.rekening_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Transfer</td>
                                        <td>:</td>
                                        <td>{{ transaction.payment_confirmation.transfer_date }}</td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Transfer</td>
                                        <td>:</td>
                                        <td>{{ formatPrice(transaction.payment_confirmation.total_payment) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Bukti Transfer</td>
                                        <td>:</td>
                                        <img v-bind:src="'/storage/upload_files/payment_confirmation/' + transaction.payment_confirmation.file" style="width: 300px;"/>
                                    </tr>
                                    <tr>
                                        <th colspan="3">&nbsp;</th>
                                    </tr>
                                </tbody>

                                <tbody v-if="transaction.transaction_status == 'pending' || transaction.transaction_status == 'paid'">
                                    <tr>
                                        <td>Ubah Status Transaksi</td>
                                        <td>:</td>
                                        <td>
                                            <select class="form-control" v-model="form.transaction_status">
                                                <option value="">[ Pilih Status Transaksi ]</option>
                                                <option value="pending">Pending</option>
                                                <option value="paid">Paid</option>
                                                <option value="done">Done</option>
                                                <option value="failed">Failed</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <button type="submit" class="btn btn-primary btn-sm px-5">Submit</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
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
    
    // import Swal
    import Swal from 'sweetalert2';

    // import Head from Inertia
    import {
        Head
    } from '@inertiajs/inertia-vue3';

    import { Inertia } from '@inertiajs/inertia';

    export default {
        // layout
        layout: LayoutAdmin,

        // register components
        components: {
            Link,
            Head,
        },

        // props
        props: {
            transaction: Object
        },
        // initialization composition API
        setup(props) {
            const form = reactive({
                transaction_status: props.transaction.transaction_status,
            });

            // submit method
            const submit = () => {
                // send data to server
                Inertia.put(`/admin/transactions/${props.transaction.id}`, {
                    // data
                    transaction_status: form.transaction_status,
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Transaksi Berhasil Diupdate!.',
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
        methods: {
            formatPrice(value) {
                let val = (value/1).toFixed().replace('.', ',')
                return 'Rp.' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            }
        }
    }
</script>
