<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Data Soal</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Soal</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Data Soal</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center mb-4 gap-3">
                        <a href="#" @click.prevent="destroyQuestionTitle(questionTitle.id)" class="btn btn-danger btn-sm mt-2 mt-lg-0">Hapus Judul & Soal</a>
                        <div class="ms-auto">
                            <Link href="/admin/question-titles" class="btn btn-primary btn-sm mt-2 mt-lg-0 ms-1">Kembali</Link>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <th width="170px">Peminatan</th>
                                    <td width="10px">:</td>
                                    <td><span class="badge bg-primary">{{ (questionTitle.category && questionTitle.category.name) ?? '-' }}</span></td>
                                </tr>
                                <tr>
                                    <th>Kategori Mata Pelajaran</th>
                                    <td>:</td>
                                    <td>{{ questionTitle.lesson_category.name }}</td>
                                </tr>
                                <tr>
                                    <th>Mata Pelajaran</th>
                                    <td>:</td>
                                    <td>{{ questionTitle.lesson.name }}</td>
                                </tr>
                                <tr>
                                    <th>Judul Soal</th>
                                    <td>:</td>
                                    <td>{{ questionTitle.name }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Pilihan Ganda</th>
                                    <td>:</td>
                                    <td>{{ questionTitle.total_choices }}</td>
                                </tr>
                                <tr>
                                    <th>Total Bagian</th>
                                    <td>:</td>
                                    <td>{{ questionTitle.total_section }}</td>
                                </tr>
                                <tr v-if="questionTitle.passing_grade">
                                    <th>Nilai Ambang Batas</th>
                                    <td>:</td>
                                    <td>{{ questionTitle.passing_grade ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tambahkan Kategori Penilaian</th>
                                    <td>:</td>
                                    <td><span class="badge bg-success">{{ questionTitle.add_value_category == 0 ? 'Tidak' : 'Ya' }}</span></td>
                                </tr>
                                <tr v-if="questionTitle.add_value_category == 1">
                                    <th>Jenis Penilaian</th>
                                    <td>:</td>
                                    <td>
                                        <span v-if="questionTitle.assessment_type == 1">Dihitung Per Kategori Penilaian</span>
                                        <span v-if="questionTitle.assessment_type == 2">Dihitung Untuk Seluruh Soal (Rata-rata)</span>
                                        <span v-if="questionTitle.assessment_type == 3">Dihitung Berdasarkan Poin Jawaban Benar</span>
                                        <span v-if="questionTitle.assessment_type == 4">Dihitung Berdasarkan Bobot Jawaban</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
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
                            <a target="_blank" :href="`/admin/question-titles/${questionTitle.id}/export-excel`" class="btn btn-sm btn-success mt-lg-0"><i class="bx bxs-file"></i> Export Soal</a>
                        </div>
                        <a target="_blank" :href="`/admin/question-titles/${questionTitle.id}/format-import-excel`" class="btn btn-sm btn-primary">
                            <i class="bx bxs-file"></i> Template Import Soal
                        </a>
                        <form @submit.prevent="importExcel" class="d-flex ml-auto">
                            <div class="btn-group me-2">
                                <input type="file" @input="form.file = $event.target.files[0]" class="form-control form-control-sm me-2" required>
                            </div>
                            <div class="btn-group">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bx bxs-file"></i>  Import Soal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card" v-if="!questions.data.length">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center gap-3">
                        <div class="ms-auto">
                            <form @submit.prevent="generateQuestion" class="d-flex ml-auto">
                                <select class="form-control me-2" v-model="form.type">
                                    <option value="number">Angka Hilang</option>
                                    <option value="letter">Huruf Hilang</option>
                                    <option value="symbol">Simbol Hilang</option>
                                    <option value="number_letter">Kombinasi Angka & Huruf Hilang</option>
                                    <option value="number_symbol">Kombinasi Angka & Simbol Hilang</option>
                                    <option value="letter_symbol">Kombinasi Huruf & Simbol Hilang</option>
                                    <option value="number_letter_symbol">Kombinasi Angka, Huruf & Simbol Hilang</option>
                                </select>
                                <button type="submit" class="btn btn-danger">Generate</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center mb-4 gap-3">
                        <form @submit.prevent="handleSearch">
                            <div class="position-relative">
                                <input
                                    type="text"
                                    v-model="search"
                                    class="form-control ps-5 radius-20"
                                    placeholder="Cari Berdasarkan Soal...."
                                    size="40"
                                    maxlength="100"
                                >
                                <span class="position-absolute top-50 product-show translate-middle-y">
                                    <i class="bx bx-search"></i>
                                </span>
                            </div>
                        </form>
                        <div class="ms-auto">
                            <a href="#" @click.prevent="destroyAllQuestion(questionTitle.id)" class="btn btn-danger btn-sm"><i class="bx bx-trash"></i> Hapus Semua Soal</a>
                            <Link :href="`/admin/question-titles/${questionTitle.id}/questions/create`" class="btn btn-sm btn-primary m-2"><i class="bx bxs-plus-square"></i> Tambah Soal</Link>
                        </div>
                    </div>
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="border-0 rounded-start" style="width:5%">No.</th>
                                <th class="border-0" style="width:85%;">Soal</th>
                                <th class="border-0 rounded-end" style="width:10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(question, index) in questions.data" :key="index">
                                <td>
                                    {{ ++index + (questions.current_page - 1) * questions.per_page }}
                                </td>
                                <td>
                                    <div v-if="question.audio_input == 1 && question.audio">
                                        <audio controls>
                                            <source v-bind:src="'/storage/upload_files/questions/audio/' + question.audio" type="audio/ogg">
                                            <source v-bind:src="'/storage/upload_files/questions/audio/' + question.audio" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    </div>
                                    <div v-html="question.question" class="clearfix"></div>
                                    <br>
                                    <ol type="A" v-if="questionTitle.assessment_type == 4">
                                        <li v-if="1 <= questionTitle.total_choices" v-html="'<span class=\'badge bg-danger\'>point ' + question['point_' + 1] + '</span> <br>' + question['option_' + 1]"></li>
                                        <li v-if="2 <= questionTitle.total_choices" v-html="'<span class=\'badge bg-danger\'>point ' + question['point_' + 2] + '</span> <br>' + question['option_' + 2]"></li>
                                        <li v-if="3 <= questionTitle.total_choices" v-html="'<span class=\'badge bg-danger\'>point ' + question['point_' + 3] + '</span> <br>' + question['option_' + 3]"></li>
                                        <li v-if="4 <= questionTitle.total_choices" v-html="'<span class=\'badge bg-danger\'>point ' + question['point_' + 4] + '</span> <br>' + question['option_' + 4]"></li>
                                        <li v-if="5 <= questionTitle.total_choices" v-html="'<span class=\'badge bg-danger\'>point ' + question['point_' + 5] + '</span> <br>' + question['option_' + 5]"></li>
                                        <li v-if="6 <= questionTitle.total_choices" v-html="'<span class=\'badge bg-danger\'>point ' + question['point_' + 6] + '</span> <br>' + question['option_' + 6]"></li>
                                    </ol>
                                    <ol type="A" v-else>
                                        <li v-if="1 <= questionTitle.total_choices" v-html="question.option_1" :class="{ 'text-danger fw-bold': question.answer == 1 }"></li>
                                        <li v-if="2 <= questionTitle.total_choices" v-html="question.option_2" :class="{ 'text-danger fw-bold': question.answer == 2 }"></li>
                                        <li v-if="3 <= questionTitle.total_choices" v-html="question.option_3" :class="{ 'text-danger fw-bold': question.answer == 3 }"></li>
                                        <li v-if="4 <= questionTitle.total_choices" v-html="question.option_4" :class="{ 'text-danger fw-bold': question.answer == 4 }"></li>
                                        <li v-if="5 <= questionTitle.total_choices" v-html="question.option_5" :class="{ 'text-danger fw-bold': question.answer == 5 }"></li>
                                        <li v-if="6 <= questionTitle.total_choices" v-html="question.option_6" :class="{ 'text-danger fw-bold': question.answer == 6 }"></li>
                                    </ol>

                                    <div class="badge rounded-pill text-primary bg-light-primary p-2 text-uppercase" v-if="question.value_category">{{ question.value_category.name }}</div>
                                </td>
                                <td>
                                    <div class="d-flex order-actions">
                                        <Link :href="`/admin/question-titles/${questionTitle.id}/questions/${question.id}/edit`" class="ms-1"><i class='bx bxs-edit'></i></Link>
                                        <a href="#" @click.prevent="destroy(question.id)" class="ms-1"><i class="bx bxs-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="3" v-if="!questions.data.length">Data Tidak Tersedia</td>
                            </tr>
                        </tbody>
                    </table>

                    <Pagination :links="questions.links" align="end" />

                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->
</template>

<script>
    //import layout admin
    import LayoutAdmin from '../../../../Layouts/Layout.vue';

    import MathJax, { initMathJax, renderByMathjax } from 'mathjax-vue3'

    //import component pagination
    import Pagination from '../../../../Components/Pagination.vue';

    // import Link
    import { Link } from '@inertiajs/inertia-vue3';

    //import sweet alert2
    import Swal from 'sweetalert2';

    //import reactive
    import { reactive } from 'vue';

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
            Pagination,
            MathJax
        },

        // props
        props: {
            questions: Object,
            questionTitle: Object
        },

        mounted() {
            let recaptchaScript = document.createElement('script')
            recaptchaScript.setAttribute('src', 'https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML')
            document.head.appendChild(recaptchaScript)

            function onMathJaxReady() {
                // The parent node of need to be rendered into the formula node set
                const el = document.getElementById('elementId')
                // ❗️❗️ When there is no el will begin to render the default root node
                renderByMathjax(el)
            }

            initMathJax({}, onMathJaxReady);
        },

        // initialization composition API
        setup(props) {

            const form = reactive({
                type: 'number',
                file: '',
            });

            // submit method
            const importExcel = () => {
                Swal.fire({
                    title: 'Pastikan Format File Sesuai',
                    text: "Jika format tidak sesuai maka seluruh soal tidak akan berhasil di import.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Import'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        Inertia.post(`/admin/question-titles/${props.questionTitle.id}/import-excel`, {
                            forceFormData: true,
                            file: form.file,
                        });
                    }
                })
            }

            const generateQuestion = () => {
                // send data to server
                Inertia.post(`/admin/question-titles/${props.questionTitle.id}/questions/generate-question`, {
                    type: form.type,
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Soal Berhasil Di Generate!.',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    },
                });
            }

            // define state search
            const search = ref('' || (new URL(document.location)).searchParams.get('search'));

            // define method search
            const handleSearch = () => {
                Inertia.get(`/admin/question-titles/${props.questionTitle.id}/questions`, {
                    //send params "search" with value from state "search"
                    search: search.value,
                })
            }


            const destroyAllQuestion = (id) => {
                Swal.fire({
                    title: 'Apakah anda yakin akan menghapus seluruh soal ?',
                    text: "Anda tidak akan dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Hapus'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        Inertia.get(`/admin/question-titles/${props.questionTitle.id}/delete-question`);

                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Seluruh Soal Berhasil Dihapus!.',
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
                        Inertia.delete(`/admin/question-titles/${props.questionTitle.id}/questions/${id}`);

                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Soal Berhasil Dihapus!.',
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false,
                        });
                    }
                })
            }

            const destroyQuestionTitle = (id) => {
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

                        Inertia.delete(`/admin/question-titles/${id}`);

                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Judul Soal Berhasil Dihapus!.',
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false,
                        });
                    }
                })
            }

            return {
                search,
                form,
                handleSearch,
                destroy,
                generateQuestion,
                destroyQuestionTitle,
                importExcel,
                destroyAllQuestion
            }
        }
    }
</script>
