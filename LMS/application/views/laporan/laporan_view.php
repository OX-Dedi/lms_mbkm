<!DOCTYPE html>
<html>
    <head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Laporan</title>
    <link href="https://livedemo.mbahcoding.com/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://livedemo.mbahcoding.com/assets/datatables/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/bootstrap1/css/bootstrap1.min.css')?> rel="stylesheet">
    <link href="<?php echo base_url('assets/datatables1/css/dataTables.bootstrap.min.css')?>" rel="stylesheet">

    </head> 
<body>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <div class="card">
        <div class="panel panel-default">
            <div class="panel-heading bg-danger">
                <h3 class="panel-title" >Filterisasi : </h3>
            </div>
            <div class="panel-body">
                <form id="form-filter" class="form-horizontal">
                <div class="form-group">
                        <label for="semester_id" class="col-sm-2 control-label">Semester</label>
                        <div class="col-sm-4">
                            <?php echo $form_semester_id; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="program_id" class="col-sm-2 control-label">Program</label>
                        <div class="col-sm-4">
                            <?php echo $form_program_id; ?>
                        </div>
                    </div>
                <div class="form-group">
                        <label for="kelas" class="col-sm-2 control-label">Kelas</label>
                        <div class="col-sm-4">
                            <?php echo $form_kelas; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="activity" class="col-sm-2 control-label">Activity</label>
                        <div class="col-sm-4">
                            <?php echo $form_activity; ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="#" class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <button type="button" id="btn-filter" class="btn btn-primary">Filter</button>
                            <button type="button" id="btn-reset" class="btn btn-default">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Faculty Id</th>
                    <th>Program Id</th>
                    <th>Semester Id</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Activity</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Faculty Id</th>
                    <th>Program Id</th>
                    <th>Semester Id</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Activity</th>
                </tr>
            </tfoot>
        </table>
    </div>
<script src="<?php echo base_url('assets/jquery1/jquery-2.2.3.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap1/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables1/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables1/js/dataTables.bootstrap.min.js')?>"></script>

            
<script type="text/javascript">

var table;

$(document).ready(function() {

   
    table = $('#table').DataTable({ 

        "processing": true, 
        "serverSide": true, 
        "order": [], 

        "ajax": {
            "url": "<?php echo site_url('Laporan/ajax_list/')?>",
            "type": "POST",
            "data": function ( data ) {
                data.activity = $('#activity').val();
                data.faculty_id = $('#faculty_id').val();
                data.program_id = $('#program_id').val();
                data.semester_id = $('#semester_id').val();
                data.kelas = $('#kelas').val();
            }
        },

        
        "columnDefs": [
        { 
            "targets": [ 0 ], 
            "orderable": false, 
        },
        ],

    });

    $('#btn-filter').click(function(){
        table.ajax.reload(); 
    });
    $('#btn-reset').click(function(){ 
        $('#form-filter')[0].reset();
        table.ajax.reload();  
    });

});

</script>

</body>
</html>