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
                            <Link :href="`/admin/exam-groups/${examGroup.id}/exam-group-details`" class="btn btn-primary btn-sm mt-2 mt-lg-0">Kembali</Link>
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
                            <tr v-if="examGroup.exam_group_type == 2">
                                <th>Durasi</th>
                                <td>:</td>
                                <td>{{ exam.duration }} Menit</td>
                            </tr>
                            <tr v-if="examGroup.exam_group_type == 2">
                                <th>Soal Acak</th>
                                <td>:</td>
                                <td>{{ exam.random_question == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr v-if="examGroup.exam_group_type == 2">
                                <th>Jawaban Acak</th>
                                <td>:</td>
                                <td>{{ exam.random_answer == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr v-if="examGroup.exam_group_type == 2">
                                <th>Tampilkan Jawaban</th>
                                <td>:</td>
                                <td>{{ exam.show_answer == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr v-if="examGroup.exam_group_type == 2">
                                <th>Tampilkan Navigasi Nomor Soal</th>
                                <td>:</td>
                                <td>{{ exam.show_question_number_navigation == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr v-if="examGroup.exam_group_type == 2">
                                <th>Tampilkan Nomor Soal</th>
                                <td>:</td>
                                <td>{{ exam.show_question_number == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr v-if="examGroup.exam_group_type == 2">
                                <th>Pertanyaan Berikutnya Secara Otomatis</th>
                                <td>:</td>
                                <td>{{ exam.next_question_automatically == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr v-if="examGroup.exam_group_type == 2">
                                <th>Tampilkan Button Sebelum & Selanjutnya</th>
                                <td>:</td>
                                <td>{{ exam.show_prev_next_button == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr v-if="examGroup.exam_group_type == 2">
                                <th>Tipe Pilihan Ganda</th>
                                <td>:</td>
                                <td>{{ exam.type_option ==  1 ? 'Button option dan soal menyatu (Normal)' : 'Button option ke samping & jawaban menyatu dengan soal (kecermatan)'}}</td>
                            </tr>
                            <tr v-if="examGroup.exam_group_type == 2">
                                <th>Tampilan Button Akhiri Ujian / Sesi Selanjutnya</th>
                                <td>:</td>
                                <td>{{ examGroup.type_option == 1 ? 'Ditampilkan Pada Setiap Soal' : 'Hanya Ditampilkan Pada Soal Terakhir' }}</td>
                            </tr>
                            <tr v-if="examGroup.exam_group_type == 2">
                                <th>Siswa Dapat Mengulangi Try Out</th>
                                <td>:</td>
                                <td>{{ exam.repeat_the_exam ==  1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr v-if="examGroup.exam_group_type == 2 && examGroup.assessment_type == 2">
                                <th>Persentase Nilai Yang Diambil Dari Tes</th>
                                <td>:</td>
                                <td>{{ exam.percentage_grade }}%</td>
                            </tr>
                            <tr  v-if="examGroup.exam_group_type == 2">
                                <th>Maksimal Toleransi Keluar Tes</th>
                                <td>:</td>
                                <td>{{ exam.total_tolerance == null ? 'Tidak ada' : exam.total_tolerance + ' Kali' }}</td>
                            </tr>
                            <tr v-if="examGroup.exam_group_type == 2 && exam.total_tolerance != null">
                                <th>Kode Membuka Blokir</th>
                                <td>:</td>
                                <td>
                                    <div class="input-group">
                                        <input type="text" class="form form-control form-control-sm" :value="exam.unblock_token" disabled>
                                        <a href="#" @click.prevent="regenerateCode()" class="btn btn-primary btn-sm"><i class="bx bx-refresh"></i>Regenerate Kode</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Tampilkan Koreksi Jawaban & Pembahasan</th>
                                <td>:</td>
                                <td>{{ exam.show_answer_discussion == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div class="text-start">
                            <h5 class="mb-0">Hasil Latihan Soal</h5>
                        </div>
                        
                        <div class="text-end">
                            <a :href="`/admin/exam-groups/${examGroup.id}/exam-group-details/${exam.id}/export-pdf`" target="_blank" class="btn btn-danger btn-sm m-1">Export PDF</a>
                            <a :href="`/admin/exam-groups/${examGroup.id}/exam-group-details/${exam.id}/export-excel`" target="_blank" class="btn btn-success btn-sm m-1">Export Excel</a>
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
                                    <th>Status</th>
                                    <th>Nilai</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td align="center" colspan="7" v-if="!rankingExams.data.length">Data Ranking kosong</td>
                                </tr>
                                <tr v-for="(rankingExam, index) in rankingExams.data" :key="index">
                                    <td>
                                        <span class="badge bg-primary">{{ ++index + (rankingExams.current_page - 1) * rankingExams.per_page }}</span>
                                    </td>
                                    <td>{{ rankingExam.user.name }}</td>
                                    <td>{{ rankingExam.user.student && rankingExam.user.student.province ? rankingExam.user.student.province.name :  '-' }}</td>
                                    <td>{{ rankingExam.user.student && rankingExam.user.student.city ? rankingExam.user.student.city.name :  '-' }}</td>
                                    <th>
                                        <span class="badge bg-primary" v-if="rankingExam.is_finished == 1">Selesai Mengerjakan</span>
                                        <span class="badge bg-danger" v-else>Belum Selesai Mengerjakan</span>
                                    </th>
                                    <th>{{ rankingExam.grade }}</th>
                                    <th>
                                        <div class="d-flex order-actions">
                                            <a href="#" @click.prevent="destroy(rankingExam.id)" class="ms-1"><i class="bx bxs-trash"></i></a>
                                        </div>
                                    </th>
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

    //import sweet alert2
    import Swal from 'sweetalert2';

    import { Inertia } from '@inertiajs/inertia';

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
            examGroup: Object,
            exam: Object,
            rankingExams: Object
        },
        setup(props) {
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

                        Inertia.delete(`/admin/exams/grades/${id}/destroy`);

                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Ujian Berhasil Dihapus!.',
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false,
                        });
                    }
                })
            }

            const regenerateCode = () => {
                Swal.fire({
                    title: 'Generarate Kode Baru !',
                    text: "Apakah Anda Yakin Akan Generate Kode Baru ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Generate Kode'
                })
                .then((result) => {
                    if (result.isConfirmed) {

                        Inertia.get(`/admin/exams/${props.exam.id}/regenerate-block-tokens`);

                        Swal.fire({
                            title: 'Success!',
                            text: 'Kode Berhasil Diperbarui.',
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false,
                        });
                    }
                })
            }

            return {
                destroy,
                regenerateCode,
            }
        }
    }
</script>
