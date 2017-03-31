<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Simpeg - Login</title>
        <script type="text/javascript">
            var BASE_URL = "";
        </script>

        <!-- CSS -->
        <!-- <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500"> -->
        <link rel="stylesheet" href="Scripts/bootstrap/dist/css/bootstrap.min.css" >
        <link rel="stylesheet" type="text/css" href="include/font-awesome-4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="Scripts/login/css/form-elements.css">
        <link rel="stylesheet" href="Scripts/login/css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="images/Logo_Kab.Pekalongan.png" />
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="Scripts/login/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="Scripts/login/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="Scripts/login/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="Scripts/login/ico/apple-touch-icon-57-precomposed.png">

        <style type="text/css">
            .img-hover img {
                -webkit-filter: grayscale(0) blur(0);
                filter: grayscale(0) blur(0);
                -webkit-transition: .3s ease-in-out;
                transition: .3s ease-in-out;
            }

            .img-hover:hover img {
                -webkit-filter: grayscale(100%);
                filter: grayscale(100%);
            }
        </style>

    </head>

    <body>
        <div class="top-content">
            <div class="container" style="margin-top: 3%;">
                <div class="row">
                    <div class="col-sm-8 col-sm-offset-2 text">
                        <h1 style="font-family: Ruda, sans-serif;">LOGIN - SIMPEG</h1>
                        <div class="description">
                        	<p>
                            	Login sistem dengan memasukkan username dan password Anda. <br/>
                                Jika lupa password Anda, silakan hubungi administrator.
                        	</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3 form-box">
                    	<div class="form-top">
                    		<div class="form-top-left">
                    			<h3 style="font-family: Ruda, sans-serif;">Login</h3>
                        		<p>Masukkan username dan password untuk login :</p>
                    		</div>
                            <div class="form-top-right img-hover">
                                <!-- <i class="fa fa-key"></i> -->
                                <img src="images/lock-icon.png">
                            </div>
                        </div>
                        <div class="form-bottom">
    	                    <form role="form" action="" method="post" class="login-form" id="loginform">
    	                    	<div class="form-group">
    	                    		<label class="sr-only" for="form-username">Username</label>
    	                        	<input type="text" name="username" placeholder="Username..." class="form-username form-control" style="font-family: Ruda, sans-serif;" autofocus>
    	                        </div>
    	                        <div class="form-group">
    	                        	<label class="sr-only" for="form-password">Password</label>
    	                        	<input type="password" name="password" placeholder="Password..." class="form-password form-control" style="font-family: Ruda, sans-serif;">
    	                        </div>
    	                        <button type="button" name="submit" class="btn" style="font-family: Ruda, sans-serif;" onclick="loginForm();">L O G I N</button>
    	                    </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Javascript -->
        <script src="Scripts/login/js/jquery-1.11.1.min.js"></script>
        <script src="Scripts/bootstrap.min.js"></script>
        <script src="Scripts/login/js/jquery.backstretch.min.js"></script>
        <script src="Scripts/login/js/scripts.js"></script>
        
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->
        <script type="text/javascript">
            $(function(){
                $('input').on('keyup', function(e) {
                    if (e.keyCode===13) {
                        loginForm();
                    }
                });
            });
            function loginForm() {
                var Url = 'include/autocomplete.php?search=logmein_fucker';
                var isiData = $('#loginform').serialize();
                //console.log(isiData);
                $.ajax({
                    type : 'POST',
                    url: Url,               
                    data: isiData,
                    dataType: 'json',
                    success: function(data) {
                        if(data.status === true){
                            location.href='index.php?sid='+data.sid;
                        } else {
                            //console.log('Success tapi gagal, username dan password harus diisikan secara benar !');
                            //dinamic_message('Peringatan','Username dan password harus diisikan secara benar !');
                        }            
                    }, error: function() {
                        console.log('Gagal total, username dan password harus diisikan secara benar !');
                        //dinamic_message('Peringatan','Username dan password harus diisikan secara benar !');
                    }
                });
                return false;
            }
        </script>

    </body>

</html>