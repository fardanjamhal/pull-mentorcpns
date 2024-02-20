<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Edit Bank</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Bank</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Bank</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center">
                        <div class="ms-auto">
                            <Link href="/admin/banks" class="btn btn-primary btn-sm mt-2 mt-lg-0">Kembali</Link>
                        </div>
                    </div>
                    <form @submit.prevent="submit" class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Nama Bank</label>
                            <input type="text" class="form-control" v-model="form.bank_name" :class="{ 'is-invalid': errors.bank_name }" placeholder="Nama">
                            <div v-if="errors.bank_name" class="invalid-feedback">
                                {{ errors.bank_name }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Logo Bank</label>
                            <input type="file" class="form-control" @input="form.image = $event.target.files[0]" :class="{ 'is-invalid': errors.image }" placeholder="image">
                            <div v-if="errors.image" class="invalid-feedback">
                                {{ errors.image }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Nomor Rekening</label>
                            <input type="text" class="form-control" v-model="form.rekening_number" :class="{ 'is-invalid': errors.rekening_number }" placeholder="Nama">
                            <div v-if="errors.rekening_number" class="invalid-feedback">
                                {{ errors.rekening_number }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Atas Nama</label>
                            <input type="text" class="form-control" v-model="form.rekening_name" :class="{ 'is-invalid': errors.rekening_name }" placeholder="Nama">
                            <div v-if="errors.rekening_name" class="invalid-feedback">
                                {{ errors.rekening_name }}
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
            bank: Object
        },

        // initialization composition API
        setup(props) {
            const form = reactive({
                bank_name: props.bank.bank_name,
                rekening_number: props.bank.rekening_number,
                rekening_name: props.bank.rekening_name,
                image: '',
                is_active: props.bank.is_active,
            });

            // submit method
            const submit = () => {
                // send data to server
                Inertia.post(`/admin/banks/${props.bank.id}`, {
                    forceFormData: true,
                    _method: 'put',
                    // data
                    bank_name: form.bank_name,
                    rekening_number: form.rekening_number,
                    rekening_name: form.rekening_name,
                    image: form.image,
                    is_active: form.is_active,
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Bank Berhasil Diupdate!.',
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
