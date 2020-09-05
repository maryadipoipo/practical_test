$( document ).ready(function() {
    loadUser();
    loadProfiles();
    loadSkills();
    $('#add_new_user').on('click', function(event) {
        event.preventDefault();
       $('.new-user').toggleClass("show-user");
       resetUserFields();
       $('input[name="input_password"]').attr('placeholder', 'password');
       loadProfiles();
       loadSkills();
    });
    $('#cancel_user').on('click', function(event) {
        $('.new-user').toggleClass("show-user");
        resetUserFields();
     });
});

function loadUser() {
    // $('input[name="skilltitle"]').val('');
    // $('input[name="skilleid"]').val('');
    $("#user_table > tbody").empty();
    $.ajax({
        type: 'GET',
        url: 'api/users',
        headers: { 'Authorization': 'Bearer '+ localStorage.getItem('atjwt') }
        }).done(function (resp) {
            $.each(resp, function(i, item) {
                skills = JSON.parse(item.skills);
                skill_text = '';
                if (skills) {
                    $.each(skills, function(i, skill) {
                        skill_text += skill.skill_name + " <br> "
                    });
                }
                $('#user_table > tbody:last-child').append("<tr id=skill_row_"+ item.id + ">" +
                    "<th scope='row'>"+ (i+1) + "</th>" + 
                    "<td>"+ item.name + "</td>" +
                    "<td>"+ item.email + "</td>" +
                    "<td>"+ item.profile_name + "</td>" +
                    "<td>"+ skill_text+ "</td>" +
                    "<td>"+
                        "<i class='fa fa-pencil text-success hover' aria-hidden='true' onclick='editUser(" + 
                            item.id+",`"+item.name+"`,`"+item.email+"`,"+item.profile_id+","+ item.skills +");'></i>"+
                    "     <i class='fa fa-trash-o text-danger ml-3 hover' aria-hidden='true' onclick='deleteUser(" + item.id +",`" + item.name +"`);'></i> </td>"
                );
            });
        }).fail(function (err) {
            // @todo show error pop here
            $('.modal-text').html(JSON.parse(err.responseText));
            $("#alert-modal").modal('show');
            setTimeout(function() {
                $("#alert-modal").modal('hide');
            }, 2000);
        });
}

function loadProfiles() {
    $('#input_profile').empty();
    $.ajax({
        type: 'GET',
        url: 'api/profile',
        headers: { 'Authorization': 'Bearer '+ localStorage.getItem('atjwt') }
        }).done(function (resp) {
            localStorage.setItem("local_profiles", JSON.stringify(resp));
            $.each(resp, function(i, item) {
                $('#input_profile').append("<option value="+ item.id  +">" + item.title + "</option>");
            });
        }).fail(function (err) {
            $('.modal-text').html(JSON.parse(err.responseText));
            $("#alert-modal").modal('show');
            setTimeout(function() {
                $("#alert-modal").modal('hide');
            }, 2000);
        });
}

function loadSkills() {
    $('#skill_list').empty();
    $.ajax({
        type: 'GET',
        url: 'api/skill',
        headers: { 'Authorization': 'Bearer '+ localStorage.getItem('atjwt') }
        }).done(function (resp) {
            localStorage.setItem("local_skills", JSON.stringify(resp));
            $.each(resp, function(i, item) {
                $('#skill_list').append(
                    "<div class='form-check form-check-inline'>"+ 
                    "<input class='form-check-input' type='checkbox' id='inlineCheckbox_"+item.id+"' value='"+ item.id + "' data-name='"+ item.title+"'>" +
                    "<label class='form-check-label' for='inlineCheckbox_"+item.id+"'>"+ item.title+"</label>"+
                    "</div>"
                );
            });
        }).fail(function (err) {
            $('.modal-text').html(JSON.parse(err.responseText));
            $("#alert-modal").modal('show');
            setTimeout(function() {
                $("#alert-modal").modal('hide');
            }, 2000);
        });
}

