<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Data FAQ</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">FAQ</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Data FAQ</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="card border-top border-0 border-3 border-primary">
                <div class="card-body">
                    <h5 class="card-title">FAQs</h5>
                    <hr/>
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item" v-for="(faq, index) in faqs" :key="index">
                            <h2 class="accordion-header" :id="`heading_${faq.id}`">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" :data-bs-target="`#collapse_${faq.id}`" aria-expanded="false" :aria-controls="`collapse_${faq.id}`">
                                {{ faq.question }}
                                </button>
                            </h2>
                            <div :id="`collapse_${faq.id}`" class="accordion-collapse collapse" :aria-labelledby="`heading_${faq.id}`" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div v-html="faq.answer"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--end page wrapper -->
</template>

<script>
    //import layout user
    import LayoutUser from '../../../Layouts/Layout.vue';

    //import component pagination
    import Pagination from '../../../Components/Pagination.vue';

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
            Pagination
        },

        // props
        props: {
            faqs: Object
        },
    }
</script>
