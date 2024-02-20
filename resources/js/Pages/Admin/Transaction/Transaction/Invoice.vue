<template>
    <Head>
        <title>{{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }} - Detail Transaksi</title>
    </Head>
    <!--start page wrapper -->
	<div class="page-wrapper">
		<div class="page-content">
			<!--breadcrumb-->
			<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
				<div class="breadcrumb-title pe-3">Transaksi</div>
				<div class="ps-3">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb mb-0 p-0">
							<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
							</li>
							<li class="breadcrumb-item active" aria-current="page">Detail Transaksi</li>
						</ol>
					</nav>
				</div>
			</div>
			<!--end breadcrumb-->
			<div class="card border-top border-0 border-3 border-primary">
				<div class="card-body">
					<div id="invoice">
						<div class="invoice overflow-auto">
							<div style="min-width: 600px">
								<header>
									<div class="row">
										<div class="col">
                                            <span class="badge bg-warning" v-if="transaction.transaction_status == 'pending'">
                                                <h6 style="color:#000; height: 10px;">Menunggu Pembayaran</h6>
                                            </span>

                                            <span class="badge bg-success" v-if="transaction.transaction_status == 'paid'">
                                                <h6 style="color:#fff; height: 10px;">Sudah Dibayar, Menunggu Verifikasi Admin</h6>
                                            </span>

                                            <span class="badge bg-danger" v-if="transaction.transaction_status == 'failed'">
                                                <h6 style="color:#fff; height: 10px;">Transaksi Gagal</h6>
                                            </span>

                                            <span class="badge bg-primary" v-if="transaction.transaction_status == 'done'">
                                                <h6 style="color:#fff; height: 10px;">Transaksi Selesai</h6>
                                            </span>
										</div>
										<div class="col company-details">
											<h2 class="name">
												<a target="_blank" href="javascript:;">
                                                    {{ $page.props.setting.app_name ?? 'Atur Setting Terlebih Dahulu' }}
												</a>
											</h2>
											<div>{{ $page.props.setting.address ?? 'Atur Setting Terlebih Dahulu' }}</div>
											<div>{{ $page.props.setting.whatsapp_number ?? 'Atur Setting Terlebih Dahulu' }}</div>
											<div>{{ $page.props.setting.email ?? 'Atur Setting Terlebih Dahulu' }}</div>
										</div>
									</div>
								</header>
								<main>
									<div class="row contacts">
										<div class="col invoice-to">
											<div class="text-gray-light">Faktur Untuk:</div>
											<h2 class="to">{{ transaction.user.name }}</h2>
											<div class="address">
                                                {{ transaction.user.student && transaction.user.student.address ? transaction.user.student.address :  '-' }},
                                                {{ transaction.user.student && transaction.user.student.village ? transaction.user.student.village.name :  '-' }}
                                                Desa/Kel.  {{ transaction.user.student && transaction.user.student.village ? transaction.user.student.village.name :  '-' }},
                                                Kec.  {{ transaction.user.student && transaction.user.student.district ? transaction.user.student.district.name :  '-' }},
                                                Kota/Kab.  {{ transaction.user.student && transaction.user.student.city ? transaction.user.student.city.name :  '-' }},
                                                Provinsi {{ transaction.user.student && transaction.user.student.province ? transaction.user.student.province.name :  '-' }}
                                                <br>
                                                {{ transaction.user.student.phone_number }}
                                            </div>
											<div class="email">{{ transaction.user.email ?? '-' }}</div>
										</div>
										<div class="col invoice-details">
											<h1 class="invoice-id">{{ transaction.code }}</h1>
											<div class="date">Tanggal Faktur : {{ transaction.created_at }}</div>
											<!-- <div class="date">Batas Waktu Pembayaran: {{ transaction.maximum_payment_time }}</div> -->
										</div>
									</div>
									<table>
										<thead>
											<tr>
												<th>#</th>
												<th class="text-left">Deskripsi</th>
												<th class="text-right">Harga</th>
												<th class="text-right">Total</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="no">01</td>
												<td class="text-left">
                                                    {{ transaction.description }}
                                                </td>
												<td class="unit">{{ formatPrice(transaction.total_payment)  }}</td>
												<td class="total">{{ formatPrice(transaction.total_payment) }}</td>
											</tr>
										</tbody>
										<tfoot>
											<tr>
												<td colspan="2"></td>
												<td>Sub Total</td>
												<td>{{ formatPrice(transaction.total_payment) }}</td>
											</tr>
											<tr>
												<td colspan="2"></td>
												<td>Pajak 0%</td>
												<td>Rp. 0.00</td>
											</tr>
											<tr>
												<td colspan="2"></td>
												<td>TOTAL PEMBAYARAN</td>
												<td>{{ formatPrice(transaction.total_payment) }}</td>
											</tr>
										</tfoot>
									</table>
                                    <h4 class="text-center">Silakan lakukan pembayaran melalui bank dibawah ini</h4>
                                    <br>
                                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-3">
                                        <div class="col" v-for="bank in banks">
                                            <div class="card border-bottom border-3 border-0">
                                                <div style="height:75px;">
                                                    <center>
                                                        <img  v-bind:src="'/storage/upload_files/banks/' + bank.image" style="width:125px; margin-top:20px;"/>
                                                    </center>
                                                </div>
                                                <div class="card-body">
                                                    <center>
                                                        <h5 class="card-title">{{ bank.bank_name }}</h5>
                                                        <p class="card-text">{{ bank.rekening_number }}</p>
                                                        <p class="card-text"><b>{{ bank.rekening_name }}</b></p>
                                                    </center>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<!-- <div class="notices">
										<div>Perhatian!</div>
										<div class="notice">
                                            Batas waktu pembayaran akan Habis pada 2 hari (2 x 24 jam) dari waktu transaksi, maka lakukan pembayaran & konfirmasi sebelum <span class="badge bg-danger">{{ transaction.maximum_payment_time }} </span><br><br>
                                            Setelah melakukan pembayaran, silakan lakukan konfirmasi melalui Whatsapp di <b>{{ $page.props.setting.whatsapp_number ?? 'Atur Setting Terlebih Dahulu' }}</b> dengan menyertakan nomor faktur serta bukti transfer pembayaran. terimakasih
                                        </div>
									</div> -->
								</main>
								<footer>Faktur dibuat di komputer dan berlaku tanpa tanda tangan dan stempel.</footer>
							</div>
							<!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
							<div></div>
						</div>
					</div>


				</div>
			</div>
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
            transaction: Object,
            banks: Object,
        },

        methods: {
            formatPrice(value) {
                let val = (value/1).toFixed().replace('.', ',')
                return 'Rp.' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            }
        }
    }
</script>
