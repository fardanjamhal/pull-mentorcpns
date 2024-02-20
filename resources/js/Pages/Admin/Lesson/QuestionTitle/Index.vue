<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Data Paket Soal</title>
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
                            <li class="breadcrumb-item active" aria-current="page">Data Paket Soal</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Filter Data</h6>
                        </div>
                    </div>
                </div>

                <div class="card-body"> <!-- Change 'text-center' to 'text-end' -->
                    <form>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="search">Judul Paket Soal</label>
                                <input type="text" v-model="form.search" class="form-control" id="search" placeholder="Cari Berdasarkan Nama Paket Soal....">
                            </div>

                            <div class="col-md-2">
                                <label for="category">Kategori Peminatan</label>
                                <select @change="lessonCategoryData" v-model="form.category_id" class="form-control">
                                    <option value="">[ Pilih]</option>
                                    <option v-for="(category, index) in categories" :key="index" :value="category.id">
                                        {{ category.name }}</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label for="lesson_category_id">Kategori Mata Pelajaran</label>
                                <select @change="lessonData" v-model="form.lesson_category_id" class="form-control">
                                    <option value="">[ Pilih ]</option>
                                    <option v-for="lessonCategory in form.lessonCategories" :value="lessonCategory.id">{{ lessonCategory.name }}</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label for="lesson_id">Mata Pelajaran</label>
                                <select v-model="form.lesson_id" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option v-for="lesson in form.lessons" :value="lesson.id">{{ lesson.name }}</option>
                            </select>
                            </div>

                            <div class="col-md-2">
                                <label for="end_date">Action</label><br>
                                <button @click.prevent="handleSearch" class="btn btn-primary btn-sm me-2">
                                    <i class="bx bx-filter"></i>Filter
                                </button>

                                <Link href="/admin/question-titles" class="btn btn-danger btn-sm me-2">
                                    <i class="bx bx-refresh"></i>reset
                                </Link>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Paket Soal</h6>
                        </div>
                        <div class="ms-auto">
                            <Link href="/admin/question-titles/create" class="btn btn-primary btn-sm me-2">
                                <i class="bx bxs-plus-square"></i>Tambah Data
                            </Link>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table table-striped table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Peminatan</th>
                                    <th>Judul Paket Soal</th>
                                    <th>Kategori Mata Pelajaran</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Kategori Penilaian</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(questionTitle, index) in questionTitles.data" :key="index">
                                    <td>
                                        {{ ++index + (questionTitles.current_page - 1) * questionTitles.per_page }}
                                    </td>
                                    <td><span class="badge bg-primary">{{ (questionTitle.category && questionTitle.category.name) ?? '-' }}</span></td>
                                    <td>{{ questionTitle.name }}</td>
                                    <td>{{ questionTitle.lesson_category.name }}</td>
                                    <td>{{ questionTitle.lesson.name }}</td>
                                    <td>
                                        <div v-if="questionTitle.add_value_category == 1">
                                            <span class="badge bg-primary" v-if="questionTitle.assessment_type == 1">Per Kategori Penilaian</span>
                                            <span class="badge bg-primary" v-if="questionTitle.assessment_type == 2">Untuk Seluruh Soal (Kecermatan)</span>
                                            <span class="badge bg-primary" v-if="questionTitle.assessment_type == 3">Berdasarkan Poin Jawaban Benar</span>
                                            <span class="badge bg-primary" v-if="questionTitle.assessment_type == 4">Berdasarkan Bobot Jawaban</span>
                                        </div>
                                        <span v-else class="badge bg-danger">Tidak ada</span>
                                    </td>
                                    <td>
                                        <div class="d-flex order-actions">
                                            <Link :href="`/admin/question-titles/${questionTitle.id}/questions`" class="ms-1"><i class='bx bx-grid-alt'></i></Link>
                                            <Link :href="`/admin/question-titles/${questionTitle.id}/edit`" class="ms-1"><i class='bx bxs-edit'></i></Link>
                                            <a href="#" @click.prevent="destroy(questionTitle.id)" class="ms-1"><i class="bx bxs-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" colspan="8" v-if="!questionTitles.data.length">Data Tidak Tersedia</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <Pagination :links="questionTitles.links" align="end" />

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

    //import reactive
    import { reactive } from 'vue';

    //import axios
    import axios from 'axios';

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
            questionTitles: Object,
            categories: Object,
        },

        // initialization composition API
        setup() {
            const form = reactive({
                search: ref("" || (new URL(document.location)).searchParams.get('search')),
                category_id: ref((new URL(document.location)).searchParams.get('category_id') || ''),
                lesson_category_id: ref((new URL(document.location)).searchParams.get('lesson_category_id') || ''),
                lesson_id: ref((new URL(document.location)).searchParams.get('lesson_id') || ''),

                lessonCategories: [],
                lessons: [],
            });


            // define state search
            const handleSearch = () => {
                Inertia.get('/admin/question-titles', {
                    search: form.search,
                    category_id: form.category_id,
                    lesson_category_id: form.lesson_category_id,
                    lesson_id: form.lesson_id,
                })
            }

            const lessonCategoryData = (category_id = "", lesson_category_id) => {
                form.lesson_category_id = category_id != form.category_id ? '' : form.lesson_category_id;
                form.lesson_id = lesson_category_id != form.lesson_category_id ? '' : form.lesson_id;
            
                axios.get(`/admin/categories/${form.category_id}/lesson-categories`).then(response => {
                    form.lessonCategories = response.data;
                }).catch(error => console.error(error));
            }

            const lessonData = (lesson_category_id = "") => {
                form.lesson_id = lesson_category_id != form.lesson_category_id ? '' : form.lesson_id;

                axios.get(`/admin/lesson-categories/${form.lesson_category_id}/lessons`).then(response => {
                    form.lessons = response.data;
                }).catch(error => console.error(error));
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

                        Inertia.delete(`/admin/question-titles/${id}`);

                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Paket Soal Berhasil Dihapus!.',
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false,
                        });
                    }
                })
            }

            if(form.category_id) {
                lessonCategoryData(form.category_id, form.lesson_category_id);
            }

            if(form.lesson_category_id) {
                lessonData(form.lesson_category_id);
            }

            return {
                form,
                handleSearch,
                destroy,
                lessonCategoryData,
                lessonData
            }
        }
    }
</script>
