<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Data Pemberitahuan</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Pemberitahuan</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Data Pemberitahuan</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-3">Pemberitahuan</h6>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Perihal</th>
                                    <th>Dibuat</th>
                                    <!-- <th>Lihat Pemberitahuan</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td align="center" colspan="4" v-if="!announcements.data.length">Data Pemberitahuan kosong</td>
                                </tr>
                                <tr v-for="(announcement, index) in announcements.data" :key="index">
                                    <td>
                                        {{ ++index + (announcements.current_page - 1) * announcements.per_page }}
                                    </td>
                                    <!-- <td>{{ announcement.title }}</td> -->
                                    <td>
                                        <Link :href="`/user/announcements/${announcement.id}`" class="ms-2">{{ announcement.title }}</Link>
                                    </td>
                                    <td>{{ announcement.created_at }}</td>
                                    <!-- <td>
                                        <div class="d-flex order-actions">
                                            <Link :href="`/user/announcements/${announcement.id}`" class="ms-2"><i class='bx bx-grid-alt'></i></Link>
                                        </div>
                                    </td> -->
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <Pagination :links="announcements.links" align="end" />

                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->
</template>

<script>
    //import layout user
    import LayoutUser from '../../../Layouts/Layout.vue';

    //import component pagination
    import Pagination from '../../../Components/Pagination.vue';

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
            Pagination
        },

        // props
        props: {
            announcements: Object
        },
    }
</script>
