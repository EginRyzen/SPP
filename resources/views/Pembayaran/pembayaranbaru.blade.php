@extends('front')

@section('csstable')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- DataTables -->
    <link href="{{ asset('dist/css/adminlte.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="row p-3 justify-content-center">
                <div class="col-md-3">
                    <div class="row">
                        <div class="card shadow-sm p-3">
                            <h6>Silahkan Pilih Tahun Ajaran</h6>
                            <div class="col-md-12">
                                <label for="">Pilih Kelas Terlebih Dahulu </label>
                                <form action="{{ url('pembayaranbaru') }}" method="GET">
                                    <div class="select2-purple">
                                        <select name="id_periode" class="form-control select2" onchange="this.form.submit()"
                                            style="width: 100%;">
                                            <option selected="selected">--- Pilih Tahun ---</option>
                                            @foreach ($tahunajaran as $data)
                                                <option value="{{ $data->id }}">{{ $data->periodekbm_periode }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @if (isset($datasiswa[0]['id_anggotakelas']))
                        <div class="row mt-3">
                            <div class="card shadow-sm p-3">
                                <h4>Detail Siswa</h4>
                                <div class="col-md-12">
                                    <ul class="d-flex list-unstyled">
                                        <li class="me-1">Nama </li>
                                        <li>: {{ $datasiswa[0]['nama'] }}</li>
                                    </ul>
                                    <ul class="d-flex list-unstyled">
                                        <li>Kelas :</li>
                                        <li class="ms-1">{{ $datasiswa[0]['nama_kelas'] }}</li>
                                    </ul>
                                    <ul class="d-flex list-unstyled">
                                        <li>Nisn :</li>
                                        <li class="ms-1">{{ $datasiswa[0]['nisn'] }}</li>
                                    </ul>
                                    <ul class="d-flex list-unstyled">
                                        <li>Nis :</li>
                                        <li class="ms-1">{{ $datasiswa[0]['nis'] }}</li>
                                    </ul>
                                    <ul class="d-flex list-unstyled">
                                        <li>Spp :</li>
                                        <li class="ms-1">Rp. {{ number_format($datasiswa[0]['nominal'], 0, ',', '.') }}
                                        </li>
                                    </ul>
                                    <ul class="d-flex list-unstyled">
                                        <li>Tahun :</li>
                                        <li class="ms-1">{{ $datasiswa[0]['periodekbm_periode'] }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row mt-3">
                        <div class="card shadow-lg p-3">
                            <h4>Cari Data Siswa</h4>
                            <form action="{{ url('pembayaranbaru') }}" method="GET">
                                <div class="col-md-12">
                                    <label for="">Pilih Kelas Terlebih Dahulu </label>
                                    <div class="select2-purple">
                                        <select name="idkelas" class="form-control select2" onchange="this.form.submit()"
                                            style="width: 100%;">
                                            <option selected="selected">--- Pilih Kelas ---</option>
                                            @foreach ($siswa as $data)
                                                <option value="{{ $data->kelas_id }}">{{ $data->nama_kelas }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>
                            <form action="{{ url('pembayaranbaru') }}" method="GET">
                                <div class="col-md-12">
                                    <label for="">Pilih Siswa</label>
                                    <div class="select2-purple">
                                        <select name="id_siswa" class="form-control select2" onchange="this.form.submit()"
                                            style="width: 100%;">
                                            <option value="" selected disabled>Silahkan Pilih Siswa</option>
                                            @foreach ($siswa as $data)
                                                <option value="{{ $data->id_anggotakelas }}">{{ $data->nama }} |
                                                    {{ $data->nama_kelas }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
                                                    <th>Bulan</th>
                                                    <th width="15%">Keterangan</th>
                                                    <th width="15%">Pilih</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($datasiswa[0]['id_anggotakelas']))
                                                    @php
                                                        $no = 1;
                                                    @endphp
                                                    <form action="{{ url('storebaru') }}" method="POST">
                                                        @foreach ($bulan as $bln)
                                                            <tr>
                                                                @if ($statusPembayaran[$bln] == 'Belum Dibayar')
                                                                    <td class="fw-bold">{{ $no++ }}.
                                                                    </td>
                                                                    <td class="fw-bold">
                                                                        {{ $bln }}</td>
                                                                    <td class="fw-bold">
                                                                        @csrf
                                                                        <input type="hidden" name="id_anggotakelas"
                                                                            value="{{ $datasiswa[0]['id_anggotakelas'] }}">
                                                                        <input type="hidden" name="tahun_bayar"
                                                                            value="{{ $datasiswa[0]['periodekbm_periode'] }}">
                                                                        <input type="hidden" name="nominal"
                                                                            value="{{ $datasiswa[0]['nominal'] }}">
                                                                        Belum Bayar
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input type="checkbox" name="bulan_bayar[]"
                                                                            value="{{ $bln }}">
                                                                    </td>
                                                                @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td>
                                                                <button type="submit"
                                                                    class="btn btn-primary mt-3">Proses</button>
                                                                @if (isset($datasiswa[0]['id_anggotakelas']))
                                                                    <a href="{{ url('print/' . $datasiswa[0]['id_anggotakelas']) }}"
                                                                        class="btn btn-secondary mt-3"
                                                                        target="_blank">Print</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    </form>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
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
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('dist/js/demo.js') }}"></script>
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
@endsection
