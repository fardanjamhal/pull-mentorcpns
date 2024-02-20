<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Tambah Paket Soal</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Paket Soal</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Paket Soal</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center">
                        <div class="ms-auto">
                            <Link href="/admin/question-titles" class="btn btn-primary btn-sm mt-2 mt-lg-0">Kembali</Link>
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
                            <select v-model="form.lesson_id" :class="{ 'is-invalid': errors.lesson_id }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option v-for="lesson in form.lessons" :value="lesson.id">
                                {{ lesson.name }}
                                </option>
                            </select>
                            <div v-if="errors.lesson_id" class="invalid-feedback">
                                {{ errors.lesson_id }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Judul Paket Soal</label>
                            <input type="text" class="form-control" v-model="form.name" :class="{ 'is-invalid': errors.name }" placeholder="Paket Soal">
                            <div v-if="errors.name" class="invalid-feedback">
                                {{ errors.name }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Jumlah Pilihan Ganda</label>
                            <input type="number" class="form-control" v-model="form.total_choices" :class="{ 'is-invalid': errors.total_choices }" placeholder="Jumlah Pilihan Ganda">
                            <div v-if="errors.total_choices" class="invalid-feedback">
                                {{ errors.total_choices }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Jumlah Sesi / Kolom</label>
                            <input type="number" class="form-control" v-model="form.total_section" :class="{ 'is-invalid': errors.total_section }" placeholder="Jumlah Sesi / Kolom">
                            <div v-if="errors.total_section" class="invalid-feedback">
                                {{ errors.total_section }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Nilai Ambang Batas (Optional)</label>
                            <input type="number" class="form-control" v-model="form.passing_grade" :class="{ 'is-invalid': errors.passing_grade }" placeholder="Nilai Ambang Batas">
                            <div v-if="errors.passing_grade" class="invalid-feedback">
                                {{ errors.passing_grade }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Tambahkan Kategori Penilaian</label>
                            <select v-model="form.add_value_category" :class="{ 'is-invalid': errors.add_value_category }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="0">Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                            <div v-if="errors.add_value_category" class="invalid-feedback">
                                {{ errors.add_value_category }}
                            </div>
                        </div>

                        <div class="col-12" v-if="form.add_value_category == 1">
                            <label class="form-label">Jenis Penilaian</label>
                            <select v-model="form.assessment_type" :class="{ 'is-invalid': errors.assessment_type }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="1">Dihitung Per Kategori Penilaian</option>
                                <option value="2">Dihitung Untuk Seluruh Soal (Rata-rata)</option>
                                <option value="3">Dihitung Berdasarkan Poin Jawaban Benar</option>
                                <option value="4">Dihitung Berdasarkan Bobot Jawaban</option>
                            </select>
                            <div v-if="errors.assessment_type" class="invalid-feedback">
                                {{ errors.assessment_type }}
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

    //import axios
    import axios from 'axios';

    export default {
        // layout
        layout: LayoutAdmin,

        // register components
        components: {
            Link,
            Head,
        },

        //props
        props: {
            errors: Object,
            categories: Object,
        },

        // initialization composition API
        setup() {
            const form = reactive({
                category_id: '',
                lesson_category_id: '',
                lesson_id: '',
                name: '',
                total_choices: '',
                total_section: '1',
                add_value_category: '',
                assessment_type: '',
                show_answer: 0,
                passing_grade: '',
                minimum_grade: 0,
                // get from api
                lessonCategories: [],
                lessons: [],
            });

            const lessonCategoryData = () => {
                form.lesson_category_id = '';
                form.lesson_id = '';

                axios.get(`/admin/categories/${form.category_id}/lesson-categories`).then(response => {
                form.lessonCategories = response.data;

                }).catch(error => console.error(error));
            }

            const lessonData = () => {
                form.lesson_id = '';
                axios.get(`/admin/lesson-categories/${form.lesson_category_id}/lessons`).then(response => {
                form.lessons = response.data;
                }).catch(error => console.error(error));
            }

            // submit method
            const submit = () => {
                // send data to server
                Inertia.post('/admin/question-titles', {
                    category_id: form.category_id,
                    lesson_category_id: form.lesson_category_id,
                    lesson_id: form.lesson_id,
                    name: form.name,
                    total_choices: form.total_choices,
                    total_section: form.total_section,
                    add_value_category: form.add_value_category,
                    assessment_type: form.assessment_type,
                    show_answer: form.show_answer,
                    minimum_grade: form.minimum_grade,
                    passing_grade: form.passing_grade,
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Paket Soal Berhasil Disimpan!.',
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
                lessonData,
                lessonCategoryData
            }
        }
    }
</script>
