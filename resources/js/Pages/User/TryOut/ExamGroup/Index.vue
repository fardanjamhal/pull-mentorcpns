<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Data Kategori Peminatan</title>
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
                            <li class="breadcrumb-item active" aria-current="page">Data Kategori Try Out</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <hr>
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12" v-for="category in categories">
                    <div class="card">
                        <div class="row g-0">
                            <div class="col-md-5 d-flex align-items-center p-2">
                                <img v-bind:src="'/storage/upload_files/categories/' + category.thumbnail" class="card-img" />
                            </div>
                            <div class="col-md-7">
                                <div class="card-body">
                                    <h5 class="card-title">Try Out {{ category.name }}</h5>
                                    <p class="card-text">Try Out dari beberapa tes untuk mengetahui nilai akhir dari tes {{ category.name }}.</p>
                                    <Link :href="`/user/exam-groups/${category.id}/lesson-categories`" class="btn btn-outline-primary btn-sm">Selengkapnya</Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="!categories.length">
                <div class="row row-cols-12 row-cols-md-12 row-cols-lg-12 row-cols-xl-12">
                    <div class="col">
                        <div class="card border-bottom border-3 border-0">
                            <div class="card-body">
                                <h5 class="card-title text-center">Data Try Out Belum Tersedia</h5>
                            </div>
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
            categories: Object,
            setting: Object,
        },
    }
</script>
