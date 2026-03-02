<div class="modal fade" id="edit_password" tabindex="-1" aria-labelledby="edit_password" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit_password"><i class="fa fa-user"></i> Edit Data Pengguna</h5>
                <button type="button" class="btn btn-danger" onclick="close_modal()" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <div class="form-group row mb-3">
                    <label class="col-md-3 col-form-label text-md-right">Nama : </label>
                    <div class="col-md-8">
                        <!-- <p class="form-control-plaintext"><?php echo $this->session->userdata('nama'); ?></p> -->
                        <div class="input-group">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $this->session->userdata('nama'); ?>" readonly>
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-md-3 col-form-label text-md-right">Email : </label>
                    <div class="col-md-8">
                        <!-- <p class="form-control-plaintext"><?php echo $this->session->userdata('email'); ?></p> -->
                        <div class="input-group">
                            <input type="text" class="form-control" id="email" name="email" value="<?php echo $this->session->userdata('email'); ?>">
                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <label for="pass_baru" class="col-md-3 col-form-label text-md-right">Password Baru :</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="password" id="pass_baru" name="pass_baru" required class="form-control">
                            <span class="input-group-text" style="cursor: pointer;" onclick="togglePassword()">
                                <i class="fa fa-eye" id="iconPass"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="show_pass"></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="checkbox" id="show_pass" onclick="togglePassword()"> Show Password
                                </div>
                            </div> -->
                <div class="text-center">
                    <button type="submit" class="btn btn-success" onclick="Simpan_password()"><i class="fa fa-download"></i> Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>