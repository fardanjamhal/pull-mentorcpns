<template>
    <!--sidebar wrapper -->
		<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div>
					<img src="/assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
				</div>
				<div>
					<h4 class="logo-text">Rocker</h4>
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
				</div>
			</div>
			<!--navigation-->
            <!-- admin -->
			<ul class="metismenu" id="menu" v-if="$page.props.auth.user.level == 1">
                <li>
					<Link href="/admin/dashboard">
						<div class="parent-icon"><i class='bx bx-home-circle'></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</Link>
				</li>
				<li class="menu-label">Manajemen</li>
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx bx-grid-alt'></i>
						</div>
						<div class="menu-title">Master Data</div>
					</a>
					<ul>
						<li>
                            <Link href="/admin/categories">
                               <i class="bx bx-right-arrow-alt"></i>Kategori Peminatan
					        </Link>
                        </li>
                        <li>
                            <Link href="/admin/sub-categories">
                               <i class="bx bx-right-arrow-alt"></i>Sub Kategori Peminatan
					        </Link>
                        </li>
                        <li>
                            <Link href="/admin/users">
                               <i class="bx bx-right-arrow-alt"></i>User
					        </Link>
                        </li>
					</ul>
				</li>
				<li>
					<a class="has-arrow" href="javascript:;">
						<div class="parent-icon"><i class='bx bx-folder'></i>
						</div>
						<div class="menu-title">Mata Pelajaran</div>
					</a>
					<ul>
                        <li>
                            <Link href="/admin/lesson-categories">
                               <i class="bx bx-right-arrow-alt"></i>Kategori Mata Pelajaran
					        </Link>
                        </li>
                        <li>
                            <Link href="/admin/lessons">
                               <i class="bx bx-right-arrow-alt"></i>Mata Pelajaran
					        </Link>
                        </li>
                        <li>
                            <Link href="/admin/value-categories">
                               <i class="bx bx-right-arrow-alt"></i>Kategori Penilaian
					        </Link>
                        </li>
                        <li>
                            <Link href="/admin/question-titles">
                               <i class="bx bx-right-arrow-alt"></i>Soal
					        </Link>
                        </li>
					</ul>
				</li>
                <li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx bx-message-square-edit'></i>
						</div>
						<div class="menu-title">Try Out</div>
					</a>
					<ul>
						<li>
                            <Link href="/admin/exams">
                               <i class="bx bx-right-arrow-alt"></i>Try Out
					        </Link>
                        </li>
						<li> <a href="#"><i class="bx bx-right-arrow-alt"></i>Grup Try Out</a></li>
						<li> <a href="#"><i class="bx bx-right-arrow-alt"></i>Sesi Try Out</a></li>
					</ul>
				</li>
                <li class="menu-label">Transaksi</li>
                <li>
					<a href="/admin/banks">
						<div class="parent-icon"><i class='bx bx-credit-card-front'></i>
						</div>
						<div class="menu-title">Bank</div>
					</a>
				</li>
				<li>
					<a href="/admin/vouchers">
						<div class="parent-icon"><i class='bx bx-outline'></i>
						</div>
						<div class="menu-title">Paket Voucher</div>
					</a>
				</li>
                <li>
                    <Link href="/admin/transactions">
						<div class="parent-icon"><i class='bx bx-transfer'></i>
						</div>
						<div class="menu-title">Transaksi</div>
					</Link>
				</li>
			</ul>

            <!-- user -->
            <ul class="metismenu" id="menu" v-if="$page.props.auth.user.level == 2">
				<li>
					<Link href="/user/dashboard">
						<div class="parent-icon"><i class='bx bx-home-circle'></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</Link>
				</li>
                <li class="menu-label">Try Out & Try Out</li>
                <li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx bx-message-square-edit'></i>
						</div>
						<div class="menu-title">Latihan Soal</div>
					</a>
					<ul>
						<li>
                            <Link href="/user/categories">
                               <i class="bx bx-right-arrow-alt"></i>Kategori Peminatan
					        </Link>
                        </li>
                        <li>
                            <Link href="user/history-practice-questions">
                               <i class="bx bx-right-arrow-alt"></i>Riwayat Try Out
					        </Link>
                        </li>
					</ul>
				</li>
                <li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx bx-grid-alt'></i>
						</div>
						<div class="menu-title">Try Out</div>
					</a>
					<ul>
						<li>
                            <Link href="/user/joint-tryout">
                               <i class="bx bx-right-arrow-alt"></i>Try Out
					        </Link>
                        </li>
                        <li>
                            <Link href="/user/joint-tryout-history">
                               <i class="bx bx-right-arrow-alt"></i>Riwayat Try Out
					        </Link>
                        </li>
					</ul>
				</li>
                <li class="menu-label">Transaksi</li>
                <li>
					<Link href="/user/vouchers">
						<div class="parent-icon"><i class='bx bx-credit-card-front'></i>
						</div>
						<div class="menu-title">Paket Voucher</div>
					</Link>
				</li>
                <li>
					<Link href="/user/transactions">
						<div class="parent-icon"><i class='bx bx-transfer-alt'></i>
						</div>
						<div class="menu-title">Riwayat Transaksi</div>
					</Link>
				</li>
                <li>
					<Link href="users/voucher-activation">
						<div class="parent-icon"><i class='bx bx-outline'></i>
						</div>
						<div class="menu-title">Aktivasi Voucher</div>
					</Link>
				</li>
                <li class="menu-label">Materi</li>
                <li>
					<a href="user/material-discussions">
						<div class="parent-icon"><i class='bx bx-repeat'></i>
						</div>
						<div class="menu-title">Bahasan Materi</div>
					</a>
				</li>
                <li>
					<a href="user/online-learnings">
						<div class="parent-icon"><i class='bx bx-video-recording'></i>
						</div>
						<div class="menu-title">Pembelajaran Online</div>
					</a>
				</li>
			</ul>
			<!--end navigation-->
		</div>
		<!--end sidebar wrapper -->
</template>

<script>
    // import Link
    import { Link } from '@inertiajs/inertia-vue3';

    export default {
        // register component
        components: {
            Link
        }
    }
</script>
