<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Tambah Kategori Peminatan</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Kategori Peminatan</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Kategori Peminatan</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center">
                        <div class="ms-auto">
                            <Link href="/admin/categories" class="btn btn-primary btn-sm mt-2 mt-lg-0">Kembali</Link>
                        </div>
                    </div>
                    <form @submit.prevent="submit" class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" v-model="form.name" :class="{ 'is-invalid': errors.name }" placeholder="Nama">
                            <div v-if="errors.name" class="invalid-feedback">
                                {{ errors.name }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Thumbnail</label>
                            <input type="file" class="form-control" @input="form.thumbnail = $event.target.files[0]" :class="{ 'is-invalid': errors.thumbnail }" placeholder="Thumbnail">
                            <div v-if="errors.thumbnail" class="invalid-feedback">
                                {{ errors.thumbnail }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Status Development</label>
                            <select v-model="form.development_status" :class="{ 'is-invalid': errors.development_status }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="development">Development</option>
                                <option value="production">Production</option>
                            </select>
                            <div v-if="errors.development_status" class="invalid-feedback">
                                {{ errors.development_status }}
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
        },

        // initialization composition API
        setup() {
            const form = reactive({
                name: '',
                thumbnail: '',
                development_status: '',
            });

            // submit method
            const submit = () => {
                // send data to server
                Inertia.post('/admin/categories', {
                    forceFormData: true,
                    // data
                    name: form.name,
                    thumbnail: form.thumbnail,
                    development_status: form.development_status,
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Kategori Berhasil Disimpan!.',
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
