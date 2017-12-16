$(document).ready(function(){
	/* 
	 *
	 *
	 */
	(function(){
		function checkdnsrr(domain, html, disable,success){
			var req = new XMLHttpRequest();

			req.open('GET', '/bookstore/sys/email_check.php?dom='+domain
					+'&t='+Math.random()*(new Date()).getTime(), true);
			
			req.onreadystatechange = function(){
				if(this.readyState == 4 && this.status == 200){
					
					if(this.responseText === 'DNS not found!'){
						$(disable).prop('disabled', true);
						$(html).html(this.responseText);
						$(success).html('');	
					}else{
						$(success).html(this.responseText);
						$(html).html('');	
					}
				}
			}
			req.send(null);
		}
	})();
	
	(function(){
		var filter = /[^\w]+/g;
		var age = /[^\d]+/g;
		var pass = /\s+/g;

		function condition(){
			return $('#empsignup [name="firstname"]').val().replace(filter, '') === '' ||
				   $('#empsignup [name="lastname"]').val().replace(filter, '') === '' ||
				   $('#empsignup [name="age"]').val().replace(age, '') === '' ||
				   $('#empsignup [name="age"]').val() < 1 ||
				   $('#empsignup [name="email"]').val().replace(filter, '') === '' ||
				   $('#empsignup [name="username"]').val().replace(filter, '') === '' ||
				   $('#empsignup [name="password"]').val().replace(pass, '') === '' ||
				   $('#empsignup [name="confirmpass"]').val().replace(pass, '') === '';
		}
	
	})();

	(function(){
		$('#in').on('click', function(){
			$('.auth').slideToggle(400);
			$('#empsignup').hide();

		});

	})();

	(function(){
		$('#signup').on('click', function(){
			$('#empsignup').slideToggle(400);
			$('.auth').hide();
		});
	})();

	(function(){
		var mail_pat = /(\w+)\@\w+\.\w{2,}\.?\w*\.?\w*/i;
		$('#uemail').on('keyup change', function(event){
			var err_message;
			$('#email_succ').css({'color':'#009900', 'font-family':'Times New Roman'});
			if(!mail_pat.test($(event.target).val()) && $(event.target).val()!==''){
				err_message = 'Wrong e-mail format...'
				$('#esave').prop('disabled', true);
				$('#email_succ').html('');	
			} else if(mail_pat.test($(event.target).val()) && $(event.target).val()!==''){
				err_message = '';
				$('#esave').prop('disabled', false);
				checkdnsrr(($(event.target).val()).replace(/(\w+)\@/i,''),'#email_err', '#esave', '#email_succ');
			}
			$('#email_err').css({'color':'#990000', 'font-family':'Times New Roman'});
			$('#email_err').html(err_message);
		});
	})();
	
				
	(function(){
		$('#empsignup [type="text"]').each(function(){
			$(this).on('keyup change', function(event){
			
				if(condition()){

					$('#esave').prop('disabled', true);
				}else{
					$('#esave').prop('disabled', false);
				}
			});
		});
	})();

	(function(){
		$('#empsignup [type="password"]').each(function(){ 
			$(this).on('keyup change', function(event){
				if(condition()){
					$('#esave').prop('disabled', true);
				}else{
					$('#esave').prop('disabled', false);
				}
			});
		});
	})();

	(function(){
		$('#empsignup [type="number"]').on('keyup change', function(event){
			$(this).on('keyup change', function(event){
				if(condition()){
					$('#esave').prop('disabled', true);
				}else{
					$('#esave').prop('disabled', false);
				}
			});
		});
	})();


});