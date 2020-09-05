$( document ).ready(function() {
    loadSkill();
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

function loadSkill() {
    $('input[name="skilltitle"]').val('');
    $('input[name="skilleid"]').val('');
    $("#skill_table > tbody").empty();
    $.ajax({
        type: 'GET',
        url: 'api/skill',
        headers: { 'Authorization': 'Bearer '+ localStorage.getItem('atjwt') }
        }).done(function (resp) {
            $.each(resp, function(i, item) {
                console.log(i);
                console.log(item);
                $('#skill_table > tbody:last-child').append("<tr id=skill_row_"+ item.id + ">" +
                    "<th scope='row'>"+ (i+1) + "</th>" + 
                    "<td>"+ item.title + "</td>" +
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

function submitSkill(event) {
    event.preventDefault();
    skill_id = $('input[name="skillid"]').val();
    url = '';
    if(skill_id) {
        // Edit
        data = {
            id: skill_id,
            title: $('input[name="skilltitle"]').val()
        };
        url = 'api/edit_skill';
    } else {
        // Create
        data = {
            title: $('input[name="skilltitle"]').val()
        };
        url = 'api/create_skill';
    }

    $.ajax({
        type: 'POST',
        headers: { 'Authorization': 'Bearer '+ localStorage.getItem('atjwt') },
        url: url,
        data: data
        }).done(function (resp) {
            if (resp.status == 'OK') {
                loadSkill();
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


function editSkill(id, title) {
    if (!$('.new-skill').hasClass("show-skill")) {
        $('.new-skill').addClass("show-skill");
    }

    $('input[name="skilltitle"]').val(title);
    $('input[name="skillid"]').val(id);
}

function deleteSkill(id) {
    $('input[name="deleteskill"]').val(id);
    $("#delete-modal").modal('show');
}


function cancelDelete(event) {
    $('input[name="deleteskill"]').val('');
    $("#delete-modal").modal('hide');
}

function submitDeleteSkill(event) {
    data = {
        id: $('input[name="deleteskill"]').val()
    };
    $.ajax({
        type: 'POST',
        headers: { 'Authorization': 'Bearer '+ localStorage.getItem('atjwt') },
        url: 'api/delete_skill',
        data: data
        }).done(function (resp) {
            if (resp.status == 'OK') {
                loadSkill();
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