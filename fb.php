<?
include_once "config.php";
$user = null;

try{
	include_once "facebook.php";
}

catch(Exception $o){
	$dialog_url= "https://www.facebook.com/dialog/oauth?"
		."client_id=".$fbconfig['appid' ] 
		."&redirect_uri=".urlencode($fbconfig['baseUrl']);
		header("Location: $dialog_url");
}

$facebook = new Facebook(array(
	'appId'  => $fbconfig['appid'],
	'secret' => $fbconfig['secret'],
	'fileUpload' => true,
	'cookie' => true,
));

$user = $facebook->getUser();

$loginUrl   = $facebook->getLoginUrl(
	array('scope' => 'publish_stream','redirect_uri' => $fbconfig['appBaseUrl'])
);

if($user){
	try{
		$user_profile = $facebook->api('/me');
	}catch(FacebookApiException $e){
		d($e);
		$user = null;
	}
}

if(!$user){
        die("<script type='text/javascript'>top.location.href = '" . $loginUrl. "';</script>");  
}

$userInfo = $facebook->api("/$user");

function d($d){
	$dialog_url= "https://www.facebook.com/dialog/oauth?"
		."client_id=".$fbconfig['appid' ] 
		."&redirect_uri=".urlencode($fbconfig['baseUrl']);
		header("Location: $dialog_url");
}

if(isset($_GET["q1"]) || isset($_GET["q2"]) || isset($_GET["q3"])){
	$q1 = addslashes($_GET["q1"]);
	$q2 = addslashes($_GET["q2"]);
	$q3 = addslashes($_GET["q3"]);
	$token=$cookie['access_token'];

	$facebook->setFileUploadSupport(true);  

	$fileName = uniqid('meme-');

	include_once('easyphpthumbnail.class.php');
	$thumb1 = new easyphpthumbnail;
	$thumb1->Copyrighttext = $q1;
	$thumb1 -> Quality = 100;
	$thumb1->Copyrightposition = $textPosition1;
	$thumb1->Copyrightfonttype = 'font.ttf';
	$thumb1->Copyrightfontsize = $fontSize;
	$thumb1->Copyrighttextcolor = $fontColor;
	$thumb1->Thumbsize = 500; // Image size
	$thumb1->Thumbfilename = $fileName.".jpg";
	$thumb1->Chmodlevel = '0755';
	$thumb1->Thumblocation = 'images/';
	$thumb1->Createthumb('memes/'.$memeImg,'file');

	$thumb2 = new easyphpthumbnail;
	$thumb2->Copyrighttext = $q2;
	$thumb2 -> Quality = 100;
	$thumb2->Copyrightposition = $textPosition2;
	$thumb2->Copyrightfonttype = 'font.ttf';
	$thumb2->Copyrightfontsize = $fontSize;
	$thumb2->Copyrighttextcolor = $fontColor;
	$thumb2->Thumbsize = 500; // Image size
	$thumb2->Thumbfilename = $fileName.".jpg";
	$thumb2->Chmodlevel = '0755';
	$thumb2->Thumblocation = 'images/';
	$thumb2->Createthumb("images/".$fileName.".jpg",'file');

	$thumb3 = new easyphpthumbnail;
	$thumb3->Copyrighttext = $q3;
	$thumb3 -> Quality = 100;
	$thumb3->Copyrightposition = $textPosition3;
	$thumb3->Copyrightfonttype = 'font.ttf';
	$thumb3->Copyrightfontsize = $fontSize;
	$thumb3->Copyrighttextcolor = $fontColor;
	$thumb3->Thumbsize = 500; // Image size
	$thumb3->Thumbfilename = $fileName.".jpg";
	$thumb3->Chmodlevel = '0755';
	$thumb3->Thumblocation = 'images/';
	$thumb3->Createthumb("images/".$fileName.".jpg",'file');

	$file = '@'.realpath('images/'.$fileName.'.jpg');

	$q1 = $q1.' '.$q2.' '.$q3.' - '.$message;

	$args = array(
		'name' => $q1,
		'message' => $message,
		"access_token" => $token,
		"image" => $file
	);
	$data = $facebook->api('/me/photos', 'post', $args);

	$newMeme = 'images/'.$fileName.'.jpg';
} ?>