<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class unit_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek unit
		$unitd["unit_id"]=$this->input->post("unit_id");
		$us=$this->db
		->get_where('unit',$unitd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $unit){		
			foreach($this->db->list_fields('unit') as $field)
			{
				$data[$field]=$unit->$field;
			}		
		}
		}else{	
			 		
			
			foreach($this->db->list_fields('unit') as $field)
			{
				$data[$field]="";
			}		
			
		}
		
		//upload image
		$data['uploadunit_picture']="";
		if(isset($_FILES['unit_picture'])&&$_FILES['unit_picture']['name']!=""){
		$unit_picture=str_replace(' ', '_',$_FILES['unit_picture']['name']);
		$unit_picture = date("H_i_s_").$unit_picture;
		if(file_exists ('assets/images/unit_picture/'.$unit_picture)){
		unlink('assets/images/unit_picture/'.$unit_picture);
		}
		$config['file_name'] = $unit_picture;
		$config['upload_path'] = 'assets/images/unit_picture/';
		$config['allowed_types'] = 'gif|jpg|png|xls|xlsx|pdf|doc|docx';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('unit_picture'))
		{
			$data['uploadunit_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadunit_picture']="Upload Success !";
			$input['unit_picture']=$unit_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("unit",array("unit_id"=>$this->input->post("unit_id")));
			$data["message"]="Delete Success";
		}
		
		//insert
		if($this->input->post("create")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='create'){$input[$e]=$this->input->post($e);}}
			$this->db->insert("unit",$input);
			$data["message"]="Insert Data Success";
		}
		//echo $_POST["create"];die;
		//update
		if($this->input->post("change")=="OK"){
			foreach($this->input->post() as $e=>$f){if($e!='change'&&$e!='unit_picture'){$input[$e]=$this->input->post($e);}}
			$input["unit_name"]=htmlentities($input["unit_name"], ENT_QUOTES);
			$this->db->update("unit",$input,array("unit_id"=>$this->input->post("unit_id")));
			$data["message"]="Update Success";
			//echo $this->db->last_query();die;
		}
		return $data;
	}
	
}
