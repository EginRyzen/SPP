@extends('front')

@section('csstable')
    <!-- DataTables -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
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
                                data-target="#siswa">Tambah Siswa</button>
                            <button class="btn btn-default" data-toggle="modal" data-target="#importsiswa">Import
                                Siswa</button>
                        </div>
                        @if (Session::has('nominal'))
                            <script>
                                window.alert("Nominal Dan Periode Tidak Cocok Silahkan Cek Di Table Setting Spp");
                            </script>
                        @endif
                        @if (Session::has('kelas'))
                            <script>
                                window.alert(
                                    "Kelas Dan Periode Tidak Cocok Silahkan Cek Di Table Kelas Dan Seetting Spp,Periode Yang Anda Masukan Harus Sama"
                                );
                            </script>
                        @endif
                        @if (Session::has('tahun'))
                            <script>
                                window.alert("Periode Tidak Di Temukan Silahkan Cek Kembali");
                            </script>
                        @endif
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
                                        <th>Nisn</th>
                                        <th>Nis</th>
                                        <th>Alamat</th>
                                        <th>No Telp.</th>
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
                                            <td class="fw-bold"><a class="text-primary"
                                                    href="{{ url('datasiswa/' . $data->id) }}">{{ Str::limit($data->nama, 20) }}</a>
                                            </td>
                                            <td class="fw-bold">{{ $data->nisn }}</td>
                                            <td class="fw-bold">{{ $data->nis }}</td>
                                            <td class="fw-bold">{{ $data->alamat }}</td>
                                            <td class="fw-bold">{{ $data->no_telp }}</td>
                                            <td class="text-center">
                                                <a href="{{ $data->id }}" type="button" class="m-2"
                                                    data-toggle="modal" data-target="#siswa" data-aksi="edit"
                                                    data-nama="{{ $data->nama }}" data-id="{{ $data->id }}"
                                                    data-nisn="{{ $data->nisn }}" data-nis="{{ $data->nis }}"
                                                    data-alamat="{{ $data->alamat }}"
                                                    data-no_telp="{{ $data->no_telp }}"><i class="fa fa-edit"></i></a>
                                                <a href="{{ url('siswa/' . $data->id) }}"
                                                    onclick="return confirm('Yakin Untuk di Hapus??')"><i
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
    <div class="modal fade" id="siswa" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Siswa</h5>
                    <button class="btn btn-default close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('siswa.store') }}" method="POST" id="fstore">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="_method" id="method" value="">
                        <div class="form-group row">
                            <div class="col-md-2 mt-2">
                                <label for="">NIS :</label>
                            </div>
                            <div class="col-md-4">
                                <input type="number" id="nis" name="nis" class="form-control"
                                    placeholder="Nis Siswa" required>
                            </div>
                            <div class="col-md-2 mt-2">
                                <label for="">NISN :</label>
                            </div>
                            <div class="col-md-4">
                                <input type="number" id="nisn" name="nisn" class="form-control"
                                    placeholder="NISN Siswa" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2 mt-2">
                                <label for="">Nama Siswa :</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="nama" name="nama" class="form-control"
                                    placeholder="Nama Siswa" required>
                            </div>
                            <div class="col-md-2 mt-2">
                                <label for="">Alamat Siswa :</label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="alamat" name="alamat" class="form-control"
                                    placeholder="ALamat Siswa" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2 mt-2">
                                <label for="">Telp Siswa :</label>
                            </div>
                            <div class="col-md-4">
                                <input type="number" id="no_telp" name="no_telp" class="form-control"
                                    placeholder="Telp Siswa" required>
                            </div>
                            <div class="col-md-2 mt-2" id="usernameLabel">
                                <label for="">UserName :</label>
                            </div>
                            <div class="col-md-4" id="usernameInput">
                                <input type="text" id="username" name="username" class="form-control"
                                    placeholder="Username Siswa" required>
                            </div>

                        </div>
                        <div class="form-group row" id="selectGroup">
                            <div class="col-md-2 mt-2">
                                <label for="">Kelas :</label>
                            </div>
                            <div class="col-md-4">
                                <div class="select2-purple">
                                    <select name="id_kelas" id="selectKelas" class="form-control select2"
                                        style="width: 100%;" required>
                                        <option value="" selected disabled>-- Pilih Kelas --</option>
                                        @foreach ($kelas as $data)
                                            <option value="{{ $data->id }}">{{ $data->nama_kelas }} |
                                                {{ $data->kompetensi_keahlian }} | {{ $data->periodekbm_periode }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 mt-2">
                                <label for="">SPP :</label>
                            </div>
                            <div class="col-md-4">
                                <div class="select2-purple">
                                    <select name="id_settingspp" id="selectSpp" class="form-control select2"
                                        style="width: 100%;" required>
                                        <option value="" selected disabled>-- Pilih Spp --</option>
                                        @foreach ($settingspp as $data)
                                            <option value="{{ $data->id }}">Rp.
                                                {{ number_format($data->nominal, 0, ',', '.') }} |
                                                {{ $data->periodekbm_periode }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row" id="passwordGroup">
                            <div class="col-md-2 mt-2">
                                <label for="">Password :</label>
                            </div>
                            <div class="col-md-10">
                                <input type="password" id="password" minlength=3 name="password" class="form-control"
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
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('dist/js/demo.js') }}"></script>
    <script>
        $(function() {
            $('#siswa').on('show.bs.modal', function(e) {
                const btn = $(e.relatedTarget);
                const aksi = btn.data('aksi');

                const id = btn.data('id');
                const nama = btn.data('nama');
                const nisn = btn.data('nisn');
                const nis = btn.data('nis');
                const alamat = btn.data('alamat');
                const no_telp = btn.data('no_telp');

                const passwordGroup = $('#passwordGroup');
                const selectGroup = $('#selectGroup');
                const usernameGroup = $('#usernameLabel, #usernameInput');

                if (aksi === 'create') {
                    $('#nis').val("");
                    $('#nisn').val("");
                    $('#nama').val("");
                    $('#alamat').val("");
                    $('#no_telp').val("");
                    $('#username').val("");
                    $('#selecKelas').val("");
                    $('#selectSpp').val("");
                    $('#password').val("");
                    passwordGroup.show();
                    selectGroup.show();
                    usernameGroup.show();
                }
                if (aksi === 'edit') {
                    $('#method').val('PUT');
                    $('#fstore').attr('action', 'siswa/' + id);
                    $('#selectSpp').removeAttr('required');
                    $('#selectKelas').removeAttr('required');
                    $('#password').removeAttr('required');
                    $('#username').removeAttr('required');
                    passwordGroup.hide();
                    selectGroup.hide();
                    usernameGroup.hide();
                    $('#nis').val(nis);
                    $('#nisn').val(nisn);
                    $('#nama').val(nama);
                    $('#alamat').val(alamat);
                    $('#no_telp').val(no_telp);
                    // alert('hello ges');
                }
            });
        });
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
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>
@endsection
