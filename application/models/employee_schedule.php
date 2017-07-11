<?php
class Employee_schedule_Model extends Model{
	protected $table_name  = 'employee_schedule';
	protected $primary_key = 'employee_schedule_id';

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
		$result = $this->db->insert($this->table_name,$data);
		return $result;
	}

	public function update($data){
		$result = $this->db->update($this->table_name, $data);
		return $result;
	}

	public function delete($id=''){
		if(!empty($id))
			$this->db->where($this->primary_key, $id);
		$result = $this->db->delete($this->table_name);
		return $result;
	}

	public function search($search){
		if($search['keyword']){
			$keyword = strtolower($search['keyword']);
            $this->db->where("LCASE(name) LIKE '%" .$keyword. "%'");
		}	
	}
	
}
?>