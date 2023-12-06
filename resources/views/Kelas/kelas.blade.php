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
                            <button class="btn btn-default" data-toggle="modal" data-aksi="create"
                                data-target="#kelas">Tambah Kelas</button>
                        </div>
                        @if (session()->has('hapus'))
                            <div class="alert alert-danger text-white fw-bold" role="alert">
                                Kelas Telah Terhapus
                            </div>
                        @endif
                        @if (session()->has('update'))
                            <div class="alert alert-success fw-bold text-white" role="alert">
                                Update Telah berhasil
                            </div>
                        @endif
                        <table class="table" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kelas</th>
                                    <th>Kompetensi Keahlian</th>
                                    <th>Tahun Ajaran</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($kelas as $data)
                                    <tr>
                                        <td class="fw-bold">{{ $no++ }}.</td>
                                        <td class="fw-bold">{{ $data->nama_kelas }}</td>
                                        <td class="fw-bold">{{ $data->kompetensi_keahlian }}</td>
                                        <td class="fw-bold">{{ $data->periodekbm_periode }}</td>
                                        <td class="text-center">
                                            <a href="{{ $data->id }}" type="button" class="m-2" data-toggle="modal"
                                                data-target="#kelas" data-aksi="edit" data-id="{{ $data->id }}"
                                                data-nama_kelas="{{ $data->nama_kelas }}"
                                                data-keahlian="{{ $data->kompetensi_keahlian }}"
                                                data-periode="{{ $data->idperiode }}"><i class="fa fa-edit"></i></a>
                                            <a href="{{ url('kelas/' . $data->id) }}"><i class="fa fa-trash"></i></a>
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

    {{-- Create Modal --}}
    <div class="modal fade" id="kelas" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Kelas</h5>
                    <button class="btn btn-default close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('kelas.store') }}" method="POST" id="fstore">
                    <input type="hidden" name="_method" id="method" value="">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="">Tahun Ajaran</label>
                            </div>
                            <div class="col-md-8">
                                <div class="select2-purple">
                                    <select name="id_periode" id="selectPeriode" class="form-control select2"
                                        style="width: 100%;">
                                        <option selected="selected">--- Pilih Tahun ---
                                        </option>
                                        @foreach ($periode as $data)
                                            <option value="{{ $data->id }}">
                                                {{ $data->periodekbm_periode }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 mt-2">
                                <label for="">Nama Kelas :</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" id="nama_kelas" name="nama_kelas" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 mt-2">
                                <label for="">Kompetensi Keahlian :</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" id="keahlian" name="kompetensi_keahlian" class="form-control"
                                    required>
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
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </script>
    <script>
        $(function() {
            $('#kelas').on('show.bs.modal', function(e) {
                // console.log('Modal is about to show');
                var btn = $(e.relatedTarget);
                var aksi = btn.data('aksi');
                // alert('tess');

                var id = btn.data('id');
                var periode = btn.data('periode');
                var nama_kelas = btn.data('nama_kelas');
                var keahlian = btn.data('keahlian');
                // console.log(periode);

                if (aksi === 'create') {
                    // alert('hello');
                    $('#nama_kelas').val("");
                    $('#keahlian').val("");
                    $('#selectPeriode').val("");
                }
                if (aksi === 'edit') {
                    $('#fstore').attr('action', 'kelas/' + id);
                    $('#selectPeriode').val(periode).trigger('change');
                    $('#nama_kelas').val(nama_kelas);
                    $('#keahlian').val(keahlian);
                    $('#method').val('PUT');
                }

            });
        });
    </script>
    <!-- Table -->
    <script src="{{ url('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('js/demo/datatables-demo.js') }}"></script>
@endsection
