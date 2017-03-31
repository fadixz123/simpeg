
jQuery(document).ready(function() {
	
    /*
        Fullscreen background
    */
    //$.backstretch("<?= base_url('assets/login/img/backgrounds/1.jpg') ?>");
    //$.backstretch("http://192.168.1.111/hkiosk/assets/login/img/backgrounds/1.jpg");
    $.backstretch("Scripts/login/img/backgrounds/1.jpg");
    
    /*
        Form validation
    */
    $('.login-form input[type="text"], .login-form input[type="password"], .login-form textarea').on('focus', function() {
    	$(this).removeClass('input-error');
    });
    
    $('.login-form').on('submit', function(e) {
    	
    	$(this).find('input[type="text"], input[type="password"], textarea').each(function(){
    		if( $(this).val() == "" ) {
    			e.preventDefault();
    			$(this).addClass('input-error');
    		}
    		else {
    			$(this).removeClass('input-error');
    		}
    	});
    	
    });
    
    
});
