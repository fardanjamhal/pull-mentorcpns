<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Edit Detail Kategori Penilaian</title>
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
                            <li class="breadcrumb-item active" aria-current="page">Edit Detail Kategori Penilaian</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center">
                        <div class="ms-auto">
                            <Link :href="`/admin/value-categories/${valueCategory.id}/detail-value-categories`" class="btn btn-primary btn-sm mt-2 mt-lg-0">Kembali</Link>
                        </div>
                    </div>
                    <form @submit.prevent="submit" class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nilai Minimal</label>
                            <input type="number" class="form-control" v-model="form.min_grade" :class="{ 'is-invalid': errors.min_grade }" placeholder="Nilai Minimal">
                            <div v-if="errors.min_grade" class="invalid-feedback">
                                {{ errors.min_grade }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Nilai Maksimal</label>
                            <input type="number" class="form-control" v-model="form.max_grade" :class="{ 'is-invalid': errors.max_grade }" placeholder="Nilai Maksimal">
                            <div v-if="errors.max_grade" class="invalid-feedback">
                                {{ errors.max_grade }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Kategori Nilai</label>
                            <input type="text" class="form-control" v-model="form.category_grade" :class="{ 'is-invalid': errors.category_grade }" placeholder="Kategori Nilai">
                            <div v-if="errors.category_grade" class="invalid-feedback">
                                {{ errors.category_grade }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Nilai Akhir</label>
                            <input type="text" class="form-control" v-model="form.final_grade" :class="{ 'is-invalid': errors.final_grade }" placeholder="Nilai Akhir">
                            <div v-if="errors.final_grade" class="invalid-feedback">
                                {{ errors.final_grade }}
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
            valueCategory: Object,
            detailValueCategory: Object,
        },

        // initialization composition API
        setup(props) {
            const form = reactive({
                min_grade: props.detailValueCategory.min_grade,
                max_grade: props.detailValueCategory.max_grade,
                category_grade: props.detailValueCategory.category_grade,
                final_grade: props.detailValueCategory.final_grade,
            });

            // submit method
            const submit = () => {
                // send data to server
                Inertia.put(`/admin/value-categories/${props.valueCategory.id}/detail-value-categories/${props.detailValueCategory.id}`, {
                    // data
                    value_category_id: props.valueCategory.id,
                    min_grade: form.min_grade,
                    max_grade: form.max_grade,
                    category_grade: form.category_grade,
                    final_grade: form.final_grade,
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Detail Kategori Penilaian Berhasil Disimpan!.',
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
            }
        }
    }
</script>
