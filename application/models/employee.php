<?php
class Employee_Model extends Model{
	protected $table_name  = 'access';
	protected $primary_key = 'access_id';

	public function get($id=''){
		if(!empty($id)){
			if(is_array($id))
				$this->db->in($this->primary_key, $id);
			else
				$this->db->where($this->primary_key, $id);
		}
		$result = $this->db->get($this->table_name)->result_array(false);
		if (count($result) > 0)
			return $result;
		return false;
	}
	
	public function save($data){
		$result    = $this->db->insert($this->table_name,$data);
		$result_id = $result->insert_id();
		return $result_id;
		
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

	public function getMaxNo($supAdmin){
		$this->db->select('max(access_no) as access_no');
		$this->db->where('admin_id', $supAdmin);
		$this->db->where('status', 1);
		$result   = $this->db->get('access')->result_array(false);
		if (count($result) > 0)
			return $result[0];
		return false;
	}

	public function search($search){
		if($search['keyword']){
			 $keyword = strtolower($search['keyword']);
             $this->db->where("LCASE(name) LIKE '%" .$keyword. "%'");
		}	
	}
	
}
?>