$( document ).ready(function() {
    //loadUser();
    //loadProfiles();
    loadSkills();
    $('#add_new_activity').on('click', function(event) {
        event.preventDefault();
       $('.new-activity').toggleClass("show-activity");
       //resetUserFields();
       //$('input[name="input_password"]').attr('placeholder', 'password');
       //loadProfiles();
       loadSkills();
    });
    $('#cancel_activity').on('click', function(event) {
        $('.new-activity').toggleClass("show-activity");
        resetUserFields();
     });
});


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
                    "<input class='form-check-input' type='checkbox' onChange='skillChange("+item.id+")' id='inlineCheckbox_"+item.id+"' value='"+ item.id + "' data-name='"+ item.title+"'>" +
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

function skillChange(skill_id) {
    skill_ids = [];
    $('.form-check-input:checked').each(function(i, item) {
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
                        "<input class='form-check-input' type='checkbox' id='inlineCheckbox_"+item.id+"' value='"+ item.id + "' data-name='"+ item.name+"'>" +
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