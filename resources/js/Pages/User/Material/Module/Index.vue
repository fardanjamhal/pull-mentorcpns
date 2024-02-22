<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Data Materi / Modul</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Materi / Modul</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Data Materi / Modul</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <hr/>
            <div v-if="!categoryModules.length">
                <div class="row row-cols-12 row-cols-md-12 row-cols-lg-12 row-cols-xl-12">
                    <div class="col">
                        <div class="card border-bottom border-3 border-0">
                            <div class="card-body">
                                <h5 class="card-title text-center">Data Materi / Modul Belum Tersedia</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-for="category in categoryModules">
                <h5 class="mb-3">Materi / Modul {{ category.name }}</h5>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3" v-for="materialModule in category.module">
                        <div class="card">
                            <span class="badge bg-success" style="position:absolute; right:-15px; top:-15px; width:50px; height: 35px; font-size: 20px;">
                                <i class="fadeIn animated bx bx-book"></i>
                            </span>
                            <div class="card-body">
                                <div class="card-title mt-1">
                                    <h6 class="mb-0">{{ materialModule.title }}</h6>
                                </div>
                                <hr/>
                                <p class="card-text" style="min-height: 50px;">{{ materialModule.description }}</p>
                                <div class="text-center">
                                    <!-- <p>Kategori Member</p> -->
                                    <span v-if="materialModule.member_categories" v-for="member_categories in materialModule.member_categories" class="badge bg-success m-1">
                                        {{  member_categories  }}
                                    </span>
                                    <span v-else class="badge bg-success mb-0">Seluruh Member & Non Member</span>
                                </div>
                                <!-- <hr/> -->
                                <div class="text-center" style="margin-top: 3px;">
                                    <div v-if="checkMemberCategories(materialModule.category_id, materialModule.member_categories) == true">
                                        <a :href="materialModule.link" class="btn btn-primary btn-sm" target="_blank">Buka Materi</a>
                                    </div>
                                    <div v-else>
                                        <Link :href="`/user/vouchers?category_id=${materialModule.category_id}`" class="btn btn-outline-primary btn-sm w-100">
                                            <div v-if="materialModule.member_categories.length == 1">
                                                Upgrade Ke
                                                <span v-for="memberCategories in materialModule.member_categories"> 
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
                        </div>
                    </div>
                </div>
                <hr>
            </div>
            <!--end row-->
        </div>
    </div>
    <!--end page wrapper -->
</template>

<script>
    //import layout admin
    import LayoutUser from '../../../../Layouts/Layout.vue';

    // import Link
    import { Link } from '@inertiajs/inertia-vue3';

    // import Head from Inertia
    import {
        Head
    } from '@inertiajs/inertia-vue3';


    export default {
        // layout
        layout: LayoutUser,

        // register components
        components: {
            Link,
            Head,
        },

        // props
        props: {
            categoryModules: Object,
            userMemberCategories: Object
        },
        setup(props) {
            const checkMemberCategories = (category_id, categories) => {
                var userMemberCategories = props.userMemberCategories.filter(function(userMemberCategories) {
                    return userMemberCategories.category_id === category_id;
                });

                if(categories) {
                    for (const entry of userMemberCategories) {
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
                checkMemberCategories
            }
        }
    }
</script>
