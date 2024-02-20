<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Try Out</title>
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
                            <li class="breadcrumb-item active" aria-current="page">Detail Try Out</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center">
                        <div class="ms-auto">
                            <Link href="/admin/exams" class="btn btn-primary btn-sm mt-2 mt-lg-0">Kembali</Link>
                        </div>
                    </div>
                    <table class="table mb-0">
                        <tbody>
                            <tr>
                                <th width="350px">Kategori</th>
                                <td width="10px">:</td>
                                <td>{{ exam.category.name }}</td>
                            </tr>
                            <tr>
                                <th>Kategori Mata Pelajaran</th>
                                <td>:</td>
                                <td>{{ exam.lesson_category.name }}</td>
                            </tr>
                            <tr>
                                <th>Mata Pelajaran</th>
                                <td>:</td>
                                <td>{{ exam.lesson.name }}</td>
                            </tr>
                            <tr>
                                <th>Paket Soal</th>
                                <td>:</td>
                                <td>{{ exam.question_title.name }}</td>
                            </tr>
                            <tr>
                                <th>Judul Try Out</th>
                                <td>:</td>
                                <td>{{ exam.title }}</td>
                            </tr>
                            <tr>
                                <th>Durasi</th>
                                <td>:</td>
                                <td>{{ exam.duration }} Menit</td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td>:</td>
                                <td>
                                    <div v-html="exam.description"></div>
                                </td>
                            </tr>
                            <tr>
                                <th>Soal Acak</th>
                                <td>:</td>
                                <td>{{ exam.random_question == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr>
                                <th>Jawaban Acak</th>
                                <td>:</td>
                                <td>{{ exam.random_answer == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr>
                                <th>Tampilkan Jawaban</th>
                                <td>:</td>
                                <td>{{ exam.show_answer == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr>
                                <th>Tampilkan Navigasi Nomor Soal</th>
                                <td>:</td>
                                <td>{{ exam.show_question_number_navigation == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr>
                                <th>Tampilkan Nomor Soal</th>
                                <td>:</td>
                                <td>{{ exam.show_question_number == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr>
                                <th>Pertanyaan Berikutnya Secara Otomatis</th>
                                <td>:</td>
                                <td>{{ exam.next_question_automatically == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr>
                                <th>Tampilkan Button Sebelum & Selanjutnya</th>
                                <td>:</td>
                                <td>{{ exam.show_prev_next_button == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr>
                                <th>Tipe Pilihan Ganda</th>
                                <td>:</td>
                                <td>{{ exam.type_option ==  1 ? 'Button option dan soal menyatu (Normal)' : 'Button option ke samping & jawaban menyatu dengan soal'}}</td>
                            </tr>
                            <tr v-if="examGroup.exam_group_type == 1">
                                <th>Siswa Dapat Mengulangi Try Out</th>
                                <td>:</td>
                                <td>{{ exam.repeat_the_exam ==  1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-primary mb-3">
                    <div class="d-flex justify-content-between">
                        <div class="text-start">
                            <h5 class="mb-0 text-white">Ranking Pada Tes Ini</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Peringkat</th>
                                    <th>Nama</th>
                                    <th>Provinsi</th>
                                    <th>Kota</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(rankingExam, index) in rankingExams.data" :key="index">
                                    <td>
                                        <span class="badge bg-danger" v-if="index == 0 || index == 1 || index == 2"> {{ ++index + (rankingExams.current_page - 1) * rankingExams.per_page }}</span>
                                        <span class="badge bg-primary" v-else>{{ ++index + (rankingExams.current_page - 1) * rankingExams.per_page }}</span>
                                    </td>
                                    <td>{{ rankingExam.user.name }}</td>
                                    <td>{{ rankingExam.user.student.province.name }}</td>
                                    <td>{{ rankingExam.user.student.city.name }}</td>
                                    <th>{{ rankingExam.grade }}</th>
                                </tr>
                            </tbody>
                        </table>

                        <Pagination :links="rankingExams.links" align="end" />
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

    //import component pagination
    import Pagination from '../../../../Components/Pagination.vue';

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
            Pagination
        },

        // props
        props: {
            exam: Object,
            rankingExams: Object
        },
    }
</script>
