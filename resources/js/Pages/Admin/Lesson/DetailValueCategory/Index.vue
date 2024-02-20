<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Data Kategori Penilaian</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Kategori Penilaian</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Data Kategori Penilaian</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center mb-4 gap-3">
                        <Link :href="`/admin/value-categories/${valueCategory.id}/detail-value-categories/create`" class="btn btn-primary btn-sm mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i> Tambah Kategori Penilaian</Link>

                        <div class="ms-auto">
                            <Link :href="`/admin/value-categories`" class="btn btn-primary btn-sm mt-2 mt-lg-0">Kembali</Link>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Kategori Penilaian</th>
                                    <th>Nilai Minimal</th>
                                    <th>Nilai Maksimal</th>
                                    <th>Kategori Nilai</th>
                                    <th>Nilai Akhir</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(detailValueCategory, index) in detailValueCategories.data" :key="index">
                                    <td>
                                        {{ ++index + (detailValueCategories.current_page - 1) * detailValueCategories.per_page }}
                                    </td>
                                    <td><span class="badge bg-primary">{{ detailValueCategory.value_category.name }}</span></td>
                                    <td>{{ detailValueCategory.min_grade }}</td>
                                    <td>{{ detailValueCategory.max_grade }}</td>
                                    <td>{{ detailValueCategory.category_grade }}</td>
                                    <td>{{ detailValueCategory.final_grade }}</td>
                                    <td>
                                        <div class="d-flex order-actions">
                                            <Link :href="`/admin/value-categories/${valueCategory.id}/detail-value-categories/${detailValueCategory.id}/edit`" class="ms-1"><i class='bx bxs-edit'></i></Link>
                                            <a href="#" @click.prevent="destroy(detailValueCategory.id)" class="ms-1"><i class="bx bxs-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <Pagination :links="detailValueCategories.links" align="end" />

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
            detailValueCategories: Object,
            valueCategory: Object,
        },

        // initialization composition API
        setup(props) {
            // define state search
            const search = ref('' || (new URL(document.location)).searchParams.get('search'));

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

                        Inertia.delete(`/admin/value-categories/${props.valueCategory.id}/detail-value-categories/${id}`);

                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Kategori Penilaian Berhasil Dihapus!.',
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false,
                        });
                    }
                })
            }

            return {
                destroy
            }
        }
    }
</script>
