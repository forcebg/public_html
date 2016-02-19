<?
	class am_model extends CI_Model{
	
		public function __construct()
		{
			$this->load->helper('url');
			$this->load->database();
		}

		
		
		public function login_ok($user_id, $passwd)
		{
			
			$SQL ="SELECT uid, user_name FROM `tb_member_master` where user_id='".$user_id."' and passwd='".$passwd."';";
			$query = $this->db->query($SQL);
			
			return $query;
		}
		
		public function pointUp($user_id, $board_id)
		{	
			//글을 읽었는지 확인 

			$SQL = "select count(*) as cnt from tb_member_log where user_id='".$user_id."' and board_id='".$board_id."'";
			$result = $this->db->query($SQL);
			
			$cntLog = $result->row()->cnt;
			//echo $cntLog;
			//exit;
			

			if($user_id && $cntLog == 0)
			{	

				//포인트 증감 .
				$SQL ="update tb_member_master set point=point+10 where user_id='".$user_id."'";
				$this->db->query($SQL);

				$SQL ="insert into tb_member_log (user_id,board_id, read_yn) value('".$user_id."','".$board_id."','Y')";
				$this->db->query($SQL);

				
			}
		}
		public function insert_board()
		{
			
			$this->load->helper('date');

			$data = array (
				'name' => $this->input->post('name'),
				'title' => $this->input->post('title'),
				'contents' => $this->input->post('contents')
			);

			$this->db->set('adddate','now()', FALSE);

			return $this->db->insert('board', $data);

		}
		
		public function select_View()
		{
		$CODE = $this->input->post('CODE');
		$SQL ="SELECT code, title, contents, name, adddate FROM `board` where code='$CODE';";
		$query = $this->db->query($SQL);

		return $query->row();
		}

		public function select_board()
		{
		
		$SQL ="SELECT code, title, contents, name, adddate FROM `board` order by adddate desc;";
		$query = $this->db->query($SQL);
		return $query->result_array();

		}
	}

?>