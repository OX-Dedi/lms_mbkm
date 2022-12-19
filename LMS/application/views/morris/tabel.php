<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data Mahasiswa</title>


  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="<?php echo base_url() ;?>assets/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ;?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ;?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ;?>assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ;?>assets/dist/css/scrol.css">
  <link rel="stylesheet" href="<?php echo base_url() ;?>assets/dist/css/adminlte.min.css">
  <style>
    .scroll{
      height: 300px;
      overflow: scroll;
    }
    </style>
       
         
</head>
<body class="hold-transition sidebar-mini">




    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Activity</h3>
              </div>

              <div class="card-body">
                <div class="scroll">
              <table id="activity" class="table table-white table-bordered table-striped table-bordered table-sm  " cellspacing="0"width="100%">
                <thead class="table-dark">
                  <tr>
                    <th class="th-sm">faculty_id</th>
                    <th class="th-sm">program_id</th>
                    <th class="th-sm">semester_id</th>
                    <th class="th-sm">nama</th>
                    <th class="th-sm">kelas</th>
                    <th class="th-sm">activity</th>
                    <th class="th-sm">total_activity</th>
                  </tr>
                 </thead>
                <tbody>
                  <?php
                  foreach ($data->result_array() as $tb_kelas):
                  $faculty_id=$tb_kelas['faculty_id'];
                  $program_id=$tb_kelas['program_id'];
                  $semester_id=$tb_kelas['semester_id'];
                  $nama=$tb_kelas['nama'];
                  $kelas=$tb_kelas['kelas'];
                  $activity=$tb_kelas['activity'];
                  $total_activity=$tb_kelas['total_activity'];
                  ?>
                  <tr>
                    <td><?php echo $faculty_id; ?></td>
                    <td><?php echo $program_id; ?></td>
                    <td><?php echo $semester_id; ?></td>
                    <td><?php echo $nama; ?></td>
                    <td><?php echo $kelas; ?></td>
                    <td><?php echo $activity; ?></td>
                    <td><?php echo $total_activity; ?></td>
                   </tr>
                         <?php endforeach ; ?>

                  </tbody>
                 
                </table>
</div>
</div></div>



<script src="<?php echo base_url() ;?>assets/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url() ;?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
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
<script src="<?php echo base_url() ;?>assets/plugins/datatables-buttons/js/scrol.js">
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
