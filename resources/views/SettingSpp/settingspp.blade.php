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
                            <button class="btn btn-default" data-aksi="create" data-toggle="modal"
                                data-target="#setting">Tambah Data</button>
                            @if (session()->has('pesan'))
                                <p class="text-danger fw-bold">Data Siswa Tinggal 1 Satu Tidak Dapat Di Hapus!!</p>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class="table" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Keterangan</th>
                                        <th>Nominal SPP</th>
                                        <th>PeroiodeTahun</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($settingspp as $data)
                                        <tr>
                                            <td class="fw-bold">{{ $no++ }}.</td>
                                            <td class="fw-bold">{{ $data->keterangan }}</td>
                                            <td class="fw-bold">Rp. {{ number_format($data->nominal, 0, ',', '.') }}</td>
                                            <td class="fw-bold">{{ $data->periodekbm_periode }}</td>
                                            <td class="text-center">
                                                <a href="{{ $data->id }}" type="button" class="m-2"
                                                    data-toggle="modal" data-target="#setting" data-aksi="edit"
                                                    data-id="{{ $data->id }}" data-spp="{{ $data->idspp }}"
                                                    data-periode="{{ $data->idperiode }}"><i class="fa fa-edit"></i></a>

                                                <a href="{{ url('settingspp/' . $data->id) }}"
                                                    onclick="return confirm('Apakah Yakin DiHapus?')"><i
                                                        class="fa fa-trash"></i></a>
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
    <div class="modal fade" id="setting" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Kelas</h5>
                    <button class="btn btn-default close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('settingspp.store') }}" method="POST" id="fstore">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="_method" id="method" value="">
                        <div class="form-group row">
                            <div class="col-md-3 mt-2">
                                <label for="">Periode Tahun :</label>
                            </div>
                            <div class="col-md-8">
                                <div class="select2-purple">
                                    <select name="idperiode" id="selectPeriode" class="form-control select2" required
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
                        <div class="form-group row">
                            <div class="col-md-3 mt-2">
                                <label for="">SPP:</label>
                            </div>
                            <div class="col-md-8">
                                <div class="select2-purple">
                                    <select name="idspp" id="selectSpp" class="form-control select2" style="width: 100%;"
                                        required>
                                        <option selected="selected">--- Pilih Tahun ---</option>
                                        @foreach ($spp as $data)
                                            <option value="{{ $data->id }}">{{ $data->nominal }} |
                                                {{ $data->keterangan }}
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
            $('#setting').on('show.bs.modal', function(event) {
                // console.log('Modal is about to show');
                var btn = $(event.relatedTarget);
                var aksi = btn.data('aksi');

                var id = btn.data('id');
                var idspp = btn.data('spp');
                var idperiode = btn.data('periode');

                if (aksi === 'create') {
                    $('#selectPeriode').val("");
                    $('#selectSpp').val("");
                }
                if (aksi === 'edit') {
                    $('#fstore').attr('action', 'settingspp/' + id);
                    $('#selectPeriode').val(idperiode).trigger('change');
                    $('#selectSpp').val(idspp).trigger('change');
                    $('#method').val('PUT');
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
