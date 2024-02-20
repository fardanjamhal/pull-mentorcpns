<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Data Try Out</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Try Out</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Daftar Siswa Try Out</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div v-if="$page.props.session.success" class="alert alert-success border-0 bg-success alert-dismissible fade show py-2">
                <div class="d-flex align-items-center">
                    <div class="font-35 text-white"><i class='bx bxs-check-circle'></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0 text-white">Sukses</h6>
                        <div class="text-white">{{ $page.props.session.success }}</div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <div v-if="$page.props.session.failed" class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
                <div class="d-flex align-items-center">
                    <div class="font-35 text-white"><i class='bx bxs-message-square-x'></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0 text-white">Gagal</h6>
                        <div class="text-white">{{ $page.props.session.failed }}</div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            
            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center mb-4 gap-3">
                        <a target="_blank" :href="`/admin/exam-groups/${exam_group_id}/export-pdf`" class="btn btn-danger btn-sm mt-lg-0">
                            <i class="bx bxs-file"></i> Export PDF
                        </a>
                        <a target="_blank" :href="`/admin/exam-groups/${exam_group_id}/export-excel`" class="btn btn-success btn-sm mt-lg-0">
                            <i class="bx bxs-file"></i> Export Excel
                        </a>
                        <div class="ms-auto">
                            <Link href="/admin/exam-groups" class="btn btn-primary btn-sm mt-2 mt-lg-0">Kembali</Link>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Provinsi</th>
                                    <th>Kota</th>
                                    <th>Status Pengerjaan</th>
                                    <th>Nilai</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(exam, index) in examGroupUsers.data" :key="index">
                                    <td>{{ ++index + (examGroupUsers.current_page - 1) * examGroupUsers.per_page }}</td>
                                    <td>{{ exam.user.name }}</td>
                                    <td>{{ exam.user.student ? (exam.user.student.province ? exam.user.student.province.name : '-') : '-' }}</td>
                                    <td>{{ exam.user.student ? (exam.user.student.city ? exam.user.student.city.name : '-') : '-' }}</td>
                                    <td>
                                        <span class="badge bg-danger" v-if="exam.is_finished == 0">Belum Selesai Mengerjakan</span>
                                        <span class="badge bg-primary" v-else>Selesai Mengerjakan</span>
                                    </td>
                                    <td>{{ exam.grade }}</td>
                                    <td>
                                        <div class="d-flex order-actions">
                                            <a target="_blank" :href="`/admin/exam-groups/${exam.exam_group_id}/students/${exam.id}/export-pdf`" class="ms-1"><i class='bx bx-file'></i></a>
                                            <Link :href="`/admin/exam-groups/${exam.exam_group_id}/students/${exam.id}/grades`" class="ms-1"><i class='bx bx-grid-alt'></i></Link>
                                            <a href="#" @click.prevent="regenerateTryoutScore(exam.exam_group_id, exam.id)" class="ms-1"><i class='bx bx-refresh'></i></a>
                                            <a href="#" @click.prevent="destroy(exam.id)" class="ms-1"><i class="bx bxs-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" colspan="9" v-if="!examGroupUsers.data.length">Data Tidak Tersedia</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <Pagination :links="examGroupUsers.links" align="end" />
                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->
</template>

<script>
    //import layout admin
    import LayoutAdmin from '../../../../Layouts/Layout.vue';

    //import component pagination
    import Pagination from '../../../../Components/Pagination.vue';

    // import Link
    import { Link } from '@inertiajs/inertia-vue3';

    //import sweet alert2
    import Swal from 'sweetalert2';

    //import ref from vue
    import {
        ref
    } from 'vue';

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
            Pagination
        },

        // props
        props: {
            examGroupUsers: Object,
            exam_group_id: Object,
        },

        // initialization composition API
        setup() {

            const destroy = (id) => {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda tidak akan dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Hapus'
                })
                .then((result) => {
                    if (result.isConfirmed) {

                        Inertia.delete(`/admin/exam-groups/${id}/exam-group-users`);

                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Try Out Berhasil Dihapus!.',
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false,
                        });
                    }
                })
            }

            const regenerateTryoutScore = (examGroupId, examId) => {
                Swal.fire({
                    title: 'Konfirmasi Hitung Ulang Nilai',
                    text: "Hitung ulang nilai akan berpengaruh pada nilai yang sudah ada.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Hitung Ulang'
                })
                .then((result) => {
                    if (result.isConfirmed) {

                        Inertia.get(`/admin/exam-groups/${examGroupId}/students/${examId}/regenerate-scores`);

                        Swal.fire({
                            title: 'Success!',
                            text: 'Hitung Ulang Berhasil.',
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false,
                        });
                    }
                })
            }

            return {
                destroy,
                regenerateTryoutScore
            }
        }
    }
</script>
