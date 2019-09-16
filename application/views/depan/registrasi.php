<div class="container" style="margin-top: 120px;">
  <div class="row">
    <div class="col-md-6">
        <img src="<?php echo base_url('')?>./assets/depan/img/sdgs.jpg" width="600px" height="400px">
    </div>
    <div class="col-md-6">
        <div class="card-body px-lg-5 py-lg-5">
            <form role="form" id="form" method="POST">
                <div class="form-group">
                    <div class="input-group input-group-alternative mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-university"></i></span>
                        </div>
                        <input name="email" class="form-control" placeholder="Nama Lembaga" type="email">
                    </div>
				</div>
				<div class="form-group">
                    <div class="input-group input-group-alternative mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                        </div>
                        <input name="email" class="form-control" placeholder="Nama Pimpiinan Lembaga" type="email">
                    </div>
				</div>
				<div class="form-group">
                    <div class="input-group input-group-alternative mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-address-card-o"></i></span>
                        </div>
                        <input name="email" class="form-control" placeholder="Jabatan Pimpinan Lembaga" type="email">
                    </div>
				</div>
				<div class="form-group">
                    <div class="input-group input-group-alternative">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-building"></i></span>
                        </div>
                        <textarea name="Alamat" form="form" class="form-control" placeholder="Alamat" style="resize: none;"></textarea>
                    </div>
				</div>
				<div class="form-group">
                    <div class="input-group input-group-alternative mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                        </div>
                        <input name="name" class="form-control" placeholder="Email Kantor" type="email">
                    </div>
				</div>
				<div class="form-group">
                    <div class="input-group input-group-alternative mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-phone"></i></span>
                        </div>
                        <input name="telepon" class="form-control" placeholder="Telepon" type="telepon">
                    </div>
				</div>
				<div class="form-group">
                    <div class="input-group input-group-alternative mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                        </div>
                        <input name="namakontak" class="form-control" placeholder="Nama Kontak Utama" type="namakontak">
                    </div>
				</div>
				<div class="form-group">
                    <div class="input-group input-group-alternative mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-address-card-o"></i></span>
                        </div>
                        <input name="email" class="form-control" placeholder="Jabatan Kontak Utama" type="email">
                    </div>
				</div>
				<div class="form-group">
                    <div class="input-group input-group-alternative mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                        </div>
                        <input name="name" class="form-control" placeholder="Email Kontak Utama" type="email">
                    </div>
				</div>
				<div class="form-group">
                    <div class="input-group input-group-alternative mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-puzzle-piece"></i></span>
                        </div>
						<select name="" id="" class="form-control">
							<option value="" selected>- Pilih Jenis Organisasi -</option>
							<option value="">Yayasan Perusahaan</option>
							<option value="">Yayasan Keluarga</option>
							<option value="">Yayasan Berbasis Keagamaan</option>
							<option value="">Yayasan Media Massa</option>
							<option value="">Lembaga Filantropi Independen</option>
						</select>
                    </div>
				</div>
				<div class="form-group">
                    <div class="input-group input-group-alternative mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-money"></i></span>
                        </div>
						<select name="" id="" class="form-control">
							<option value="" selected>- Iuran Keanggotaan -</option>
							<option value="">1 Tahun IDR 6000.000</option>
							<option value="">2 Tahun IDR 12.000.000</option>
						</select>
                    </div>
				</div>
				<div class="form-group">
                    <div class="input-group input-group-alternative mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-key"></i></span>
                        </div>
                        <input name="name" class="form-control" placeholder="Password" type="email">
                    </div>
				</div>
				<div class="form-group">
                    <div class="input-group input-group-alternative mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-unlock-alt"></i></span>
                        </div>
                        <input name="name" class="form-control" placeholder="Konfirmasi Password" type="email">
                    </div>
				</div>
				


              <div class="row mt-4">
                <div class="col-md-6 mt-2">
                  <span>
                    <a href="<?php echo site_url('')?>/home/login">sudah punya akun ?</a>
                  </span>
                </div>
                <div class="text-right col-md-6">
                  <button name="register" type="submit" class="btn btn-success">Buat akun</button>
                </div>
              </div>
            </form>
          </div>
    </div>
  </div>
</div>
