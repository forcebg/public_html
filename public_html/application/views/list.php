<!DOCTYPE html>
<html lang="kr">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
	
	<script src="/js/jquery-1.10.1.min.js" type="text/javascript"></script>
	<script src="/js/jquery.bpopup.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	$(document).ready(function()
		{
			loadingList();
			
		});
	//alert('글쓰기');
/*			$.ajax({
			type: 'POST',
			url: "/indexp.php/board/list",
			data: {},
			cache: false,
			async: false			
			})
			
			.done(function( html ){
			
			});
*/			

		function board_init()
		{
			$("#name").val("");
			$("#title").val("");
			$("#contents").val("");
			
			$('#writeBody').bPopup().close();
		}

		

		function openMessage(IDS)
		{
			$('#'+IDS).bPopup();
//			$('#writeBody').bPopup();
		}
		
		

		function loadingList()
		{
			$.ajax({
				type: "POST",
				url: "/board/getList",
				data: { PAGE: '1' },
				cache: false,
				async: false
			})
			
			.done(function( html ){
				$("#tableBody").html(html);
				
			});
		}
		
		function addBoard()
		{
			openMessage('writeBody');
		}
		
		function openLogin()
		{
			openMessage('loginBody');
		}
		
		function execLogin(e)
		{	

			document.loginForm.submit();
			e.preventDefault();
		}

		function viewBoard(CODE)
		{
			$.ajax({
				type: "POST",
				url: "/board/getView",
				data: { CODE: CODE },
				cache: false,
				async: false
			})
			
			.done(function( html ){
				var html_array = html.split("^");

				if (html_array.length == 4)
				{
					var name = html_array[0];
					var title = html_array[1];
					var contents = html_array[2];
					var code = html_array[3];

					$('#v_name').val(name);
					$('#v_title').val(title);
					$('#v_contents').val(contents);
					$('#v_code').val(code);
				}
				else
				{
				alert("에러 :" + html);
				}
			});
			
			openMessage('viewBody');
		}
		
		function execSave()
		{
			if (!Trim($("#name").val()))
			{
				alert("이름을 입력해주세요");
				$("#name").focus();
				return false;
			}

			if (!Trim($("#title").val()))
			{
				alert("제목을 입력해주세요");
				$("#title").focus();
				return false;
			}
			if (!Trim($("#contents").val()))
			{
				alert("내용을 입력해주세요");
				$("#contents").focus();
				return false;
			}

			$.ajax({
			type: 'POST',
			url: "/index.php/board/write_ok",
			data: {
				name : Trim($("#name").val()),
				title : Trim($("#title").val()),
				contents : Trim($("#contents").val())
			},
			cache: false,
			async: false 
			})
			
			.done(function( html ){
				if(html =="1"){
					alert('저장되었습니다.');
					board_init();
					loadingList();
				}
				else
				{
				alert("에러 : " +html);
				}
			});
		}

		function Trim(str) //Remove Blank Function for javascript
		{
			var index, len, bJudge

			while(true)
			{
				bJudge = true;
				index = str.indexOf(' ');
				if (index == -1) break;
				if (index == 0)
				{
					len = str.length;
					str = str.substring(0, index) + str.substring((index+1),len);
				}
				else
				{
					bJudge = false;
				}

				index = str.lastIndexOf(' ');
				if (index == -1) break;
				if (index == str.length - 1)
				{
					len = str.length;
					str = str.substring(0, index) + str.substring((index+1),len);
				}
				else
				{
					if(bJudge == false)
					{
						break;
					}
				}
			}
			return str;
		}

		function logout()
		{
			location.href="/board/logout";
		}

		

	</script>
</head>
<body>


<div id="container" style="width:800px; margin:0 auto;">
테스트계정 : test/test , test2/test2
	<?
	if(!$session_member_id){
		?>
		<div style="width:800px; height:30px; text-align:right;">
			<button style="background-color:#bbbbbb;" onclick="javascript:openLogin();">로그인</button>
		</div>
		<?
	}
	else
	{
		?>
		<div style="width:800px; height:30px; text-align:right;">
			<?echo $session_member_name;?>님 안녕하세요 
			<a style="color:blue; text-decoration:underline; cursor:pointer;" onclick="javascript:logout();">로그아웃</a>
		</div>
		<?
		
	}
	?>
	<div id="body" style="width:100%;">
		<div id="tableBody" style="width:93%; margin:0 auto;">
		</div>
	</div>

	<div id="bottom" style="float:right; width:50%; text-align:right;">
		<button onclick="javascript:addBoard();">글쓰기</button>
	</div>

