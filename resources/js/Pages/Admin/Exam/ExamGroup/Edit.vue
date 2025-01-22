<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Edit Try Out</title>
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
                            <li class="breadcrumb-item active" aria-current="page">Edit Try Out</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center">
                        <div class="ms-auto">
                            <Link href="/admin/exam-groups" class="btn btn-primary btn-sm mt-2 mt-lg-0">Kembali</Link>
                        </div>
                    </div>
                    <form @submit.prevent="submit" class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Kategori Peminatan</label>
                            <select  @change="lessonCategoryData" v-model="form.category_id" :class="{ 'is-invalid': errors.category_id }" class="form-select" disabled>
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
                            <label class="form-label">Judul Try Out</label>
                            <input type="text" class="form-control" v-model="form.title" :class="{ 'is-invalid': errors.title }" placeholder="Nama">
                            <div v-if="errors.title" class="invalid-feedback">
                                {{ errors.title }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Deskripsi Try Out</label>
                            <Editor
                                api-key="z0orjv2sirc3srvbm5cveadi07v3y2i0voly8s87wdik0l0r"
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
                            <label class="form-label">Tipe Try Out</label>
                            <select v-model="form.exam_group_type" :class="{ 'is-invalid': errors.exam_group_type }" class="form-select" disabled>
                                <option value="">[ Pilih ]</option>
                                <option value="1">Tiap Tes Digabung Dalam Satu Waktu</option>
                                <option value="2">Tiap Tes Memiliki Waktunya Masing-Masing</option>
                            </select>
                            <div v-if="errors.exam_group_type" class="invalid-feedback">
                                {{ errors.exam_group_type }}
                            </div>
                        </div>

                        <div class="col-12" v-if="form.exam_group_type == 1">
                            <label class="form-label">Durasi Try Out (Menit)</label>
                            <input type="number" class="form-control" v-model="form.duration" :class="{ 'is-invalid': errors.duration }" placeholder="Durasi">
                            <div v-if="errors.duration" class="invalid-feedback">
                                {{ errors.duration }}
                            </div>
                        </div>

                        <div class="col-12" v-if="form.exam_group_type == 1">
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

                        <div class="col-12" v-if="form.exam_group_type == 1">
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

                        <div class="col-12" v-if="form.exam_group_type == 1">
                            <label class="form-label">Tampilkan Jawaban</label>
                            <select v-model="form.show_answer" :class="{ 'is-invalid': errors.show_answer }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                            <div v-if="errors.show_answer" class="invalid-feedback">
                                {{ errors.show_answer }}
                            </div>
                        </div>

                        <div class="col-12" v-if="form.exam_group_type == 1">
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

                        <div class="col-12" v-if="form.exam_group_type == 1">
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

                        <div class="col-12" v-if="form.exam_group_type == 1">
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

                        <div class="col-12" v-if="form.exam_group_type == 1">
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

                        <div class="col-12" v-if="form.exam_group_type == 1">
                            <label class="form-label">Tipe Pilihan Ganda</label>
                            <select v-model="form.type_option" :class="{ 'is-invalid': errors.type_option }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="1">Button Option dan Soal Menyatu (Normal)</option>
                                <option value="2">Button Option ke Samping dan jawaban menyatu dengan soal</option>
                            </select>
                            <div v-if="errors.type_option" class="invalid-feedback">
                                {{ errors.type_option }}
                            </div>
                        </div>

                        <div class="col-12" v-if="form.exam_group_type == 1">
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

                        <div class="col-12" v-if="form.exam_group_type == 1">
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

                        <div class="col-12">
                            <label class="form-label">Jenis Penilaian</label>
                            <select v-model="form.assessment_type" :class="{ 'is-invalid': errors.assessment_type }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="1">Nilai pada tiap tes dijumlahkan</option>
                                <option value="2">Persentase dari masing-masing tes</option>
                                <option value="3">Nilai rata-rata dari masing-masing tes</option>
                                <option value="4">Nilai pada tiap kategori tes dijumlahkan</option>
                            </select>
                            <div v-if="errors.assessment_type" class="invalid-feedback">
                                {{ errors.assessment_type }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Tipe Nilai Minimal</label>
                            <select v-model="form.minimal_grade_type" :class="{ 'is-invalid': errors.minimal_grade_type }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="0">Tidak Ada Nilai Minimal</option>
                                <option value="1">Nilai Minimal Di Ambil Dari Ambang Batas Tiap Tes</option>
                                <option value="2">Nilai Minimal Ditentukan Untuk Keseluruhan Tes</option>
                            </select>
                            <div v-if="errors.minimal_grade_type" class="invalid-feedback">
                                {{ errors.minimal_grade_type }}
                            </div>
                        </div>

                        <div class="col-12" v-if="form.minimal_grade_type == 2">
                            <label class="form-label">Nilai Minimal Lulus</label>
                            <input type="text" class="form-control" v-model="form.minimal_grade" :class="{ 'is-invalid': errors.minimal_grade }" placeholder="Nilai Minimal Lulus">
                            <div v-if="errors.minimal_grade" class="invalid-feedback">
                                {{ errors.minimal_grade }}
                            </div>
                        </div>

                        <div class="col-12" v-if="form.minimal_grade_type == 1 || form.minimal_grade_type == 2">
                            <label class="form-label">Keterangan Nilai Kurang Dari Nilai Minimal</label>
                            <input type="text" class="form-control" v-model="form.description_grade_less_than_minimal" :class="{ 'is-invalid': errors.description_grade_less_than_minimal }" placeholder="Keterangan Nilai < Nilai Minimal">
                            <div v-if="errors.description_grade_less_than_minimal" class="invalid-feedback">
                                {{ errors.description_grade_less_than_minimal }}
                            </div>
                        </div>

                        <div class="col-12" v-if="form.minimal_grade_type == 1 || form.minimal_grade_type == 2">
                            <label class="form-label">Keterangan Nilai Lebih Dari Nilai Minimal</label>
                            <input type="text" class="form-control" v-model="form.description_grade_more_than_minimal" :class="{ 'is-invalid': errors.description_grade_more_than_minimal }" placeholder="Keterangan Nilai > Nilai Minimal">
                            <div v-if="errors.description_grade_more_than_minimal" class="invalid-feedback">
                                {{ errors.description_grade_more_than_minimal }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Nilai Minimal Yang Ditampilkan (Kosongkan Jika Tidak Ada)</label>
                            <input type="number" class="form-control" v-model="form.smallest_value_limit" :class="{ 'is-invalid': errors.smallest_value_limit }" placeholder="Nilai Minimal Yang Ditampilkan">
                            <div v-if="errors.smallest_value_limit" class="invalid-feedback">
                                {{ errors.smallest_value_limit }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Nilai Maksimal Yang Ditampilkan (Kosongkan Jika Tidak Ada)</label>
                            <input type="number" class="form-control" v-model="form.biggest_value_limit" :class="{ 'is-invalid': errors.biggest_value_limit }" placeholder="Nilai Maksimal Yang Ditampilkan">
                            <div v-if="errors.biggest_value_limit" class="invalid-feedback">
                                {{ errors.biggest_value_limit }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Izinkan Siswa Mencetak Hasil Ujian</label>
                            <select v-model="form.certificate_print_user" :class="{ 'is-invalid': errors.certificate_print_user }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="0">Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                            <div v-if="errors.certificate_print_user" class="invalid-feedback">
                                {{ errors.certificate_print_user }}
                            </div>
                        </div>

                        <div class="col-12" v-if="form.exam_group_type == 1">
                            <label class="form-label">Maksimal Toleransi Keluar Tes (Kosongkan Jika Tidak Ada)</label>
                            <input type="number" class="form-control" v-model="form.total_tolerance" :class="{ 'is-invalid': errors.total_tolerance }" placeholder="Maksimal Toleransi Keluar Tes">
                            <div v-if="errors.total_tolerance" class="invalid-feedback">
                                {{ errors.total_tolerance }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Harga TryOut (Sebelum Diskon)</label>
                            <input type="number" class="form-control" v-model="form.price_before_discount" :class="{ 'is-invalid': errors.price_before_discount }" placeholder="Harga TryOut (Sebelum Diskon)" min="0">
                            <div v-if="errors.price_before_discount" class="invalid-feedback">
                                {{ errors.price_before_discount }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Harga TryOut (Sesudah Diskon)</label>
                            <input type="number" class="form-control" v-model="form.price_after_discount" :class="{ 'is-invalid': errors.price_after_discount }" placeholder="Harga TryOut (Sesudah Diskon)" min="0">
                            <div v-if="errors.price_after_discount" class="invalid-feedback">
                                {{ errors.price_after_discount }}
                            </div>
                        </div>

                        <div class="col-12">
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

    //import axios
    import axios from 'axios';

    //import tinyMCE
    import Editor from '@tinymce/tinymce-vue';

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
            examGroup: Object,
            subCategories: Object,
            memberCategories: Object,
        },

        // initialization composition API
        setup(props) {
            const form = reactive({
                category_id: props.examGroup.category_id,
                lesson_category_id: props.examGroup.lesson_category_id,
                title: props.examGroup.title,
                description: props.examGroup.description,

                exam_group_type: props.examGroup.exam_group_type ?? '', 
                duration: props.examGroup.duration ?? '',
                random_question: props.examGroup.random_question ?? '',
                random_answer: props.examGroup.random_answer ?? '',
                show_answer: props.examGroup.show_answer ?? '',
                show_question_number_navigation: props.examGroup.show_question_number_navigation ?? '',
                show_question_number: props.examGroup.show_question_number ?? '',
                next_question_automatically: props.examGroup.next_question_automatically ?? '',
                show_prev_next_button: props.examGroup.show_prev_next_button ?? '',
                type_option: props.examGroup.type_option ?? '',
                button_type_finish: props.examGroup.button_type_finish ?? '',
                repeat_the_exam: props.examGroup.repeat_the_exam ?? '',
                total_tolerance: props.examGroup.total_tolerance ?? '',
                smallest_value_limit: props.examGroup.smallest_value_limit ?? '',
                biggest_value_limit: props.examGroup.biggest_value_limit ?? '',

                assessment_type: props.examGroup.assessment_type,
                minimal_grade_type: props.examGroup.minimal_grade_type,
                minimal_grade: props.examGroup.minimal_grade ?? '',
                description_grade_less_than_minimal: props.examGroup.description_grade_less_than_minimal ?? '',
                description_grade_more_than_minimal: props.examGroup.description_grade_more_than_minimal ?? '',
                certificate_print_user: props.examGroup.certificate_print_user,
                exam_status: props.examGroup.exam_status,
                price_before_discount: props.examGroup.price_before_discount,
                price_after_discount: props.examGroup.price_after_discount,
                member_categories: !props.examGroup.member_categories ? [] : props.examGroup.member_categories.map(item => {
                    return { 'name': item };
                }),

                sub_category_ids: props.subCategories,

                // get form API
                lessonCategories: [],
                subCategories: []
            });

            // get lesson category by category id
            axios.get(`/admin/categories/${form.category_id}/lesson-categories`).then(response => {
            form.lessonCategories = response.data;
            }).catch(error => console.error(error));

            // get sub category by category id
            axios.get(`/admin/categories/${form.category_id}/sub-categories`).then(response => {
            form.subCategories = response.data;
            }).catch(error => console.error(error));

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

            // submit method
            const submit = () => {
                // send data to server
                Inertia.put(`/admin/exam-groups/${props.examGroup.id}`, {
                    // data
                    category_id: form.category_id,
                    lesson_category_id: form.lesson_category_id,
                    title: form.title,
                    description: form.description,

                    exam_group_type: form.exam_group_type,
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
                    repeat_the_exam: form.repeat_the_exam,
                    total_tolerance: form.total_tolerance,
                    smallest_value_limit: form.smallest_value_limit,
                    biggest_value_limit: form.biggest_value_limit,
                    
                    assessment_type: form.assessment_type,
                    minimal_grade_type: form.minimal_grade_type,
                    minimal_grade: form.minimal_grade,
                    description_grade_less_than_minimal: form.description_grade_less_than_minimal,
                    description_grade_more_than_minimal: form.description_grade_more_than_minimal,
                    certificate_print_user: form.certificate_print_user,
                    exam_status: form.exam_status,
                    price_before_discount: form.price_before_discount,
                    price_after_discount: form.price_after_discount,
                    member_categories: form.member_categories,

                    sub_category_ids: form.sub_category_ids,
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
                lessonCategoryData,
            }
        }
    }
</script>

<style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css"></style>
