<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");
class task_M extends CI_Model {
	
	public function data()
	{	
		$data=array();	
		$data["message"]="";
		//cek task
		if(isset($_POST['task_id'])){
		$taskd["task_id"]=$this->input->post("task_id");
		$us=$this->db
		->get_where('task',$taskd);	
		//echo $this->db->last_query();die;	
		if($us->num_rows()>0)
		{
			foreach($us->result() as $task){		
				foreach($this->db->list_fields('task') as $field)
				{
					$data[$field]=$task->$field;
				}				
			}
		}else{	
			 		
			
			foreach($this->db->list_fields('task') as $field)
			{
				$data[$field]="";
			}		
			
		}
		}
		
		//upload image
		$data['uploadtask_picture']="";
		if(isset($_FILES['task_picture'])&&$_FILES['task_picture']['name']!=""){
		$task_picture=str_replace(' ', '_',$_FILES['task_picture']['name']);
		$task_picture = date("H_i_s_").$task_picture;
		if(file_exists ('assets/images/task_picture/'.$task_picture)){
		unlink('assets/images/task_picture/'.$task_picture);
		}
		$config['file_name'] = $task_picture;
		$config['upload_path'] = 'assets/images/task_picture/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '3000000000';
		$config['max_width']  = '5000000000';
		$config['max_height']  = '3000000000';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('task_picture'))
		{
			$data['uploadtask_picture']="Upload Gagal !<br/>".$config['upload_path']. $this->upload->display_errors();
		}
		else
		{
			$data['uploadtask_picture']="Upload Success !";
			$input['task_picture']=$task_picture;
		}
	
	}
	 
		//delete
		if($this->input->post("delete")=="OK"){
			$this->db->delete("task",array("task_id"=>$this->input->post("task_id")));			
			//$this->db->delete("taskproduct",array("task_no"=>$this->input->post("task_no")));
			$data["message"]="Delete Success";
		}
		
		//bulan romawi		
		$array_bulan = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
		$bulan = $array_bulan[date('n')];
		
		//insert
		if($this->input->post("create")=="OK"){	
		
		$nosura=$this->db
		->where("nomor_name","Assignment")
		->get("nomor");
		if($nosura->num_rows()>0){
			$nosurat=$nosura->row()->nomor_no."-";
		}else{
			$nosurat="ASG-";
		}
			
		$sjno=$this->db
		->order_by("task_id","desc")
		->limit("1")
		->get("task");
		if($sjno->num_rows()>0){
			//caribulan
			$terakhir=$sjno->row()->task_no;
			$blno=explode("-",$terakhir);
			$blnno=$blno[1];
			$noterakhir=end($blno);
			$identity_number=$this->db->get("identity")->row()->identity_number;
			if($identity_number=="Monthly"){
				if($blnno!=$bulan){
					$inno=1;
				}else{
					$inno=$noterakhir+1;
					//$inno=1;
				}
			}
			if($identity_number=="Yearly"){
				if($blno[2]!=date("Y")){
					$inno=1;
				}else{
					$inno=$noterakhir+1;
					//$inno=1;
				}
			}
		}else{
			$inno=1;
		}
			$sno=$nosurat.$bulan.date("-Y-").str_pad($inno,5,"0",STR_PAD_LEFT);
			$input["task_no"]=$sno;
			foreach($this->input->post() as $e=>$f){
			if($e!='create'){
				$input[$e]=$this->input->post($e);				
				}
			}
			$this->db->insert("task",$input);			
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
			$this->db->update("task",$input,array("task_id"=>$this->input->post("task_id")));
			$data["message"]="Insert Data Success";
		}
		
		return $data;
	}
	
}
