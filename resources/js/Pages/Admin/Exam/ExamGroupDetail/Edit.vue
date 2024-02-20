<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Tambah Try Out</title>
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
                            <li class="breadcrumb-item active" aria-current="page">Tambah Try Out</li>
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
                    <!-- {{ $page.props.session.failed }}
                    {{ errors }} -->
                    <form @submit.prevent="submit" class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Mata Pelajaran</label>
                            <select @change="questionTitleData" v-model="form.lesson_id" :class="{ 'is-invalid': errors.lesson_id }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option v-for="lesson in form.lessons" :value="lesson.id">{{ lesson.name }}</option>
                            </select>
                            <div v-if="errors.lesson_id" class="invalid-feedback">
                                {{ errors.lesson_id }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Paket Soal</label>
                            <select v-model="form.question_title_id" :class="{ 'is-invalid': errors.question_title_id }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option v-for="questionTitle in form.questionTitles" :value="questionTitle.id">{{ questionTitle.name }}</option>
                            </select>
                            <div v-if="errors.question_title_id" class="invalid-feedback">
                                {{ errors.question_title_id }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Judul Try Out</label>
                            <input type="text" class="form-control" v-model="form.title" :class="{ 'is-invalid': errors.title }" placeholder="Judul">
                            <div v-if="errors.title" class="invalid-feedback">
                                {{ errors.title }}
                            </div>
                        </div>
                        <div class="col-12" v-if="examGroup.exam_group_type == 2">
                            <label class="form-label">Durasi Try Out (Menit)</label>
                            <input type="number" class="form-control" v-model="form.duration" :class="{ 'is-invalid': errors.duration }" placeholder="Durasi">
                            <div v-if="errors.duration" class="invalid-feedback">
                                {{ errors.duration }}
                            </div>
                        </div>
                        <div class="col-12" v-if="examGroup.exam_group_type == 2">
                            <label class="form-label">Soal Acak</label>
                            <select v-model="form.random_question" :class="{ 'is-invalid': errors.random_question }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                            <div v-if="errors.random_question" class="invalid-feedback">
                                {{ errors.random_question }}
                            </div>
                        </div>
                        <div class="col-12" v-if="examGroup.exam_group_type == 2">
                            <label class="form-label">Jawaban Acak</label>
                            <select v-model="form.random_answer" :class="{ 'is-invalid': errors.random_answer }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                            <div v-if="errors.random_answer" class="invalid-feedback">
                                {{ errors.random_answer }}
                            </div>
                        </div>
                        <div class="col-12" v-if="examGroup.exam_group_type == 2">
                            <label class="form-label">Tampilkan Jawaban Pilihan Ganda</label>
                            <select v-model="form.show_answer" :class="{ 'is-invalid': errors.show_answer }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                            <div v-if="errors.show_answer" class="invalid-feedback">
                                {{ errors.show_answer }}
                            </div>
                        </div>
                        <div class="col-12" v-if="examGroup.exam_group_type == 2">
                            <label class="form-label">Tampilkan Navigasi Nomor Soal</label>
                            <select v-model="form.show_question_number_navigation" :class="{ 'is-invalid': errors.show_question_number_navigation }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                            <div v-if="errors.show_question_number_navigation" class="invalid-feedback">
                                {{ errors.show_question_number_navigation }}
                            </div>
                        </div>
                        <div class="col-12" v-if="examGroup.exam_group_type == 2">
                            <label class="form-label">Tampilkan Nomor Soal</label>
                            <select v-model="form.show_question_number" :class="{ 'is-invalid': errors.show_question_number }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                            <div v-if="errors.show_question_number" class="invalid-feedback">
                                {{ errors.show_question_number }}
                            </div>
                        </div>
                        <div class="col-12" v-if="examGroup.exam_group_type == 2">
                            <label class="form-label">Pertanyaan Selanjutnya Secara Otomatis</label>
                            <select v-model="form.next_question_automatically" :class="{ 'is-invalid': errors.next_question_automatically }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                            <div v-if="errors.next_question_automatically" class="invalid-feedback">
                                {{ errors.next_question_automatically }}
                            </div>
                        </div>
                        <div class="col-12" v-if="examGroup.exam_group_type == 2">
                            <label class="form-label">Tampilkan Button Sebelum & Selanjutnya</label>
                            <select v-model="form.show_prev_next_button" :class="{ 'is-invalid': errors.show_prev_next_button }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                            <div v-if="errors.show_prev_next_button" class="invalid-feedback">
                                {{ errors.show_prev_next_button }}
                            </div>
                        </div>
                        <div class="col-12" v-if="examGroup.exam_group_type == 2">
                            <label class="form-label">Tipe Pilihan Ganda</label>
                            <select v-model="form.type_option" :class="{ 'is-invalid': errors.type_option }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="1">Button Option dan Soal Menyatu (Normal)</option>
                                <option value="2">Button Option ke Samping dan jawaban menyatu dengan soal (kecermatan)</option>
                            </select>
                            <div v-if="errors.type_option" class="invalid-feedback">
                                {{ errors.type_option }}
                            </div>
                        </div>
                        <div class="col-12" v-if="examGroup.exam_group_type == 2">
                            <label class="form-label">Tampilan Button Akhiri Ujian / Sesi Selanjutnya</label>
                            <select v-model="form.button_type_finish" :class="{ 'is-invalid': errors.button_type_finish }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="1">Ditampilkan Pada Setiap Soal</option>
                                <option value="2">Hanya Ditampilkan Pada Soal Terakhir</option>
                            </select>
                            <div v-if="errors.button_type_finish" class="invalid-feedback">
                                {{ errors.button_type_finish }}
                            </div>
                        </div>
                        <div class="col-12" v-if="examGroup.exam_group_type == 2">
                            <label class="form-label">Siswa Dapat Mengulangi Try Out</label>
                            <select v-model="form.repeat_the_exam" :class="{ 'is-invalid': errors.repeat_the_exam }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="0">Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                            <div v-if="errors.repeat_the_exam" class="invalid-feedback">
                                {{ errors.repeat_the_exam }}
                            </div>
                        </div>
                        <div class="col-12" v-if="examGroup.exam_group_type == 2">
                            <label class="form-label">Maksimal Toleransi Keluar Tes (Kosongkan Jika Tidak Ada)</label>
                            <input type="number" class="form-control" v-model="form.total_tolerance" :class="{ 'is-invalid': errors.total_tolerance }" placeholder="Maksimal Toleransi">
                            <div v-if="errors.total_tolerance" class="invalid-feedback">
                                {{ errors.total_tolerance }}
                            </div>
                        </div>
                        <div class="col-12" v-if="examGroup.assessment_type == 2">
                            <label class="form-label">Persentase Nilai Yang Diambil Dari Tes (%)</label>
                            <input type="number" class="form-control" v-model="form.percentage_grade" :class="{ 'is-invalid': errors.percentage_grade }" placeholder="Persentase">
                            <div v-if="errors.percentage_grade" class="invalid-feedback">
                                {{ errors.percentage_grade }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Tampilkan Koreksi Jawaban & Pembahasan</label>
                            <select v-model="form.show_answer_discussion" :class="{ 'is-invalid': errors.show_answer_discussion }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="0">Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                            <div v-if="errors.show_answer_discussion" class="invalid-feedback">
                                {{ errors.show_answer_discussion }}
                            </div>
                        </div>
                        <div class="col-12" v-if="examGroup.exam_group_type == 2">
                            <label class="form-label">Status Try Out</label>
                            <select v-model="form.exam_status" :class="{ 'is-invalid': errors.exam_status }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="active">Aktive</option>
                                <option value="inactive">Inactive</option>
                                <option value="inprogress">Inprogress</option>
                            </select>
                            <div v-if="errors.exam_status" class="invalid-feedback">
                                {{ errors.exam_status }}
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-sm px-5">Submit</button>
                        </div>
                    </form>
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

    //import tinyMCE
    import Editor from '@tinymce/tinymce-vue';

    //import axios
    import axios from 'axios';

    export default {
        // layout
        layout: LayoutAdmin,

        // register components
        components: {
            Link,
            Head,
            Editor
        },

        //props
        props: {
            errors: Object,
            categories: Object,
            examGroup: Object,
            exam: Object,
        },

        // initialization composition API
        setup(props) {
            const form = reactive({
                exam_group_id: props.examGroup.id,
                category_id: props.examGroup.category_id,
                lesson_category_id: props.examGroup.lesson_category_id,
                assessment_type: props.examGroup.assessment_type,
                exam_group_type: props.examGroup.exam_group_type,
                lesson_id: props.exam.lesson_id,
                question_title_id: props.exam.question_title_id,
                title: props.exam.title,
                duration: props.exam.duration,
                access_type: props.examGroup.category_id,
                random_question: props.exam.random_question,
                random_answer: props.exam.random_answer,
                show_answer: props.exam.show_answer,
                show_question_number_navigation: props.exam.show_question_number_navigation,
                percentage_grade: props.exam.percentage_grade,
                show_question_number: props.exam.show_question_number,
                next_question_automatically: props.exam.next_question_automatically,
                show_prev_next_button: props.exam.show_prev_next_button,
                type_option: props.exam.type_option,
                button_type_finish: props.exam.button_type_finish,
                repeat_the_exam: props.exam.repeat_the_exam,
                show_answer_discussion: props.exam.show_answer_discussion,
                exam_status: props.exam.exam_status,
                total_tolerance: props.exam.total_tolerance,

                // get form API
                lessons: [],
                questionTitles: [],
            });

            // get lesson by lesson category id
            axios.get(`/admin/lesson-categories/${props.examGroup.lesson_category_id}/lessons`).then(response => {
                form.lessons = response.data;
            }).catch(error => console.error(error));

            // get question title by lesson id
            axios.get(`/admin/lessons/${form.lesson_id}/question-titles`).then(response => {
                form.questionTitles = response.data;
            }).catch(error => console.error(error));

            const questionTitleData = () => {
                form.question_title_id = '';
                axios.get(`/admin/lessons/${form.lesson_id}/question-titles`).then(response => {
                form.questionTitles = response.data;
                }).catch(error => console.error(error));
            }

            // submit method
            const submit = () => {
                // send data to server
                Inertia.put(`/admin/exam-groups/${props.examGroup.id}/exam-group-details/${props.exam.id}`, {
                    // data
                    exam_group_id: props.examGroup.id,
                    category_id: props.examGroup.category_id,
                    lesson_category_id: props.examGroup.lesson_category_id,
                    assessment_type: props.examGroup.assessment_type,
                    exam_group_type: props.examGroup.exam_group_type,
                    percentage_grade: form.percentage_grade,
                    lesson_id: form.lesson_id,
                    question_title_id: form.question_title_id,
                    title: form.title,
                    duration: form.duration,
                    access_type: props.examGroup.category_id,
                    random_question: form.random_question,
                    random_answer: form.random_answer,
                    show_answer: form.show_answer,
                    show_question_number_navigation: form.show_question_number_navigation,
                    show_question_number: form.show_question_number,
                    next_question_automatically: form.next_question_automatically,
                    show_prev_next_button: form.show_prev_next_button,
                    type_option: form.type_option,
                    button_type_finish: form.button_type_finish,
                    exam_status: form.exam_status,
                    show_answer_discussion: form.show_answer_discussion,
                    repeat_the_exam: form.repeat_the_exam,
                    total_tolerance: form.total_tolerance,
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Try Out Berhasil Disimpan!.',
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
                questionTitleData
            }
        }
    }
</script>
