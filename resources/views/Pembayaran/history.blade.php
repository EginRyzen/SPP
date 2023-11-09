@extends('front')

@section('csstable')
    <!-- DataTables -->
    <link href="{{ url('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="row p-3">
                <h3 class="text-muted">
                    History Pembayaran
                </h3>
                <div class="col-md-12">
                    <div class="table-resposive">
                        <table class="table" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Petugas</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Tanggal</th>
                                    <th>Bulan Tahun</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($history as $data)
                                    <tr>
                                        <td class="font-weight-bold">{{ $no++ }}.</td>
                                        <td>{{ $data->nama_petugas }}</td>
                                        <td>{{ $data->nama }}</td>
                                        <td>{{ $data->nama_kelas }}</td>
                                        <td>{{ $data->tgl_bayar }}</td>
                                        <td>{{ $data->bulan_bayar . ' ' . $data->tahun_bayar }}</td>
                                        <td>Rp. {{ number_format($data->nominal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('table')
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Table -->
    <script src="{{ url('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('js/demo/datatables-demo.js') }}"></script>
@endsection
