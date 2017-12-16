$(document).ready(function(){


	(function(){
		function checkAll(checkbox){
			
			return !checkbox.checked;
		}
	})();

	(function(){
		function checkdnsrr(domain, html, disable, success){
			var req = new XMLHttpRequest();

			req.open('GET', '/bookstore/sys/email_check.php?dom='+domain+'&t='+
					Math.random()*(new Date()).getTime(), true);
			
			req.onreadystatechange = function(){
				if(this.readyState == 4 && this.status == 200){
					if(this.responseText === 'DNS not found!'){
						$(disable).prop('disabled', true);
						$(disable).prop('checked', false);
						$('#submit').prop('disabled', true);
						$(disable).parent().next().children('input').prop('disabled', true);
						$(disable).parent().next().children('input').val(null);
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
		$('#num_succ').css({'color':'#009900', 'font-family':'Times New Roman'});
		$('#num_err').css({'color':'#990000', 'font-family':'Times New Roman'});
		$('#mail_err').css({'color':'#990000', 'font-family':'Times New Roman'});
		$('#mail_succ').css({'color':'#009900', 'font-family':'Times New Roman'});

	})();

	(function(){
		$(':checkbox.books').each(function(){

			$(this).on('change',function(event){
				var disabled;
				var val;
				var check = Object.values($(':checkbox.books')).every(checkAll);
				var buttondisable = check === true ? true : false;
				if($(event.target).prop('checked') === true){
					disabled = false;
					val = 1;
				} else{
					disabled = true;
					val = null;
				}
				
				$(this).parent().next().children('input').prop('disabled', disabled);
				$(this).parent().next().children('input').val(val);
				$('#submit').prop('disabled', buttondisable);
			});
			
		});
	})();
	
	(function(){	
		$(':checkbox.rent').each(function(){
			$(this).on('change',function(event){
				var check = Object.values($(':checkbox.rent')).every(checkAll);
				var disabled = check === true ? true : false;
				
				$('#save').prop('disabled', disabled);
			});
				
		});
	})();

	(function(){
		var num_pat = /^(\d{4})-(\d{3})-(\d{4})$/;
		var mail_pat = /(\w+)\@\w+\.\w{2,}\.?\w*\.?\w*/i;
		$('#cemail').on('keyup', function(event){
			var err_message;
			
			if(!mail_pat.test($(event.target).val()) && $(event.target).val()!==''){
				err_message = 'Wrong e-mail format...'
				$('#mail_succ').html('');	
			} else{
				err_message = '';
				$('.books').prop('disabled', false);
				checkdnsrr(($('#addcustomer [name="email"]').val()).replace(/(\w+)\@/i,''),
								'#mail_err','.books', '#mail_succ');
				
			}
			
			$('#mail_err').html(err_message);
		});
	})();

	(function(){
		$('#cnum').on('keyup', function(event){
			var err_num;
			var succ_num;
			
			if(!num_pat.test($(event.target).val()) && $(event.target).val()!==''){
			   err_num = 'Wrong phone number format...' 
			   succ_num = '';
			} else if(num_pat.test($(event.target).val()) && $(event.target).val()!==''){
				err_num = '';
				succ_num = 'Correct format!';
			} else {
				err_num = '';
				succ_num = '';
			}
			
			$('#num_err').html(err_num);
			
			$('#num_succ').html(succ_num);
		});
	})();

	(function(){
		var quantity = /^\d+$/;
		$('#addcustomer [name="quantity[]"]').each(function(){
			$(this).on('keyup change', function(event){
				if(!($(this).val() > 0 && quantity.test($(this).val()))){
					$('#submit').prop('disabled', true);
				}else{
					$('#submit').prop('disabled', false);
				}
			});
		});
	})();

	(function(){
		var filter = /[^\w]+/g;
		var disabled;
		$('#addcustomer [type="text"]').each(function(){
			$(this).on('keyup change', function(event){
				if($('#addcustomer [name="firstname"]').val().replace(filter, '') === '' ||
				   $('#addcustomer [name="lastname"]').val().replace(filter, '') === '' ||
				   $('#addcustomer [name="phone"]').val().replace(filter, '') === '' ||
				   $('#addcustomer [name="email"]').val().replace(filter, '') === '' ||
				   (!mail_pat.test($('#addcustomer [name="email"]').val()) &&
				    $('#addcustomer [name="email"]').val()!=='') ||
				   (!num_pat.test($('#cnum').val()) && $('#cnum').val()!=='')){

					disabled = true;
					$('#submit').prop('disabled', disabled);
					
					$('.books').prop('checked', !disabled);
					$('.books').parent().next().children('input').prop('disabled', disabled);
					$('.books').parent().next().children('input').val(null);
				}else{
					disabled = false;

				}
					$('.books').prop('disabled', disabled);
					
						
			});
		});
	})();


});
