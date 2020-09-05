$( document ).ready(function() {
    loadProfile();
    $('#add_new_profile').on('click', function(event) {
       $('.new-profile').toggleClass("show-profile");
       $('input[name="profiletitle"]').val('');
       $('input[name="profileid"]').val('');
    });
    $('#cancel_profile').on('click', function(event) {
        $('.new-profile').toggleClass("show-profile");
        $('input[name="profiletitle"]').val('');
        $('input[name="profileid"]').val('');
     });
    
    
});

function loadProfile() {
    $("#profile_table > tbody").empty();
    $.ajax({
        type: 'GET',
        url: 'api/profile',
        headers: { 'Authorization': 'Bearer '+ localStorage.getItem('atjwt') }
        }).done(function (resp) {
            $.each(resp, function(i, item) {
                console.log(i);
                console.log(item);
                $('#profile_table > tbody:last-child').append("<tr id=profile_row_"+ item.id + ">" +
                    "<th scope='row'>"+ (i+1) + "</th>" + 
                    "<td>"+ item.title + "</td>" +
                    "<td> <i class='fa fa-pencil text-success hover' aria-hidden='true' onclick='editProfile(" + item.id +",`" + item.title +"`);'></i>"+
                    "     <i class='fa fa-trash-o text-danger ml-3 hover' aria-hidden='true' onclick='deleteProfile(" + item.id +",`" + item.title +"`);'></i> </td>"
                );
            });
        }).fail(function (error) {
            // @todo show error pop here
            console.log(error)
        });
}


function editProfile(id, title) {
    if (!$('.new-profile').hasClass("show-profile")) {
        $('.new-profile').addClass("show-profile");
    }

    $('input[name="profiletitle"]').val(title);
    $('input[name="profileid"]').val(id);
}

function deleteProfile(id) {
    $('input[name="deleteprofile"]').val(id);
    $("#delete-modal").modal('show');
}

function submitProfile(event) {
    event.preventDefault();
    profile_id = $('input[name="profileid"]').val();
    url = '';
    if(profile_id) {
        // Edit
        data = {
            id: profile_id,
            title: $('input[name="profiletitle"]').val()
        };
        url = 'api/edit_profile';
    } else {
        // Create
        data = {
            title: $('input[name="profiletitle"]').val()
        };
        url = 'api/create_profile';
    }

    $.ajax({
        type: 'POST',
        headers: { 'Authorization': 'Bearer '+ localStorage.getItem('atjwt') },
        url: url,
        data: data
        }).done(function (resp) {
            if (resp.status == 'OK') {
                loadProfile();
                $('.modal-text').html(resp.message);
                $("#alert-modal").modal('show');
                setTimeout(function() {
                    $("#alert-modal").modal('hide');
                }, 2000);
            }
        }).fail(function (err) {
            $('.modal-text').html(JSON.parse(err.responseText));
            $("#alert-modal").modal('show');
            setTimeout(function() {
                $("#alert-modal").modal('hide');
            }, 2000);
        });
}


function cancelDelete(event) {
    $('input[name="deleteprofile"]').val('');
    $("#delete-modal").modal('hide');
}

function submitDeleteProfile(event) {
    data = {
        id: $('input[name="deleteprofile"]').val()
    };
    $.ajax({
        type: 'POST',
        headers: { 'Authorization': 'Bearer '+ localStorage.getItem('atjwt') },
        url: 'api/delete_profile',
        data: data
        }).done(function (resp) {
            if (resp.status == 'OK') {
                loadProfile();
                $("#delete-modal").modal('hide');
            }
        }).fail(function (err) {
            console.log('failed');
        });
}