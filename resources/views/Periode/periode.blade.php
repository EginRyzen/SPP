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
                            <button class="btn btn-default" data-toggle="modal" data-target="#periode">Tambah Kelas</button>
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
                                    <th>Tahun KBM</th>
                                    <th>Tahun Awal</th>
                                    <th>Tahun Akhir</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($periode as $data)
                                    <tr>
                                        <td class="fw-bold">{{ $no++ }}.</td>
                                        <td class="fw-bold">{{ $data->periodekbm_periode }}</td>
                                        <td class="fw-bold">{{ $data->periodekbm_tanggalawal }}</td>
                                        <td class="fw-bold">{{ $data->periodekbm_tanggalakhir }}</td>
                                        <td class="text-center">
                                            <a href="{{ $data->id }}" type="button" class="m-2" data-toggle="modal"
                                                data-target="#periode{{ $data->id }}"><i class="fa fa-edit"></i></a>
                                            <a href="{{ url('periode/' . $data->id) }}"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    {{-- Update Modal --}}
                                    <div class="modal fade" id="periode{{ $data->id }}" tabindex="-1" role="dialog"
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
                                                <form action="{{ url('periode/' . $data->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group row">
                                                            <div class="col-md-3 mt-2">
                                                                <label for="">Tahun KBM :</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" name="periodekbm_periode"
                                                                    value="{{ $data->periodekbm_periode }}"
                                                                    class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-3 mt-2">
                                                                <label for="">Tahun Awal :</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="date" name="periodekbm_tanggalawal"
                                                                    value="{{ $data->periodekbm_tanggalawal }}"
                                                                    class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-3 mt-2">
                                                                <label for="">Tahun Akhir :</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="date" name="periodekbm_tanggalakhir"
                                                                    value="{{ $data->periodekbm_tanggalakhir }}"
                                                                    class="form-control" required>
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
    <div class="modal fade" id="periode" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create PeriodeKBM</h5>
                    <button class="btn btn-default close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('periode.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-3 mt-2">
                                <label for="">Tahun KBM :</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="periodekbm_periode" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 mt-2">
                                <label for="">Tahun Awal :</label>
                            </div>
                            <div class="col-md-8">
                                <input type="date" name="periodekbm_tanggalawal" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 mt-2">
                                <label for="">Tahun Akhir :</label>
                            </div>
                            <div class="col-md-8">
                                <input type="date" name="periodekbm_tanggalakhir" class="form-control" required>
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
    <!-- Table -->
    <script src="{{ url('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('js/demo/datatables-demo.js') }}"></script>
@endsection
