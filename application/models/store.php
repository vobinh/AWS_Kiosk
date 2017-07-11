<?php
class Store_Model extends Model{
	protected $table_name  = 'store';
	protected $primary_key = 'store_id';

	public function get($ids = ''){
		if(!empty($ids)){
			if(is_array($ids))
				$this->db->in($this->primary_key, $ids);
			else
				$this->db->where($this->primary_key, $ids);
		}
		$result = $this->db->get($this->table_name)->result_array(false);
		if (count($result) > 0)
			return $result;
		return false;
	}
	
	public function getStoreAdmin($supAdmin){
		$this->db->where('admin_id', $supAdmin);
		$result = $this->db->get($this->table_name)->result_array(false);
		if (count($result) > 0)
			return $result;
		return false;
	}

	public function save($data){
		$result = $this->db->insert($this->table_name,$data);
		return $result;
		
	}

	public function update($data){
		$result = $this->db->update($this->table_name, $data);
		return $result;
	}

	public function delete($id){
		$this->db->where($this->primary_key, $id);
		$result = $this->db->delete($this->table_name);
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