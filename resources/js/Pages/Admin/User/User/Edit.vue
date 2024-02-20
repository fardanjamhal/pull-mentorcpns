<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Edit User</title>
    </Head>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">User</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit User</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <form @submit.prevent="submit">
                <div class="card border-top border-0 border-3 border-primary">
                    <input type="hidden" class="form-control" v-model="form.id" :class="{ 'is-invalid': errors.id }">
                    <div class="card-body">
                        <div class="d-lg-flex align-items-center">
                            <h6 class="card-title">Informasi Akun</h6>
                            <div class="ms-auto">
                                <Link href="/admin/users" class="btn btn-primary btn-sm mt-2 mt-lg-0">Kembali</Link>
                            </div>
                        </div>
                        <hr/>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" v-model="form.name" :class="{ 'is-invalid': errors.name }" placeholder="Nama">
                                <div v-if="errors.name" class="invalid-feedback">
                                    {{ errors.name }}
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <label class="form-label">Level</label>
                                <select v-model="form.level" :class="{ 'is-invalid': errors.level }" class="form-select">
                                    <option value="">[ Pilih ]</option>
                                    <option value="1">Admin</option>
                                    <option value="2">User</option>
                                </select>
                                <div v-if="errors.level" class="invalid-feedback">
                                    {{ errors.level }}
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" v-model="form.username" :class="{ 'is-invalid': errors.username }" placeholder="Username">
                                <div v-if="errors.username" class="invalid-feedback">
                                    {{ errors.username }}
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <label class="form-label">Email (Optional)</label>
                                <input type="email" class="form-control" v-model="form.email" :class="{ 'is-invalid': errors.email }" placeholder="Email">
                                <div v-if="errors.email" class="invalid-feedback">
                                    {{ errors.email }}
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <label class="form-label">password</label>
                                <input type="password" class="form-control" v-model="form.password" :class="{ 'is-invalid': errors.password }" placeholder="Password">
                                <div v-if="errors.password" class="invalid-feedback">
                                    {{ errors.password }}
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" v-model="form.password_confirmation" :class="{ 'is-invalid': errors.password_confirmation }" placeholder="Konfirmasi Password">
                                <div v-if="errors.password_confirmation" class="invalid-feedback">
                                    {{ errors.password_confirmation }}
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <label class="form-label">Tipe Member</label>
                                <select v-model="form.member_type" :class="{ 'is-invalid': errors.member_type }" class="form-select">
                                    <option value="">[ Pilih ]</option>
                                    <option value="1">Member Gratis Try Out</option>
                                    <option value="2">Member Try Out Berbayar </option>
                                </select>
                                <div v-if="errors.member_type" class="invalid-feedback">
                                    {{ errors.member_type }}
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <label class="form-label">Status Akun</label>
                                <select v-model="form.is_active" :class="{ 'is-invalid': errors.is_active }" class="form-select">
                                    <option value="">[ Pilih ]</option>
                                    <option value="1">Active</option>
                                    <option value="0">Non Active</option>
                                </select>
                                <div v-if="errors.is_active" class="invalid-feedback">
                                    {{ errors.is_active }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-top border-0 border-3 border-primary">
                    <div class="card-body">
                        <h6 class="card-title">Informasi Lainnya (Optional)</h6>
                        <hr/>
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6">
                                <label class="form-label">Jenis Kelamin</label>
                                <select v-model="form.gender" :class="{ 'is-invalid': errors.gender }" class="form-select">
                                    <option value="">[ Pilih ]</option>
                                    <option value="M">Laki-laki</option>
                                    <option value="F">Perempuan</option>
                                </select>
                                <div v-if="errors.gender" class="invalid-feedback">
                                    {{ errors.gender }}
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <label class="form-label">Nomor Whatsapp Aktif</label>
                                <input type="text" v-model="form.phone_number" :class="{ 'is-invalid': errors.phone_number }" class="form-control" placeholder="Nomor Hp (WA Aktif)">
                                <div v-if="errors.phone_number" class="invalid-feedback">
                                    {{ errors.phone_number }}
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <label class="form-label">Alamat</label>
                                <textarea cols="" rows="5" v-model="form.address" :class="{ 'is-invalid': errors.address }" class="form-control" placeholder="Alamat RT/RW/No Rumah"></textarea>
                                <div v-if="errors.address" class="invalid-feedback">
                                    {{ errors.address }}
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <label class="form-label">Provinsi</label>
                                <select  @change="cityData" v-model="form.province_id" :class="{ 'is-invalid': errors.province_id }" class="form-select">
                                    <option value="">[ Pilih ]</option>
                                    <option v-for="province in provinces" :value="province.id">
                                        {{ province.name }}
                                    </option>
                                </select>
                                <div v-if="errors.province_id" class="invalid-feedback">
                                    {{ errors.province_id }}
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <label class="form-label">Kota / Kab</label>
                                <select @change="districtData" v-model="form.city_id" :class="{ 'is-invalid': errors.city_id }" class="form-select">
                                    <option value="">[ Pilih ]</option>
                                    <option v-for="city in form.cities" :value="city.id">
                                    {{ city.name }}
                                    </option>
                                </select>
                                <div v-if="errors.city_id" class="invalid-feedback">
                                    {{ errors.city_id }}
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <label class="form-label">Kecamatan</label>
                                <select @change="villageData" v-model="form.district_id" :class="{ 'is-invalid': errors.district_id }" class="form-select">
                                    <option value="">[ Pilih ]</option>
                                    <option v-for="district in form.districts" :value="district.id">
                                    {{ district.name }}
                                    </option>
                                </select>
                                <div v-if="errors.district_id" class="invalid-feedback">
                                    {{ errors.district_id }}
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <label class="form-label">Desa / Kelurahan</label>
                                <select v-model="form.village_id" :class="{ 'is-invalid': errors.village_id }" class="form-select">
                                    <option value="">[ Pilih ]</option>
                                    <option v-for="village in form.villages" :value="village.id">
                                    {{ village.name }}
                                    </option>
                                </select>
                                <div v-if="errors.village_id" class="invalid-feedback">
                                    {{ errors.village_id }}
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                <button type="submit" class="btn btn-primary btn-sm px-5">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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

    import axios from 'axios';

    export default {
        // layout
        layout: LayoutAdmin,

        // register components
        components: {
            Link,
            Head,
        },
        data() {
            return {
                provinces: [],
            }
        },

        //props
        props: {
            errors: Object,
            user: Object,
        },
        mounted() {
            // get all provinces data
            axios.get('/region/province').then(response => {
                this.provinces = response.data;
            }).catch(error => console.error(error));
        },
        // initialization composition API
        setup(props) {         
            const form = reactive({
                id: props.user.id,
                name: props.user.name,
                email: props.user.email,
                username: props.user.username,
                password: '',
                password_confirmation: '',
                member_type: props.user.member_type,
                level: props.user.level,
                is_active: props.user.is_active,

                province_id: props.user.student && props.user.student.province_id ? props.user.student.province_id : '',
                city_id: props.user.student && props.user.student.city_id ? props.user.student.city_id : '',
                district_id: props.user.student && props.user.student.district_id ? props.user.student.district_id : '',
                village_id: props.user.student && props.user.student.village_id ? props.user.student.village_id : '',
                address: props.user.student && props.user.student.address ? props.user.student.address : '',
                phone_number: props.user.student && props.user.student.phone_number ? props.user.student.phone_number : '',
                gender: props.user.student && props.user.student.gender ? props.user.student.gender : '',
           
                // get from api
                cities: [],
                districts: [],
                villages: [],
            });

            const cityData = () => {
                axios.get(`/region/city/${form.province_id}`).then(response => {
                form.city_id = props.user.student.province_id == form.province_id ? props.user.student.city_id : '';
                form.district_id = props.user.student.city_id == form.city_id ? props.user.student.district_id : '';
                form.village_id = props.user.student.district_id == form.district_id ? props.user.student.village_id : '';

                form.cities = response.data;
                }).catch(error => console.error(error));
            }

            const districtData = () => {
                form.district_id = props.user.student.city_id == form.city_id ? props.user.student.district_id : '';
                form.village_id = props.user.student.district_id == form.district_id ? props.user.student.village_id : '';

                axios.get(`/region/district/${form.city_id}`).then(response => {
                form.districts = response.data;
                }).catch(error => console.error(error));
            }

            const villageData = () => {
                form.village_id = props.user.student.district_id == form.district_id ? props.user.student.village_id : '';

                axios.get(`/region/village/${form.district_id}`).then(response => {
                form.villages = response.data;
                }).catch(error => console.error(error));
            }

            // submit method
            const submit = () => {
                // send data to server
                Inertia.put(`/admin/users/${props.user.id}`, {
                    // data
                    id: form.id,
                    name: form.name,
                    email: form.email,
                    username: form.username,
                    password: form.password,
                    password_confirmation: form.password_confirmation,
                    member_type: form.member_type,
                    level: form.level,
                    is_active: form.is_active,

                    province_id: form.province_id,
                    city_id: form.city_id,
                    district_id: form.district_id,
                    village_id: form.village_id,
                    address: form.address,
                    phone_number: form.phone_number,
                    gender: form.gender,
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'User Berhasil Disimpan!.',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1000
                        });
                    },
                });
            }

            if(props.user.student) {
                cityData();
                districtData();
                villageData();
            }
            
            // return form state and submit method
            return {
                form,
                submit,
                cityData,
                districtData,
                villageData
            }
        }
    }
</script>
