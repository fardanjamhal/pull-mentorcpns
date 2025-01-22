<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Edit Soal</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Soal</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Soal</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <div class="d-lg-flex align-items-center">
                        <div class="ms-auto">
                            <Link :href="`/admin/question-titles/${questionTitle.id}/questions`" class="btn btn-primary btn-sm mt-2 mt-lg-0">Kembali</Link>
                        </div>
                    </div>
                    {{ $page.props.session.failed }}
                    <form @submit.prevent="submit" class="row g-3">
                        <div v-if="questionTitle.add_value_category == 1 && questionTitle.assessment_type == 1" class="col-12">
                            <label class="form-label">Kategori Penilaian</label>
                            <select v-model="form.value_category_id" :class="{ 'is-invalid': errors.value_category_id }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option v-for="(valueCategory, index) in valueCategories" :key="index" :value="valueCategory.id">
                                    {{ valueCategory.name }}
                                </option>
                            </select>
                            <div v-if="errors.value_category_id" class="invalid-feedback">
                                {{ errors.value_category_id }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Bagian Ke</label>
                            <input type="text" class="form-control" v-model="form.section" :class="{ 'is-invalid': errors.section }" placeholder="Bagian Ke" :readonly="questionTitle.total_section == 1">
                            <div v-if="errors.section" class="invalid-feedback">
                                {{ errors.section }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Tambah Audio</label>
                            <select v-model="form.audio_input" :class="{ 'is-invalid': errors.audio_input }" class="form-select">
                                <option value="0">Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                            <div v-if="errors.audio_input" class="invalid-feedback">
                                {{ errors.audio_input }}
                            </div>
                        </div>

                        <div class="col-12" v-if="form.audio_input == 1">
                            <label class="form-label">Audio</label>
                            <input type="file" class="form-control" @input="form.audio = $event.target.files[0]" :class="{ 'is-invalid': errors.audio }" placeholder="Audio">
                            <div v-if="errors.audio" class="invalid-feedback">
                                {{ errors.audio }}
                            </div>
                        </div>

                        <div class="col-12" v-if="form.audio_input == 1">
                            <label class="form-label">Batasan Audio Bisa Diputar</label>
                            <input type="number" class="form-control" v-model="form.audio_played_limit" :class="{ 'is-invalid': errors.audio_played_limit }" placeholder="Batasan Audio Bisa Diputar">
                            <div v-if="errors.audio_played_limit" class="invalid-feedback">
                                {{ errors.audio_played_limit }}
                            </div>
                        </div>

                        <div class="col-12" v-if="form.audio_input == 1">
                            <label class="form-label">Batas Waktu Menjawab (Detik), Input 0 Jika Tidak Ada Batasan</label>
                            <input type="number" class="form-control" v-model="form.audio_answer_time" :class="{ 'is-invalid': errors.audio_answer_time }" placeholder="Batas Waktu Menjawab Sesudah Audio Di Putar">
                            <div v-if="errors.audio_answer_time" class="invalid-feedback">
                                {{ errors.audio_answer_time }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label"><b>Soal</b></label>
                            <Editor
                                api-key="z0orjv2sirc3srvbm5cveadi07v3y2i0voly8s87wdik0l0r"
                                v-model="form.question"
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
                            <div v-if="errors.question">
                                {{ errors.question }}
                            </div>
                        </div>

                        <hr>

                        <div v-if="1 <= questionTitle.total_choices" class="col-12">
                            <label class="form-label"><b>Pilihan A</b></label>
                            <Editor
                                api-key="z0orjv2sirc3srvbm5cveadi07v3y2i0voly8s87wdik0l0r"
                                v-model="form.option_1"
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
                                    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor emoticons | tiny_mce_wiris_formulaEditor tiny_mce_wiris_formulaEditorChemistry',
                                    image_advtab: true,
                                    image_title: true,
                                    automatic_uploads: true,
                                    images_upload_url: '/upload',
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
                            <div v-if="errors.option_1">
                                {{ errors.option_1 }}
                            </div>
                        </div>

                        <div v-if="2 <= questionTitle.total_choices" class="col-12">
                            <label class="form-label"><b>Pilihan B</b></label>
                            <Editor
                                api-key="z0orjv2sirc3srvbm5cveadi07v3y2i0voly8s87wdik0l0r"
                                v-model="form.option_2"
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
                                    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor emoticons | tiny_mce_wiris_formulaEditor tiny_mce_wiris_formulaEditorChemistry',
                                    image_advtab: true,
                                    image_title: true,
                                    automatic_uploads: true,
                                    images_upload_url: '/upload',
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
                            <div v-if="errors.option_2">
                                {{ errors.option_2 }}
                            </div>
                        </div>

                        <div v-if="3 <= questionTitle.total_choices" class="col-12">
                            <label class="form-label"><b>Pilihan C</b></label>
                            <Editor
                                api-key="z0orjv2sirc3srvbm5cveadi07v3y2i0voly8s87wdik0l0r"
                                v-model="form.option_3"
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
                                    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor emoticons | tiny_mce_wiris_formulaEditor tiny_mce_wiris_formulaEditorChemistry',
                                    image_advtab: true,
                                    image_title: true,
                                    automatic_uploads: true,
                                    images_upload_url: '/upload',
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
                            <div v-if="errors.option_3">
                                {{ errors.option_3 }}
                            </div>
                        </div>

                        <div v-if="4 <= questionTitle.total_choices" class="col-12">
                            <label class="form-label"><b>Pilihan D</b></label>
                            <Editor
                                api-key="z0orjv2sirc3srvbm5cveadi07v3y2i0voly8s87wdik0l0r"
                                v-model="form.option_4"
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
                                    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor emoticons | tiny_mce_wiris_formulaEditor tiny_mce_wiris_formulaEditorChemistry',
                                    image_advtab: true,
                                    image_title: true,
                                    automatic_uploads: true,
                                    images_upload_url: '/upload',
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
                            <div v-if="errors.option_4">
                                {{ errors.option_4 }}
                            </div>
                        </div>

                        <div v-if="5 <= questionTitle.total_choices" class="col-12">
                            <label class="form-label"><b>Pilihan E</b></label>
                            <Editor
                                api-key="z0orjv2sirc3srvbm5cveadi07v3y2i0voly8s87wdik0l0r"
                                v-model="form.option_5"
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
                                    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor emoticons | tiny_mce_wiris_formulaEditor tiny_mce_wiris_formulaEditorChemistry',
                                    image_advtab: true,
                                    image_title: true,
                                    automatic_uploads: true,
                                    images_upload_url: '/upload',
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
                            <div v-if="errors.option_5">
                                {{ errors.option_5 }}
                            </div>
                        </div>

                        <div class="col-12" v-if="questionTitle.assessment_type == 4">
                            <label class="form-label">Poin Jawaban A</label>
                            <input type="number" class="form-control" v-model="form.point_1" :class="{ 'is-invalid': errors.point_1 }" placeholder="Poin Jawaban A">
                            <div v-if="errors.point_1" class="invalid-feedback">
                                {{ errors.point_1 }}
                            </div>
                        </div>

                        <div class="col-12" v-if="questionTitle.assessment_type == 4">
                            <label class="form-label">Poin Jawaban B</label>
                            <input type="number" class="form-control" v-model="form.point_2" :class="{ 'is-invalid': errors.point_2 }" placeholder="Poin Jawaban B">
                            <div v-if="errors.point_2" class="invalid-feedback">
                                {{ errors.point_2 }}
                            </div>
                        </div>

                        <div class="col-12" v-if="questionTitle.assessment_type == 4">
                            <label class="form-label">Poin Jawaban C</label>
                            <input type="number" class="form-control" v-model="form.point_3" :class="{ 'is-invalid': errors.point_3 }" placeholder="Poin Jawaban C">
                            <div v-if="errors.point_3" class="invalid-feedback">
                                {{ errors.point_3 }}
                            </div>
                        </div>

                        <div class="col-12" v-if="questionTitle.assessment_type == 4">
                            <label class="form-label">Poin Jawaban D</label>
                            <input type="number" class="form-control" v-model="form.point_4" :class="{ 'is-invalid': errors.point_4 }" placeholder="Poin Jawaban D">
                            <div v-if="errors.point_4" class="invalid-feedback">
                                {{ errors.point_4 }}
                            </div>
                        </div>

                        <div class="col-12" v-if="questionTitle.assessment_type == 4">
                            <label class="form-label">Poin Jawaban E</label>
                            <input type="number" class="form-control" v-model="form.point_5" :class="{ 'is-invalid': errors.point_5 }" placeholder="Poin Jawaban E">
                            <div v-if="errors.point_5" class="invalid-feedback">
                                {{ errors.point_5 }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label"><b>Jawaban</b></label>
                            <select v-model="form.answer" :class="{ 'is-invalid': errors.answer }" class="form-select">
                                <option value="">[ Pilih ]</option>
                                <option value="1">A</option>
                                <option value="2">B</option>
                                <option value="3">C</option>
                                <option value="4">D</option>
                                <option value="5">E</option>
                            </select>
                            <div v-if="errors.answer" class="invalid-feedback">
                                {{ errors.answer }}
                            </div>
                        </div>

                        <div class="col-12" v-if="questionTitle.assessment_type == 3">
                            <label class="form-label">Poin Setiap Jawaban Benar</label>
                            <input type="number" class="form-control" v-model="form.correct_point" :class="{ 'is-invalid': errors.correct_point }" placeholder="Poin Setiap Jawaban Benar">
                            <div v-if="errors.correct_point" class="invalid-feedback">
                                {{ errors.correct_point }}
                            </div>
                        </div>

                        <div class="col-12" v-if="questionTitle.assessment_type == 3">
                            <label class="form-label">Poin Setiap Jawaban Salah</label>
                            <input type="number" class="form-control" v-model="form.wrong_point" :class="{ 'is-invalid': errors.wrong_point }" placeholder="Poin Setiap Jawaban Salah">
                            <div v-if="errors.wrong_point" class="invalid-feedback">
                                {{ errors.wrong_point }}
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label"><b>ID Video Youtube</b></label>
                            <input type="text" class="form-control" v-model="form.discussion_video" placeholder="ID Video Youtube">
                        </div>

                        <div class="col-12">
                            <label class="form-label"><b>Pembahasan</b></label>
                            <Editor
                                api-key="z0orjv2sirc3srvbm5cveadi07v3y2i0voly8s87wdik0l0r"
                                v-model="form.discussion"
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
                            <div v-if="errors.discussion">
                                {{ errors.discussion }}
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
            questionTitle: Object,
            question: Object,
            valueCategories: Object
        },

        // initialization composition API
        setup(props) {
            const form = reactive({
                value_category_id: props.question.value_category_id,
                question: props.question.question,

                audio_input: props.question.audio_input,
                audio: props.question.audio,
                audio_played_limit: props.question.audio_played_limit,
                audio_answer_time: props.question.audio_answer_time,

                option_1: props.question.option_1,
                option_2: props.question.option_2,
                option_3: props.question.option_3,
                option_4: props.question.option_4,
                option_5: props.question.option_5,

                point_1: props.question.point_1,
                point_2: props.question.point_2,
                point_3: props.question.point_3,
                point_4: props.question.point_4,
                point_5: props.question.point_5,

                wrong_point: props.question.wrong_point,
                correct_point: props.question.correct_point,

                answer: props.question.answer,
                section: props.questionTitle.total_section == 1 ? 1 : props.question.section,
                discussion_video: props.question.discussion_video,
                discussion: props.question.discussion,
            });

            // submit method
            const submit = () => {
                // send data to server
                Inertia.put(`/admin/question-titles/${props.questionTitle.id}/questions/${props.question.id}`, {
                    // data
                    question_title_id: props.questionTitle.id,
                    add_value_category: props.questionTitle.add_value_category,
                    value_category_id: form.value_category_id,
                    question: form.question,

                    audio_input: form.audio_input,
                    audio: form.audio,
                    audio_played_limit: form.audio_played_limit,
                    audio_answer_time: form.audio_answer_time,

                    option_1: form.option_1,
                    option_2: form.option_2,
                    option_3: form.option_3,
                    option_4: form.option_4,
                    option_5: form.option_5,

                    point_1: form.point_1,
                    point_2: form.point_2,
                    point_3: form.point_3,
                    point_4: form.point_4,
                    point_5: form.point_5,

                    correct_point: form.correct_point,
                    wrong_point: form.wrong_point,

                    answer: form.answer,
                    section: form.section,
                    discussion_video: form.discussion_video,
                    discussion: form.discussion,
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Soal Berhasil Diupdate!.',
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
