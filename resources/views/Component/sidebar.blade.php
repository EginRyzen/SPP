<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="#" target="_blank">
            <img src="{{ asset('/assets/img/logo-ct-dark.png') }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">Argon Dashboard 2</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="/dasbord">
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1 fw-bold">Dashboard</span>
            </a>
        </li>
        @if (Auth::user()->level == 'petugas' || Auth::user()->level == 'admin')
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Pembayaran</h6>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link " href="{{ route('pembayaran.index') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Pembayaran</span>
                </a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link " href="{{ url('pembayaranbaru') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Pembayaran2</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{ url('history') }}">
                    <div class="text-center me-2 d-flex align-items-center justify-content-center">
                    </div>
                    <i class="fas fa-history"></i>
                    <span class="nav-link-text ms-1"> History Pembayaran</span>
                </a>
            </li>
        @endif
        @if (Auth::user()->level == 'admin')
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Setting Dasar</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{ route('anggotakelas.index') }}">
                    <div class="text-center me-2 d-flex align-items-center justify-content-center">
                    </div>
                    <i class="fas fa-users"></i>
                    <span class="nav-link-text ms-1">Anggota Kelas</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">User Tables</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{ route('petugas.index') }}">
                    <div class="text-center me-2 d-flex align-items-center justify-content-center">
                    </div>
                    <i class="fas fa-user-tie"></i>
                    <span class="nav-link-text ms-1">Petugas</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{ url('usersiswa') }}">
                    <div class="text-center me-2 d-flex align-items-center justify-content-center">
                    </div>
                    <i class="fas fa-users"></i>
                    <span class="nav-link-text ms-1">User Siswa</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Master Tables</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{ route('periode.index') }}">
                    <div class="text-center me-2 d-flex align-items-center justify-content-center">
                    </div>
                    <i class="fas fa-calendar-check"></i>
                    <span class="nav-link-text ms-1">Periode KBM</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{ route('spp.index') }}">
                    <div class="text-center me-2 d-flex align-items-center justify-content-center">
                    </div>
                    <i class="fas fa-dollar-sign"></i>
                    <span class="nav-link-text ms-1">SPP</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{ route('settingspp.index') }}">
                    <div class="text-center me-2 d-flex align-items-center justify-content-center">
                    </div>
                    <i class="fas fa-cash-register"></i>
                    <span class="nav-link-text ms-1">Seeting SPP</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{ route('kelas.index') }}">
                    <div class="text-center me-2 d-flex align-items-center justify-content-center">
                    </div>
                    <i class="fas fa-house-user"></i>
                    <span class="nav-link-text ms-1">Kelas</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{ route('siswa.index') }}">
                    <div class="text-center me-2 d-flex align-items-center justify-content-center">
                    </div>
                    <i class="fas fa-user"></i>
                    <span class="nav-link-text ms-1">Siswa</span>
                </a>
            </li>
        @endif
        <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
        </li>
        <li class="nav-item">
            <a class="nav-link"
                @if (Auth::user()->level == 'admin' || Auth::user()->level == 'petugas') href="{{ url('profile/' . Auth::user()->id) }}"
                @else
                href="{{ url('datasiswa/' . session('siswa')['id']) }}" @endif>
                <div
                    class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">
                    @if (Auth::user()->level == 'admin' || Auth::user()->level == 'petugas')
                        {{ Auth::user()->nama_petugas }}
                    @else
                        {{ session('siswa')['nama'] }}
                    @endif
                </span>
            </a>
        </li>
    </ul>
    <div class="collapse navbar-collapse w-auto " id="sidenav-collapse-main">
    </div>
</aside>
