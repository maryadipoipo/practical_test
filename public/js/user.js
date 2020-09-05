$( document ).ready(function() {
    loadUser();
    $('#add_new_skill').on('click', function(event) {
       $('.new-skill').toggleClass("show-skill");
       $('input[name="skilltitle"]').val('');
       $('input[name="skilleid"]').val('');
    });
    $('#cancel_skill').on('click', function(event) {
        $('.new-skill').toggleClass("show-skill");
        $('input[name="skilltitle"]').val('');
        $('input[name="skilleid"]').val('');
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
                    "<td> <i class='fa fa-pencil text-success hover' aria-hidden='true' onclick='editSkill(" + item.id +",`" + item.title +"`);'></i>"+
                    "     <i class='fa fa-trash-o text-danger ml-3 hover' aria-hidden='true' onclick='deleteSkill(" + item.id +",`" + item.title +"`);'></i> </td>"
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