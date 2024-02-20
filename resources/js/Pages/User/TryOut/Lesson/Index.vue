<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Data Mata Pelajaran</title>
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
                            <li class="breadcrumb-item active" aria-current="page">Data Mata Pelajaran</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <Link :href="`/user/categories/${categoryId}/lesson-categories`" class="btn btn-primary btn-sm mt-2 mt-lg-0">Kembali</Link>
                </div>
            </div>
            <!--end breadcrumb-->
            <hr/>
            <div v-if="!lessons.length">
                <div class="row row-cols-12 row-cols-md-12 row-cols-lg-12 row-cols-xl-12">
                    <div class="col">
                        <div class="card border-bottom border-3 border-0">
                            <div class="card-body">
                                <h5 class="card-title text-center">Mata Pelajaran Belum Tersedia.</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3" v-for="lesson in lessons">
                    <div class="card border-bottom border-3 border-0">
                        <div class="p-2">
                            <img  v-bind:src="'/storage/upload_files/lessons/' + lesson.thumbnail" class="card-img"/>
                        </div>
                        <div class="card-header">
                            <h5 class="card-title">{{ lesson.name }}</h5>
                            <p class="card-text">Kerjakan Soal Sesuai Perintah Yang Ada Dalam Informasi.</p>
                        </div>
                        <div class="card-body">
                            <Link :href="`/user/categories/${lesson.lesson_category.category.id}/lesson-categories/${lesson.lesson_category_id}/lessons/${lesson.id}/exams`" class="btn btn-outline-primary btn-sm w-100">Selengkapnya</Link>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
    <!--end page wrapper -->
</template>

<script>
    //import layout admin
    import LayoutUser from '../../../../Layouts/Layout.vue';

    // import Link
    import { Link } from '@inertiajs/inertia-vue3';


    // import Head from Inertia
    import {
        Head
    } from '@inertiajs/inertia-vue3';


    export default {
        // layout
        layout: LayoutUser,

        // register components
        components: {
            Link,
            Head,
        },

        // props
        props: {
            lessons: Object,
            categoryId: Object,
        },
    }
</script>
