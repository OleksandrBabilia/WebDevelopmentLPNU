var id = 0;

var genders = {
    "1": "Male",
    "2": "Female",
};

var groups = {
    "1": "PZ-21",
    "2": "PZ-22",
    "3": "PZ-23",
    "4": "PZ-24",
    "5": "PZ-25",
    "6": "PZ-26"
};

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

var checkAll = document.querySelector('#check-all');

function getRowCheckboxes() 
{
    return document.querySelectorAll('tbody input[type="checkbox"]');
}

checkAll.addEventListener('change', () => 
{
    getRowCheckboxes().forEach(checkbox => checkbox.checked = checkAll.checked);
});

$("#add_student").on("click", function() {
    clearModal();

    $('#id_student').val('');
    $("#addModal h5").html("Add student");

    $('#name').val('');
    $('#surname').val('');
    $('#dob').val('');

})

var currentRow;

$('table').on('click', '.edit-btn', function() {
    clearModal();

    $("#addModal h5").html("Edit student");

    var user_id = $(this).closest("tr").data("id")
	$("#id_student").val(user_id)
    currentRow = $(this).closest('tr');
    var name = currentRow.find('td:nth-child(3)').text().split(' ')[0];
    var surname = currentRow.find('td:nth-child(3)').text().split(' ')[1]; 
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
}

$(document).on('click', '#addData', function(event) 
{   
    event.preventDefault();

    const user = {
        id: $("#id_student").val() === "" ? String(id + 1) : $("#id_student").val(),
        group: $("#group").val(), 
        firstName: $("#name").val(), 
        lastName: $("#surname").val(),
        gender: $("#gender").val(), 
        birthday: $("#dob").val()
    };

    clearModal();
    
    $.ajax({
        url: 'server.php',
        method: 'POST',
        data: user,
        dataType: 'json',
        success: function(response) {
            if ($("#id_student").val())
            {  
                currentRow.find('td:nth-child(3)').text(response.user.firstName + ' ' + response.user.lastName);
                currentRow.find('td:nth-child(4)').text(genders[response.user.gender]);
                currentRow.find('td:nth-child(5)').text(response.user.birthday);
                currentRow.find('td:nth-child(2)').text(groups[response.user.group]);
                        
                $('#addModal').modal('hide');
            }
            else
            {
                id++;
                var html =  '<tr class="text-center" data-id="' + response.user.id + '">' +
                    '<td><input type="checkbox" name="select"></td>\
                    <td>' + groups[response.user.group] + '</td>\
                    <td>' + response.user.firstName + ' ' + user.lastName + '</td>\
                    <td>' + genders[response.user.gender] + '</td>\
                    <td>' + response.user.birthday + '</td>\
                    <td><figure class="circle-green"></figure></td>' 
                    + '<td><button class="btn bg-transparent edit-btn icon-holder"><i class=" far fa-edit edit-btn"></i></button>\
                    <button class="btn bg-transparent delete-btn icon-holder"><i class="fas fa-trash-alt "></i></button></td></tr>';

                $('table tbody').append(html);
                $('#addModal').modal('hide');
            }
        }, 
        error: function(xhr, error) {
          if (xhr.status === 400)
          {
            var response = JSON.parse(xhr.responseText);
            if (response.errors.group) {
                $("#group").addClass('is-invalid');
                $("#group-error").text(response.errors.group);
                $("#group-error").prop('hidden', false);
            } else {
                $("#group").addClass('is-valid');
            }
            
            if (response.errors.firstName) {
                $("#name").addClass('is-invalid');
                $("#first-name-error").text(response.errors.firstName);
                $("#first-name-error").prop('hidden', false);
            } else {
                $("#name").addClass('is-valid');
            }

            if (response.errors.lastName) {
                $("#surname").addClass('is-invalid');
                $("#last-name-error").text(response.errors.lastName);
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
            alert("Error: " + error);
          }
        }
    });
});


$('table').on('click', '.delete-btn', function() 
{
    var row = $(this).closest('tr');
    $('#confirmModal').modal('show');
            
    $('#confirmDelete').click(function() 
    {
        row.remove();
        $('#confirmModal').modal('hide');
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