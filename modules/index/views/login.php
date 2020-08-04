<!DOCTYPE html>
<html>
<head>
	<title></title>

</head>
<body>
	
	<div class="container">
	
	<div class="container_form">

		<form method="post">
			 
			<div class="input">
				
				<label>Login</label>
				
				<input type="text" name="email">

				<label>Senha</label>
				
				<input type="password" name="password" />

                <input type="hidden" name="token">

                 <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
				
				<input type="submit" value="Acessar" class="btn-submit" />
				
				<?php if(isset($error)):?>

					<?php echo $error; ?>

				<?php endif;?>	
			</div>
		</form>

	</div>
	
	<script src="https://www.google.com/recaptcha/api.js?render=6LfzEboZAAAAAFAncoyXd6JIkQB9lc2On-FNPLs9"></script>

     <script>
        grecaptcha.ready(function () {

            grecaptcha.execute('6LfzEboZAAAAAFAncoyXd6JIkQB9lc2On-FNPLs9', { action: 'submit' }).then(function (token) {
                
                var recaptchaResponse = document.getElementById('recaptchaResponse');
                
                recaptchaResponse.value = token;
            });
        });
    </script>
</body>
</html>