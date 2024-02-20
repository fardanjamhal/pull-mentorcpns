<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Data Generate Report Nilai</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Generate Report Nilai</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Data Generate Report Nilai</li>
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

            <div class="card">
                <div class="card-body"> <!-- Change 'text-center' to 'text-end' -->
                    <div class="d-lg-flex align-items-center gap-3">
                        <div class="ms-auto">
                            <a href="#" @click.prevent="destroyAllGrade" class="btn btn-danger btn-sm"><i class="bx bx-trash"></i> Hapus Semua Soal</a>
                        </div>
                        <form @submit.prevent="importExcel" class="d-flex ml-auto">
                            <div class="btn-group me-2">
                                <input type="file" @input="form.file = $event.target.files[0]" class="form-control form-control-sm me-2" required>
                            </div>
                            <div class="btn-group">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bx bxs-file"></i>  Import Nilai
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Gender</th>
                                    <th>TWK</th>
                                    <th>PU</th>
                                    <th>Matematika</th>
                                    <th>Inggris</th>
                                    <th>Akhir</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(grade, index) in grades.data" :key="index">
                                    <td>{{ ++index + (grades.current_page - 1) * grades.per_page }}</td>
                                    <td>{{ grade.nama }}</td>
                                    <td>{{ grade.gender == 1 ? 'L' : 'P' }}</td>
                                    <td align="center">
                                        {{ grade.nilai_twk  ?? '-' }}
                                        <div v-if="grade.nilai_twk">
                                            <br><span class="badge bg-danger">TO {{ grade.twk_ke }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        {{ grade.nilai_pu ?? '-'}}
                                        <div v-if="grade.nilai_pu">
                                            <br><span class="badge bg-danger">TO {{ grade.pu_ke }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        {{ grade.nilai_mtk ?? '-'}}
                                        <div v-if="grade.nilai_mtk">
                                            <br><span class="badge bg-danger">TO {{ grade.mtk_ke }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        {{ grade.nilai_inggris ?? '-' }}
                                        <div v-if="grade.nilai_inggris">
                                            <br><span class="badge bg-danger">TO {{ grade.inggris_ke }}</span>
                                        </div>
                                    </td>
                                    <td>{{ grade.nilai_akhir ?? '-' }}</td>
                                    <td>
                                        <a class="btn btn-info btn-sm" target="_blank" :href="`/admin/grade-generators/${grade.id}/export-pdf`">Export</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <Pagination :links="grades.links" align="end" />

                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->
</template>

<script>
    //import layout admin
    import LayoutAdmin from '../../../Layouts/Layout.vue';

    //import component pagination
    import Pagination from '../../../Components/Pagination.vue';

    // import Link
    import { Link } from '@inertiajs/inertia-vue3';

    // import Head from Inertia
    import {
        Head
    } from '@inertiajs/inertia-vue3';

    //import reactive
    import { reactive } from 'vue';

    import { Inertia } from '@inertiajs/inertia';

    //import sweet alert2
    import Swal from 'sweetalert2';


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
            grades: Object
        },

        // initialization composition API
        setup() {
            const form = reactive({
                file: '',
            });

            const destroyAllGrade = (id) => {
                Swal.fire({
                    title: 'Apakah anda yakin akan menghapus seluruh data nilai ?',
                    text: "Anda tidak akan dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Hapus'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        Inertia.get(`/admin/grade-generators/delete-all`);

                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Seluruh Data Berhasil Dihapus!.',
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false,
                        });
                    }
                })
            }

            const importExcel = () => {
                Swal.fire({
                    title: 'Pastikan Format File Sesuai',
                    text: "Jika format tidak sesuai maka nilai tidak bisa di import.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Import'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        Inertia.post(`/admin/grade-generators`, {
                            forceFormData: true,
                            file: form.file,
                        });
                    }
                })
            }

            return {
                form,
                importExcel,
                destroyAllGrade
            }
        }
    }
</script>
