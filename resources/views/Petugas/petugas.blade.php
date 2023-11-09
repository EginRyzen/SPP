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
                            <button class="btn btn-default" data-toggle="modal" data-target="#petugas">Tambah Petugas</button>
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
                                    <th>Username</th>
                                    <th>Nama</th>
                                    <th>Level</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($petugas as $data)
                                    <tr>
                                        <td class="font-weight-bold">{{ $no++ }}.</td>
                                        <td>{{ $data->username }}</td>
                                        <td>{{ $data->nama_petugas }}</td>
                                        <td>{{ $data->level }}</td>
                                        <td class="text-center">
                                            <a href="{{ $data->id }}" type="button" class="m-2" data-toggle="modal"
                                                data-target="#petugas{{ $data->id }}"><i class="fa fa-edit"></i></a>
                                            <a href="{{ url('petugas/' . $data->id) }}"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    {{-- Update Modal --}}
                                    <div class="modal fade" id="petugas{{ $data->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Create Petugas</h5>
                                                    <button class="btn btn-default close" type="button"
                                                        data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <form action="{{ url('petugas/' . $data->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group row">
                                                            <div class="col-md-3 mt-2">
                                                                <label for="">Username :</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" name="username"
                                                                    value="{{ $data->username }}" class="form-control"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-3 mt-2">
                                                                <label for="">Nama Petugas :</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="text" name="nama_petugas"
                                                                    value="{{ $data->nama_petugas }}" class="form-control"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-3 mt-2">
                                                                <label for="">Password :</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <input type="password" name="password" class="form-control"
                                                                    placeholder="Isikan jika password ingin di ganti">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-md-3 mt-2">
                                                                <label for="">Level :</label>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select name="level" class="form-select" id="">
                                                                    <option value="admin"
                                                                        {{ $data->level == 'admin' ? 'selected' : '' }}>
                                                                        Admin
                                                                    </option>
                                                                    <option value="petugas"
                                                                        {{ $data->level == 'petugas' ? 'selected' : 'x`' }}>
                                                                        Petugas</option>
                                                                </select>
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
    <div class="modal fade" id="petugas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Petugas</h5>
                    <button class="btn btn-default close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('petugas.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-3 mt-2">
                                <label for="">Username :</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="username" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 mt-2">
                                <label for="">Nama Petugas :</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="nama_petugas" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 mt-2">
                                <label for="">Password :</label>
                            </div>
                            <div class="col-md-8">
                                <input type="password" minlength=3 name="password" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 mt-2">
                                <label for="">Level :</label>
                            </div>
                            <div class="col-md-8">
                                <select name="level" class="form-select" id="">
                                    <option value="admin">Admin</option>
                                    <option value="petugas" selected>Petugas</option>
                                </select>
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
