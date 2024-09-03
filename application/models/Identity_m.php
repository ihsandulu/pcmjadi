<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class identity_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek identity
		$identityd["identity_id"]=$this->input->post("identity_id");
		$us=$this->db
		->get_where('identity',$identityd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $identity){		
			foreach($this->db->list_fields('identity') as $field)
			{
				$data[$field]=$identity->$field;
			}				foreach($this->db->list_fields('identity') as $field)
			{
				$data[$field]=$identity->$field;
			}		
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('identity') as $field)
			{
				$data[$field]="";
			}		
			
		}
		
		//upload image
		$data['uploadidentity_picture']="";
		if(isset($_FILES['identity_picture'])&&$_FILES['identity_picture']['name']!=""){
			$array = explode('.', $_FILES['identity_picture']['name']);
			$extension = end($array);
			$identity_picture=str_replace(' ', '_',$_FILES['identity_picture']['name']);
			$identity_picture=str_replace('.', '_',$identity_picture);
			$identity_picture=$identity_picture.".".$extension;
			$identity_picture = date("H_i_s_").$identity_picture;
			if(file_exists ('assets/images/identity_picture/'.$identity_picture)){
			unlink('assets/images/identity_picture/'.$identity_picture);
			}
			$config['file_name'] = $identity_picture;
			$config['upload_path'] = 'assets/images/identity_picture/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']	= '3000000000';
			$config['max_width']  = '5000000000';
			$config['max_height']  = '3000000000';
	
			$this->load->library('upload', $config);
	
			if ( ! $this->upload->do_upload('identity_picture'))
			{
				$data['uploadidentity_picture']="Upload Gagal !<br/>".$config['upload_path'].$identity_picture. $this->upload->display_errors();
			}
			else
			{
				$data['uploadidentity_picture']="Upload Success !";
				$input['identity_picture']=$identity_picture;
			}	
		}
		
		$data['uploadidentity_npwpi']="";
		if(isset($_FILES['identity_npwpi'])&&$_FILES['identity_npwpi']['name']!=""){
			$array = explode('.', $_FILES['identity_npwpi']['name']);
			$extension = end($array);
			$identity_npwpi=str_replace(' ', '_',$_FILES['identity_npwpi']['name']);
			$identity_npwpi=str_replace('.', '_',$identity_npwpi);
			$identity_npwpi=$identity_npwpi.".".$extension;
			$identity_npwpi = date("H_i_s_").$identity_npwpi;
			if(file_exists ('assets/images/identity_npwpi/'.$identity_npwpi)){
			unlink('assets/images/identity_npwpi/'.$identity_npwpi);
			}
			$config['file_name'] = $identity_npwpi;
			$config['upload_path'] = 'assets/images/identity_npwpi/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']	= '3000000000';
			$config['max_width']  = '5000000000';
			$config['max_height']  = '3000000000';
	
			$this->load->library('upload', $config);
	
			if ( ! $this->upload->do_upload('identity_npwpi'))
			{
				$data['uploadidentity_npwpi']="Upload Gagal !<br/>".$config['upload_path'].$identity_npwpi. $this->upload->display_errors();
			}
			else
			{
				$data['uploadidentity_npwpi']="Upload Success !";
				$input['identity_npwpi']=$identity_npwpi;
			}	
		}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("identity",array("identity_id"=>$this->input->post("identity_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("identity",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='identity_picture'){$input[$e]=$this->input->post($e);}}
			$this->db->update("identity",$input,array("identity_id"=>$this->input->post("identity_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
