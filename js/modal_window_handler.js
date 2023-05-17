var id = 0;
var currentRow;

var gendersReverse = {
    "Male": "1",
    "Female": "2",
};

var groupsReverse = {
    "PZ-21": "1",
    "PZ-22": "2",
    "PZ-23": "3",
    "PZ-24": "4",
    "PZ-25": "5",
    "PZ-26": "6"
};

$(document).ready(function()
{
    var checkAll = document.querySelector('#check-all');
    checkAll.addEventListener('change', () => 
    {
        getRowCheckboxes().forEach(checkbox => checkbox.checked = checkAll.checked);
    });

});

function getRowCheckboxes() 
{
    return document.querySelectorAll('tbody input[type="checkbox"]');
}

$("#add_student").on("click", function() {
    clearModal();

    $('#id_student').val('');
    $("#addModal h5").html("Add student");

    $('#group').val('0');
    $('#gender').val('0');
    $('#name').val('');
    $('#surname').val('');
    $('#dob').val('');

})

$('table').on('click', '.edit-btn', function() {
    clearModal();

    $("#addModal h5").html("Edit student");

    var user_id = $(this).closest("tr").data("id")
	$("#id_student").val(user_id)
    currentRow = $(this).closest('tr');
    var name = currentRow.find('td:nth-child(3)').data('name');
    var surname = currentRow.find('td:nth-child(3)').data('surname'); 
    var gender = currentRow.find('td:nth-child(4)').text();      
    var dob = currentRow.find('td:nth-child(5)').text();
    var group = currentRow.find('td:nth-child(2)').text();
    
    $('#name').val(name);
    $('#surname').val(surname);
    $('#gender').val(gendersReverse[gender]);
    $('#dob').val(dob);
    $('#group').val(groupsReverse[group]);
				
    $('#addModal').modal('show');
});

function clearModal() {
    $("#group").removeClass('is-valid is-invalid');
    $("#name").removeClass('is-valid is-invalid');
    $("#surname").removeClass('is-valid is-invalid');
    $("#gender").removeClass('is-valid is-invalid');
    $("#dob").removeClass('is-valid is-invalid');
    

    $("#group-error").prop('hidden', true);
    $("#first-name-error").prop('hidden', true);
    $("#last-name-error").prop('hidden', true);
    $("#gender-error").prop('hidden', true);
    $("#birthday-error").prop('hidden', true);
    $("#server-error-addModal").prop('hidden', true);
}

$(document).on('click', '#addData', function(event) 
{   
    event.preventDefault();

    const user = {
        id: $("#id_student").val(),
        group_id: $("#group").val(), 
        name: $("#name").val(), 
        surname: $("#surname").val(),
        gender_id: $("#gender").val(), 
        birthday: $("#dob").val(),
        status: 1,
    };
    
    clearModal();

    console.log(user);
    $.ajax({
        url: 'addEditStudent.php',
        method: 'POST',
        data: user,
        dataType: 'json',
        success: function(response) {
            if ($("#id_student").val())
            {  
                currentRow.find('td:nth-child(3)').text(response.user.name + ' ' + response.user.surname);
                currentRow.find('td:nth-child(4)').text(response.user.gender_id);
                currentRow.find('td:nth-child(5)').text(response.user.birthday);
                currentRow.find('td:nth-child(2)').text(response.user.group_id);
                        
                $('#addModal').modal('hide');
            }
            else
            {
                addStudent(response.user);
                $('#addModal').modal('hide');
            }
        }, 
        error: function(xhr, error) {
          if (xhr.status === 400)
          {
            var response = JSON.parse(xhr.responseText);
            console.log(response);
            if (response.errors.uni_group) {
                $("#group").addClass('is-invalid');
                $("#group-error").text(response.errors.uni_group);
                $("#group-error").prop('hidden', false);
            } else {
                $("#group").addClass('is-valid');
            }
            
            if (response.errors.name) {
                $("#name").addClass('is-invalid');
                $("#first-name-error").text(response.errors.name);
                $("#first-name-error").prop('hidden', false);
            } else {
                $("#name").addClass('is-valid');
            }

            if (response.errors.surname) {
                $("#surname").addClass('is-invalid');
                $("#last-name-error").text(response.errors.surname);
                $("#last-name-error").prop('hidden', false);
            } else {
                $("#surname").addClass('is-valid');
            }

            if (response.errors.gender) {
                $("#gender").addClass('is-invalid');
                $("#gender-error").text(response.errors.gender);
                $("#gender-error").prop('hidden', false);
            } else {
                $("#gender").addClass('is-valid');
            }

            if (response.errors.birthday) {
                $("#dob").addClass('is-invalid');
                $("#birthday-error").text(response.errors.birthday);
                $("#birthday-error").prop('hidden', false);
            } else {
                $("#dob").addClass('is-valid');
            }
          }
          else {
            $("#server-error-addModal").text("Error: "+ xhr.statusText);
            $("#server-error-addModal").prop('hidden', false);
          }
        }
    });
});

$('table').on('click', '.delete-btn', function() 
{
    var row = $(this).closest('tr');
    var name = row.find(".user-name").text()
    var data = row.data("id");

    $("#server-error-deleteModal").prop('hidden', true);
    $("#delete-text").html("Are you sure you want to delete " + name + "?");

    $('#confirmModal').modal('show');
            
    $('#confirmDelete').click(function() 
    {
        deleteStudent(data, row)
        
    });
});

if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/serviceWorker.js').then(function(registration) {
            console.log('ServiceWorker registration successful with scope: ', registration.scope);
        }, function(err) {
            console.log('ServiceWorker registration failed: ', err);
        });
    });
}

function deleteStudent(id, row)
{
    $.ajax({
        url: 'deleteStudent.php',
        method: 'POST',
        data: {
            id: id,
        },
        dataType: 'json',
        success: function(response) {
            row.remove();
            $('#confirmModal').modal('hide');
        }, 
        error: function(xhr, error) {
            $("#server-error-deleteModal").text("Error: "+ xhr.statusText);
            $("#server-error-deleteModal").prop('hidden', false);
        }
    });
}

function addStudent(user)
{
    var html =  '<tr class="text-center" data-id="' + user.id + '">' +
    '<td><input type="checkbox" name="select"></td>\
    <td>' + user.group_id + '</td>\
    <td class="user-name" data-name='+ user.name +' data-surname='+ user.surname + '>' + user.name + ' ' + user.surname + '</td>\
    <td>' + user.gender_id + '</td>\
    <td>' + user.birthday + '</td>\
    <td><figure class="circle-green"></figure></td>' 
    + '<td><button class="btn bg-transparent edit-btn icon-holder"><i class=" far fa-edit edit-btn"></i></button>\
    <button class="btn bg-transparent delete-btn icon-holder"><i class="fas fa-trash-alt "></i></button></td></tr>';

    $('table tbody').append(html);
}
