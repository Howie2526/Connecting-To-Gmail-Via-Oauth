<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\OAuth;
use League\OAuth2\Client\Provider\Google;
if((isset($_POST['form-title']))&&(isset($_POST['middle-name']))&&(isset($_POST['first-name']))&&(isset($_POST['last-name']))&&(isset($_POST['email-address']))&&(isset($_POST['message']))){
	$array=array(
		'form-title'=>$_POST['form-title'],
		'middle-name'=>$_POST['middle-name'],
		'first-name'=>$_POST['first-name'],
		'last-name'=>$_POST['last-name'],
		'email-address'=>$_POST['email-address'],
		'message'=>$_POST['message']
	);
	if(($array['form-title']!='Contact Us')||(!empty($array['middle-name']))){
		$body='<p>We have detected some unusual activity, Form Title or Middle Name is not valid.</p>';
	}else{
		$body='';
	}
	$array['first-name']=filter_var($array['first-name'],FILTER_SANITIZE_STRING);
	$array['last-name']=filter_var($array['last-name'],FILTER_SANITIZE_STRING);
	$array['email-address']=filter_var($array['email-address'],FILTER_SANITIZE_EMAIL);
	$array['message']=filter_var($array['message'],FILTER_SANITIZE_STRING);
	if((empty($array['first-name']))||(empty($array['last-name']))||(empty($array['message']))){
		$body=$body.'<p>We have detected some unusual activity, Name or Message is not valid.</p>';
	}
	if(!filter_var($array['email-address'],FILTER_VALIDATE_EMAIL)){
		$body=$body.'<p>We have detected some unusual activity, Email Address is not valid.</p>';
	}
	if(!empty($body)){
		$body=$body.'<p>Please make sure JavaScript is enabled and resubmit <a href="'.$BaseURL.'contact-us/">our contact form</a>.</p>';
	}else{
		if($ReqSer==='localhost'){
			require 'C:\\xampp\composer\vendor\autoload.php';
		}else{
			require '/home2/cdunionc/php/composer/vendor/autoload.php';
		}
		date_default_timezone_set('Etc/UTC');
		$google_email='Censored';
		$oauth2_clientId='Censored';
		$oauth2_clientSecret='Censored';
		$oauth2_refreshToken='Censored';
		$mail=new PHPMailer(TRUE);
		try{
			$mail->setFrom($google_email,'The Canadian Disability Union');
			$mail->addAddress($google_email,'Admin');
			$mail->isHTML(TRUE);
			$mail->Subject='Contact Form';
			$mail->Body=
				'<p>Form Title: '.$array['form-title'].'</p>'.
				'<p>First Name: '.$array['first-name'].'</p>'.
				'<p>Last Name: '.$array['last-name'].'</p>'.
				'<p>Email Address: '.$array['email-address'].'</p>'.
				'<p>Message: '.$array['message'].'</p>';
			$mail->isSMTP();
			$mail->Port=587;
			$mail->SMTPAuth=TRUE;
			$mail->SMTPSecure='tls';
			$mail->Host='smtp.gmail.com';
			$mail->AuthType='XOAUTH2';
			$provider=new Google([
				'clientId'=>$oauth2_clientId,
				'clientSecret'=>$oauth2_clientSecret,
			]);
			$mail->setOAuth(new OAuth([
				'provider'=>$provider,
				'clientId'=>$oauth2_clientId,
				'clientSecret'=>$oauth2_clientSecret,
				'refreshToken'=>$oauth2_refreshToken,
				'userName'=>$google_email,
			]));
			$mail->send();
			$body='<p>Thank you for contacting us, we will be in touch as soon as possible</p>';
		}catch(Exception $e){
			$body='<p>There was an error sending your message.</p>';
		}catch(\Exception $e){
			$body='<p>There was an error sending your message.</p>';
		}
	}
}else{
	ob_start();
	include('main.php');
	$body=ob_get_contents();
	ob_end_clean();
}
?>
<!doctype html>
<html lang="en">
	<head>
		<?php
		if($ReqSer==='cdunion.ca'){
			include($root.'common/google-analytics.php');
		}
		?>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<meta name="robots" content="noindex,nofollow">
		<title>Contact Us - The Canadian Disability Union</title>
		<link rel="canonical" href="<?php echo($BaseURL); ?>contact-us/">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap">
		<link rel="stylesheet" href="<?php echo($BaseURL); ?>common/css.php?v=1.00">
		<link rel="stylesheet" href="<?php echo($BaseURL); ?>common/menu.php?v=1.00">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script async src="https://kit.fontawesome.com/bbe1b77f5f.js" crossorigin="anonymous"></script>
		<script src="https://s3.amazonaws.com/menumaker/menumaker.min.js"></script>
		<script src="https://js.stripe.com/v3/"></script>
	</head>
	<body>
		<div class="page">
			<header>
				<?php
				include($root.'common/header.php');
				?>
			</header>
			<main>
				<h2>Contact Us</h2>
				<?php
				echo($body);
				?>
			</main>
			<footer>
			</footer>
		</div>
		<script>
			$("#cssmenu").menumaker({
				title:"Menu",
				breakpoint:768,
				format:"multitoggle"
			});
		</script>
		<script>
			function validateFirstName(){
				var FirstName=document.getElementById('first-name');
				var FirstNameError=document.getElementById('first-name-error');
				if(FirstName.value!=''){
					FirstNameError.style.display='none';
				}
			}
			function validateLastName(){
				var LastName=document.getElementById('last-name');
				var LastNameError=document.getElementById('last-name-error');
				if(LastName.value!=''){
					LastNameError.style.display='none';
				}
			}
			function validateEmail(){
				var EmailAddress=document.getElementById('email-address');
				var EmailAddressError=document.getElementById('email-address-error');
				var EmailFormat=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
				if(EmailAddress.value.match(EmailFormat)){
					EmailAddressError.style.display='none';
				}
			}
			function validateMessage(){
				var Message=document.getElementById('message');
				var MessageError=document.getElementById('message-error');
				if(Message.value!=''){
					MessageError.style.display='none';
				}
			}
			function validateForm(){
				var FirstName=document.getElementById('first-name');
				var LastName=document.getElementById('last-name');
				var EmailAddress=document.getElementById('email-address');
				var Message=document.getElementById('message');
				var EmailFormat=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
				if(FirstName.value==''){
					var FirstNameError=document.getElementById('first-name-error');
					FirstNameError.innerHTML='First Name is required';
					FirstNameError.style.display='block';
					event.preventDefault();
				}
				if(LastName.value==''){
					var LastNameError=document.getElementById('last-name-error');
					LastNameError.innerHTML='Last Name is required';
					LastNameError.style.display='block';
					event.preventDefault();
				}
				if(!EmailAddress.value.match(EmailFormat)){
					var EmailAddressError=document.getElementById('email-address-error');
					EmailAddressError.innerHTML='Email Address is not valid';
					EmailAddressError.style.display='block';
					event.preventDefault();
				}
				if(Message.value==''){
					var MessageError=document.getElementById('message-error');
					MessageError.innerHTML='Message is required';
					MessageError.style.display='block';
					event.preventDefault();
				}
			}
		</script>
	</body>
</html>
