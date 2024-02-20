<table>
    <thead>
        <tr>
            <th>No</th>
            <th width="25">Nama</th>
            <th width="25">Email</th>
            <th width="20">Provinsi</th>
            <th width="20">Kota/Kab</th>
            <th width="20">Kecamatan</th>
            <th width="20">Desa/Kelurahan</th>
            <th width="60">Alamat</th>
            <th width="20">Nomor Whatsapp</th>
            <th width="20">Kode Transaksi</th>
            <th width="20">Tanggal Transaksi</th>
            <th width="20">Kategori Peminatan</th>
            <th width="20">Keterangan</th>
            <th width="20">Total Pembayaran</th>
            <th width="15">Status Transaksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $index => $transaction)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $transaction->user->name }}</td>
                <td>{{ $transaction->user->email }}</td>
                <td>{{ $transaction->user->student->province->name }}</td>
                <td>{{ $transaction->user->student->city->name }}</td>
                <td>{{ $transaction->user->student->district->name }}</td>
                <td>{{ $transaction->user->student->village->name }}</td>
                <td>{{ $transaction->user->student->address }}</td>
                <td>{{ $transaction->user->student->phone_number }}</td>
                <th>{{ $transaction->code }}</th>
                <th>{{ $transaction->created_at }}</th>
                <th>{{ $transaction->category->name }}</th>
                <th>Pembelian {{ $transaction->examGroup ? $transaction->examGroup->title : ($transaction->exam ? $transaction->exam->title : '-') }}</th>
                <th>{{ $transaction->total_payment }}</th>
                <th>{{ $transaction->transaction_status }}</th>
            </tr>
        @endforeach
    </tbody>
</table>