<html>
    <head>
        <title>SIMPEG | Login</title>
        <link rel="shortcut icon" href="images/Logo_Kab.Pekalongan.png" />
        <link rel="stylesheet" href="css/login.css" />
        <script type="text/javascript" src="Scripts/jquery.min.js"></script>
        <script type="text/javascript">
        function show_ajax_indicator(){
            $('body').block({ 
                  message: '<span><img src="images/loading-black.gif" /> Loading ...</span>', 
                  css: { 
                      border: '1px solid #000',
                      padding: '5px',
                      backgroundColor: '#f4f4f4', 
                      '-webkit-border-radius': '10px', 
                      '-moz-border-radius': '10px', 
                      opacity: 1, 
                      width: '120px',
                      color: '#000' 
                  } 
            }); 
        }

        function hide_ajax_indicator(){
          $('body').unblock(); 
        }
        $(document).ready(function(){
            //$.cookie('url', null);
            $('#username').focus();
            $('.warning').hide();
            $('input').live('keyup', function(e) {
                if (e.keyCode===13) {
                    loginForm();
                }
            });
        });
        function loginForm() {
            var Url = 'include/autocomplete.php?search=logmein_fucker';
                $.ajax({
                    type : 'POST',
                    url: Url,               
                    data: $('#loginform').serialize(),
                    dataType: 'json',
                    success: function(data) {
                        if(data.status === true){
                            //location.href='index.php?sid='+data.sid;
                        } else {
                            $('#username-label').html('Username :');
                            $('#password-label').html('Password :');
                            $('#username').focus().select();
                            $('#username-check .loadingbar,#password-check .loadingbar').fadeOut();
                            $('.loading').hide();
                            $('.warning').show().html('Username atau password yang Anda masukkan salah !');
                        }            
                    }, error: function() {
                        $('.loading').hide();
                        $('.warning').show().html('Username atau password yang Anda masukkan salah !');
                    }
                });
                return false;
        }
        </script>
    </head>
<body class="body-login">
    <div class="container">
	<section id="content">
            <form id="loginform">
			<h1>Login Form</h1>
			<div>
				<input type="text" name="username" placeholder="Username" required="" id="username" />
			</div>
			<div>
				<input type="password" name="password" placeholder="Password" required="" id="password" />
			</div>
			<div>
                            <input type="button" onclick="loginForm();" value="Log in" />
			</div>
            </form><!-- form -->
		<div class="button">
                    <a href="#">&COPY; 2014 SIMPEG Kab. Pekalongan</a>
		</div><!-- button -->
	</section><!-- content -->
    </div><!-- container -->
</body>
</html>
