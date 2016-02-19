<?php


	class Test_m extends CI_Model
	{
		
		function __construct()
		{
			// 공통적인 처리
			parent :: __construct();
		}

		function insertMember($Params)
		{
			$this->db->insert('TB_MEMBER', $Params);
		}

		function selectMember() 
		{
			$this->db->select('userid');
			$this->db->select('userpw');
			$this->db->select('reg_date');
			$this->db->from('TB_MEMBER');

			return $this->db->get()->result_array();

		}
	}


?>