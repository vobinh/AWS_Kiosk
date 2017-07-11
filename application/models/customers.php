<?php
class Customers_Model extends Model{
	protected $table_name  = 'account';
	protected $primary_key = 'account_id';

	public function get($id = ''){
		if($id != '')
			$this->db->where($this->primary_key,$id);
		$result = $this->db->get($this->table_name)->result_array(false);
		if (count($result) > 0){
			if($id != '')
				return $result[0];
			else
				return $result;
		}
		return false;
	}
	
	public function chk_customers_code($no, $store_id){
		$this->db->join('user', array('user.account_id' => 'account.account_id'),'','left');
		$this->db->where('account.account_no', $no);
		$this->db->in('user.store_id', $store_id);
		$this->db->limit(1);
		$result = $this->db->get($this->table_name)->result_array(false);
		if (count($result) > 0)
			return $result;
		return false;
	}

	public function get_max_cus_no($store_id){
		$this->db->select('MAX(account.account_no) AS max_no');
		$this->db->join('user', array('user.account_id' => 'account.account_id'),'','left');
		$this->db->where('user.u_status', 1);
		$this->db->in('user.store_id',$store_id);
		$result = $this->db->get($this->table_name)->result_array(false);
		if (count($result) > 0)
			return $result[0];
		return false;
	}

	public function save($data){
		$result    = $this->db->insert($this->table_name,$data);
		return $result;
		
	}

	public function delete($id){
		$this->db->where($this->primary_key, $id);
		$result =$this->db->delete($this->table_name);
		if($result){
			return true;
		}else{
			return false;
		}
	}
}
?>