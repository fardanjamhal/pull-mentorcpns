<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Soal</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Latihan Soal</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Soal</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <Link :href="`/user/categories/${categoryId}/lesson-categories/${lessonCategoryId}/lessons`" class="btn btn-primary btn-sm mt-2 mt-lg-0">Kembali</Link>
                </div>
            </div>
            <!--end breadcrumb-->
            <hr/>
            <div v-if="!exams.data.length">
                <div class="row row-cols-12 row-cols-md-12 row-cols-lg-12 row-cols-xl-12">
                    <div class="col">
                        <div class="card border-bottom border-3 border-0">
                            <div class="card-body">
                                <h5 class="card-title text-center">Soal Belum Tersedia.</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div v-if="$page.props.session.failed" class="alert alert-danger border-0">
                        <div v-html="$page.props.session.failed"></div>
                    </div>
                    <div v-if="$page.props.session.error" class="alert alert-danger border-0">
                        <div v-html="$page.props.session.error"></div>
                    </div>
                    <div v-if="$page.props.session.success" class="alert alert-success border-0">
                        <div v-html="$page.props.session.success"></div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3" v-for="(exam, index) in exams.data" :key="index">
                    <div class="card">       
                        <div v-if="$page.props.auth.user.member_type == 2">
                            <span v-if="(exam.transaction.length > 0 || checkMemberCategories(exam.member_categories) == true) && exam.member_categories" class="badge bg-danger" style="position:absolute; font-size: 14px; margin:4px;"></span>
                        </div>
                        <div class="p-2">
                            <img  v-bind:src="'/storage/upload_files/lessons/' + exam.lesson.thumbnail" class="card-img"/>
                        </div>

                        <div class="card-header">
                            <h6 class="card-title">{{ exam.title }}</h6>
                            <!-- <p class="card-text">Kerjakan Soal Sesuai Perintah Yang Ada Dalam Informasi.</p> -->
                        </div>
                        <div class="card-body" v-if="$page.props.auth.user.member_type == 2">  
                            <div v-if="($page.props.setting.purchase_type == 1 || $page.props.setting.purchase_type == 3)"  style="min-height: 50px;">
                                <div v-if="exam.price_before_discount == exam.price_after_discount">
                                    <h6 class="card-price text-center">Rp.{{ formatPrice(exam.price_after_discount) }}</h6>
                                </div>
                                <div v-else>
                                    <h6 class="text-dark text-center"><sup><s>Rp.{{ formatPrice(exam.price_before_discount) }}</s><span class="badge bg-danger mx-1">{{ formatPrice((exam.price_before_discount - exam.price_after_discount) / exam.price_before_discount * 100)}}% </span></sup><br>Rp.{{ formatPrice(exam.price_after_discount) }}
                                    </h6>
                                </div>                                        
                            </div>

                            <!-- check member categories -->
                            <div class="text-center" v-if="$page.props.setting.purchase_type == 2 || $page.props.setting.purchase_type == 3">
                                <div v-if="exam.member_categories">
                                    <span v-for="memberCategories in exam.member_categories" class="badge bg-success mb-0 ms-1"> 
                                        {{ memberCategories }}
                                    </span>
                                </div>
                                <div v-else>
                                    <span class="badge bg-success mb-0">Seluruh Member & Non Member</span>
                                </div>
                            </div>
                            <!-- end check member categories -->

                        </div>
                        <div class="card-footer">
                            <div v-if="exam.exam_status == 'active'">
                                <div v-if="$page.props.auth.user.member_type == 2">
                                    <div v-if="$page.props.setting.purchase_type == 1">
                                        <div v-if="exam.transaction.length > 0">
                                            <Link :href="`/user/categories/${exam.category_id}/lesson-categories/${exam.lesson_category_id}/lessons/${exam.lesson_id}/exams/${exam.id}`" class="btn btn-primary btn-sm w-100">Kerjakan Soal</Link>
                                        </div>
                                        <div v-else>
                                            <button class="btn btn-outline-primary btn-sm w-100" @click="buyExam(exam.id)">Beli Latihan Soal</button>         
                                        </div>
                                    </div>
                                    
                                    <div v-if="$page.props.setting.purchase_type == 2">
                                        <div v-if="checkMemberCategories(exam.member_categories) == true">
                                            <Link v-if="exam.exam_status == 'active'" :href="`/user/categories/${exam.category_id}/lesson-categories/${exam.lesson_category_id}/lessons/${exam.lesson_id}/exams/${exam.id}`" class="btn btn-primary btn-sm w-100">Kerjakan Soal</Link>
                                        </div>
                                        <div v-else>
                                            <Link :href="`/user/vouchers?category_id=${exam.category_id}`" class="btn btn-outline-primary btn-sm w-100">
                                                <div v-if="exam.member_categories.length == 1">
                                                    Upgrade Ke
                                                    <span v-for="memberCategories in exam.member_categories"> 
                                                        {{ memberCategories }}
                                                    </span>
                                                </div>
                                                <div v-else>
                                                    Upgrade Member
                                                </div>
                                            </Link> 
                                        </div>
                                    </div>     

                                    <div v-if="$page.props.setting.purchase_type == 3">
                                        <div v-if="exam.transaction.length > 0 && checkMemberCategories(exam.member_categories) == true">
                                            <Link :href="`/user/categories/${exam.category_id}/lesson-categories/${exam.lesson_category_id}/lessons/${exam.lesson_id}/exams/${exam.id}`" class="btn btn-primary btn-sm w-100 mb-2">Kerjakan Soal</Link>
                                        </div>

                                        <div v-if="(exam.transaction.length == 0 || checkMemberCategories(exam.member_categories) == false) && (exam.transaction.length > 0 || checkMemberCategories(exam.member_categories) == true)">
                                            <Link :href="`/user/categories/${exam.category_id}/lesson-categories/${exam.lesson_category_id}/lessons/${exam.lesson_id}/exams/${exam.id}`" class="btn btn-primary btn-sm w-100 mb-2">Kerjakan Soal</Link>
                                        </div>

                                        <div v-if="exam.transaction.length == 0">
                                            <button class="btn btn-outline-primary btn-sm w-100 mb-2" @click="buyExam(exam.id)">Beli Latihan Soal</button>       
                                        </div>

                                        <div v-if="checkMemberCategories(exam.member_categories) == false">
                                            <Link :href="`/user/vouchers?category_id=${exam.category_id}`" class="btn btn-outline-primary btn-sm w-100 mb-2">
                                                <div v-if="exam.member_categories.length == 1">
                                                    Upgrade Ke
                                                    <span v-for="memberCategories in exam.member_categories"> 
                                                        {{ memberCategories }}
                                                    </span>
                                                </div>
                                                <div v-else>
                                                    Upgrade Member
                                                </div>
                                            </Link>      
                                        </div>
                                    </div>   
                                </div>
                                <div v-else>
                                    <Link :href="`/user/categories/${exam.category_id}/lesson-categories/${exam.lesson_category_id}/lessons/${exam.lesson_id}/exams/${exam.id}`" class="btn btn-primary btn-sm w-100">Kerjakan Soal</Link>
                                </div>
                            </div>
                            <div v-else>
                                <button class="btn btn-sm w-100" :class="{ 'btn-danger': exam.exam_status == 'inactive', 'btn-warning': exam.exam_status === 'inprogress'}">
                                    {{ exam.exam_status === 'inactive' ? 'Non Active' : 'In Progress' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3" v-if="exams.data.length">
                <div class="col">
                    <Pagination :links="exams.links" align="center" />
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
    <!--end page wrapper -->
</template>

<script>
    //import layout admin
    import LayoutUser from '../../../../Layouts/Layout.vue';

    //import component pagination
    import Pagination from '../../../../Components/Pagination.vue';

    // import Link
    import { Link } from '@inertiajs/inertia-vue3';

    import { Inertia } from '@inertiajs/inertia';

    // import Head from Inertia
    import {
        Head
    } from '@inertiajs/inertia-vue3';

    //import sweet alert2
    import Swal from 'sweetalert2';

    export default {
        // layout
        layout: LayoutUser,

        // register components
        components: {
            Link,
            Head,
            Pagination
        },

        // props
        props: {
            exams: Object,
            categoryId: Object,
            lessonCategoryId: Object,
            lessonId: Object,
            userMemberCategories: Object,
        },
        setup(props) {
            const buyExam = (examId) => {
                Swal.fire({
                    title: 'Anda yakin akan membeli Latihan Soal ini ?',
                    text: "Pastikan Saldo Anda Cukup Untuk Bertransaksi",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Beli Latihan Soal',
                    cancelButtonText: 'Tidak'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        Inertia.get(`/user/account-balances/buy-exam/${examId}?type=exam`);
                    }
                })
            }

            const checkMemberCategories = (categories) => {
                if(categories) {
                    for (const entry of props.userMemberCategories) {
                        if (entry.member_categories.some(category => categories.includes(category))) {
                        return true;
                        }
                    }
                    return false;
                } else {
                    return true;
                }
            }

            return {
                buyExam,
                checkMemberCategories
            }
        },
        methods: {
            formatPrice(value) {
                let val = (value/1).toFixed().replace('.', ',')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            }
        }
    }
</script>
