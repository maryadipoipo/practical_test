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
        }).fail(function (err) {
            $('.modal-text').html(JSON.parse(err.responseText).error);
            $("#alert-modal").modal('show');
            setTimeout(function() {
                $("#alert-modal").modal('hide');
            }, 2000);
        });
    });
});