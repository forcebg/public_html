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


<div id="container">
	게시판만들기 
	<div id="body">
		<p>샵만들기</p>
	</div>
</div>

</body>
</html>