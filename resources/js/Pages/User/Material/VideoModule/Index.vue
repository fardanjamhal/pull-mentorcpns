<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Data Video Pembelajaran</title>
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
                            <li class="breadcrumb-item active" aria-current="page">Data Video Pembelajaran</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->
            <hr/>
            <div v-if="!categoryVideoModules.length">
                <div class="row row-cols-12 row-cols-md-12 row-cols-lg-12 row-cols-xl-12">
                    <div class="col">
                        <div class="card border-bottom border-3 border-0">
                            <div class="card-body">
                                <h5 class="card-title text-center">Data Video Pembelajaran Belum Tersedia.</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-for="category in categoryVideoModules">
                <!-- <h5 class="mb-3">Video Pembelajaran {{ category.name }}</h5> -->
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3" v-for="videoModule in category.video_module">

                        <div class="card">
                            <span class="badge bg-danger" style="position:absolute; right:-15px; top:-15px; width:50px; height: 35px; font-size: 20px;">
                                <i class="fadeIn animated bx bx-book"></i>
                            </span>
                            <div class="card-body">
                                <div class="card-title mt-1">
                                    <h6 class="mb-0">{{ videoModule.title }}</h6>
                                </div>
                                <hr/>
                                <!-- <p class="card-text" style="min-height: 50px;">{{ videoModule.description }}</p> -->
                                <div class="text-center">
                                    <!-- <p>Kategori Member</p> -->
                                    <span v-if="videoModule.member_categories" v-for="member_categories in videoModule.member_categories" class="badge bg-success m-1">
                                        {{  member_categories  }}
                                    </span>
                                    <span v-else class="badge bg-success mb-0">Seluruh Member & Non Member</span>
                                </div>
                                <!-- <hr/> -->
                                <div class="text-center" style="margin-top: 3px;">
                                    <div v-if="checkMemberCategories(videoModule.category_id, videoModule.member_categories) == true">
                                        <!-- <a :href="videoModule.link" class="btn btn-primary btn-sm" target="_blank">Buka Video2</a> -->
                                        <br>
                                        <div class="text-start">
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleFullScreenModal">01 TIU : Deret</button>
                                        </div>
                                        <div class="modal fade" id="exampleFullScreenModal" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-fullscreen">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">01 TIU : Deret</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" @click="closeVideo()" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-0 m-0">
                                                        <iframe width="100%" id="youtube-video" height="100%" :src="`https://www.youtube.com/embed/xMOq5WQM10A`" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"  @click="closeVideo()">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="text-start">
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#exampleFullScreenModal2">02 TWK : Nasionalisme (Part 1)</button>
                                        </div>
                                        <div class="modal fade" id="exampleFullScreenModal2" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-fullscreen">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">02 TWK : Nasionalisme (Part 1)</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" @click="closeVideo()" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-0 m-0">
                                                        <iframe width="100%" id="youtube-video" height="100%" :src="`https://www.youtube.com/embed/HPIuHZ0xyfQ`" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"  @click="closeVideo()">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="text-start">
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#exampleFullScreenModal3">03 TWK : Nasionalisme (Part 2)</button>
                                        </div>
                                        <div class="modal fade" id="exampleFullScreenModal3" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-fullscreen">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">03 TWK : Nasionalisme (Part 2)</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" @click="closeVideo()" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-0 m-0">
                                                        <iframe width="100%" id="youtube-video" height="100%" :src="`https://www.youtube.com/embed/oua7mWZphGc`" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"  @click="closeVideo()">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="text-start">
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#exampleFullScreenModal4">04 TWK : Nasionalisme (Part 3)</button>
                                        </div>
                                        <div class="modal fade" id="exampleFullScreenModal4" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-fullscreen">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">04 TWK : Nasionalisme (Part 3)</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" @click="closeVideo()" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-0 m-0">
                                                        <iframe width="100%" id="youtube-video" height="100%" :src="`https://www.youtube.com/embed/CP84rYOmB0s`" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"  @click="closeVideo()">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="text-start">
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#exampleFullScreenModal5">05 TIU : Analitis</button>
                                        </div>
                                        <div class="modal fade" id="exampleFullScreenModal5" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-fullscreen">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">05 TIU : Analitis</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" @click="closeVideo()" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-0 m-0">
                                                        <iframe width="100%" id="youtube-video" height="100%" :src="`https://www.youtube.com/embed/VeCuOvkfnXk`" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"  @click="closeVideo()">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    <div v-else>
                                        <Link :href="`/user/vouchers?category_id=${videoModule.category_id}`">
                                            <div v-if="videoModule.member_categories.length == 1">
                                                <br>
                                                <div class="text-start">
                                                <button type="button" class="btn btn-sm btn-danger">01 TWK : Nasionalisme</button>
                                                </div>
                                                <br>
                                                <div class="text-start">
                                                <button type="button" class="btn btn-sm btn-danger">02 TWK : Nasionalisme (Part 2)</button>
                                                </div>
                                                <br>
                                                <div class="text-start">
                                                <button type="button" class="btn btn-sm btn-danger">03 TWK : Integritas</button>
                                                </div>
                                                <br>
                                                <div class="text-start">
                                                <button type="button" class="btn btn-sm btn-danger">04 TWK : Bela Negara</button>
                                                </div>
                                                <br>
                                                <div class="text-start">
                                                <button type="button" class="btn btn-sm btn-danger">05 TWK : Pilar Negara (Part 1)</button>
                                                </div>
                                                <br>
                                                <div class="text-start">
                                                <button type="button" class="btn btn-sm btn-danger">06 TWK : Pilar Negara (Part 2)</button>
                                                </div>
                                                <br>
                                                <div class="text-start">
                                                <button type="button" class="btn btn-sm btn-danger">07 TWK : Bahasa Indonesia (Part 1)</button>
                                                </div>
                                                <br>
                                                <div class="text-start">
                                                <button type="button" class="btn btn-sm btn-danger">08 TWK : Bahasa Indonesia (Part 2)</button>
                                                </div>
                                                <br>
                                                <div class="text-start">
                                                <button type="button" class="btn btn-sm btn-primary">01 TIU : Analogi</button>
                                                </div>
                                                <br>
                                                <div class="text-start">
                                                <button type="button" class="btn btn-sm btn-primary">02 TIU : Silogisme</button>
                                                </div>
                                                <br>
                                                <div class="text-start">
                                                <button type="button" class="btn btn-sm btn-primary">03 TIU : Analitis </button>
                                                </div>
                                                <br>
                                                <div class="text-start">
                                                <button type="button" class="btn btn-sm btn-primary">04 TIU : Hitung Cepat</button>
                                                </div>
                                                <br>
                                                <div class="text-start">
                                                <button type="button" class="btn btn-sm btn-primary">05 TIU : Deret</button>
                                                </div>
                                                <br>
                                                <div class="text-start">
                                                <button type="button" class="btn btn-sm btn-primary">06 TIU : Perbandingan Kuantitatif </button>
                                                </div>
                                                <br>
                                                <div class="text-start">
                                                <button type="button" class="btn btn-sm btn-primary">07 TIU : Soal Cerita</button>
                                                </div>
                                                <br>
                                                <div class="text-start">
                                                <button type="button" class="btn btn-sm btn-primary">08 TIU : Figural Pertidaksamaan</button>
                                                </div>
                                                <br>
                                                <div class="text-start">
                                                <button type="button" class="btn btn-sm btn-primary">09 TIU : Figural Analogi</button>
                                                </div>
                                                <br>
                                                <div class="text-start">
                                                <button type="button" class="btn btn-sm btn-primary">10 TIU : Figural Serial</button>
                                                </div>
                                                <br>
                                                <div class="text-start">
                                                <button type="button" class="btn btn-sm btn-success">01 TKP : Pelayanan Publik</button>
                                                </div>
                                                <br>
                                                <div class="text-start">
                                                <button type="button" class="btn btn-sm btn-success">02 TKP : Jejaring Kerja</button>
                                                </div>
                                                <br>
                                                <div class="text-start">
                                                <button type="button" class="btn btn-sm btn-success">03 TKP : Sosial Budaya</button>
                                                </div>
                                                <br>
                                                <div class="text-start">
                                                <button type="button" class="btn btn-sm btn-success">04 TKP : Profesionalisme</button>
                                                </div>
                                                <br>
                                                <div class="text-start">
                                                <button type="button" class="btn btn-sm btn-success">05 TKP : TIK</button>
                                                </div>
                                                <br>
                                                <div class="text-start">
                                                <button type="button" class="btn btn-sm btn-success">06 TKP : Anti Radikalisme</button>
                                                </div>
                                                <br>
                                                <div class="text-start">
                                                <button type="button" class="btn btn-sm btn-success">07 TKP : Materi Tambahan Sering Muncul (Part 1)</button>
                                                </div>
                                                <br>
                                                <div class="text-start">
                                                <button type="button" class="btn btn-sm btn-success">08 TKP : Materi Tambahan Sering Muncul (Part 2)</button>
                                                </div>
                                                <!-- Upgrade Ke -->
                                                <span v-for="memberCategories in videoModule.member_categories"> 
                                                    <!-- {{ memberCategories }} -->
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
    // Import komponen dan pustaka yang diperlukan
    import LayoutUser from '../../../../Layouts/Layout.vue';
    import { Link } from '@inertiajs/inertia-vue3';
    import { Head } from '@inertiajs/inertia-vue3';

    export default {
        // Menetapkan layout
        layout: LayoutUser,

        // Mendaftarkan komponen
        components: {
            Link,
            Head,
        },

        // Props yang diterima
        props: {
            categoryVideoModules: Array,
            userMemberCategories: Array,
        },
        
        data() {
            return {
                selectedVideoModule: null
            };
        },

        methods: {
            // Memeriksa kategori member
            checkMemberCategories(category_id, categories) {
                var userMemberCategories = this.userMemberCategories.filter(function(userMemberCategory) {
                    return userMemberCategory.category_id === category_id;
                });

                if (categories) {
                    for (const entry of userMemberCategories) {
                        if (entry.member_categories.some(category => categories.includes(category))) {
                            return true;
                        }
                    }
                    return false;
                } else {
                    return true;
                }
            },

            // Berhenti memutar video
            stopVideo() {
                var iframe = document.getElementById("youtube-video");
                var iframeSrc = iframe.src;
                iframe.src = iframeSrc;
            },

            // Menutup modal video
            closeVideo() {
                this.stopVideo();
                window.location.reload(); // Memuat ulang halaman
            },

            // Membuka modal video
            openModal(videoModule) {
                this.selectedVideoModule = videoModule;
                $('#exampleFullScreenModal').modal('show'); // Menampilkan modal menggunakan jQuery
            }
        }
    }
</script>
