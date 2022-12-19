<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark bg-dark" id="sidenavAccordion">
            <?php if ($this->session->userdata('role_id') == 1) : ?>
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">E-Learning</div>
                        <a class="nav-link" href="<?= base_url('User/kelasku'); ?>">
                            <div class="sb-nav-link-icon"><span class="fas fa-users"></span></div>
                            Perkuliahan
                        </a>
                        <a class="nav-link" href="<?= base_url('Nilai/index'); ?>">
                            <div class="sb-nav-link-icon"><span class="fas fa-chart-area"></span></div>
                            Nilai
                        </a>
                        <a class="nav-link" href='http://localhost/calendar/'>
                            <div class="sb-nav-link-icon"><span class="fas fa-calendar"></span></div>
                            Agenda Perkuliahan
                        </a><a class="nav-link" href="<?= base_url('absensi'); ?>">
                            <div class="sb-nav-link-icon"><span class="fas fa-user-check"></span></div>
                            Absensi Mahasiswa
                        </a>
                        <div class="sb-sidenav-menu-heading">Tautan Cepat</div>
                        </a><a class="nav-link" href="<?= base_url('home/index'); ?>">
                            <div class="sb-nav-link-icon"><span class="fas fa-cog"></span></div>
                            Oasis
                        </a>
                    </div>
                </div>
            <?php elseif ($this->session->userdata('role_id') == 2) : ?>
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Home</div>
                        <a class="nav-link" href="<?= base_url(''); ?>">
                            <div class="sb-nav-link-icon"><span class="fas fa-tachometer-alt"></span></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link" href="<?= base_url('absensiku'); ?>">
                            <div class="sb-nav-link-icon"><span class="fas fa-chart-area"></span></div>
                            Data Kehadiran
                        </a>
                        <div class="sb-sidenav-menu-heading">Moderator</div>
                        </a><a class="nav-link" href="<?= base_url('absensi'); ?>">
                            <div class="sb-nav-link-icon"><span class="fas fa-user-check"></span></div>
                            Absensi Pegawai
                        </a>
                    </div>
                </div>
            <?php elseif ($this->session->userdata('role_id') == 3) : ?>
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Home</div>
                        <a class="nav-link" href="<?= base_url(''); ?>">
                            <div class="sb-nav-link-icon"><span class="fas fa-tachometer-alt"></span></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link" href="<?= base_url('absensiku'); ?>">
                            <div class="sb-nav-link-icon"><span class="fas fa-chart-area"></span></div>
                            Data Kehadiran
                        </a>
                    </div>
                </div>
            <?php endif; ?>
            <div class="sb-sidenav-footer">
                <div class="small">Selamat Datang:</div>
                <?= $user['nama_lengkap'] ?>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main>