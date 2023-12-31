@extends('front')

@section('csstable')
    <!-- DataTables -->
    <link href="{{ url('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="row p-3">
                <div class="col-md-12">
                    <div class="fresh-table full-color-orange">
                        <div class="toolbar">
                            <button class="btn btn-default" data-toggle="modal" data-aksi="create" data-target="#spp">Tambah
                                SPP</button>
                        </div>
                        @if (session()->has('hapus'))
                            <div class="alert alert-success fw-bold" role="alert">
                                User Telah Terhapus
                            </div>
                        @endif
                        @if (session()->has('pesan'))
                            <div class="alert alert-danger fw-bold text-white" role="alert">
                                User Tinggal Satu Tidak Dapat Di Hapus
                            </div>
                        @endif
                        <table class="table" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Keterangan</th>
                                    <th>Nominal</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($spp as $data)
                                    <tr>
                                        <td class="fw-bold">{{ $no++ }}.</td>
                                        <td class="fw-bold">{{ $data->keterangan }}</td>
                                        <td class="fw-bold">Rp. {{ number_format($data->nominal, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <a href="{{ $data->id }}" type="button" class="m-2" data-toggle="modal"
                                                data-target="#spp" data-id="{{ $data->id }}" data-aksi="edit"
                                                data-keterangan="{{ $data->keterangan }}"
                                                data-nominal="{{ $data->nominal }}"><i class="fa fa-edit"></i></a>
                                            <a href="{{ url('spp/' . $data->id) }}"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    {{-- Update Modal --}}
                                    <div class="modal fade" id="spp{{ $data->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Update Spp</h5>
                                                    <button class="btn btn-default close" type="button"
                                                        data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <form action="{{ url('spp/' . $data->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group row">
                                                            <div class="col-md-3 mt-2">
                                                                <label for="">Keterangan :</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" name="keterangan"
                                                                    value="{{ $data->keterangan }}" class="form-control"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-3 mt-2">
                                                                <label for="">Nominal :</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" name="nominal"
                                                                    value="{{ $data->nominal }}" class="form-control"
                                                                    required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" type="button"
                                                            data-dismiss="modal">Cancel</button>
                                                        <button class="btn btn-primary" type="submit">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Create Modal --}}
    <div class="modal fade" id="spp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">SPP</h5>
                    <button class="btn btn-default close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('spp.store') }}" method="POST" id="fstore">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="_method" id="method" value="">
                        <div class="form-group row">
                            <div class="col-md-3 mt-2">
                                <label for="">Keterangan :</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" id="keterangan" name="keterangan" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 mt-2">
                                <label for="">Nominal :</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" id="nominal" name="nominal" class="form-control" required>
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
    <script>
        $(function() {
            $('#spp').on('show.bs.modal', function(e) {
                // console.log('Modal is about to show');
                var btn = $(e.relatedTarget);
                var aksi = btn.data('aksi');
                // alert(aksi);

                var id = btn.data('id');
                var keterangan = btn.data('keterangan');
                var nominal = btn.data('nominal');
                // console.log(periode);

                if (aksi === 'create') {
                    // alert('hello');
                    $('#keterangan').val("");
                    $('#nominal').val("");
                }
                if (aksi === 'edit') {
                    // alert('heheh')
                    $('#fstore').attr('action', 'spp/' + id);
                    $('#keterangan').val(keterangan);
                    $('#nominal').val(nominal);
                    $('#method').val('PUT');
                }

            })
        })
    </script>
    <!-- Table -->
    <script src="{{ url('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('js/demo/datatables-demo.js') }}"></script>
@endsection
