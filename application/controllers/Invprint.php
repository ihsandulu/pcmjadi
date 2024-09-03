<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class invprint extends CI_Controller {


	public function index()
	{	$custo=$this->db
		->where("customer_id",$this->input->get("customer_id"))
		->get("customer");
		foreach($custo->result() as $customer){
			foreach($this->db->list_fields('customer') as $field){
				$data[$field]=$customer->$field;
			}
		}
		
		$identit=$this->db
		->get("identity");
		foreach($identit->result() as $identity){
			foreach($this->db->list_fields('identity') as $field){
				$data[$field]=$identity->$field;
			}
		}
		
		$in=$this->db
		->join("invproduct","invproduct.inv_no=inv.inv_no","left")
		->join("product","product.product_id=invproduct.product_id","left")
		->where("inv.inv_no",$this->input->get("inv_no"))
		->get("inv");
		//echo $this->db->last_query();
		$data["inv_ppn"]=0;
		$data["inv_pph"]=0;
		foreach($in->result() as $inv){	
			foreach($this->db->list_fields('inv') as $field){
				 $data[$field]=$inv->$field;	
			}		
			foreach($this->db->list_fields('product') as $field){
				$data[$field]=$inv->$field;			
			}
			foreach($this->db->list_fields('invproduct') as $field){
				$data[$field]=$inv->$field;			
			}
			
			
				
			if($data["inv_ppn"]==1){
				$data["inv_ppn"]=10/100;
			}else{
				$data["inv_ppn"]=0;
			}
			
			
			if($data["inv_pph"]==1){
				$data["inv_pph"]=2/100;
			}else{
				$data["inv_pph"]=0;
			}
			
		}
		$this->load->view('invprint_v',$data);
		
	}
}
