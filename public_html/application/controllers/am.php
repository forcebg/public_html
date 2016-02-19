<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Am extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */


	 /**
	 * 생성자
	 *사용할 모델을 로드해온다 
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('am_model');
	}

	public function index()
		{
			$this->load->view('am/index');
		}
	public function productAdd()
	{
		$this->load->view('am/product/productAdd');
	}
	public function lists()
	{	
		$session_member_id = $this->session->userdata("session_member_id");
		$session_member_name = $this->session->userdata("session_member_name");
		
		$data['session_member_id'] = $session_member_id;
		$data['session_member_name'] = $session_member_name;
		
		$this->load->view('list', $data);
	}

	public function loginok()
	{
		$user_id = $this->input->post('user_id');
		$passwd = $this->input->post('passwd');

		$result_login = $this->board_model->login_ok($user_id, $passwd);

		if($result_login-> num_rows() == 0)
		{
			echo "<script>alert('로그인정보를 정확히 입력하세요.');location.href='/board/lists';</script>";
		}
		else
		{
			$session_arr = array('session_member_id' => $user_id, 'session_member_name' => $result_login->row()->user_name);

			$this->session->set_userdata($session_arr);
			redirect("/board/lists");
		}
/*		if(!$rs_login)
		{
			$bLoginSuccess = false;
		}
		
		if($rs_login->uid) //login 성공..
		{
			$session_arr = array('session_member_id' => $user_id, 'session_member_name' => $rs_login->user_name);
			$this->session->set_userdata($session_arr);
			redirect("/board/lists");
		}
		else
		{
			redirect("/board/loginFail");
		}
*/
	}



	public function write_ok()
	{
		$return_value = $this->board_model->insert_board();
		echo $return_value;
	}

	public function getView()
	{
		$session_member_id = $this->session->userdata("session_member_id");

		$CODE = $this->input->post('CODE');

		$data = $this->board_model->select_View();

		$this->board_model->pointUp($session_member_id, $CODE);
		
		echo $data->name."^". $data->title."^". $data->contents."^". $data->code;
	}

	public function getList()
	{	
		$header_html="
		<div style='width:100%; border-top:1px solid #333333; height:30px; clear:both;'>
				<span style='width:10%; float:left; text-align:center;'>
					<b>NO.</b>
				</span>
				<span style='width:20%; float:left; text-align:center;'>
					<b>이름</b>
				</span>
				<span style='width:40%; float:left; text-align:center;'>
					<b>제목</b>
				</span>
				<span style='width:30%; float:left; text-align:center;'>
					<b>날짜</b>
				</span>
			</div>
		";
		$footer_html ="	
		</div>
		";

		$return_html = $header_html;

		$return_value = $this->board_model->select_board();
		$data['board'] = $return_value;

		$idx =0;		
		foreach ($data['board'] as $items)
		{	
			$idx++;
			$return_html .= "
			<div style='width:100%; border-top:1px solid #aaaaaa; height:30px; clear:both; color:#999999;'>
				<span style='width:10%; float:left; text-align:center;'>
					$idx
				</span>
				<span style='width:20%; float:left; text-align:center;'>
					$items[name]
				</span>
				<span style='width:40%; float:left; text-align:center;'>
					<a style='text-decoration:underline; cursor:pointer;' onclick=\"javascript:viewBoard('$items[code]');\">$items[title]</a>
				</span>
				<span style='width:30%; float:left; text-align:center;'>
					$items[adddate]
				</span>
			</div>
			";
		}
		$return_html .= $footer_html;

		echo $return_html;
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */