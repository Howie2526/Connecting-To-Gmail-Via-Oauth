<p>If you have any general inquiries, please do not hesitate to contact us.</p>
<form action="<?php echo($BaseURL); ?>contact-us/" method="post" name="form" onsubmit="validateForm();" style="max-width:600px;">
	<input class="form-title" name="form-title" value="Contact Us">
	<input class="middle-name" id="middle-name" name="middle-name" placeholder="Middle Name" type="text">
	<div style="display:inline-block;width:100%;">
		<div class="width-50">
			<label for="first-name">First Name &nbsp;<i class="fas fa-asterisk"></i></label><br>
			<input class="input" id="first-name" name="first-name" onkeyup="validateFirstName();" placeholder="First Name" type="text"><br>
			<div class="error" id="first-name-error"></div>
		</div>
		<div class="width-50">
			<label for="last-name">Last Name &nbsp;<i class="fas fa-asterisk"></i></label><br>
			<input class="input" id="last-name" name="last-name" onkeyup="validateLastName();" placeholder="Last Name" type="text"><br>
			<div class="error" id="last-name-error"></div>
		</div>
	</div>
	<div style="display:inline-block;width:100%;">
		<div>
			<label for="email-address">Email Address &nbsp;<i class="fas fa-asterisk"></i></label><br>
			<input class="input" id="email-address" name="email-address" onkeyup="validateEmail();" placeholder="Email Address" type="text"><br>
			<div class="error" id="email-address-error"></div>
			</div>
	</div>
	<div style="width:100%;">
		<div>
			<label for="message">Message &nbsp;<i class="fas fa-asterisk"></i></label><br>
			<textarea id="message" name="message" onkeyup="validateMessage();" placeholder="Message"></textarea><br>
			<div class="error" id="message-error"></div>
		</div>
	</div>
	<div class="center">
		<input class="button" name="submit" type="submit">
		<input class="button" name="reset" type="reset">
	</div>
</form>
