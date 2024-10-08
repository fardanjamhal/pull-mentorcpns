<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Tambah Latihan Soal</title>
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
                            <li class="breadcrumb-item active" aria-current="page">Tambah Latihan Soal</li>
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
                    <form @submit.prevent="submit" class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Kategori Peminatan</label>
                            <select @change="lessonCategoryData" v-model="form.category_id" :class="{ 'is-invalid': errors.category_id }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option v-for="(category, index) in categories" :key="index" :value="category.id">{{ category.name }}</option>
                            </select>
                            <div v-if="errors.category_id" class="invalid-feedback">
                                {{ errors.category_id }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Sub Kategori Peminatan</label>
                            <multiselect
                                v-model="form.sub_category_ids"
                                :options="form.subCategories"
                                :multiple="true"
                                label="name"
                                :close-on-select="true"
                                :allow-empty="true"
                                track-by="id"
                                placeholder="[ Pilih ]"
                            ></multiselect>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Kategori Member (Khusus Untuk Membership Bulanan, Kosongkan Jika Tidak Ada)</label>
                            <multiselect
                                v-model="form.member_categories"
                                :options="memberCategories"
                                :multiple="true"
                                label="name"
                                :close-on-select="true"
                                :allow-empty="true"
                                track-by="name"
                                placeholder="[ Pilih ]"
                            ></multiselect>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Kategori Mata Pelajaran</label>
                            <select @change="lessonData" v-model="form.lesson_category_id" :class="{ 'is-invalid': errors.lesson_category_id }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option v-for="lessonCategory in form.lessonCategories" :value="lessonCategory.id">{{ lessonCategory.name }}</option>
                            </select>
                            <div v-if="errors.lesson_category_id" class="invalid-feedback">
                                {{ errors.lesson_category_id }}
                            </div>
                        </div>

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
                            <label class="form-label">Judul Latihan Soal</label>
                            <input type="text" class="form-control" v-model="form.title" :class="{ 'is-invalid': errors.title }" placeholder="Nama">
                            <div v-if="errors.title" class="invalid-feedback">
                                {{ errors.title }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Deskripsi Latihan Soal</label>
                            <Editor
                                api-key="78gw58jnh98gnhix73b37osdkyoq9njwvzgo05s9sjyf9a55"
                                v-model="form.description"
                                :init="{
                                    images_upload_url: '/upload',
                                    automatic_uploads: true,
                                    height: 400,
                                    plugins: [
                                        'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                                        'searchreplace wordcount visualblocks visualchars code fullscreen',
                                        'insertdatetime media nonbreaking save table contextmenu directionality',
                                        'emoticons template paste textcolor colorpicker textpattern imagetools'
                                    ],
                                    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor emoticons',
                                    image_advtab: true,
                                }"
                            />
                            <div v-if="errors.description">
                                {{ errors.description }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Durasi Latihan Soal (Menit)</label>
                            <input type="number" class="form-control" v-model="form.duration" :class="{ 'is-invalid': errors.duration }" placeholder="Durasi">
                            <div v-if="errors.duration" class="invalid-feedback">
                                {{ errors.duration }}
                            </div>
                        </div>

                        <div class="col-12">
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

                        <div class="col-12">
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

                        <div class="col-12">
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

                        <div class="col-12">
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

                        <div class="col-12">
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

                        <div class="col-12">
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

                        <div class="col-12">
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

                        <div class="col-12">
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

                        <div class="col-12">
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

                        <div class="col-12">
                            <label class="form-label">Siswa Dapat Mengulangi Latihan Soal</label>
                            <select v-model="form.repeat_the_exam" :class="{ 'is-invalid': errors.repeat_the_exam }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="0">Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                            <div v-if="errors.repeat_the_exam" class="invalid-feedback">
                                {{ errors.repeat_the_exam }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Maksimal Toleransi Keluar Tes (Kosongkan Jika Tidak Ada)</label>
                            <input type="number" class="form-control" v-model="form.total_tolerance" :class="{ 'is-invalid': errors.total_tolerance }" placeholder="Maksimal Toleransi Keluar Tes" min="0">
                            <div v-if="errors.total_tolerance" class="invalid-feedback">
                                {{ errors.total_tolerance }}
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
                      
                        <div class="col-12">
                            <label class="form-label">Harga Latihan Soal (Sebelum Diskon)</label>
                            <input type="number" class="form-control" v-model="form.price_before_discount" :class="{ 'is-invalid': errors.price_before_discount }" placeholder="Harga Latihan Soal (Sebelum Diskon)" min="0">
                            <div v-if="errors.price_before_discount" class="invalid-feedback">
                                {{ errors.price_before_discount }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Harga Latihan Soal (Sesudah Diskon)</label>
                            <input type="number" class="form-control" v-model="form.price_after_discount" :class="{ 'is-invalid': errors.price_after_discount }" placeholder="Harga Latihan Soal (Sesudah Diskon)" min="0">
                            <div v-if="errors.price_after_discount" class="invalid-feedback">
                                {{ errors.price_after_discount }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Status Latihan Soal</label>
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

    import Multiselect from '@suadelabs/vue3-multiselect'

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
            Editor,
            Multiselect
        },

        //props
        props: {
            errors: Object,
            categories: Object,
            memberCategories: Object
        },

        // initialization composition API
        setup() {
            const form = reactive({
                category_id: '',
                lesson_category_id: '',
                lesson_id: '',
                question_title_id: '',
                title: '',
                description: '',
                duration: '',
                random_question: '',
                random_answer: '',
                show_answer: '',
                show_question_number_navigation: '',
                show_question_number: '',
                next_question_automatically: '',
                show_prev_next_button: '',
                type_option: '',
                button_type_finish: '',
                access_type: '',
                repeat_the_exam: '',
                exam_status: '',
                show_answer_discussion: '',
                total_tolerance: '',
                price_before_discount: '',
                price_after_discount: '',
                member_categories: '',

                sub_category_ids: [],

                // get form API
                lessonCategories: [],
                lessons: [],
                questionTitles: [],
                subCategories: []
            });

            const lessonCategoryData = () => {
                form.lesson_category_id = '';
                form.lesson_id = '';
                form.question_title_id = '';
                
                axios.get(`/admin/categories/${form.category_id}/lesson-categories`).then(response => {
                form.lessonCategories = response.data;
                }).catch(error => console.error(error));

                axios.get(`/admin/categories/${form.category_id}/sub-categories`).then(response => {
                form.sub_category_ids = [];
                form.subCategories = response.data;
                }).catch(error => console.error(error));
            }

            const lessonData = () => {
                form.lesson_id = '';
                form.question_title_id = '';
                axios.get(`/admin/lesson-categories/${form.lesson_category_id}/lessons`).then(response => {
                form.lessons = response.data;
                }).catch(error => console.error(error));
            }

            const questionTitleData = () => {
                form.question_title_id = '';
                axios.get(`/admin/lessons/${form.lesson_id}/question-titles`).then(response => {
                form.questionTitles = response.data;
                }).catch(error => console.error(error));
            }

            // submit method
            const submit = () => {
                // send data to server
                Inertia.post('/admin/exams', {
                    // data
                    category_id: form.category_id,
                    lesson_category_id: form.lesson_category_id,
                    lesson_id: form.lesson_id,
                    question_title_id: form.question_title_id,
                    title: form.title,
                    description: form.description,

                    duration: form.duration,
                    random_question: form.random_question,
                    random_answer: form.random_answer,
                    show_answer: form.show_answer,
                    show_question_number_navigation: form.show_question_number_navigation,
                    show_question_number: form.show_question_number,
                    next_question_automatically: form.next_question_automatically,
                    show_prev_next_button: form.show_prev_next_button,
                    type_option: form.type_option,
                    button_type_finish: form.button_type_finish,

                    access_type: form.access_type,
                    repeat_the_exam: form.repeat_the_exam,
                    show_answer_discussion: form.show_answer_discussion,
                    exam_status: form.exam_status,
                    total_tolerance: form.total_tolerance,
                    price_before_discount: form.price_before_discount,
                    price_after_discount: form.price_after_discount,
                    sub_category_ids: form.sub_category_ids,
                    member_categories: form.member_categories

                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Latihan Soal Berhasil Disimpan!.',
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
                lessonCategoryData,
                lessonData,
                questionTitleData
            }
        }
    }
</script>

<style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css"></style>