<!--글쓰기 영역-->
	<div id="writeBody" style="width:70%; height:500px; border:1px solid #333333; background-color:white; display:none;">
		<div style="width:80%; clear:both; height:30px; margin:0 auto; margin-top:20px;">
			<span style="width:70%; height:100%; line-height:30px;">
				<b>이름</b>
			</span>
			<span style="width:70%; height:100%; line-height:30px;">
				<input type="text" name="name" id="name" value="<?=@$session_member_name;?>">
			</span>
		</div>
		<div style="width:80%; clear:both; height:30px; margin:0 auto;">
			<span style="width:70%; height:100%; line-height:30px;">
				<b>제목</b>
			</span>
			<span style="width:70%; height:100%; line-height:30px;">
				<input type="text" name="title" id="title" style="width:90%;">
			</span>
		</div>
		<div style="width:80%; clear:both; height:270px; margin:0 auto;">
			<span style="width:30%; height:30px; line-height:30px; vertical-align:top;">
				<b>내용</b>
			</span>
			<span style="width:70%; height:100%;">
				<textarea style="width:90%; height:100%;" name="contents" id="contents"> </textarea>
			</span>
		</div>
		<div style=" width:100%; clear:both; height:30px; margine:0 auto; margin-top:30px; text-align:center;">
			<button onclick="javascript:execSave();">저장하기</button>
		</div>
	</div>
<!--글쓰기 영역 끝-->

<!--로그인 영역-->
	<div id="loginBody" style="width:300px; height:150px;  background-color:white; display:none;">
		<form name="loginForm" method=post action="/board/loginok">
		<div style="width:80%; clear:both; height:30px; margin:0 auto; margin-top:20px;">
			<span style="width:100px; height:100%; line-height:30px; text-align:center;">
				<b>아이디&nbsp;&nbsp;&nbsp;</b>
			</span>
			<span style="width:70%; height:100%; line-height:30px;">
				<input type="text" name="user_id" id="user_id" style="width:160px;">
			</span>
		</div>
		<div style="width:80%; clear:both; height:30px; margin:0 auto;">
			<span style="width:100px; height:100%; line-height:30px; text-align:center;">
				<b>패스워드</b>
			</span>
			<span style="width:70%; height:100%; line-height:30px;">
				<input type="password" name="passwd" id="passwd" style="width:160px;">
			</span>
		</div>
		<div style=" width:80%; clear:both; height:30px; margine:0 auto; margin-top:20px; text-align:center;">
			<button onclick="javascript:execLogin(event);">로그인</button>
		</div>
		</form>
	</div>
<!--로그인 영역 끝-->

<!--상세페이지 영역-->
	<div id="viewBody" style="width:70%; height:500px; border:1px solid #333333; background-color:white; display:none;">
		<input type="hidden" name="v_code" id="v_code" value="">
		<div style="width:80%; clear:both; height:30px; margin:0 auto; margin-top:20px;">
			<span style="width:70%; height:100%; line-height:30px;">
				<b>이름</b>
			</span>
			<span style="width:70%; height:100%; line-height:30px; border:1px solid #bbbbbb;">
				<input type="text" name="v_name" id="v_name" value="">
			</span>
		</div>
		<div style="width:80%; clear:both; height:30px; margin:0 auto;">
			<span style="width:70%; height:100%; line-height:30px;">
				<b>제목</b>
			</span>
			<span style="width:70%; height:100%; line-height:30px; border:1px solid #bbbbbb;">
				<input type="text" name="v_title" id="v_title" style="width:90%; border:1px solid #bbbbbb;">
			</span>
		</div>
		<div style="width:80%; clear:both; height:270px; margin:0 auto;">
			<span style="width:30%; height:30px; line-height:30px; vertical-align:top;">
				<b>내용</b>
			</span>
			<span style="width:70%; height:100%;">
				<textarea style="width:90%; height:100%; border:1px solid #bbbbbb;" name="v_contents" id="v_contents"> </textarea>
			</span>
		</div>
	</div>
<!--상세페이지 영역 끝-->
</div>

</body>
</html>