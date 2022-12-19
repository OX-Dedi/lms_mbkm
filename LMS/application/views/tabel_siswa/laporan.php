<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data Mahasiswa</title>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?php echo base_url() ;?>assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ;?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ;?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ;?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ;?>assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">



    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Mahasiswa</h3>
              </div>
              <!-- card-header -->
              <div class="card-body">
                <table id="activity" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Menu</th>
                    <th>Nama</th>
                    <th>Kode Dosen</th>
                    <th>Course View</th>
                    <th>Resource</th>
                    <th>Activity</th>
                    <th>Sum Resource Activity</th>
                  </tr>
                 </thead>
                <tbody>
                  <?php
                  foreach ($data->result_array() as $activity):
                  $NIP=$activity['nip'];
                  $Nama=$activity['nama'];
                  $Kode_Dosen=$activity['kode_dosen'];
                  $Course_View=$activity['course_view'];
                  $Resouce=$activity['resource'];
                  $Activity=$activity['activity'];
                  $Sum_Rsource_Activity=$activity['sra'];
                  ?>
                  <tr>
                    <td><?php echo $NIP; ?></td>
                    <td><?php echo $Nama; ?></td>
                    <td><?php echo $Kode_Dosen; ?></td>
                    <td><?php echo $Course_View; ?></td>
                    <td><?php echo $Resouce; ?></td>
                    <td><?php echo $Activity; ?></td>
                    <td><?php echo $Sum_Rsource_Activity; ?></td>

                   </tr>
                         <?php endforeach ; ?>

                  </tbody>
                 
                </table>
</div>
</div>

<script src="<?php echo base_url() ;?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url() ;?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?php echo base_url() ;?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ;?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ;?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url() ;?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ;?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url() ;?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ;?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo base_url() ;?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo base_url() ;?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo base_url() ;?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url() ;?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url() ;?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="<?php echo base_url() ;?>assets/dist/js/adminlte.min.js"></script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
