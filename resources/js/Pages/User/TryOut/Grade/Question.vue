<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Riwayat Try Out</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="d-flex justify-content-between">
                <div class="ms-start">
                    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                        <div class="breadcrumb-title pe-3">Riwayat Try Out</div>
                        <div class="ps-3">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0 p-0">
                                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Kunci jawaban & Pembahasan</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="ms-auto mb-3">
                    <Link v-if="grade.exam_group_id" :href="`/user/exam-groups/${grade.category_id}/lesson-categories/${grade.lesson_category_id}/exams/${grade.exam_group_id}`" class="btn btn-primary btn-sm mt-2 mt-lg-0">Kembali</Link>
                    <Link v-else :href="`/user/categories/${grade.category_id}/lesson-categories/${grade.lesson_category_id}/lessons/${grade.lesson_id}/exams/${grade.exam_id}`" class="btn btn-primary btn-sm">Kembali</Link>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="card bg-light">
                <div class="card-header">
                    <div class="text-center">
                        <h4 class="m-2">Pembahasan Soal <span class="text-purple">{{ exam.lesson.name }}</span></h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 col-lg-8">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <div class="d-flex justify-content-between">
                                <div class="text-start">
                                    <h5 class="mb-0 text-white">Soal Nomor {{ questionLists[indexPage]['navigation_order'] }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div v-if="question">
                                <div v-html="question['question']" class="prevent-select clearfix"></div>
                                <ol v-if="exam.type_option == 1 || (examGroup && examGroup.type_option == 1)" type="A">
                                    <div v-for="(answerOrder, index) in (questionLists[indexPage]['answer_order'].split(','))" :key="index">
                                        <div v-if="exam.question_title.assessment_type == 4">
                                            <li v-html="'<span class=\'badge bg-danger mb-1\'>poin ' + question['point_' + answerOrder] + '</span>' + question['option_' + answerOrder]" class="mb-3"></li>
                                        </div>
                                        <div v-else>
                                            <li v-if="answerOrder == question.answer && question.answer == questionLists[indexPage]['answer']" v-html="question['option_'+answerOrder]" class="text-success fw-bold fs-6"></li>
                                            <li v-else-if="answerOrder == question.answer && question.answer != questionLists[indexPage]['answer']" v-html="question['option_'+answerOrder]" class="text-success fw-bold fs-6"></li>
                                            <li v-else-if="answerOrder == questionLists[indexPage]['answer']" v-html="question['option_'+answerOrder]" class="text-danger fw-bold fs-6"></li>
                                            <li v-else v-html="question['option_'+answerOrder]"></li>
                                        </div>
                                    </div>
                                </ol>
                                <!-- <br> -->
                            </div>
                            <div v-else>
                                <div class="alert alert-danger border-0 shadow">
                                    <i class="fa fa-exclamation-triangle"></i> Question Not Found!.
                                </div>
                            </div>
                            <hr style="border:1px solid red;">
                            <table v-if="question">
                                <tr>
                                    <td>Jawaban Anda</td>
                                    <td>:</td>
                                    <td>{{ questionLists[indexPage]['answer'] == 0 ? 'Tidak Menjawab' :  indexAnswer(questionLists[indexPage]['answer_order'], questionLists[indexPage]['answer']) }}</td>
                                </tr>
                                <tr v-if="exam.question_title.assessment_type != 4">
                                    <td>Kunci Jawaban</td>
                                    <td>:</td>
                                    <td>{{ indexAnswer(questionLists[indexPage]['answer_order'], parseInt(question.answer))  }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-footer" style="min-height: 60px;">
                            <div class="text-center">
                                <button v-if="indexPage > 0" @click="prevPage()" type="button" class="btn btn-primary btn-sm me-3">Sebelumnya</button>
                                <button v-if="indexPage < Object.keys(questionLists).length - 1" @click="nextPage()" type="button" class="btn btn-success btn-sm">Selanjutnya</button>
                            </div>
                        </div>
                    </div>

                    <div class="card border-top border-0 border-3 border-primary">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <div class="text-start">
                                    <h4 class="mb-0">Pembahasan</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div v-html="question['discussion'] ?? 'Tidak Ada Pembahasan'" class="prevent-select"></div>
                        </div>
                        <div class="card-footer" v-if="question.discussion_video">
                            <div class="text-center">
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#exampleFullScreenModal">Pembahasan Video Youtube</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12 col-lg-4">
                    <div class="card">
                        <div class="card-header text-white bg-primary">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="mb-0 text-white">Navigasi Soal</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body mb-3" style="height: 480px; overflow-y: auto">
                            <div v-for="(question, index) in questionLists" :key="index">
                                <div style="width: 20%; float: left;">
                                    <div style="padding: 3px;">
                                        <div v-if="exam.question_title.assessment_type == 4">
                                            <button @click="clickQuestion(index)" v-if="index == indexPage" class="btn btn-primary w-100"><span style="font-size:11px; font-weight: 500;">{{ question.navigation_order }}</span></button>
                                            <button @click="clickQuestion(index)" v-if="index != indexPage && question.answer != 0" class="btn btn-success w-100"><span style="font-size:11px; font-weight: 500;">{{ question.navigation_order }}</span></button>
                                            <button @click="clickQuestion(index)" v-if="index != indexPage && question.answer == 0" class="btn btn-secondary w-100"><span style="font-size:11px; font-weight: 500;">{{ question.navigation_order }}</span></button>
                                        </div>
                                        <div v-else>
                                            <button @click="clickQuestion(index)" v-if="index == indexPage" class="btn btn-primary w-100"><span style="font-size:11px; font-weight: 500;">{{ question.navigation_order }}</span></button>
                                            <button @click="clickQuestion(index)" v-if="index != indexPage && question.is_correct == 'Y' && question.answer != 0" class="btn btn-success w-100"><span style="font-size:11px; font-weight: 500;">{{ question.navigation_order }}</span></button>
                                            <button @click="clickQuestion(index)" v-if="index != indexPage && question.is_correct =='N' && question.answer != 0" class="btn btn-danger w-100"><span style="font-size:11px; font-weight: 500;">{{ question.navigation_order }}</span></button>
                                            <button @click="clickQuestion(index)" v-if="index != indexPage && question.is_correct && question.answer == 0" class="btn btn-secondary w-100"><span style="font-size:11px; font-weight: 500;">{{ question.navigation_order }}</span></button>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <div class="row">
                                <div class="col-md-6 sm-12">
                                    <button type="button" class="w-100 mt-2 btn-sm btn btn-primary">Soal Saat Ini</button>
                                </div>
                                <div class="col-md-6 sm-12">
                                    <button type="button" class="w-100 mt-2 btn-sm btn btn-success">{{ exam.question_title.assessment_type == 4 ? 'Dijawab' : 'Jawaban Benar' }}</button>
                                </div>
                                <div v-if="exam.question_title.assessment_type != 4" class="col-md-6 sm-12">
                                    <button type="button" class="w-100 mt-2 btn-sm btn btn-danger">Jawaban Salah</button>
                                </div>
                                <div class="col-md-6 sm-12">
                                    <button type="button" class="w-100 mt-2 btn-sm btn btn-secondary">Tidak Dijawab</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <!--end page wrapper -->

    <div class="modal fade" id="exampleFullScreenModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Pembahasan Soal Video</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0 m-0">
                        <iframe width="100%" id="youtube-video" height="100%" :src="`https://www.youtube.com/embed/${question.discussion_video}?rel=0&modestbranding=1&showinfo=0`" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"  @click="closeVideo()">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

</template>

<script>
    //import layout admin
    import LayoutAdmin from '../../../../Layouts/Layout.vue';

    // import Link
    import { Link } from '@inertiajs/inertia-vue3';

    import MathJax, { initMathJax, renderByMathjax } from 'mathjax-vue3'
    
    import { ref } from 'vue';

    import { Inertia } from '@inertiajs/inertia';

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
            MathJax
        },

        // props
        props: {
            grade: Object,
            examGroup: Object,
            questionLists: Object,
            question: Object,
            exam: Object,
            indexPage: Object,
        },
        mounted() {
            let recaptchaScript = document.createElement('script')
            recaptchaScript.setAttribute('src', '/assets/js/MathJax.js?config=TeX-AMS-MML_HTMLorMML')
            document.head.appendChild(recaptchaScript)

            function onMathJaxReady() {
                const el = document.getElementById('elementId')
                renderByMathjax(el)
            }
            initMathJax({}, onMathJaxReady);
        },

        setup(props) {
            var indexPage;

            indexPage = ref(props.indexPage);

            let options = ["A", "B", "C", "D", "E"];

            const prevPage = (() => {
                indexPage.value = parseInt(indexPage.value) - 1;
                Inertia.get(`/user/grades/${props.grade.id}/questions`, {indexPage: indexPage.value})
                loadMath();
            });

            const nextPage = (() => {
                indexPage.value = parseInt(indexPage.value) + 1;
                Inertia.get(`/user/grades/${props.grade.id}/questions`, {indexPage: indexPage.value})
                loadMath();
            });

            const clickQuestion = ((index) => {
                indexPage.value = index;
                Inertia.get(`/user/grades/${props.grade.id}/questions`, {indexPage: indexPage.value})
                loadMath();
            });

            const loadMath = (() => {
                let recaptchaScript = document.createElement('script')
                recaptchaScript.setAttribute('src', '/assets/js/MathJax.js?config=TeX-AMS-MML_HTMLorMML')
                document.head.appendChild(recaptchaScript)

                function onMathJaxReady() {
                    const el = document.getElementById('elementId')
                    renderByMathjax(el)
                }
                initMathJax({}, onMathJaxReady);
            });

            const stopVideo = (() => {
                var iframe = document.getElementById("youtube-video");
                var iframeSrc = iframe.src;
                iframe.src = iframeSrc;
            });

            const indexAnswer = ((answerOrder, answer) => {
                var answerArray = answerOrder.split(',').map(Number);
                return options[answerArray.indexOf(answer)];
            });

            const closeVideo = (() => {
                stopVideo();
            });
            return {
                indexPage,
                options,
                stopVideo,
                closeVideo,
                indexAnswer,

                prevPage,
                nextPage,
                clickQuestion,
                loadMath
            }

        }
    }
</script>
