<!doctype html>
<html>

<head>
    <?php 	
	require_once("meta.php");?>
  
</head>

<body class="  " >
	<?php require_once("header.php");?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li class="active">Assignment</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-md-10">
				<h1 class="page-header"> Assignment</h1>
			</div>
			<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
				<?php if($this->session->userdata("position_id")!=2&&$this->session->userdata("position_id")!=6&&!isset($_GET['report'])){?>	
			<form method="POST" class="col-md-2">							
				<h1 class="page-header col-md-12"> 
				<button name="new" class="btn btn-info btn-block btn-lg" value="OK" style="">New</button>
				<input type="hidden" name="task_id"/>
				</h1>
			</form>
			<?php }?>
			<?php }?>
		</div><!--/.row-->
		
		
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				<div class="panel panel-default">
					<div class="panel-body">
					<?php if(isset($_POST['new'])||isset($_POST['edit'])){?>
						<div class="">
							<?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Assignment";}else{$namabutton='name="create"';$judul="Create Assignment";}?>	
							<?php if($this->session->userdata("position_id")!=2){$disabled="";$readonly="";}else{$disabled='disabled="disabled"';$readonly='readonly="readonly"';}?>
							<div class="lead"><h3><?=$judul;?></h3></div>
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
								<?php if(isset($_GET['inv_no'])){
								if(isset($_GET['inv_no'])){$inv_no=$this->input->get("inv_no");}
								?>
							  <div class="form-group">
								<label class="control-label col-sm-2" for="inv_no">Invoice No.:</label>
								<div class="col-sm-10">
								  <input <?=$disabled;?> name="inv_no" id="inv_no" value="<?=$inv_no;?>" class="form-control" readonly=""/>
								</div>
							  </div>
							  <?php }?>
							  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="customer_id">Customer:</label>
								<div class="col-sm-10">
								<?php if(isset($_GET['customer_id'])){$customer_id=$this->input->get("customer_id");}?>
								  <select <?=$disabled;?> name="customer_id" class="form-control" required>
								  <option value="">Select Customer</option>
								  <?php $prod=$this->db->get("customer");
								  foreach($prod->result() as $customer){?>
								  <option value="<?=$customer->customer_id;?>" <?php if($customer_id==$customer->customer_id){?>selected="selected"<?php }?>>
								  	<?=$customer->customer_name;?>
								  </option>
								  <?php }?>
								  </select>
								</div>
							  </div>
													  
							  	
													  
							  <div class="form-group">
								<label class="control-label col-sm-2" for="task_pengirim">Ditugaskan pada:</label>
								<div class="col-sm-10">
								 <select <?=$disabled;?> name="user_id" class="form-control" required>
								  <option value="">Select User</option>
								  <?php $tek=$this->db
								  //->where("position_id","2")
								  ->get("user");
								  foreach($tek->result() as $teknisi){?>
								  <option value="<?=$teknisi->user_id;?>" <?php if($user_id==$teknisi->user_id){?>selected="selected"<?php }?>>
								  	<?=$teknisi->user_name;?>
								  </option>
								  <?php }?>
								  </select>
								</div>
							  </div>	
							  
							   <div class="form-group">
								<label class="control-label col-sm-2" for="task_pengirim">Tgl. Penugasan:</label>
								<div class="col-sm-10">
									<input <?=$disabled;?> class="form-control date" type="text" name="task_date" id="task_date" value="<?=$task_date;?>"/>	
								</div>
							  </div>	
							  
							   <div class="form-group">
								<label class="control-label col-sm-2" for="task_due">Batas Waktu Pekerjaan:</label>
								<div class="col-sm-10">
									<input <?=$disabled;?> class="form-control date" type="text" name="task_due" id="task_due" value="<?=$task_due;?>"/>	
								</div>
							  </div>	
							  
							   <div class="form-group">
								<label class="control-label col-sm-2" for="task_content">Isi Tugas:</label>
								<div class="col-sm-10">
									<textarea <?=$readonly;?> class="form-control" type="text" name="task_content" id="task_content"><?=$task_content;?></textarea>
									<script>
								var roxyFileman = '<?=site_url("fileman/index.html");?>'; 
								  CKEDITOR.replace(
									'task_content',{filebrowserBrowseUrl:roxyFileman,
																filebrowserImageBrowseUrl:roxyFileman+'?type=image',
																removeDialogTabs: 'link:upload;image:upload',
																height: '200px',
																stylesSet: 'my_custom_style'}
								); 
								
								</script>
								</div>
							  </div>		
							  
							   <div class="form-group">
								<label class="control-label col-sm-2" for="task_finished">Selesai Pekerjaan:<br/><small>(Diisi setelah selesai)</small></label>
								<div class="col-sm-10">
									<input class="form-control date" type="text" name="task_finished" id="task_finished" value="<?=$task_finished;?>"/>	
								</div>
							  </div>
							  
							  <div class="form-group">
                                        <label class="control-label col-sm-2" for="task_picture">Bukti Pekerjaan:<br/><small>(Diisi setelah selesai)</small></label>
                                        <div class="col-sm-10" align="left"> 
                                          <input type="file"  id="task_picture" name="task_picture"><br/>
                                        <?php if($task_picture!=""){$user_image="assets/images/task_picture/".$task_picture;}else{$user_image="assets/images/task_picture/noimage.png";}?>
                                          <img id="task_picture_image" width="100" height="100" src="<?=base_url($user_image);?>"/>
                                          <script>
                                            function readURL(input) {
                                                if (input.files && input.files[0]) {
                                                    var reader = new FileReader();
                                        
                                                    reader.onload = function (e) {
                                                        $('#task_picture_image').attr('src', e.target.result);
                                                    }
                                        
                                                    reader.readAsDataURL(input.files[0]);
                                                }
                                            }
                                        
                                            $("#task_picture").change(function () {
                                                readURL(this);
                                            });
                                          </script>
                                        </div>
                                      </div>	
							 
							 <input class="form-control" type="hidden" name="task_id" id="task_id" value="<?=$task_id;?>"/>					  					  
							  <div class="form-group"> 
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
									<a href="<?=site_url("task");?>" type="button" class="btn btn-warning col-md-offset-1 col-md-5" >Back</a>
								</div>
							  </div>
							</form>
						</div>
						<?php }else{?>	
							<?php if($message!=""){?>
							<div class="alert alert-info alert-dismissable">
							  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							  <strong><?=$message;?></strong><br/><?=$uploadtask_picture;?>
							</div>
							<?php }?>
							<div class="box">
								
								<div style="margin-bottom:30px; border-radius:5px; background-color:#FEEFC2; padding:15px;">
								<form class="form-inline">
								<?php
								if($this->session->userdata("position_id")!=2&&$this->session->userdata("position_id")!=6){
								?>
								  <div class="form-group">
									<label for="email">Petugas:</label>
									<select class="form-control" name="user_id">
										<option value="" <?=($this->input->get("user_id")=="")?"selected":"";?>>All</option>
										<?php $user=$this->db->where("position_id","2")->get("user");
										foreach($user->result() as $user){?>
										<option value="<?=$user->user_id;?>" <?=($this->input->get("user_id")==$user->user_id)?"selected":"";?>><?=$user->user_name;?></option>
										<?php }?>
									</select>
								  </div>
								  <button class="btn btn-warning btn-md fa fa-search"></button>
								<?php }?>
								  <a target="_blank" href="<?=site_url("taskprintall");?>" class="btn btn-success btn-md fa fa-print"></a>
								 </form>
								</div>
								<div id="collapse4" class="body table-responsive">				
								<table id="dataTable" class="table table-condensed table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<?php if($this->session->userdata("position_id")!=6){?>
											<th>Date</th>
											<th>Due Date  </th>
											<?php }?>
											<th>Finished Date </th>
											<?php if($this->session->userdata("position_id")!=6){?>
											<th>INV No.</th>
											<?php }?>
											<th>Task No. </th>
											<th>Customer</th>
											<?php if($this->session->userdata("position_id")!=6){?>
											<th>Teknisi</th>
											<?php }?>
											<th>Task</th>
											<th>Status</th>
											<th class="col-md-1">Proof </th>
											<?php if(!isset($_GET['report'])){$col="col-md-3";}else{$col="col-md-1";}?>
											<th class="<?=$col;?>">Action</th>
											
										</tr>
									</thead>
									<tbody> 
										<?php 
										if(isset($_GET['inv_no'])){$this->db->where("inv_no",$_GET['inv_no']);}
										
										if($this->session->userdata("position_id")==2){
											$this->db->where("task.user_id",$this->session->userdata("user_id"));
										}
										if($this->session->userdata("position_id")==6){
											$this->db->where("task.customer_id",$this->session->userdata("customer_id"));
										}
										if(isset($_GET['user_id'])&& $_GET['user_id']!=""){
											$this->db->where("task.user_id",$this->input->get("user_id"));
										}
										$usr=$this->db
										->join("user","user.user_id=task.user_id","left")
										->join("customer","customer.customer_id=task.customer_id","left")
										->order_by("task_id","desc")
										->get("task");
										//echo $this->db->last_query();
										$no=1;
										foreach($usr->result() as $task){
										$warna="background-color:#BAFFC9;"; $status="Done";										
										if($task->task_finished=="0000-00-00"){
											$warna="background-color:#FFB3BA;"; $status="";
										}
										?>
										<tr style="<?=$warna;?>">
											<td><?=$no++;?></td>
											<?php if($this->session->userdata("position_id")!=6){?>											
											<td><?=$task->task_date;?></td>
											<td><?=($task->task_due=="0000-00-00")?"":$task->task_due;?></td>
											<?php }?>
											<td><?=($task->task_finished=="0000-00-00")?"":$task->task_finished;?></td>
											<?php if($this->session->userdata("position_id")!=6){?>
											<td><?=$task->inv_no;?></td>
											<?php }?>
											<td><?=$task->task_no;?></td>
											<td><?=$task->customer_name;?></td>
											<?php if($this->session->userdata("position_id")!=6){?>
											<td><?=$task->user_name;?></td>
											<?php }?>
											<td><?=$task->task_content;?></td>
											<td><?=$status;?></td>																					
											<td><?php if($task->task_picture!=""){$gambar=$task->task_picture;}else{$gambar="noimage.png";}?>
                                                <img src="<?=base_url("assets/images/task_picture/".$gambar);?>" alt="approve" style="width:20px; height:20px;" onClick="tampil(this)">
                                                <script>
											function tampil(a){
												var gambar=$(a).attr("src");
												$("#imgumum").attr("src",gambar);
												$("#myImage").modal("show");
											}
											  </script>
                                            </td>
											<td style="text-align:center; ">  
											<?php if(!isset($_GET['report'])){$float="float:right;";?> 												
												<?php if($this->session->userdata("position_id")!=2){?>	 	 									
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
													<button data-toggle="tooltip" title="Delete" class="btn btn-sm btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
													<input type="hidden" name="task_id" value="<?=$task->task_id;?>"/>
												</form>	
												<?php }?>
												                                     											
												<form method="POST" class="" style="padding:0px; margin:2px; float:right;">
													<button data-toggle="tooltip" title="Edit" class="btn btn-sm btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
													<input type="hidden" name="task_id" value="<?=$task->task_id;?>"/>
												</form>	
												
											<?php }else{$float="";}?>
												<?php if($this->session->userdata("position_id")!=2){?>	 										
												<form method="POST" class="" style="padding:0px; margin:2px; <?=$float;?>">
												  <a data-toggle="tooltip" title="Print Invoice" target="_blank" href="<?=site_url("taskprint?task_no=".$task->task_no)."&customer_id=".$task->customer_id;?>" class="btn btn-sm btn-success " name="edit" value="OK"> 
												  <span class="fa fa-print" style="color:white;"></span>												  </a>
												</form>
												<?php }?>	
												<form method="POST" class="" style="padding:0px; margin:2px; <?=$float;?>">
												  <a data-toggle="tooltip" title="Material / Product" target="_blank" href="<?=site_url("taskproduct?task_no=".$task->task_no)."&customer_id=".$task->customer_id;?>" class="btn btn-sm btn-primary "> 
												  <span class="fa fa-shopping-bag" style="color:white;"></span>												  </a>
												</form>										
											</td>
										</tr>
										<?php }?>
									</tbody>
								</table>
								</div>
							</div>
						<?php }?>
					</div>
				</div>
			</div>
		</div>
	
	<!-- /#wrap -->
	<?php require_once("footer.php");?>
</body>

</html>
