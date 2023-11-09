@extends('front')

@section('csstable')
    <!-- DataTables -->
    <link href="{{ url('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="row p-3 justify-content-center">
                <div class="col-md-3">
                    <div class="row">
                        <div class="card shadow-sm p-3">
                            <h4>Silahkan Pilih Kelas</h4>
                            <div class="col-md-12">
                                <label for="">Pilih Kelas Terlebih Dahulu </label>
                                <form action="{{ url('pembayaran') }}" method="GET">
                                    <select name="id_kelas" class="form-select" id=""
                                        onchange="this.form.submit()">
                                        <option value="" selected disabled>--- Silahkan Pilih Kelas ---</option>
                                        @foreach ($kelas as $data)
                                            <option value="{{ $data->id }}">{{ $data->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                    <form action="{{ url('cart') }}" method="GET">
                        <div class="row mt-3">
                            <div class="card shadow-lg p-3">
                                <h4>Data Siswa</h4>
                                <div class="col-md-12">
                                    <label for="">Pilih Siswa</label>
                                    <select name="id_siswa" class="form-select" id="" required>
                                        <option value="" selected disabled>--- Silahkan Pilih Siswa ---</option>
                                        @foreach ($siswa as $data)
                                            <option value="{{ $data->id }}">{{ $data->nama }} |
                                                {{ $data->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="">Bulan/Tahun</label>
                                    <input type="month" class="form-control" name="month">
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-success float-end mt-2" type="submit">Tambahkan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-8 ms-2">
                    <div class="row">
                        <div class="card shadow-sm p-3">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-responsive">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>Kelas</th>
                                                    <th>Bulan/Tahun</th>
                                                    <th>Jumlah Bayar</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no = 1;
                                                    $total = 0;
                                                @endphp
                                                @if (session()->has('cart'))
                                                    @foreach (session('cart') as $id => $data)
                                                        @php
                                                            $total = $total + $data['jumlah'] * $data['jumlah_bayar'];
                                                        @endphp
                                                        <tr>
                                                            <td class="fw-bold">{{ $no++ }}.</td>
                                                            <td>{{ $data['nama'] }}</td>
                                                            <td>{{ $data['kelas'] }}</td>
                                                            <td>{{ $data['bulan_bayar'] . ' ' . $data['tahun_bayar'] }}
                                                            </td>
                                                            <td>Rp. {{ number_format($data['jumlah_bayar'], 0, ',', '.') }}
                                                            </td>
                                                            <td class="text-center"><a {{-- href="{{ url('hapus/' . $data['id_siswa'] . '/' . $data['bulan_dibayar'] . '/' . $data['tahun_dibayar']) }}" --}}
                                                                    href="{{ url('hapus/' . $data['id']) }}"
                                                                    class="text-danger"><i class="fa fa-trash"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="4" class="text-center font-weight-bold">
                                                        </td>
                                                        <td colspan="2">Rp. {{ number_format($total, 0, ',', '.') }}
                                                        </td>
                                                    </tr>
                                                @else
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    @if (session()->has('cart'))
                                        <div class="float-end mt-4">
                                            <a role="button" href="{{ url('reset') }}" class="btn btn-danger">Reset</a>
                                            <a role="button" href="{{ url('store') }}" class="btn btn-primary">Simpan</a>
                                        </div>
                                    @else
                                    @endif
                                </div>
                            </div>
                        </div>
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
