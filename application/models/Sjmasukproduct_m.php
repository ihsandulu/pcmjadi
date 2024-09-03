<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class sjmasukproduct_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		$identity=$this->db->get("identity")->row();
		//cek sjmasukproduct
		if(isset($_POST['sjmasukproduct_id'])){
		$sjmasukproductd["sjmasukproduct_id"]=$this->input->post("sjmasukproduct_id");
		$us=$this->db
		->join("product","product.product_id=sjmasukproduct.product_id","left")
		->get_where('sjmasukproduct',$sjmasukproductd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $sjmasukproduct){		
			foreach($this->db->list_fields('sjmasukproduct') as $field)
			{
				$data[$field]=$sjmasukproduct->$field;
			}		
			foreach($this->db->list_fields('product') as $field)
			{
				$data[$field]=$sjmasukproduct->$field;
			}	
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('sjmasukproduct') as $field)
			{
				$data[$field]="";
			}	
			foreach($this->db->list_fields('product') as $field)
			{
				$data[$field]="";
			}		
			
		}
		}
		
		//upload image
		$data['uploadsjmasukproduct_picture']="";
		if(isset($_FILES['sjmasukproduct_picture'])&&$_FILES['sjmasukproduct_picture']['name']!=""){
		$sjmasukproduct_picture=str_replace(' ', '_',$_FILES['sjmasukproduct_picture']['name']);
		$sjmasukproduct_picture = date("H_i_s_").$sjmasukproduct_picture;
		if(file_exists ('assets/images/sjmasukproduct_picture/'.$sjmasukproduct_picture)){
		unlink('assets/images/sjmasukproduct_picture/'.$sjmasukproduct_picture);
		}
		$config['file_name'] = $sjmasukproduct_picture;
		$config['upload_path'] = 'assets/images/sjmasukproduct_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('sjmasukproduct_picture'))
		{
			$data['uploadsjmasukproduct_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadsjmasukproduct_picture']="Upload Success !";
			$input['sjmasukproduct_picture']=$sjmasukproduct_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){//delete stok
			$sj=$this->db
			->where("sjmasukproduct_id",$this->input->post("sjmasukproduct_id"))
			->get("sjmasukproduct");
			foreach($sj->result() as $sj){	
				$istok["gudang_barcode"]=$sj->gudang_barcode;
				$this->db->delete("stok",$istok);
			}
			//echo $this->db->last_query();die;
			
			
			$this->db->delete("sjmasukproduct",array("sjmasukproduct_id"=>$this->input->post("sjmasukproduct_id")));
			if($identity->identity_stok==0){
				$this->db->delete("gudang",array("sjmasukproduct_id"=>$this->input->post("sjmasukproduct_id")));
			}
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			
			$code=$this->db
			->where("product_id",$input["product_id"])
			->get("product")
			->row()
			->product_code;
			$sjmasukproduct1=$this->db
			->where("product_id",$input["product_id"])
			->order_by("gudang_barcode","desc")
			->limit(1)
			->get("sjmasukproduct");
			$gudang_barcode=0;
			$tgl=date("ymd");
			$potong=strlen($tgl)+strlen($code);
			foreach($sjmasukproduct1->result() as $sjmasukproduct){
				$gudang_barcode=substr($sjmasukproduct->gudang_barcode,$potong);
			}
			$length=13-strlen($tgl)-strlen($code);
			$barcode=str_pad(str_replace($code,"",$gudang_barcode)+1,$length,"0",STR_PAD_LEFT);
			$input["gudang_barcode"]=$code.$tgl.$barcode;
			
			$this->db->insert("sjmasukproduct",$input);
			
			if($identity->identity_stok==0){
				$gudang["product_id"]=$this->input->post("product_id");
				$gudang["gudang_qty"]=$this->input->post("sjmasukproduct_qty");
				$gudang["gudang_inout"]="in";
				$gudang["branch_id"]=$this->session->userdata("branch_id");
				$gudang["sjmasukproduct_id"]=$this->db->insert_id();
				$gudang["sjmasuk_no"]=$this->input->post("sjmasuk_no");
				$this->db->insert("gudang",$gudang);
				//echo $this->db->last_query();die();
				
				
				//input stok
				$istok["gudang_barcode"]=$input["gudang_barcode"];
				$istok["product_id"]=$input["product_id"];
				$istok["varian_id"]=$input["varian_id"];
				$istok["stok_amount"]=$input["sjmasukproduct_qty"];
				$this->db->insert("stok",$istok);
			}
			//echo $this->db->last_query();die;
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='sjmasukproduct_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("sjmasukproduct",$input,array("sjmasukproduct_id"=>$this->input->post("sjmasukproduct_id")));
						
			if($identity->identity_stok==0){			
				//update stok				
				$istok["gudang_barcode"]=$input["gudang_barcode"];
				$ustok["stok_amount"]=$input["sjmasukproduct_qty"];
				$this->db->update("stok",$ustok,$istok);
			
				$gudang["product_id"]=$this->input->post("product_id");
				$gudang["gudang_qty"]=$this->input->post("sjmasukproduct_qty");
				$gudang["branch_id"]=$this->session->userdata("branch_id");
				$this->db->update("gudang",$gudang,array("sjmasukproduct_id"=>$this->input->post("sjmasukproduct_id")));
			}
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
