<head><script src="http://maps.googleapis.com/maps/api/js"></script></head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<script src="<?= base_url('assets')?>/plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets')?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets')?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?= base_url('assets')?>/dist/js/adminlte.js"></script>
<script src="<?= base_url('assets')?>/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="<?= base_url('assets')?>/plugins/raphael/raphael.min.js"></script>
<script src="<?= base_url('assets')?>/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="<?= base_url('assets')?>/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<script src="<?= base_url('assets')?>/plugins/chart.js/Chart.min.js"></script>
<script src="<?= base_url('assets')?>/dist/js/pages/dashboard2.js"></script>
<script src="<?= base_url('assets')?>/plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets')?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets')?>/dist/js/adminlte.min.js"></script>
<div class="wrapper">
 

 <!-- Main content -->
 <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="card bg-danger">
              <div class="card-body">
                <h3>Keamanan Jaringan</h3>

                <p>Informatika</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <div class="card-footer"><a href="#" class="small-box-footer text-white">Selamat Datang dan Selamat Belajar</a>
</div>
            </div>
          </div>

           <!-- TEACHER -->
           <div class="col-md-0">
                <div class="card">
                  <div class="card-header bg-danger">
                    <h3 class="card text-center">Guru Pembimbing</h3>
                    <div class="card-tools ">
                      <span class="card badge badge-danger"></span>
                    </div>
                  </div>
                  <!-- /card-header -->
                  <div class="card-body bg-danger">
                      <li>
                        <div class="card">
                        <img src="https://i.pinimg.com/236x/e9/57/2a/e9572a70726980ed5445c02e1058760b.jpg"class="img-circle elevation-1 " alt="User Image">
                        <div class="card-footer text-center">
                        <a class="users" href="#">Dedi Rosadi</a>
                        <br>
                        <span class="users-center">Jaringan</span>
                      </li>
                  </div>
                  </div>
                </div>

            <div class="col-xl-5">
            <div class="card mb-4">
                <div class="card-header text-center bg-danger"><span class="fas fa-clock mr-1"></span>Absensi</div>
                <div class="card-body text-center">
                    <div id="infoabsensi"></div>
                    <?php if ($dataapp['maps_use'] == 1) : ?>
                        <div id='maps-absen' style='width: 100%; height:250px;'></div>
                        <hr>
                    <?php endif; ?>
                    <div id="location-maps" style="display: none;"></div>
                    <div id="date-and-clock">
                        <h3 id="clocknow"></h3>
                        <h3 id="datenow"></h3>
                    </div>
                    <?= form_dropdown('ket_absen', ['Belajar Di Kampus' => 'Belajar Di Kampus', 'Belajar Di Rumah / Daring' => 'Belajar Di Rumah / Daring', 'Sakit' => 'Sakit', 'Alfa' => 'Alfa'], '', ['class' => 'form-control align-content-center my-2', 'id' => 'ket_absen']); ?>
                    <div class="mt-2">
                        <div id="func-absensi">
                            <p class="font-weight-bold">Status Kehadiran: <?= $statuspegawai = (empty($dbabsensi['status_pegawai'])) ? '<span class="badge badge-primary">Belum Absen</span>' : (($dbabsensi['status_pegawai'] == 1) ? '<span class="badge badge-success">Sudah Absen</span>' : '<span class="badge badge-danger">Absen Terlambat</span>'); ?></p>
                            <div id="jamabsen">
                                <p>Waktu Datang: <?= $jammasuk = (empty($dbabsensi['jam_masuk'])) ? '00:00:00' : $dbabsensi['jam_masuk']; ?></p>
                                <p>Waktu Pulang: <?= $jammasuk = (empty($dbabsensi['jam_pulang'])) ? '00:00:00' : $dbabsensi['jam_pulang']; ?></p>
                            </div>
                        </div>
                        <button class="btn btn-dark" id="btn-absensi">Absen</button>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="text-muted">Absen Datang Jam: <?= $dataapp['absen_mulai'] ?></div>
                        <div class="text-muted">Absen Pulang Jam: <?= $dataapp['absen_pulang']; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


            <!-- PRODUCT LIST -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title size-6">Dokument Penunjang Perkuliahan</h3>
              </div>
              <!-- /.card-header -->
              <div class="card p-2">
                <ul class="products-list product-list-in-card pl-3 pr-3">
                  <li class="item">
                    <div class="card product-img">
                      <img src="https://w7.pngwing.com/pngs/433/5/png-transparent-pdf-information-document-printing-promotion-label-angle-text-logo.png" alt="Product Image" class="img-size-10">
                    </div>
                    <div class="product-info">
                      <div class="card-footer">
                      <a href="http://p4tkmatematika.org/file/ARTIKEL/Artikel%20Teknologi/PEMBUATAN%20FILE%20PDF_FNH_tamim.pdf" class="product-title">Pengantar Matakuliah</a>
                        <span class="badge badge-success float-right">Pertemuan 1</span>
                        <div>
                          
                        <a href="https://apps.google.com/meet/"><span class="badge badge-success float-right" >Ikuti Kelas</span></a>
                      <span class="product-description">
                        Date : 05 Oktober 2022
                      </span>
                    </div>
                  </li>
                  <!-- /.item -->
                  <li class="item">
                    <div class="product-img">
                      <img src="https://e7.pngegg.com/pngimages/681/472/png-clipart-computer-icons-question-mark-font-awesome-others-logo-silhouette.png" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                      <a href="https://islamic-economics.uii.ac.id/wp-content/uploads/2018/05/Template-Laporan.doc" class="product-title">Pengenalan Jaringan
                        <span class="badge badge-danger float-right">Pertemuan 2</span></a>
                      <span class="product-description">
                      Date :
                      </span>
                    </div>
                  </li>
                  <!-- /.item -->
                  <li class="item">
                    <div class="product-img">
                      <img src="https://e7.pngegg.com/pngimages/681/472/png-clipart-computer-icons-question-mark-font-awesome-others-logo-silhouette.png" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                      <a href="https://drive.google.com/file/d/1eTsgpUMJrwq8C8ZXvhraoHLoxCplrr3R/view" class="product-title">Topologi Jaringan
                        <span class="badge badge-danger float-right">
                        Pertemuan 3
                      </span>
                      </a>
                      <span class="product-description">
                      Date :
                      </span>
                    </div>
                  </li>
                  <!-- /.item -->
                  <li class="item">
                    <div class="product-img">
                      <img src="https://e7.pngegg.com/pngimages/681/472/png-clipart-computer-icons-question-mark-font-awesome-others-logo-silhouette.png" alt="Product Image" class="img-size-50">
                    </div>
                    <div class="product-info">
                      <a href="https://www.taukan.com/wp-content/uploads/2020/07/Excel-Laporan-Keuangan-Perusahaan-Dagang.xlsx?_ga=2.120907342.75893694.1664866897-1653317068.1664866897" class="product-title">Ujian Tengah Semester
                        <span class="badge badge-danger float-right">Pertemuan 4</span></a>
                      <span class="product-description">
                      Date :
                      </span>
                    </div>
                  </li>
                </ul>
              </div>
                      </div>
 
  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>
</body>
</html>
