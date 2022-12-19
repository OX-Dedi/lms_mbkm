<div class="container pt-5">''
    <h3><?= $title ?></h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb ">
            <li class="breadcrumb-item"><a>Mahasiswa</a></li>
            <li class="breadcrumb-item "><a href="<?= base_url('Nilai/Index'); ?>">List Data</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Data</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <?php
                    //create form
                    $attributes = array('id' => 'FrmAddMahasiswa', 'method' => "post", "autocomplete" => "off");
                    echo form_open('', $attributes);
                    ?>
                    <div class="form-group row">
                        <label for="Nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="Nama" name="Nama" value=" <?= set_value('Nama'); ?>">
                            <small class="text-danger">
                                <?php echo form_error('Nama') ?>
                            </small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="UTS" class="col-sm-2 col-form-label">UTS</label>
                        <div class="col-sm-5">
                        <input type="text" class="form-control" id="UTS" name="UTS" value="<?= set_value('UTS'); ?>">
                            <small class="text-danger">
                                <?php echo form_error('UTS') ?>
                            </small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="UAS" class="col-sm-2 col-form-label">UAS</label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="UAS" name="UAS" value="<?= set_value('UAS'); ?>">
                            <small class="text-danger">
                                <?php echo form_error('UAS') ?>
                            </small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10 offset-md-2">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a class="btn btn-secondary" href="javascript:history.back()">Kembali</a>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>