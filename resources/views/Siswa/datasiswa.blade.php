@extends('front')

@section('content')
    <div class="container-fluid py-4">
        <div class="card">
            <div class="row p-4">
                <div class="col-md-12">
                    <div class="card shadow-sm p-4">
                        <h3 class="text-muted">*Indentitas Siswa*</h3>
                        <h6>Nama : {{ $siswa->nama }}</h6>
                        <h6>Kelas : {{ $siswa->nama_kelas }} </h6>
                        <h6>Nisn : {{ $siswa->nisn }}</h6>
                        <h6>Nis : {{ $siswa->nis }}</h6>
                    </div>
                </div>
            </div>
            <div class="row p-4">
                <div class="col-md-12">
                    <div class="card shadow-sm p-4">
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <h4>Pilih Kelas Dan Periode</h4>
                                <form action="{{ url('datasiswa/' . $siswa->id) }}" method="GET">
                                    <select name="idperiode" class="form-select" id=""
                                        onchange="this.form.submit()">
                                        @foreach ($periode as $tahun)
                                            <option value="{{ $tahun->idperiode }}"
                                                @if ($tahun->idperiode == $siswa->idperiode) selected @endif>
                                                {{ $tahun->nama_kelas }} | {{ $tahun->periodekbm_periode }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                        </div>
                        <h4 class="text-muted">Data Pembayaran Setiap Bulan Tahun {{ $siswa->periodekbm_periode }}</h4>
                        <table class="table table-hover">
                            <thead>
                                <th>No</th>
                                <th>Bulan</th>
                                <th width="15%">Keterangan</th>
                                @if (Auth::user()->level == 'admin')
                                    <th width="15%">Pilih</th>
                                    <th width="15%">Status</th>
                                @endif
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                <form action="{{ url('storebaru') }}" method="POST">
                                    @csrf
                                    @foreach ($bulan as $bln)
                                        <tr @if ($statusPembayaran[$bln] == 'Sudah Dibayar') class="table-info" @endif>
                                            <td class="fw-bold">{{ $no++ }}.
                                            </td>
                                            <td class="fw-bold">
                                                {{ $bln }}</td>
                                            <td class="fw-bold">
                                                <input type="hidden" name="id_anggotakelas"
                                                    value="{{ $siswa->id_anggotakelas }}">
                                                <input type="hidden" name="tahun_bayar"
                                                    value="{{ $siswa->periodekbm_periode }}">
                                                <input type="hidden" name="nominal" value="{{ $siswa->nominal }}">
                                                @if ($statusPembayaran[$bln] == 'Sudah Dibayar')
                                                    Sudah Bayar
                                                @else
                                                    Belum Bayar
                                                @endif
                                            </td>
                                            @if (Auth::user()->level == 'admin')
                                                <td class="">
                                                    @if ($statusPembayaran[$bln] == 'Belum Dibayar')
                                                        <input class="ms-4" type="checkbox" name="bulan_bayar[]"
                                                            value="{{ $bln }}">
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($statusPembayaran[$bln] == 'Sudah Dibayar')
                                                        @foreach ($pembayaran as $bayar)
                                                            @if ($bayar->bulan_bayar == $bln)
                                                                <a href="{{ route('pembayaran.show', $bayar->id) }}"
                                                                    class="btn btn-danger">Batal
                                                                    Pembayaran</a>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td>
                                            @if (Auth::user()->level == 'admin')
                                                <button type="submit" class="btn btn-primary mt-3">Proses</button>
                                            @endif
                                            <a href="{{ url('print/' . $siswa->id_anggotakelas) }}"
                                                class="btn btn-secondary mt-3" target="_blank">Print</a>
                                        </td>
                                    </tr>
                                </form>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
