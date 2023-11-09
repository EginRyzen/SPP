<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<style>
    p {
        margin-top: -10px;
        font-weight: bold;
        color: #404040;
        border-bottom: black 2px solid;
    }

    .tahun {
        margin-top: -10px;
    }
</style>

<body>
    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-md-1">
                <img src="{{ asset('img/logosmk.png') }}" alt="" width="50">
            </div>
            <div class="col-md-9">
                <h6 class="text-center">BANK MINI SEKOLAH "TUNAS HARAPAN"</h6>
                <h4 class="text-center">SMK Negeri 1 Ponorogo</h4>
                <p class="text-center">Jl. Jenderal Sudirman No.10, Krajan, Pakunden, Kec. Ponorogo, Kabupaten Ponorogo,
                    Jawa Timur 63416</p>
                <h4 class="text-center">TANDA BUKTI PEMBAYARAN</h4>
                <h6 class="text-center tahun">Tahun Pelajaran {{ $siswa[0]['tahun'] }}</h6>
            </div>
            <div class="col-md-1">
                <img src="{{ asset('img/logorpl.png') }}" alt="" width="65">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-1"></div>
            <div class="col-md-1">
                <h5>Nama </h5>
            </div>
            <div class="col-md-10">
                <h5>: {{ $siswa[0]['nama'] }}</h5>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-1">
                <h5>Kelas </h5>
            </div>
            <div class="col-md-10">
                <h5>: {{ $siswa[0]['nama_kelas'] }}</h5>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Bulan</th>
                            <th width="40%">Tanggal Pembayaran</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($bulan as $bln)
                            <tr>
                                {{-- @if ($statusPembayaran[$bln] == 'Belum Dibayar') --}}
                                <td class="fw-bold">{{ $no++ }}.
                                </td>
                                <td class="fw-bold">
                                    {{ $bln }}</td>
                                <td class="fw-bold">
                                    @foreach ($pembayaran as $bayar)
                                        @if ($bayar->bulan_bayar == $bln)
                                            {{ $bayar->tgl_bayar }}
                                        @endif
                                    @endforeach
                                </td>
                                <td class="fw-bold">
                                    @foreach ($pembayaran as $bayar)
                                        @if ($bayar->bulan_bayar == $bln)
                                            Rp. {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}
                                        @endif
                                    @endforeach
                                </td>
                                {{-- @endif --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
</script>
<script>
    if (!localStorage.getItem('reloaded')) {
        localStorage.setItem('reloaded', 'yes');
        window.location.reload();
    } else {
        localStorage.removeItem('reloaded');

        setTimeout(function() {
            window.print();

            window.close();
        }, 500);
    }
</script>

</html>
