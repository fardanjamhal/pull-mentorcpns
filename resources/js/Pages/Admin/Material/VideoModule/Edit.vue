<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Edit Video Pembelajaran</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Video Pembelajaran</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Video Pembelajaran</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center">
                        <div class="ms-auto">
                            <Link href="/admin/video-modules" class="btn btn-primary btn-sm mt-2 mt-lg-0">Kembali</Link>
                        </div>
                    </div>
                    <form @submit.prevent="submit" class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Kategori Peminatan</label>
                            <select v-model="form.category_id" :class="{ 'is-invalid': errors.category_id }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option v-for="(category, index) in categories" :key="index" :value="category.id">
                                    {{ category.name }}</option>
                            </select>
                            <div v-if="errors.category_id" class="invalid-feedback">
                                {{ errors.category_id }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Kategori Member (Khusus Untuk Membership Bulanan, Kosongkan Jika Tidak Ada)</label>
                            <multiselect
                                v-model="form.member_categories"
                                :options="memberCategories"
                                :multiple="true"
                                label="name"
                                :close-on-select="true"
                                :allow-empty="true"
                                track-by="name"
                                placeholder="[ Pilih ]"
                            ></multiselect>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Judul</label>
                            <input type="text" class="form-control" v-model="form.title" :class="{ 'is-invalid': errors.title }" placeholder="Judul">
                            <div v-if="errors.title" class="invalid-feedback">
                                {{ errors.title }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea cols="30" rows="10" class="form-control" v-model="form.description" :class="{ 'is-invalid': errors.description }" placeholder="Deskripsi Video"></textarea>
                            <div v-if="errors.description" class="invalid-feedback">
                                {{ errors.description }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Link</label>
                            <input type="text" class="form-control" v-model="form.link" :class="{ 'is-invalid': errors.link }" placeholder="Link">
                            <div v-if="errors.link" class="invalid-feedback">
                                {{ errors.link }}
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

    import Multiselect from '@suadelabs/vue3-multiselect'

    export default {
        // layout
        layout: LayoutAdmin,

        // register components
        components: {
            Link,
            Head,
            Multiselect
        },

        //props
        props: {
            errors: Object,
            categories: Object,
            videoModule: Object,
            memberCategories: Object,
        },

        // initialization composition API
        setup(props) {
            const form = reactive({
                link: props.videoModule.link,
                title: props.videoModule.title,
                description: props.videoModule.description,
                category_id: props.videoModule.category_id,
                member_categories: !props.videoModule.member_categories ? [] : props.videoModule.member_categories.map(item => {
                    return { 'name': item };
                })
            });

            // submit method
            const submit = () => {
                // send data to server
                Inertia.put(`/admin/video-modules/${props.videoModule.id}`, {
                    // data
                    category_id: form.category_id,
                    title: form.title,
                    description: form.description,
                    link: form.link,
                    member_categories: form.member_categories,
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Materi /Modul Berhasil Diupdate!.',
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

<style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css"></style>