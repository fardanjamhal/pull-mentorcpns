<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Data User</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">User</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Data User</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div v-if="$page.props.session.error" class="alert alert-danger border-0 alert-dismissible fade show">
                <i class="fa fa-exclamation-triangle"></i>  {{ $page.props.session.error }}
            </div>

            <div v-if="$page.props.session.success" class="alert alert-success border-0 alert-dismissible fade show">
                <i class="fa fa-exclamation-triangle"></i>  {{ $page.props.session.success }}
            </div>
            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center">
                        <div class="ms-auto">
                            <Link href="/admin/users" class="btn btn-primary btn-sm mt-2 mt-lg-0">Kembali</Link>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <th>Level</th>
                                    <td>:</td>
                                    <td>{{ user.level == 1 ? 'Admin' : 'User' }}</td>
                                </tr>
                                <tr>
                                    <th>Username</th>
                                    <td>:</td>
                                    <td>{{ user.username ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>:</td>
                                    <td>{{ user.email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tipe Member</th>
                                    <td>:</td>
                                    <td>{{ user.member_type == 1 ? 'Member Gratis Try Out' : 'Member Try Out Berbayar' }}</td>
                                </tr>
                                <tr>
                                    <th>Created at</th>
                                    <td>:</td>
                                    <td>{{ user.created_at }}</td>
                                </tr>
                                <tr>
                                    <th>Saldo Akun</th>
                                    <td>:</td>
                                    <td>{{ formatPrice(user.account_balance) }}</td>
                                </tr>
                                <tr>
                                    <th>Status Akun</th>
                                    <td>:</td>
                                    <td>
                                        <span v-if="user.is_active == 1" class="badge bg-success">Active</span>
                                        <span v-else class="badge bg-danger">Non-active</span>
                                    </td>
                                </tr>
                                <tr v-if="user.is_active == 0 && user.student">
                                    <th>Kirim Verifikasi Akun Via WhatsApp</th>
                                    <td>:</td>
                                    <td><Link :href="`/admin/users/${user.id}/send-activation-link`" class="btn btn-success btn-sm">Klik Untuk Mengirim Link Verifikasi</Link></td>
                                </tr>
                                <tr v-if="user.is_active == 0 && user.student">
                                    <th>Kirim Reminder Aktivasi</th>
                                    <td>:</td>
                                    <td><Link :href="`/admin/users/${user.id}/activation-reminder`" class="btn btn-success btn-sm">Kirim Reminder Aktivasi Akun</Link></td>
                                </tr>
                                <tr>
                                    <th colspan="3">&nbsp;</th>
                                </tr>
                                <tr>
                                    <th colspan="3"><h6>INFORMASI LAINNYA</h6></th>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>:</td>
                                    <td>{{ user.student ? (user.student.gender == 'M' ? 'Laki-laki' : 'Perempuan') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor Whatsapp Aktif</th>
                                    <td>:</td>
                                    <td>{{ user.student && user.student.phone_number ? user.student.phone_number : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>:</td>
                                    <td>{{ user.student && user.student.address ? user.student.address : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Provinsi</th>
                                    <td>:</td>
                                    <td>{{ user.student && user.student.province ? user.student.province.name : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Kota</th>
                                    <td>:</td>
                                    <td>{{ user.student && user.student.city ? user.student.city.name : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Kecamatan</th>
                                    <td>:</td>
                                    <td>{{ user.student && user.student.district ? user.student.district.name : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Desa / Kel</th>
                                    <td>:</td>
                                    <td>{{ user.student && user.student.village ? user.student.village.name : '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-header">
                    <h6>Akses Kategori Member</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kategori</th>
                                    <th>Kategori Member</th>
                                    <th>Tanggal Kedaluarsa</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(member, index) in user.user_member_category" :key="index">
                                    <td>{{ ++index }}</td>
                                    <td>{{ member.category.name }}</td>
                                    <td>
                                        <span v-if="member.member_categories" v-for="member_categories in member.member_categories" class="badge bg-success m-1">
                                            {{  member_categories  }}
                                        </span>
                                        <span v-else class="badge bg-danger">Tidak ada</span>
                                    </td>
                                    <td>{{ formatDate(member.expired_date) }}</td>
                                    <td>
                                        <div class="d-flex order-actions">
                                            <a href="#" @click.prevent="destroy(member.id)" class="ms-1"><i class="bx bxs-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" colspan="5" v-if="!user.user_member_category.length">Data Tidak Tersedia</td>
                                </tr>
                            </tbody>
                        </table>
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

    //import sweet alert2
    import Swal from 'sweetalert2';

    import { Inertia } from '@inertiajs/inertia';

    import moment from 'moment';

    // import Head from Inertia
    import {
        Head
    } from '@inertiajs/inertia-vue3';

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
            user: Object,
            verificationLink: String,
            errors: Object,
            session: Object
        },
        setup(props) {
            const destroy = (id) => {
                Swal.fire({
                    title: 'Apakah Anda yakin ?',
                    text: "Menghapusnya dapat menyebabkan akses soal dan voucher siswa terhapus.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus'
                })
                .then((result) => {
                    if (result.isConfirmed) {

                        Inertia.delete(`/admin/users/${props.user.id}/user-member-categories/${id}`);

                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Pelajaran Berhasil Dihapus!.',
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false,
                        });
                    }
                })
            }

            return {
                destroy
            }
        },
        methods: {
            formatPrice(value) {
                let val = (value/1).toFixed().replace('.', ',')
                return 'Rp.' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            },
            formatDate: function (date) {
                return moment(date).format('DD MMMM YYYY');
            },
        }
    }
</script>
