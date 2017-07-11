<?php
class Stage_Model extends Model{
	protected $table_name  = 'stage';
	protected $primary_key = 'id';

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
	
	public function getStore($idStore){
		if(is_array($idStore))
			$this->db->in($this->table_name.'.store_id', $idStore);
		else
			$this->db->where($this->table_name.'.store_id', $idStore);
		$this->db->notin($this->table_name.'.status', array('DELETE'));
		$result = $this->db->get($this->table_name);
		return $result;
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