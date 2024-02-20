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
                            <li class="breadcrumb-item active" aria-current="page">Data Try Out</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center mb-4 gap-3">
                        <div class="ms-auto">
                            <Link href="/admin/exam-groups" class="btn btn-primary btn-sm mt-2 mt-lg-0">Kembali</Link>
                        </div>
                    </div>
                    <table class="table mb-0">
                        <tbody>
                            <tr>
                                <th width="400px">Peminatan</th>
                                <td width="10px">:</td>
                                <td><span class="badge bg-primary">{{ examGroup.category.name }}</span></td>
                            </tr>
                            <tr>
                                <th>Sub Peminatan</th>
                                <td>:</td>
                                <td>
                                    <div v-if="examGroup.sub_categories.length">
                                        <div v-for="(sub_category, index) in examGroup.sub_categories" :key="index" style="display: inline;">
                                            <span class="badge bg-danger ms-1">{{ sub_category.name }}</span>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <span>Seluruh kategori peminatan</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Kategori Member</th>
                                <td>:</td>
                                <td>
                                    <span v-if="examGroup.member_categories" v-for="member_categories in examGroup.member_categories" class="badge bg-success m-1">
                                        {{  member_categories  }}
                                    </span>
                                    <span v-else class="badge bg-danger">Untuk Seluruh Kategori Member</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Kategori Mata Pelajaran</th>
                                <td>:</td>
                                <td>{{ examGroup.lesson_category.name }}</td>
                            </tr>
                            <tr>
                                <th>Judul Try Out</th>
                                <td>:</td>
                                <td>{{ examGroup.title }}</td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td>:</td>
                                <td>
                                    <div v-html="examGroup.description"></div>
                                </td>
                            </tr>
                            <tr>
                                <th>Tipe Try Out</th>
                                <td>:</td>
                                <td>{{ examGroup.exam_group_type == 1 ? 'Tiap Tes Digabung Dalam Satu Waktu' : 'Tiap Tes Memiliki Waktunya Masing-Masing'}}</td>
                            </tr>
                            <tr v-if="examGroup.exam_group_type == 1">
                                <th>Soal Acak</th>
                                <td>:</td>
                                <td>{{ examGroup.random_question == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr v-if="examGroup.exam_group_type == 1">
                                <th>Jawaban Acak</th>
                                <td>:</td>
                                <td>{{ examGroup.random_answer == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr v-if="examGroup.exam_group_type == 1">
                                <th>Tampilkan Jawaban</th>
                                <td>:</td>
                                <td>{{ examGroup.show_answer == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr v-if="examGroup.exam_group_type == 1">
                                <th>Tampilkan Navigasi Nomor Soal</th>
                                <td>:</td>
                                <td>{{ examGroup.show_question_number_navigation == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr v-if="examGroup.exam_group_type == 1">
                                <th>Tampilkan Nomor Soal</th>
                                <td>:</td>
                                <td>{{ examGroup.show_question_number == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr v-if="examGroup.exam_group_type == 1">
                                <th>Pertanyaan Selanjutnya Secara Otomatis</th>
                                <td>:</td>
                                <td>{{ examGroup.next_question_automatically == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr v-if="examGroup.exam_group_type == 1">
                                <th>Tampilkan Button Sebelum & Selanjutnya</th>
                                <td>:</td>
                                <td>{{ examGroup.show_prev_next_button == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr v-if="examGroup.exam_group_type == 1">
                                <th>Tipe Pilihan Ganda</th>
                                <td>:</td>
                                <td>{{ examGroup.type_option == 1 ? 'Button Option dan Soal Menyatu (Normal)' : 'Button Option ke Samping dan jawaban menyatu dengan soal' }}</td>
                            </tr>
                            <tr v-if="examGroup.exam_group_type == 1">
                                <th>Tampilan Button Akhiri Ujian / Sesi Selanjutnya</th>
                                <td>:</td>
                                <td>{{ examGroup.type_option == 1 ? 'Ditampilkan Pada Setiap Soal' : 'Hanya Ditampilkan Pada Soal Terakhir' }}</td>
                            </tr>
                            <tr v-if="examGroup.exam_group_type == 1">
                                <th>Siswa Dapat Mengulangi Try Out</th>
                                <td>:</td>
                                <td>{{ examGroup.repeat_the_exam ==  1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Penilaian</th>
                                <td>:</td>
                                <td>
                                    <span v-if="examGroup.assessment_type == 1">Nilai pada tiap tes dijumlahkan</span>
                                    <span v-if="examGroup.assessment_type == 2">Persentase dari masing-masing tes</span>
                                    <span v-if="examGroup.assessment_type == 3">Nilai rata-rata dari masing-masing tes</span>
                                    <span v-if="examGroup.assessment_type == 4">Nilai pada tiap kategori tes dijumlahkan</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Tipe Nilai Minimal</th>
                                <td>:</td>
                                <td>
                                    <span v-if="examGroup.minimal_grade_type == 0">Tidak Ada Nilai Minimal</span>
                                    <span v-if="examGroup.minimal_grade_type == 1">Nilai Minimal Di Ambil Dari Ambang Batas Tiap Tes</span>
                                    <span v-if="examGroup.minimal_grade_type == 2">Nilai Minimal Ditentukan Untuk Keseluruhan Tes</span>
                                </td>
                            </tr>
                            <tr v-if="examGroup.minimal_grade_type == 2">
                                <th>Nilai Minimal Lulus</th>
                                <td>:</td>
                                <td>{{ examGroup.minimal_grade }}</td>
                            </tr>
                            <tr v-if="examGroup.minimal_grade_type != 0">
                                <th>Keterangan Nilai Kurang Dari Nilai Minimal</th>
                                <td>:</td>
                                <td>{{ examGroup.description_grade_less_than_minimal ?? '-' }}</td>
                            </tr>
                            <tr v-if="examGroup.minimal_grade_type != 0">
                                <th>Keterangan Nilai Lebih Dari Nilai Minimal</th>
                                <td>:</td>
                                <td>{{ examGroup.description_grade_more_than_minimal ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Izinkan Siswa Mencetak Hasil Ujian</th>
                                <td>:</td>
                                <td>{{ examGroup.certificate_print_user == 1 ? 'Ya' : 'Tidak' }}</td>
                            </tr>
                            <tr>
                                <th>Tipe Akses</th>
                                <td>:</td>
                                <td>
                                    <span v-if="examGroup.access_type == 'basic_member'">Basic Member</span>
                                    <span v-if="examGroup.access_type == 'standard_member'">Standard Member</span>
                                    <span v-if="examGroup.access_type == 'premium_member'">Premium Member</span>
                                </td>
                            </tr>
                            <tr v-if="examGroup.exam_group_type == 1">
                                <th>Maksimal Toleransi Keluar Tes</th>
                                <td>:</td>
                                <td>{{ examGroup.total_tolerance == null ? 'Tidak ada' : examGroup.total_tolerance + ' Kali' }}</td>
                            </tr>
                            <tr v-if="examGroup.exam_group_type == 1 && examGroup.total_tolerance != null">
                                <th>Kode Membuka Blokir</th>
                                <td>:</td>
                                <td>
                                    <div class="input-group">
                                        <input type="text" class="form form-control form-control-sm" :value="examGroup.unblock_token" disabled>
                                        <a href="#" @click.prevent="regenerateCode()" class="btn btn-primary btn-sm"><i class="bx bx-refresh"></i>Regenerate Kode</a>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="examGroup.price_before_discount">
                                <th>Harga Try Out (Sebelum Diskon)</th>
                                <td>:</td>
                                <td>
                                   {{ formatPrice(examGroup.price_before_discount) }}
                                </td>
                            </tr>
                            <tr v-if="examGroup.price_after_discount">
                                <th>Harga Try Out (Sesudah Diskon)</th>
                                <td>:</td>
                                <td>
                                    {{ formatPrice(examGroup.price_after_discount) }}
                                   
                                </td>
                            </tr>
                            <tr>
                                <th>Status Try Out</th>
                                <td>:</td>
                                <td>
                                    <span v-if="examGroup.exam_status == 'active'" class="badge bg-primary">Active</span>
                                    <span v-if="examGroup.exam_status == 'inactive'" class="badge bg-success">Inactive</span>
                                    <span v-if="examGroup.exam_status == 'inprogress'" class="badge bg-danger">Inprogress</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center mb-4 gap-3">
                        <div class="ms-auto">
                            <Link :href="`/admin/exam-groups/${examGroup.id}/exam-group-details/create`" class="btn btn-primary btn-sm mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i> Tambah Paket Soal Try Out</Link>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kategori</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Paket Soal</th>
                                    <th>Judul Try Out</th>
                                    <th>Siswa</th>
                                    <th v-if="examGroup.exam_group_type == 2">Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(exam, index) in exams.data" :key="index">
                                    <td>{{ ++index + (exams.current_page - 1) * exams.per_page }}</td>
                                    <td>{{ exam.category.name }}</td>
                                    <td>{{ exam.lesson.name }}</td>
                                    <td>{{ exam.question_title.name }}</td>
                                    <td>{{ exam.title }}</td>
                                    <td>
                                        <span class="badge bg-danger" v-if="exam.grade_finished_count == 0">0</span>
                                        <span class="badge bg-primary" v-else>{{ exam.grade_count }}</span>
                                    </td>
                                    <td v-if="examGroup.exam_group_type == 2">
                                        <span class="badge bg-primary" v-if="exam.exam_status == 'active'">Active</span>
                                        <span class="badge bg-danger" v-if="exam.exam_status == 'inactive'">Inactive</span>
                                        <span class="badge bg-warning" v-if="exam.exam_status == 'inprogress'">In Progress</span>
                                    </td>
                                    <td>
                                        <div class="d-flex order-actions">
                                            <Link :href="`/admin/exam-groups/${exam.exam_group_id}/exam-group-details/${exam.id}`" class="ms-1"><i class='bx bxs-grid-alt'></i></Link>
                                            <Link :href="`/admin/exam-groups/${exam.exam_group_id}/exam-group-details/${exam.id}/edit`" class="ms-1"><i class='bx bxs-edit'></i></Link>
                                            <a href="#" @click.prevent="destroy(exam.id)" class="ms-1"><i class="bx bxs-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" colspan="9" v-if="!exams.data.length">Data Tidak Tersedia</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <Pagination :links="exams.links" align="end" />
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
            examGroup: Object,
            exams: Object
        },

        // initialization composition API
        setup(props) {

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

                        Inertia.get(`/admin/exam-groups/${props.examGroup.id}/regenerate-block-tokens`);

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

                        Inertia.delete(`/admin/exam-groups/${props.examGroup.id}/exam-group-details/${id}`);

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

            return {
                destroy,
                regenerateCode
            }
        },
        methods: {
            formatPrice(value) {
                let val = (value/1).toFixed().replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            }
        }
    }
</script>