function editUser(id, name, email, profile_id, skills) {
    if (!$('.new-user').hasClass("show-user")) {
        $('.new-user').addClass("show-user");
    }
    $('input[name="userid"]').val(id);
    $('input[name="input_name"]').val(name);
    $('input[name="input_email"]').val(email);
    $('input[name="input_password"]').val('');
    $('input[name="input_password"]').attr('placeholder', "leave this empty if you don't wanna change password");

    // Adjust profiles
    $('#input_profile').empty();
    lprofiles = JSON.parse(localStorage.getItem('local_profiles'));
    console.log(lprofiles);
    $.each(lprofiles, function(i, item) {
        console.log('item_id : '+ item.id);
        console.log('profile_id : '+profile_id);
        if (item.id == profile_id) {
            $('#input_profile').append("<option value="+ item.id  +" selected>" + item.title + "</option>");
        } else {
            $('#input_profile').append("<option value="+ item.id  +">" + item.title + "</option>");
        }
    });

    // Adjust skills
    $('#skill_list').empty();
    lskills = JSON.parse(localStorage.getItem('local_skills'));
    $.each(lskills, function(i, item) {
        status = '';
        $.each(skills, function(i, skl) {
            if (skl.key == item.id) {
                status = true;
            }
        });
        console.log('status : '+ status);
        if(status){
            $('#skill_list').append(
                "<div class='form-check form-check-inline'>"+ 
                "<input class='form-check-input' checked type='checkbox' id='inlineCheckbox_"+item.id+"' value='"+ item.id + "' data-name='"+ item.title+"'>" +
                "<label class='form-check-label' for='inlineCheckbox_"+item.id+"'>"+ item.title+"</label>"+
                "</div>"
            );
        } else {
            $('#skill_list').append(
                "<div class='form-check form-check-inline'>"+ 
                "<input class='form-check-input' type='checkbox' id='inlineCheckbox_"+item.id+"' value='"+ item.id + "' data-name='"+ item.title+"'>" +
                "<label class='form-check-label' for='inlineCheckbox_"+item.id+"'>"+ item.title+"</label>"+
                "</div>"
            );
        }
        
    });
}

function resetUserFields() {
    $('input[name="userid"]').val('');
    $('input[name="input_name"]').val('');
    $('input[name="input_email"]').val('');
    $('input[name="input_password"]').val('');
}

function submitUser(event) {
    event.preventDefault();
    user_id = $('input[name="userid"]').val();
    url = '';
    if(user_id) {
        // Edit
        data = {
            id: user_id,
            name: $('input[name="input_name"]').val(),
            email: $('input[name="input_email"]').val(),
            password: $('input[name="input_password"]').val(),
            username: $('input[name="input_name"]').val()
        };
        url = 'api/edit_user';
    } else {
        // Create
        data = {
            name: $('input[name="input_name"]').val(),
            email: $('input[name="input_email"]').val(),
            password: $('input[name="input_password"]').val(),
            password_confirmation: $('input[name="input_password"]').val(),
            username: $('input[name="input_name"]').val()
        };
        url = 'api/register';
    }

    // process profile_id
    data.profile_id = $('#input_profile').children('option:selected').val();


    // process skills
    skill_data = [];
    $('.form-check-input:checked').each(function(i, item) {
        // console.log(item);
        // console.log(item.value);
        // console.log($(this).attr('data-name'));
        // console.log($(this).val());
        skill_data.push({
            key: $(this).val(),
            skill_name: $(this).attr('data-name')
        });
    });
    //console.log(skill_data);
    data.skills = skill_data;
    console.log(data);

    $.ajax({
        type: 'POST',
        headers: { 'Authorization': 'Bearer '+ localStorage.getItem('atjwt') },
        url: url,
        data: data
        }).done(function (resp) {
            if (resp.status == 'OK') {
                loadUser();
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

function deleteUser(id, name) {
    $('input[name="deleteUser"]').val(id);
    $("#delete-modal").modal('show');
}

function cancelDelete(event) {
    $('input[name="deleteUser"]').val('');
    $("#delete-modal").modal('hide');
}


function submitDelete(event) {
    data = {
        id: $('input[name="deleteUser"]').val()
    };
    $.ajax({
        type: 'POST',
        headers: { 'Authorization': 'Bearer '+ localStorage.getItem('atjwt') },
        url: 'api/delete_user',
        data: data
        }).done(function (resp) {
            if (resp.status == 'OK') {
                loadUser();
                $("#delete-modal").modal('hide');
            }
        }).fail(function (err) {
            $('.modal-text').html(JSON.parse(err.responseText));
            $("#alert-modal").modal('show');
            setTimeout(function() {
                $("#alert-modal").modal('hide');
            }, 2000);
        });
}