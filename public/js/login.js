$( document ).ready(function() {
    $('#login_btn').on('click', function(event) {
        event.preventDefault();
        data = {
            email: $('input[name="email"]').val(),
            password: $('input[name="password"]').val()
        };
        $.ajax({
            type:'POST',
            url:'api/login',
            data: data
        }).done(function (response) {
            localStorage.setItem("atjwt", response.token);
            window.location.href = "/home";
        }).fail(function (error) {
            // @todo show error pop here
            console.log(error)
        });
    });
});