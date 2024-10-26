<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Edit Pemberitahuan</title>
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
                            <li class="breadcrumb-item active" aria-current="page">Edit Pemberitahuan</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center">
                        <div class="ms-auto">
                            <Link href="/admin/announcements" class="btn btn-primary btn-sm mt-2 mt-lg-0">Kembali</Link>
                        </div>
                    </div>
                    <form @submit.prevent="submit" class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Judul</label>
                            <input type="text" class="form-control" v-model="form.title" :class="{ 'is-invalid': errors.title }" placeholder="Nama">
                            <div v-if="errors.title" class="invalid-feedback">
                                {{ errors.title }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label"><b>Deskripsi</b></label>
                            <Editor
                                api-key="wcihyvnlo8xq5nmvwzduo9uq9yc46c78z81499i6y8sb3bzs"
                                v-model="form.description"
                                :init="{
                                    automatic_uploads: true,
                                    height: 400,
                                    external_plugins: {
                                        'tiny_mce_wiris' : '/assets/plugins/wiris/mathtype-tinymce5/plugin.min.js'
                                    },
                                    plugins: [
                                        'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                                        'searchreplace wordcount visualblocks visualchars code fullscreen',
                                        'insertdatetime media nonbreaking save table contextmenu directionality',
                                        'emoticons template paste textcolor colorpicker textpattern imagetools'
                                    ],
                                    draggable_modal: true,
                                    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor emoticons | tiny_mce_wiris_formulaEditor tiny_mce_wiris_formulaEditorChemistry',
                                    image_advtab: true,
                                    image_title: true,
                                    automatic_uploads: true,
                                    images_upload_url: '/upload',
                                    images_upload_credentials: true,
                                    file_picker_types: 'image',
                                    file_picker_callback: function(cb, value, meta) {
                                        var input = document.createElement('input');
                                        input.setAttribute('type', 'file');
                                        input.setAttribute('accept', 'image/*');
                                        input.onchange = function() {
                                            var file = this.files[0];

                                            var reader = new FileReader();
                                            reader.readAsDataURL(file);
                                            reader.onload = function () {
                                                var id = 'blobid' + (new Date()).getTime();
                                                var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                                                var base64 = reader.result.split(',')[1];
                                                var blobInfo = blobCache.create(id, file, base64);
                                                blobCache.add(blobInfo);
                                                cb(blobInfo.blobUri(), { title: file.name });
                                            };
                                        };
                                        input.click();
                                    }
                                }"
                            />
                            <div v-if="errors.description">
                                {{ errors.description }}
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

    //import tinyMCE
    import Editor from '@tinymce/tinymce-vue';

    export default {
        // layout
        layout: LayoutAdmin,

        // register components
        components: {
            Link,
            Head,
            Editor
        },

        //props
        props: {
            errors: Object,
            announcement: Object,
        },

        // initialization composition API
        setup(props) {
            const form = reactive({
                title: props.announcement.title,
                description: props.announcement.description,
            });

          // submit method
            const submit = () => {
                // send data to server
                Inertia.put(`/admin/announcements/${props.announcement.id}`, {
                    // data
                    title: form.title,
                    description: form.description,
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Pemberitahuan Berhasil Diupdate!.',
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
