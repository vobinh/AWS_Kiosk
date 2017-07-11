<?php
class User_Model extends Model{
	protected $table_name  = 'user';
	protected $primary_key = 'user_id';

	public function get(){
		$result = $this->db->get($this->table_name)->result_array(false);
		if (count($result) > 0)
			return $result;
		return false;
	}
	
	public function join_user_account($store_id){
		$this->db->where('store_id', $store_id);
		$this->db->join('account', array('account.account_id' => 'user.account_id'),'','left');
		$this->db->orderby('account_no','DESC');
		$m_user = $this->db->get('user')->result_array(false);
		if (count($m_user) > 0)
			return $m_user;
		return false;
	}

	public function count_user(){
		$this->db->select('count(user_id) AS total_user');
		$result = $this->db->get($this->table_name)->result_array(false);
		if (count($result) > 0)
			return $result;
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

	public function search($search){
		if($search['keyword']){
			 $keyword = strtolower($search['keyword']);
             $this->db->where("LCASE(name) LIKE '%" .$keyword. "%'");
		}	
	}
	
}
?>