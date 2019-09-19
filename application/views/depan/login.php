<main>

<div class="container" style="margin-top: 120px; margin-bottom: 50px;">
  <div class="row">
	<div class="col-md-6">
	  <img src="<?php echo base_url('')?>./assets/depan/img/8.png" width="100%" height="100%">
	</div>
	<div class="col-md-6">
		<div class="container row m-auto p-0 shadow">
			 <div class="col-md-7 p-5 bg-white rounded-left">
			   <div class="row mt-4">
				 <span>
				   <h1>Masuk</h1>
				 </span> 
			   </div>        
			   <div class="row">
				 <span>
				   Masuk ke akun anda
				 </span> 
			   </div>


			   <!-- Login Form -->
				 <form method="post" action="<?= site_url('member/dologin') ?>" class="row mt-3">
				   <h6 class="text-danger text-center"> <b><?= $this->session->flashdata('msg'); ?></b> </h6>
				   <div class="input-group">
					 <div class="input-group-prepend">
					   <span class="input-group-text"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
					 </div>
					 <input autocomplete="off" type="text" class="form-control" id="member_username" placeholder="<?php echo GET_LABEL('PLACEHOLDER_USERNAME', $LANG['code']); ?>" name="member_username">
				   </div>

				   <div class="input-group mt-2 mb-3">
					 <div class="input-group-prepend">
					   <span class="input-group-text">
					   <i class="fa fa-unlock" aria-hidden="true"></i></span>
					 </div>
					 <input type="password" class="form-control" id="member_password" placeholder="<?php echo GET_LABEL('PLACEHOLDER_PASSWORD', $LANG['code']); ?>" name="member_password">
				   </div>

				   <div class="col-md-6 p-0">
					   <button type="submit" class="btn btn-success">Masuk!</button>
				   </div>

					<div class="form-group clearfix">
						<div class="checkbox-custom checkbox-inline pull-left">
						</div>
						<a class="pull-right" href="<?php echo base_url("jpanel/cpanelx/resetpassword"); ?>"><?php echo GET_LABEL('LABEL_FORGOT_PASSWORD', $LANG['code']); ?></a>
					</div>
				 </form>
			   <!-- ./Login Form -->
			 </div>

			 <div class="col-md-5 text-center bg-success p-5 rounded-right text-white" style="background: #28a745;" >
			   <h3>Daftar!</h3>
				 <a href="registrasi.html" class="btn btn-light">Daftar Sekarang!</a>
			 </div>
		 </div>
	</div>
  </div>
</div>
