<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Data Kategori Mata Pelajaran</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Kategori Mata Pelajaran</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Data Kategori Mata Pelajaran</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center mb-4 gap-3">
                        <form @submit.prevent="handleSearch">
                            <div class="position-relative">
                                <input
                                    type="text"
                                    v-model="search"
                                    class="form-control ps-5 radius-20"
                                    placeholder="Cari Berdasarkan Kategori Mata Pelajaran...."
                                    size="40"
                                    maxlength="100"
                                >
                                <span class="position-absolute top-50 product-show translate-middle-y">
                                    <i class="bx bx-search"></i>
                                </span>
                            </div>
                        </form>
                        <div class="ms-auto">
                            <Link href="/admin/lesson-categories/create" class="btn btn-primary btn-sm mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i> Tambah Kategori</Link>
                        </div>
                    </div>
                    <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Kategori Mata Pelajaran</th>
                                <th>Thumbnail</th>
                                <th>Kategori Peminatan</th>
                                <th>Deskripsi</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(lessonCategory, index) in lessonCategories.data" :key="index">
                                <td>
                                    {{ ++index + (lessonCategories.current_page - 1) * lessonCategories.per_page }}
                                </td>
                                <td>{{ lessonCategory.name }}</td>
                                <td>
                                    <div v-if="lessonCategory.thumbnail">
                                        <img  v-bind:src="'/storage/upload_files/lesson_categories/' + lessonCategory.thumbnail" style="width:90px;"/>
                                    </div>
                                    <div v-else="lessonCategory.thumbnail">
                                        -
                                    </div>
                                </td>
                                <td><span class="badge bg-primary">{{ lessonCategory.category.name }}</span></td>
                                <td>{{ lessonCategory.description }}</td>
                                <td>
                                    <div class="d-flex order-actions">
                                        <Link :href="`/admin/lesson-categories/${lessonCategory.id}/edit`" class="ms-1"><i class='bx bxs-edit'></i></Link>
                                        <a href="#" @click.prevent="destroy(lessonCategory.id)" class="ms-1"><i class="bx bxs-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="6" v-if="!lessonCategories.data.length">Data Tidak Tersedia</td>
                            </tr>
                        </tbody>
                        </table>
                    </div>

                    <Pagination :links="lessonCategories.links" align="end" />

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
            lessonCategories: Object
        },

        // initialization composition API
        setup() {
            // define state search
            const search = ref('' || (new URL(document.location)).searchParams.get('search'));

            // define method search
            const handleSearch = () => {
                Inertia.get('/admin/lesson-categories', {
                    //send params "search" with value from state "search"
                    search: search.value,
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

                        Inertia.delete(`/admin/lesson-categories/${id}`);

                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Kategori Mata Pelajaran Berhasil Dihapus!.',
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false,
                        });
                    }
                })
            }

            return {
                search,
                handleSearch,
                destroy
            }
        }
    }
</script>
