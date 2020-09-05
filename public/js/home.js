$( document ).ready(function() {
    loadActivity();
    //loadProfiles();
    loadSkills();
    $('#add_new_activity').on('click', function(event) {
        event.preventDefault();
       $('.new-activity').toggleClass("show-activity");
       resetActivityFields();
       //$('input[name="input_password"]').attr('placeholder', 'password');
       //loadProfiles();
       loadSkills();
    });
    $('#cancel_activity').on('click', function(event) {
        $('.new-activity').toggleClass("show-activity");
        resetActivityFields();
     });
});

function resetActivityFields() {
    $('input[name="input_title"]').val(''),
    $('input[name="input_start_date"]').val(''),
    $('input[name="input_end_date"]').val(''),
    $('textarea[name="input_description"]').val('')
}

function loadActivity() {
    $("#activity_table > tbody").empty();
    $.ajax({
        type: 'GET',
        url: 'api/activity',
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

                participants = JSON.parse(item.participants);
                participants_text = '';
                if (participants) {
                    $.each(participants, function(i, participant) {
                        participants_text += participant.name + " <br> "
                    });
                }

                inputData = {
                    id: item.id,
                    title: item.title,
                    desc: item.description,
                    start: item.start_date,
                    end: item.end_date,
                    skills: item.skills,
                    participants: item.participants
                };

                $('#activity_table > tbody:last-child').append("<tr id=activity_row_"+ item.id + ">" +
                    "<th scope='row'>"+ (i+1) + "</th>" + 
                    "<td>"+ item.title + "</td>" +
                    "<td>"+ item.description + "</td>" +
                    "<td> Start Date: <br> "+ item.start_date + "<br>End Date: <br> "+ item.end_date +"</td>" +
                    "<td>"+ skill_text + "</td>" +
                    "<td>"+ participants_text + "</td>" +
                    "<td>"+
                        "<i class='fa fa-pencil text-success hover' aria-hidden='true' onclick='editActivity(" + JSON.stringify(inputData) +");'></i>"+
                        "<i class='fa fa-trash-o text-danger ml-3 hover' aria-hidden='true' onclick='deleteActivity(" + item.id +");'></i>"+
                    "</td>"
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

function editActivity(item) {
    console.log(item);
    skills = JSON.parse(item.skills);
    participants = JSON.parse(item.participants);
    if (!$('.new-activity').hasClass("show-activity")) {
        $('.new-activity').addClass("show-activity");
    }
    $('input[name="activityid"]').val(item.id);
    $('input[name="input_title"]').val(item.title);
    $('input[name="input_start_date"]').val(item.start);
    $('input[name="input_end_date"]').val(item.end);
    $('textarea[name="input_description"]').val(item.desc)

    // Adjust skills
    $('#activity_skills').empty();
    lskills = JSON.parse(localStorage.getItem('local_skills'));
    skill_ids = [];
    $.each(lskills, function(i, item) {
        status = '';
        $.each(skills, function(i, skl) {
            if (skl.key == item.id) {
                status = true;
                skill_ids.push(item.id);
            }
        });
        if(status){
            $('#activity_skills').append(
                "<div class='form-check form-check-inline'>"+ 
                "<input class='form-check-input skills' onChange='skillChange()' checked type='checkbox' id='inlineCheckbox_"+item.id+"' value='"+ item.id + "' data-name='"+ item.title+"'>" +
                "<label class='form-check-label' for='inlineCheckbox_"+item.id+"'>"+ item.title+"</label>"+
                "</div>"
            );
        } else {
            $('#activity_skills').append(
                "<div class='form-check form-check-inline'>"+ 
                "<input class='form-check-input skills' onChange='skillChange()' type='checkbox' id='inlineCheckbox_"+item.id+"' value='"+ item.id + "' data-name='"+ item.title+"'>" +
                "<label class='form-check-label' for='inlineCheckbox_"+item.id+"'>"+ item.title+"</label>"+
                "</div>"
            );
        }
        
    });

    // Adjust participants
    if (skill_ids.length > 0) {
        $('#input_participants').empty();
        $.ajax({
            type: 'GET',
            url: 'api/user_by_skill_id',
            data: {id: skill_ids},
            headers: { 'Authorization': 'Bearer '+ localStorage.getItem('atjwt') }
            }).done(function (resp) {
                $.each(resp.data, function(i, item) {
                    status = '';
                    $.each(participants, function(k, participant) {
                        if (participant.key == item.id) {
                            status = true;
                        }
                    });
                    if (status) {
                        $('#input_participants').append(
                            "<div class='form-check form-check-inline'>"+ 
                            "<input class='form-check-input participants' type='checkbox' checked id='inlineCheckbox_"+item.id+"' value='"+ item.id + "' data-name='"+ item.name+"'>" +
                            "<label class='form-check-label' for='inlineCheckbox_"+item.id+"'>"+ item.name+"</label>"+
                            "</div>"
                        );
                    } else {
                        $('#input_participants').append(
                            "<div class='form-check form-check-inline'>"+ 
                            "<input class='form-check-input participants' type='checkbox' id='inlineCheckbox_"+item.id+"' value='"+ item.id + "' data-name='"+ item.name+"'>" +
                            "<label class='form-check-label' for='inlineCheckbox_"+item.id+"'>"+ item.name+"</label>"+
                            "</div>"
                        );
                    }
                });
            }).fail(function (err) {
                $('.modal-text').html(JSON.parse(err.responseText));
                $("#alert-modal").modal('show');
                setTimeout(function() {
                    $("#alert-modal").modal('hide');
                }, 2000);
            });
    }

}

function deleteActivity(id) {
    $('input[name="deleteActivity"]').val(id);
    $("#delete-modal").modal('show');
}

function loadSkills() {
    $('#activity_skills').empty();
    $.ajax({
        type: 'GET',
        url: 'api/skill',
        headers: { 'Authorization': 'Bearer '+ localStorage.getItem('atjwt') }
        }).done(function (resp) {
            localStorage.setItem("local_skills", JSON.stringify(resp));
            $.each(resp, function(i, item) {
                $('#activity_skills').append(
                    "<div class='form-check form-check-inline'>"+ 
                    "<input class='form-check-input skills' type='checkbox' onChange='skillChange()' id='inlineCheckbox_"+item.id+"' value='"+ item.id + "' data-name='"+ item.title+"'>" +
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

function skillChange() {
    skill_ids = [];
    $('.skills:checked').each(function(i, item) {
        skill_ids.push($(this).val());
    });

    $('#input_participants').empty();
    if (skill_ids.length > 0){
        $.ajax({
            type: 'GET',
            url: 'api/user_by_skill_id',
            data: {id: skill_ids},
            headers: { 'Authorization': 'Bearer '+ localStorage.getItem('atjwt') }
            }).done(function (resp) {
                $.each(resp.data, function(i, item) {
                    $('#input_participants').append(
                        "<div class='form-check form-check-inline'>"+ 
                        "<input class='form-check-input participants' type='checkbox' id='inlineCheckbox_"+item.id+"' value='"+ item.id + "' data-name='"+ item.name+"'>" +
                        "<label class='form-check-label' for='inlineCheckbox_"+item.id+"'>"+ item.name+"</label>"+
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
}

function submitActivity(event) {
    event.preventDefault();
    activity_id = $('input[name="activityid"]').val();
    url = '';
    if(activity_id) {
        // Edit
        data = {
            id: activity_id,
            title: $('input[name="input_title"]').val(),
            start_date: $('input[name="input_start_date"]').val(),
            end_date: $('input[name="input_end_date"]').val(),
            description: $('textarea[name="input_description"]').val()
        };
        url = 'api/edit_activity';
    } else {
        // Create
        data = {
            title: $('input[name="input_title"]').val(),
            start_date: $('input[name="input_start_date"]').val(),
            end_date: $('input[name="input_end_date"]').val(),
            description: $('textarea[name="input_description"]').val()
        };
        url = 'api/create_activity';
    }

    //SKILLS
    skill_data = [];
    $('.skills:checked').each(function(i, item) {
        skill_data.push({
            key: $(this).val(),
            skill_name: $(this).attr('data-name')
        });
    });
    data.skills = skill_data;

    // PARTICIPANTS
    participant_data = [];
    $('.participants:checked').each(function(i, item) {
        participant_data.push({
            key: $(this).val(),
            name: $(this).attr('data-name')
        });
    });
    data.participants = participant_data;

    $.ajax({
        type: 'POST',
        headers: { 'Authorization': 'Bearer '+ localStorage.getItem('atjwt') },
        url: url,
        data: data
        }).done(function (resp) {
            if (resp.status == 'OK') {
                loadActivity();
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
    $('input[name="deleteActivity"]').val('');
    $("#delete-modal").modal('hide');
}


function submitDelete(event) {
    data = {
        id: $('input[name="deleteActivity"]').val()
    };
    $.ajax({
        type: 'POST',
        headers: { 'Authorization': 'Bearer '+ localStorage.getItem('atjwt') },
        url: 'api/delete_activity',
        data: data
        }).done(function (resp) {
            if (resp.status == 'OK') {
                loadActivity();
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