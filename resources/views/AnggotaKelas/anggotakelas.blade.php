@extends('front')

@section('csstable')
    <!-- DataTables -->
    <link href="{{ url('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- DataTables -->
    <link href="{{ asset('dist/css/adminlte.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="row p-3">
                <div class="col-md-12">
                    <div class="fresh-table full-color-orange">
                        <div class="toolbar">
                            {{-- <button class="btn btn-default">Import Data</button> --}}
                            @if (session()->has('pesan'))
                                <p class="text-danger fw-bold">Data Siswa Tinggal 1 Satu Tidak Dapat Di Hapus!!</p>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class="table" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Nama Kelas</th>
                                        <th>KompetensiKeahlian</th>
                                        <th>Nominal SPP</th>
                                        <th>PeroiodeTahun</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($anggota_kelas as $data)
                                        <tr>
                                            <td class="fw-bold">{{ $no++ }}.</td>
                                            <td class="fw-bold">{{ Str::limit($data->nama, 20) }}</td>
                                            <td class="fw-bold">{{ $data->nama_kelas }}</td>
                                            <td class="fw-bold">{{ $data->kompetensi_keahlian }}</td>
                                            <td class="fw-bold">Rp. {{ number_format($data->nominal, 0, ',', '.') }}</td>
                                            <td class="fw-bold">{{ $data->periodekbm_periode }}</td>
                                            <td class="text-center">
                                                <a href="{{ $data->id }}" type="button" class="m-2"
                                                    data-toggle="modal" data-target="#kelas" data-aksi="edit"
                                                    data-id="{{ $data->id }}" data-kelas="{{ $data->idkelas }}"
                                                    data-siswa="{{ $data->idsiswa }}"
                                                    data-periode="{{ $data->idperiode }}"
                                                    data-setting="{{ $data->idsetting }}"><i class="fa fa-edit"></i></a>

                                                <a href="{{ url('anggotakelas/' . $data->id) }}"><i
                                                        class="fa fa-trash"></i></a>

                                                <a href="{{ url('kelas/' . $data->id) }}" class="m-2"
                                                    data-aksi="duplicate" data-toggle="modal" data-target="#kelas"
                                                    data-aksi="edit" data-id="{{ $data->id }}"
                                                    data-kelas="{{ $data->idkelas }}" data-siswa="{{ $data->idsiswa }}"
                                                    data-periode="{{ $data->idperiode }}"
                                                    data-setting="{{ $data->idsetting }}"><i
                                                        class="fas fa-user-plus"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Create Modal --}}
    <div class="modal fade" id="kelas" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Anngota Kelas</h5>
                    <button class="btn btn-default close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('kelas.store') }}" method="POST" id="fstore">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="_method" id="method" value="">
                        <div class="form-group row">
                            <div class="col-md-3 mt-2">
                                <label for="">Nama Siswa :</label>
                            </div>
                            <div class="col-md-8">
                                <div class="select2-purple">
                                    <select name="idkelas" id="selectKelas" class="form-control select2"
                                        style="width: 100%;">
                                        <option selected="selected">--- Pilih Kelas ---</option>
                                        @foreach ($kelas as $data)
                                            <option value="{{ $data->id }}">{{ $data->nama_kelas }} |
                                                {{ $data->kompetensi_keahlian }} | {{ $data->periodekbm_periode }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 mt-2">
                                <label for="">Nama Siswa :</label>
                            </div>
                            <div class="col-md-8">
                                <div class="select2-purple">
                                    <select name="idsiswa" id="selectSiswa" class="form-control select2"
                                        style="width: 100%;">
                                        <option selected="selected">--- Pilih Siswa ---</option>
                                        @foreach ($siswa as $data)
                                            <option value="{{ $data->id }}">{{ $data->nama }} |
                                                {{ $data->nis }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 mt-2">
                                <label for="">SPP :</label>
                            </div>
                            <div class="col-md-8">
                                <div class="select2-purple">
                                    <select name="id_settingspp" id="selectSpp" class="form-control select2"
                                        style="width: 100%;">
                                        <option selected="selected">--- Pilih SPP ---</option>
                                        @foreach ($settingspp as $data)
                                            <option value="{{ $data->id }}">{{ $data->nominal }} |
                                                {{ $data->periodekbm_periode }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 mt-2">
                                <label for="">Periode Tahun :</label>
                            </div>
                            <div class="col-md-8">
                                <div class="select2-purple">
                                    <select name="idperiode" id="selectPeriode" class="form-control select2"
                                        style="width: 100%;">
                                        <option selected="selected">--- Pilih Tahun ---</option>
                                        @foreach ($periode as $data)
                                            <option value="{{ $data->id }}">{{ $data->periodekbm_periode }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('table')
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('dist/js/demo.js') }}"></script>
    <script>
        $(function() {
            $('#kelas').on('show.bs.modal', function(event) {
                console.log('Modal is about to show');
                var btn = $(event.relatedTarget);
                var aksi = btn.data('aksi');

                var id = btn.data('id');
                var idkelas = btn.data('kelas');
                var idsiswa = btn.data('siswa');
                var idperiode = btn.data('periode');
                var idsetting = btn.data('setting');
                // alert(idsetting);

                if (aksi === 'edit') {
                    $('#fstore').attr('action', 'anggotakelas/' + id);
                    $('#selectKelas').val(idkelas).trigger('change');
                    $('#selectSiswa').val(idsiswa).trigger('change');
                    $('#selectPeriode').val(idperiode).trigger('change');
                    $('#selectSpp').val(idsetting).trigger('change');
                    $('#method').val('PUT');
                }
                if (aksi === 'duplicate') {
                    $('#fstore').attr('action', 'anggotakelas');
                    $('#selectKelas').val(idkelas).trigger('change');
                    $('#selectSiswa').val(idsiswa).trigger('change');
                    $('#selectPeriode').val(idperiode).trigger('change');
                    $('#selectSpp').val(idsetting).trigger('change');
                }

            })
        })
    </script>
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
    <!-- Table -->
    <script src="{{ url('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('js/demo/datatables-demo.js') }}"></script>
@endsection
