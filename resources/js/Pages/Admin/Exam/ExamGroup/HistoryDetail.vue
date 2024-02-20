<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Try Out</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Try Out</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Detail Riwayat Try Out</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div class="text-start">
                            <h5 class="mb-0">Informasi Try Out</h5>
                        </div>
                        <div class="ms-auto">
                            <Link :href="`/admin/exam-groups/${history.exam_group_id}/students`" class="btn btn-primary btn-sm">Kembali</Link>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <th width="210px">Peminatan</th>
                                    <td width="10px">:</td>
                                    <td><span class="badge bg-primary">{{ history.exam_group.category.name }}</span></td>
                                </tr>
                                <tr>
                                    <th>Kategori Mata Pelajaran</th>
                                    <td>:</td>
                                    <td>{{ history.exam_group.lesson_category.name }}</td>
                                </tr>
                                <tr>
                                    <th>Mata Pelajaran</th>
                                    <td>:</td>
                                    <td>
                                        <span v-for="(grade, index) in history.exam_group.grade" :key="index" class="badge bg-danger m-1">
                                            {{ grade.lesson.name }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Judul Try Out</th>
                                    <td>:</td>
                                    <td>{{ history.exam_group.title }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Mengerjakan</th>
                                    <td>:</td>
                                    <td>{{ formatDate(history.created_at) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div class="text-start">
                            <h5 class="mb-0">Penilaian</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <!-- if table  -->
                        <table class="table mb-0">
                            <thead>
                                <tr style="font-weight: bold;">
                                    <td width="10%">No</td>
                                    <td width="35%">Kategori Penilaian</td>
                                    <td width="25%" v-if="history.exam_group.minimal_grade_type == 1">Ambang Batas</td>
                                    <td width="25%" v-if="history.exam_group.minimal_grade_type != 1">Keterangan</td>
                                    <td width="5%" align="right">Nilai</td>
                                </tr>
                            </thead>
                            <template v-for="(grade, index) in history.exam_group.grade" :key="index">
                                <tbody>
                                    <tr v-if="grade.exam.question_title.assessment_type == 1 || grade.exam.question_title.assessment_type == 2">
                                        <th colspan="5" style="background:#eee;"><h6>{{ grade.lesson.name }}</h6></th>
                                    </tr>
                                    <tr v-if="grade.exam.question_title.assessment_type != 1 && grade.exam.question_title.assessment_type != 2">
                                        <td>{{ ++index }}</td>
                                        <td>{{ grade.lesson.name }}</td>
                                        <td>{{ grade.exam.question_title.passing_grade ?? '-'}}</td>
                                        <!-- <td>-</td> -->
                                        <td align="right">{{  grade.grade  }}</td>
                                    </tr>

                                    <tr v-if="(grade.exam.question_title.assessment_type == 1 || grade.exam.question_title.assessment_type == 2) && grade.grade_details" v-for="(gradeDetail, index) in grade.grade_details" :key="index">
                                        <td>{{ ++index }}</td>
                                        <td>{{ gradeDetail.grade_category_name }}</td>
                                        <td v-if="history.exam_group.minimal_grade_type == 1">-</td>
                                        <td>{{ gradeDetail.grade_category }}</td>
                                        <td align="right">{{ gradeDetail.grade }}</td>
                                    </tr>
                                </tbody>
                            </template>
                            <tfoot v-if="history.is_finished == 1">
                                <tr>
                                    <th colspan="3"><h5>Nilai Akhir</h5></th>
                                    <td align="right">
                                        <h5>{{ history.grade }}</h5>
                                    </td> 
                                </tr>
                                <tr v-if="history.exam_group.minimal_grade_type != 0">
                                    <th colspan="3"><h5>Keterangan</h5></th>
                                    <td colspan="2" align="right">
                                        <h5>{{ history.description ?? '-' }}</h5>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
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

    //import component pagination
    import Pagination from '../../../../Components/Pagination.vue';

    // import Head from Inertia
    import {
        Head
    } from '@inertiajs/inertia-vue3';

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
            history: Object,
        },
        computed: {
            totalAbovePassingGrade() {
                return this.history.exam_group.grade.reduce((total, grade) => {
                    // Memastikan passing_grade ada dan berupa angka sebelum melakukan perbandingan
                    const passingGrade = parseFloat(grade.exam.question_title.passing_grade);

                    // Memeriksa apakah passing_grade valid (bukan NaN) dan apakah nilai grade lebih besar atau sama dengan passing_grade
                    if (!isNaN(passingGrade) && parseFloat(grade.grade) >= passingGrade) {
                        // Jika memenuhi syarat, tambahkan 1 ke total nilai di atas passing_grade
                        return total + 1;
                    } else {
                        // Jika tidak memenuhi syarat, tetapkan nilai total tanpa penambahan
                        return total;
                    }
                }, 0);
            },
        },
    }
</script>
