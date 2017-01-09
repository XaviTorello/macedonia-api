$(document).ready(function(){
	$("#login").click(function(){
		login();
	});


	$(document).keypress(function(e) {
	    if(e.which == 13) {
	       login();
	    }
	});

	login = function(){
		var email = $("#email").val();
		var password = $("#password").val();

		var datos = {
			'email':email,
			'password':password
		}

		$.ajax({
			url: "/es/auth/login",
			type: "post",
			data:datos,
			dataType: "json",
			success: function(data) {
				if(data.response==true){
					var d = new Date();
    				d.setTime(d.getTime() + (2*24*60*60*1000));
    				var expires = "expires="+ d.toUTCString();
					document.cookie = "token="+data.result+";" + expires + ";path=/";;
					new PNotify({
						title: 'Login',
						text: data.message,
						type: 'success',
						styling: 'bootstrap3'
					});
					window.location = "/dashboard";

				}else{
					new PNotify({
						title: 'Login',
						text: data.message,
						styling: 'bootstrap3'
					});
				}
			},
			error: function(xhr, status, error) {
				new PNotify({
					title: 'Oh No!',
					text: xhr.responseText,
					type: 'error',
					styling: 'bootstrap3'
				});
				var err = eval("(" + xhr.responseText + ")");
				console.log(err);
			}
		});


	}
});