<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class kasprint_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek kas
		if(isset($_POST['kas_id'])){
		$kasd["kas_id"]=$this->input->post("kas_id");
		$us=$this->db
		->get_where('kas',$kasd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $kas){		
				foreach($this->db->list_fields('kas') as $field)
				{
					$data[$field]=$kas->$field;
				}				
			}
		}else{	
			 		
			
			foreach($this->db->list_fields('kas') as $field)
			{
				$data[$field]="";
			}		
			
		}
		}
		
		$identit=$this->db
		->get("identity");
		foreach($identit->result() as $identity){
			foreach($this->db->list_fields('identity') as $field){
				$data[$field]=$identity->$field;
			}
		}
		
		//upload image
		$data['uploadkas_picture']="";
		if(isset($_FILES['kas_picture'])&&$_FILES['kas_picture']['name']!=""){
		$kas_picture=str_replace(' ', '_',$_FILES['kas_picture']['name']);
		$kas_picture = date("H_i_s_").$kas_picture;
		if(file_exists ('assets/images/kas_picture/'.$kas_picture)){
		unlink('assets/images/kas_picture/'.$kas_picture);
		}
		$config['file_name'] = $kas_picture;
		$config['upload_path'] = 'assets/images/kas_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('kas_picture'))
		{
			$data['uploadkas_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadkas_picture']="Upload Success !";
			$input['kas_picture']=$kas_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("kas",array("kas_id"=>$this->input->post("kas_id")));			
			$this->db->delete("kasproduct",array("kas_id"=>$this->input->post("kas_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){		
		foreach($this->input->post() as $e=>$f){
			if($e!='create'){
				$input[$e]=$this->input->post($e);				
				}
			}			
			$this->db->insert("kas",$input);			
			//echo $this->db->last_query();die;
			
			$data["message"]="Insert Data Success";
		}
		
		//update
		if($this->input->post("change")=="OK"){
		
			foreach($this->input->post() as $e=>$f){
			if($e!='change'){
				$input[$e]=$this->input->post($e);				
				}
			}			
			$this->db->update("kas",$input,array("kas_id"=>$this->input->post("kas_id")));
			$data["message"]="Insert Data Success";
		}
		
		return $data;
	}
	
}
