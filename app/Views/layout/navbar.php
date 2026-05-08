<nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">

    <div class="container-fluid">

        <a class="navbar-brand" href="javascript:void(0)">
            Att Management
        </a>

        <button class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown"
            aria-expanded="false"
            aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">

            <!-- kiri -->
            <ul class="navbar-nav mr-auto">

                <li class="nav-item active">
                    <a class="nav-link" href="/">
                        Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>

                <!-- Karyawan -->
                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle"
                        href="#"
                        id="navbarDropdownKaryawan"
                        role="button"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">

                        Karyawan

                    </a>

                    <div class="dropdown-menu"
                        aria-labelledby="navbarDropdownKaryawan">

                        <a class="dropdown-item"
                            href="javascript:void(0)"
                            id="menuKaryawan">

                            Data Karyawan

                        </a>

                    </div>

                </li>

                <!-- Shift -->
                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle"
                        href="#"
                        id="navbarDropdownShift"
                        role="button"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">

                        Shift / Jadwal

                    </a>

                    <div class="dropdown-menu"
                        aria-labelledby="navbarDropdownShift">

                        <a class="dropdown-item"
                            href="javascript:void(0)"
                            id="menuJamkerja">

                            Data Shift

                        </a>

                        <a class="dropdown-item"
                            href="/jadwalkaryawan"
                            id="menuJadwalKerja">

                            Jadwal Karyawan

                        </a>

                    </div>

                </li>

                <!-- Absensi -->
                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle"
                        href="#"
                        id="navbarDropdownAbsensi"
                        role="button"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">

                        Absensi

                    </a>

                    <div class="dropdown-menu"
                        aria-labelledby="navbarDropdownAbsensi">

                        <a class="dropdown-item" href="javascript:void(0)" id="menuAbsensi">
                            Data Absensi
                        </a>

                        <a class="dropdown-item"
                            href="javascript:void(0)"
                            id="menuAttMgmt">

                            Import Absensi

                        </a>

                    </div>

                </li>

            </ul>

        </div>

    </div>

</nav>