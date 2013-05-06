<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>Meme Generator</title>
<script type="text/javascript">
	<? if(isset($_POST['q'])){ echo "alert('Ready, published in the meme timeline');"; } ?>
	function streamPublish(name, description, hrefTitle, hrefLink, userPrompt){
		FB.ui({
			method: 'stream.publish',
			message: '',
			attachment: {
				name: name,
				caption: '',
				description: (description),
				href: hrefLink
			},
			action_links: [
				{ text: hrefTitle, href: hrefLink }
			],
			user_prompt_message: userPrompt
		},
		function(response){});
	}
	function publish(){
		streamPublish("Meme Generator", '<?=$message ?>', 'by Evoluzando', '<?=$fbconfig['appBaseUrl'] ?>', "Facebook Application");
	}
	function invite(){
		 FB.ui({ method: 'apprequests',
		 message: '<?=$message ?>'});
	}
	function send(){
		q1 = document.getElementById("q1").value;
		q2 = document.getElementById("q2").value;
		q3 = document.getElementById("q3").value;
		if(q1 || q2 || q3){
			document.forms[0].submit();
		}else{
			alert('Enter one phrase.');
			return false;
		}
	}
</script>
<style>
	html, body{margin:0; padding:0; font-family: Arial, Verdana, Tahoma; width: 100%;}
	#container{width: 100%; margin: 0 auto; float: none;}
	form h1{margin: 5px 0; padding:3px 0; width: 100%; float: left; background: #3B5998; color: #fff; text-align: center; font-size: 20px;}
	form p{margin: 0 0 5px 0; padding:3px 0; width: 100%; float: left; background: #f5f5f5; color: #333; text-align: center; font-size: 12px;}
	form div{margin: 0 0 5px 0; padding:0; width: 100%; float: left; color: #333; font-size: 12px; text-align: center;}
	.text{margin: 0 auto; width: 246px; text-align: center; font-size: 12px; padding: 3px 0; border: 1px solid #f3f3f3;}
	#submit{margin: 0 auto; width: 246px; text-align: center; font-size: 12px; padding: 3px 0; border: 1px solid #f3f3f3; background-color:#f3f3f3; cursor: pointer;}
</style>
</head>
<body onLoad="document.send_form.q1.focus();">
<form action="index.php" method="get">
	<h1>
		Meme Generator 
		<fb:like href="<?=$fbconfig['appBaseUrl'] ?>" layout="button_count"></fb:like>
	</h1>
	<p>
		<a href="#" onClick="publish(); return false;">publish this app in my timeline</a> | 
		<a href="#" onClick="invite(); return false;">invite for friends</a>
	</p>
	<? if(isset($_GET['q1']) || isset($_GET['q2']) || isset($_GET['q3'])){ ?>
	<p>Meme published in your timeline:</p>
	<div><img src="<?=$newMeme ?>" style="width: 400px; height: 400px;"/></div>
	<h1>Generate More</h1>
	<? }else{ ?>
		<div><img src="memes/<?=$memeImg ?>"/ style="width: 300px; height: 300px;"></div>
	<? } ?>
	<p>1. Enter a phrase</p>
	<div>
		<input type="text" class="text" maxlength="34" name="q1" id="q1"/><br/>
	</div>
	<p>2. Enter other phrase</p>
	<div>
		<input type="text" class="text" maxlength="34" name="q2" id="q2"/><br/>
	</div>
	<p>3. Enter the last phrase</p>
	<div>
		<input type="text" class="text" maxlength="34" name="q3" id="q3"/><br/>
	</div>
	<p>4. Finished</p>
	<div>
		<input type="submit" id="submit" onClick="send()" value="Click here and publish im your timeline"/>
	</div>
</form>
<script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">
	FB.init({
		appId  : '<?=$fbconfig['appid']?>',
		status : true, // check login status
		cookie : true, // enable cookies to allow the server to access the session
		xfbml  : true  // parse XFBML
	});
</script>
</body>
</html>