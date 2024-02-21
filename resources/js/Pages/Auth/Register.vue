<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Register</title>
    </Head>

    <div class="d-flex align-items-center justify-content-center my-5 my-lg-0">
        <div class="container">
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2">
                <div class="col mx-auto">
                    <div class="my-4 text-center">
                        <img src="/assets/images/logo-img.png" width="180" alt="" />
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="border p-4 rounded">
                                <div class="text-center">
                                    <div style="text-align:center;" v-if="$page.props.setting && $page.props.setting.logo">
                                        <img v-bind:src="'/storage/upload_files/settings/' + $page.props.setting.logo" style="height:90px;"/>
                                    </div>
                                    <h3 class="">Registrasi</h3>
                                    <p>Sudah punya akun ? <Link href="/login">Login disini</Link>
                                    </p>
                                </div>
                                <div class="form-body">
                                    <form @submit.prevent="submit" class="row g-3">
                                        <div class="col-12">
                                            <label class="form-label">Nama Lengkap</label>
                                            <input type="text" v-model="form.name" :class="{ 'is-invalid': errors.name }" class="form-control" placeholder="Nama Lengkap">
                                            <div v-if="errors.name" class="invalid-feedback">
                                                {{ errors.name }}
                                            </div>
                                        </div>

                                        <div class="col-12" v-if="$page.props.setting.add_data_detail_for_registration == 1">
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

                                        <div class="col-12">
                                            <label class="form-label">Nomor Hp (WA Aktif Untuk Aktivasi Akun)</label>
                                            <input type="text" v-model="form.phone_number" :class="{ 'is-invalid': errors.phone_number }" class="form-control" placeholder="Nomor Hp (WA Aktif)">
                                            <div v-if="errors.phone_number" class="invalid-feedback">
                                                {{ errors.phone_number }}
                                            </div>
                                        </div>

                                        <div class="col-12" v-if="$page.props.setting.add_data_detail_for_registration == 1">
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

                                        <div class="col-12" v-if="$page.props.setting.add_data_detail_for_registration == 1">
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

                                        <div class="col-12" v-if="$page.props.setting.add_data_detail_for_registration == 1">
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

                                        <div class="col-12" v-if="$page.props.setting.add_data_detail_for_registration == 1">
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

                                        <div class="col-12" v-if="$page.props.setting.add_data_detail_for_registration == 1">
                                            <label class="form-label">Alamat</label>
                                            <textarea cols="30" rows="10" v-model="form.address" :class="{ 'is-invalid': errors.address }" class="form-control" placeholder="Alamat RT/RW/No Rumah"></textarea>
                                            <div v-if="errors.address" class="invalid-feedback">
                                                {{ errors.address }}
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Username</label>
                                            <input type="text" v-model="form.username" :class="{ 'is-invalid': errors.username }" class="form-control" placeholder="Username">
                                            <div v-if="errors.username" class="invalid-feedback">
                                                {{ errors.username }}
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Email</label>
                                            <input type="email" v-model="form.email" :class="{ 'is-invalid': errors.email }" class="form-control" placeholder="Email">
                                            <div v-if="errors.email" class="invalid-feedback">
                                                {{ errors.email }}
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Password</label>
                                            <input type="password" v-model="form.password" :class="{ 'is-invalid': errors.password }" class="form-control" placeholder="Password">
                                            <div v-if="errors.password" class="invalid-feedback">
                                                {{ errors.password }}
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Konfirmasi Password</label>
                                            <input type="password" v-model="form.password_confirmation" :class="{ 'is-invalid': errors.password_confirmation }" class="form-control" placeholder="Konfirmasi Password">
                                            <div v-if="errors.password_confirmation" class="invalid-feedback">
                                                {{ errors.password_confirmation }}
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary"><i class='bx bx-user'></i>Registrasi</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
</template>

<script>
    //import layout
    import LayoutAuth from '../../Layouts/Auth.vue';

    // import Head form Inertia
    import { Head } from '@inertiajs/inertia-vue3';

    //import reactive
    import { reactive } from 'vue';

    // import link
    import { Link } from '@inertiajs/inertia-vue3';

    //import inertia adapter
    import { Inertia } from '@inertiajs/inertia';

    //import axios
    import axios from 'axios';

    export default {
        // layout
        layout: LayoutAuth,

        components: {
            Head,
            Link
        },
        data() {
            return {
                cities: [],
                provinces: [],
            }
        },

        //props
        props: {
            errors: Object,
            session: Object,
            cities: Object,
        },
        mounted() {
            // get all provinces data
            axios.get('region/province').then(response => {
                this.provinces = response.data;
            }).catch(error => console.error(error));
        },

        setup(props) {
            const form = reactive({
                name: '',
                email: '',
                username: '',
                password: '',
                password_confirmation: '',
                province_id: '',
                city_id: '',
                district_id: '',
                village_id: '',
                address: '',
                phone_number: '',
                gender: '',
                // get from api
                cities: [],
                districts: [],
                villages: [],
            });

            const cityData = () => {
                form.city_id = '';
                form.district_id = '';
                form.village_id = '';
                axios.get(`/region/city/${form.province_id}`).then(response => {
                form.cities = response.data;
                }).catch(error => console.error(error));
            }

            const districtData = () => {
                form.district_id = '';
                form.village_id = '';
                axios.get(`/region/district/${form.city_id}`).then(response => {
                form.districts = response.data;
                }).catch(error => console.error(error));
            }

            const villageData = () => {
                form.village_id = '';
                axios.get(`/region/village/${form.district_id}`).then(response => {
                form.villages = response.data;
                }).catch(error => console.error(error));
            }

            // submit method
            const submit = () => {
                // send data to server
                Inertia.post('/register', {
                    // data
                    name: form.name,
                    email: form.email,
                    username: form.username,
                    password: form.password,
                    password_confirmation: form.password_confirmation,
                    province_id: form.province_id,
                    city_id: form.city_id,
                    district_id: form.district_id,
                    village_id: form.village_id,
                    address: form.address,
                    phone_number: form.phone_number,
                    gender: form.gender,
                });
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
