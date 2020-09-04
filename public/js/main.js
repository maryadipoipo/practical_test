$( document ).ready(function() {
    getAuthenticatedUser();
    $('#logout_btn').on('click', function(event) {
        event.preventDefault();
        $.ajax({
			type: 'POST',
			url: 'api/logout',
			headers: { 'Authorization': 'Bearer '+ localStorage.getItem('atjwt') }
			}).done(function (resp) {
				if (resp.status == 'OK') {
					window.location.href = "/";
				}
			});
    });
});

function getAuthenticatedUser() {
    $.ajax({
        type: 'GET',
        url: 'api/user',
        headers: { 'Authorization': 'Bearer '+ localStorage.getItem('atjwt') }
    }).done(function (resp) {
        $('#unauthorized').css('display', 'none');
        $('#authorized').css('display', 'block');

        if (undefined !== resp.status) {
            $('#unauthorized').css('display', 'block');
            $('#authorized').css('display', 'none');
            $('#unauthorized').html("<b>"+ resp.status + "</b>"+"<br> You will be redirected to Login page in 3 seconds");
            setTimeout(function(){ 
                window.location.href = "/";
            }, 3000);
            
        }			
        $('#userName').html("Welcome <b>"+resp.user.name+"</b>");
    }).fail(function (err) {
        $('#unauthorized').css('display', 'block');
        $('#authorized').css('display', 'none');
        console.log(err);
        $('#unauthorized').html(
            "YOU ARE NOT AUTHORIZED TO VIEW THIS PAGE<br>"+
            "<b>"+ err.responseJSON.message + "</b> <br>"+
            "You will be redirected to Login page in 3 seconds"
        );
        setTimeout(function(){ 
            window.location.href = "/";
        }, 3000);
    });
}