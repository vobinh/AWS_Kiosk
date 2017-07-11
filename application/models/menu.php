<?php
class Menu_Model extends Model{
	protected $table_name  = 'menu';
	protected $primary_key = 'menu_idx';

	public function get(){
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

	public function search($search){
		if($search['keyword']){
			 $keyword = strtolower($search['keyword']);
             $this->db->where("LCASE(name) LIKE '%" .$keyword. "%'");
		}	
	}
	
}
?>