<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Edit Kategori Penilaian</title>
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
                            <li class="breadcrumb-item active" aria-current="page">Tambah Kategori Penilaian</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center">
                        <div class="ms-auto">
                            <Link href="/admin/value-categories" class="btn btn-primary btn-sm mt-2 mt-lg-0">Kembali</Link>
                        </div>
                    </div>
                    <form @submit.prevent="submit" class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Mata Pelajaran</label>
                            <select v-model="form.lesson_id" :class="{ 'is-invalid': errors.lesson_id }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option v-for="(lesson, index) in lessons" :key="index" :value="lesson.id">
                                    {{ lesson.lesson_category.category.name }} - {{ lesson.lesson_category.name }} - {{ lesson.name }}</option>
                            </select>
                            <div v-if="errors.lesson_id" class="invalid-feedback">
                                {{ errors.lesson_id }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" v-model="form.name" :class="{ 'is-invalid': errors.name }" placeholder="Nama">
                            <div v-if="errors.name" class="invalid-feedback">
                                {{ errors.name }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Jenis Penilaian</label>
                            <select v-model="form.assessment_type" :class="{ 'is-invalid': errors.assessment_type }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="1">Nilai = Jumlah Benar : Total Soal</option>
                                <option value="4">Nilai = Jumlah Benar : Total Menjawab</option>
                                <option value="2">Nilai = Jumlah Jawaban Benar</option>
                                <option value="3">Nilai = Linear Slope</option>
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
            lessons: Object,

        },

        // initialization composition API
        setup(props) {
            const form = reactive({
                name: props.valueCategory.name,
                lesson_id: props.valueCategory.lesson_id,
                assessment_type: props.valueCategory.assessment_type,
            });

            // submit method
            const submit = () => {
                // send data to server
                Inertia.put(`/admin/value-categories/${props.valueCategory.id}`, {
                    // data
                    name: form.name,
                    lesson_id: form.lesson_id,
                    assessment_type: form.assessment_type,
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Kategori Penilaian Berhasil Diupdate!.',
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
