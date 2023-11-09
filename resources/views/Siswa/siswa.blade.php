@extends('front')

@section('csstable')
    <!-- DataTables -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="row p-3">
                <div class="col-md-12">
                    <div class="fresh-table full-color-orange">
                        <div class="toolbar">
                            <button class="btn btn-default" data-toggle="modal" data-target="#siswa">Tambah Siswa</button>
                            <button class="btn btn-default" data-toggle="modal" data-target="#importsiswa">Import
                                Siswa</button>
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
                        <div class="table-reponsive">
                            <table class="table" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama</th>
                                        <th>Nis</th>
                                        <th>Nama Kelas</th>
                                        <th>Alamat</th>
                                        <th>Tahun</th>
                                        <th>Nominal</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($siswa as $data)
                                        <tr>
                                            <td class="fw-bold">{{ $no++ }}.</td>
                                            <td class="fw-bold"><i class="fas fa-user"></i><a
                                                    href="{{ url('datasiswa/' . $data->id) }}"
                                                    class="text-primary ms-1">{{ Str::limit($data->nama, 20) }}</a>
                                            </td>
                                            <td class="fw-bold">{{ $data->nis }}</td>
                                            <td class="fw-bold">{{ $data->nama_kelas }}</td>
                                            <td class="fw-bold">{{ $data->alamat }}</td>
                                            <td class="fw-bold">{{ $data->tahun }}</td>
                                            <td class="fw-bold">Rp. {{ number_format($data->nominal, 0, ',', '.') }}</td>
                                            <td class="text-center">
                                                <a href="{{ $data->id }}" type="button" class="m-2"
                                                    data-toggle="modal" data-target="#siswa{{ $data->id }}"><i
                                                        class="fa fa-edit"></i></a>
                                                <a href="{{ url('siswa/' . $data->id) }}"
                                                    onclick="return confirm('Yakin Untuk di Hapus??')"><i
                                                        class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        {{-- Update Modal --}}
                                        <div class="modal fade" id="siswa{{ $data->id }}" tabindex="-1" role="dialog"
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
                                                    <form action="{{ url('siswa/' . $data->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="form-group row">
                                                                <div class="col-md-3 mt-2">
                                                                    <label for="">Nama Kelas :</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <select name="id_kelas" class="form-select"
                                                                        id="" required>
                                                                        @foreach ($kelas as $kls)
                                                                            <option value="{{ $kls->id }}"
                                                                                @if ($kls->id == $data->id_kelas) selected @endif>
                                                                                {{ $data->nama_kelas }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-md-3 mt-2">
                                                                    <label for="">SPP Tahun :</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <select name="id_spp" class="form-select"
                                                                        id="" required>
                                                                        @foreach ($spp as $row)
                                                                            <option value="{{ $row->id }}"
                                                                                @if ($row->id == $data->id_spp) selected @endif>
                                                                                Rp.
                                                                                {{ number_format($row->nominal, 0, ',', '.') }}
                                                                                | Tahun
                                                                                {{ $row->tahun }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-md-3 mt-2">
                                                                    <label for="">NIS :</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="number" name="nis"
                                                                        value="{{ $data->nis }}" class="form-control"
                                                                        placeholder="Nis Siswa" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-md-3 mt-2">
                                                                    <label for="">NISN :</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="number" name="nisn"
                                                                        value="{{ $data->nisn }}" class="form-control"
                                                                        placeholder="NISN Siswa" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-md-3 mt-2">
                                                                    <label for="">Nama Siswa :</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" name="nama"
                                                                        value="{{ $data->nama }}" class="form-control"
                                                                        placeholder="Nama Siswa" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-md-3 mt-2">
                                                                    <label for="">Alamat Siswa :</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="text" name="alamat"
                                                                        value="{{ $data->alamat }}" class="form-control"
                                                                        placeholder="ALamat Siswa" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <div class="col-md-3 mt-2">
                                                                    <label for="">Telp Siswa :</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <input type="number" name="no_telp"
                                                                        value="{{ $data->no_telp }}" class="form-control"
                                                                        placeholder="Telp Siswa" required>
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
    </div>

    {{-- Import Siswa --}}
    <div class="modal fade" id="importsiswa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Siswa</h5>
                    <button class="btn btn-default close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ url('importsiswa') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <p class="text-danger" style="margin-bottom:-5px">Dwnload Format File Jika Belum Punyaa</p>
                        <a class="fw-bold text-primary border-bottom border-primary"
                            href="{{ asset('DefaultFile/DataSiswa.xlsx') }}" download>Unduh
                            File</a>

                        <h6 class="mt-5">Masukan File Jika Sudah Memenuhi Standar</h6>
                        <input type="file" class="form-control" name="file">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="reset">Reset</button>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Create Modal --}}
    <div class="modal fade" id="siswa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Siswa</h5>
                    <button class="btn btn-default close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('siswa.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-2 mt-2">
                                <label for="">Nama Kelas :</label>
                            </div>
                            <div class="col-md-4">
                                <select name="id_kelas" class="form-select" id="" required>
                                    <option value="" disabled selected>--- Pilih Kelas ---</option>
                                    @foreach ($kelas as $data)
                                        <option value="{{ $data->id }}">{{ $data->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 mt-2">
                                <label for="">SPP Tahun :</label>
                            </div>
                            <div class="col-md-4">
                                <select name="id_spp" class="form-select" id="" required>
                                    <option value="" disabled selected>--- Pilih Spp ---</option>
                                    @foreach ($spp as $row)
                                        <option value="{{ $row->id }}">Rp.
                                            {{ number_format($row->nominal, 0, ',', '.') }} | Tahun
                                            {{ $row->tahun }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2 mt-2">
                                <label for="">NIS :</label>
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="nis" class="form-control" placeholder="Nis Siswa"
                                    required>
                            </div>
                            <div class="col-md-2 mt-2">
                                <label for="">NISN :</label>
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="nisn" class="form-control" placeholder="NISN Siswa"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2 mt-2">
                                <label for="">Nama Siswa :</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="nama" class="form-control" placeholder="Nama Siswa"
                                    required>
                            </div>
                            <div class="col-md-2 mt-2">
                                <label for="">Alamat Siswa :</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="alamat" class="form-control" placeholder="ALamat Siswa"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2 mt-2">
                                <label for="">Telp Siswa :</label>
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="no_telp" class="form-control" placeholder="Telp Siswa"
                                    required>
                            </div>
                            <div class="col-md-2 mt-2">
                                <label for="">UserName :</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="username" class="form-control" placeholder="Username Siswa"
                                    required>
                            </div>

                        </div>
                        <div class="form-group row">
                            <div class="col-md-2 mt-2">
                                <label for="">Password :</label>
                            </div>
                            <div class="col-md-10">
                                <input type="password" minlength=3 name="password" class="form-control"
                                    placeholder="Password Siswa" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="reset">Reset</button>
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
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endsection
