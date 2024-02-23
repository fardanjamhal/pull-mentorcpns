<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Latihan Soal</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Latihan Soal</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Detail Latihan Soal</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <Link :href="`/user/categories/${exam.category_id}/lesson-categories/${exam.lesson_category_id}/lessons/${exam.lesson_id}/exams`" class="btn btn-primary btn-sm mt-2 mt-lg-0">Kembali</Link>
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
                    <!-- <div class="card">
                        <div class="card-header bg-primary">
                            <h5 class="mb-0 text-white" data-bs-toggle="collapse" href="#collapseDetailTryOutInformation" aria-expanded="false" @click="toggleCollapseDetailTryOutInformation">
                                Informasi
                                <a class="float-end" data-bs-toggle="collapse" href="#collapseDetailTryOutInformation" aria-expanded="false">
                                    <i class="text-white" :class="{ 'bx bx-chevron-down': collapseDetailTryOutInformation, 'bx bx-chevron-up': !collapseDetailTryOutInformation }"></i>
                                </a>
                            </h5>
                        </div>
                        <div class="collapse" :class="{ 'show': collapseDetailTryOutInformation, 'fade in': true}" id="collapseDetailTryOutInformation">
                            <div class="card-body">
                                <div v-html="exam.description"></div>
                            </div>
                        </div>
                    </div> -->
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h5 class="mb-0 text-white" data-bs-toggle="collapse" href="#collapseDetailTryOutExam" aria-expanded="false" @click="toggleCollapseDetailTryOutExam">
                                Detail Try Out
                                <a class="float-end" data-bs-toggle="collapse" href="#collapseDetailTryOutExam" aria-expanded="false">
                                    <i class="text-white" :class="{ 'bx bx-chevron-down': collapseDetailTryOutExam, 'bx bx-chevron-up': !collapseDetailTryOutExam }"></i>
                                </a>
                            </h5>
                        </div>
                        <div class="collapse" :class="{ 'show': collapseDetailTryOutExam, 'fade in': true}" id="collapseDetailTryOutExam">
                            <div class="card-body">
                                <table class="table mb-0">
                                    <tbody>
                                        <tr>
                                            <th>Nama</th>
                                            <td>:</td>
                                            <td>{{ $page.props.auth.user.name }}</td>
                                        </tr>
                                        <tr>
                                            <th width="300px">Email</th>
                                            <td width="2px">:</td>
                                            <td>{{ $page.props.auth.user.email ?? '-' }}</td>
                                        </tr>
                                        <!-- <tr>
                                            <th>Username</th>
                                            <td>:</td>
                                            <td>{{ $page.props.auth.user.username ?? '-' }}</td>
                                        </tr> -->
                                        <!-- <tr>
                                            <td colspan="3">&nbsp;</td>
                                        </tr> -->
                                        <tr>
                                            <th>Peminatan</th>
                                            <td>:</td>
                                            <td><span class="badge bg-primary">{{ exam.category.name }}</span></td>
                                        </tr>
                                        <!-- <tr>
                                            <th>Sub peminatan khusus untuk</th>
                                            <td>:</td>
                                            <td>
                                                <div v-if="exam.sub_categories.length">
                                                    <div v-for="(sub_category, index) in exam.sub_categories" :key="index" style="display: inline;">
                                                        <span>{{ sub_category.name }}</span>
                                                        <span v-if="index < exam.sub_categories.length - 1">, </span>
                                                    </div>
                                                </div>
                                                <div v-else>
                                                    <span>Seluruh kategori peminatan</span>
                                                </div>
                                            </td>
                                        </tr> -->

                                        <tr>
                                            <th>Kategori</th>
                                            <td>:</td>
                                            <td>{{ exam.lesson_category.name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Mata Pelajaran</th>
                                            <td>:</td>
                                            <td>{{ exam.lesson.name }}</td>
                                        </tr>
                                        <!-- <tr>
                                            <th>Judul</th>
                                            <td>:</td>
                                            <td>{{ exam.title }}</td>
                                        </tr> -->
                                        <tr>
                                            <th>Durasi</th>
                                            <td>:</td>
                                            <td>{{ exam.duration }} Menit</td>
                                        </tr>
                                        <tr v-if="$page.props.auth.user.member_type == 2">
                                            <th>Untuk Kategori Member</th>
                                            <td>:</td>
                                            <td>
                                                <span v-if="exam.member_categories" v-for="member_categories in exam.member_categories" class="badge bg-success m-1">
                                                    {{  member_categories  }}
                                                </span>
                                                <span v-else class="badge bg-danger">Untuk Seluruh Kategori Member</span>
                                            </td>
                                        </tr>
                                        <!-- <tr>
                                            <td colspan="3">&nbsp;</td>
                                        </tr> -->
                                        <tr>
                                            <td colspan="9">
                                                <div class="text-center" v-if="!grade">
                                                    <Link :href="`/user/exams/${exam.id}/exam-start`" class="btn btn-sm btn-primary" style="width: 16vh;">Mulai Kerjakan</Link>
                                                </div>
                                                <div class="text-center" v-else-if="grade && grade.is_finished == 0">
                                                    <Link :href="`/user/exams/${exam.id}/exam-start`" class="btn btn-sm btn-warning" style="width: 19vh;">Lanjut Mengerjakan</Link>
                                                </div>
                                                <div class="text-center" v-else-if="grade && grade.is_finished == 1">
                                                    <a href="#" @click.prevent="repeatExam()" class="btn btn-sm btn-danger" style="width: 16vh;margin: 6px;" v-if="exam.repeat_the_exam == 1">Tes Ulang</a>
                                                    &nbsp;
                                                    <Link :href="`/user/grades/${grade.id}`" class="btn btn-sm btn-primary" style="width: 16vh;margin: 6px;">Hasil</Link>
                                                    &nbsp;
                                                    <Link :href="`/user/grades/${grade.id}/questions`" v-if="exam.show_answer_discussion == 1" class="btn btn-sm btn-primary" style="width: 16vh; margin: 6px;">Pembahasan</Link>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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

    import { ref } from 'vue';

    // import Link
    import { Link } from '@inertiajs/inertia-vue3';

    // import Head from Inertia
    import {
        Head
    } from '@inertiajs/inertia-vue3';

    //import sweet alert2
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

        // props
        props: {
            exam: Object,
            grade: Object,
        },
        setup(props) {
            const collapseDetailTryOutInformation = ref(localStorage.getItem('collapseDetailTryOutInformation') !== null ? JSON.parse(localStorage.getItem('collapseDetailTryOutInformation')) : true);
            const collapseDetailTryOutExam = ref(localStorage.getItem('collapseDetailTryOutExam') !== null ? JSON.parse(localStorage.getItem('collapseDetailTryOutExam')) : true);

            const toggleCollapseDetailTryOutInformation = () => {
                collapseDetailTryOutInformation.value = !collapseDetailTryOutInformation.value;
                localStorage.setItem('collapseDetailTryOutInformation', JSON.stringify(collapseDetailTryOutInformation.value));
            }

            const toggleCollapseDetailTryOutExam = () => {
                collapseDetailTryOutExam.value = !collapseDetailTryOutExam.value;
                localStorage.setItem('collapseDetailTryOutExam', JSON.stringify(collapseDetailTryOutExam.value));
            }

            const repeatExam = () => {
                Swal.fire({
                    title: 'Konfirmasi Ulangi Pengerjaan',
                    text: "Mengulangi Ujian Dapat Mempengaruhi Nilai Anda.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ulangi Ujian'
                })
                .then((result) => {
                    if (result.isConfirmed) {

                        Inertia.get(`/user/exams/${props.exam.id}/exam-start?repeat=1`);

                        Swal.fire({
                            title: 'Success!',
                            text: 'Silakan Untuk Mengerjakan Kembali.',
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false,
                        });
                    }
                })
            }

            return {
                repeatExam,

                collapseDetailTryOutInformation,
                collapseDetailTryOutExam,

                toggleCollapseDetailTryOutInformation,
                toggleCollapseDetailTryOutExam,
            }
        }
    }
</script>
