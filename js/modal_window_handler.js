var id = 1;

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
    $('#id_student').val('');
    $("#addModal h5").html("Add student");

    $('#name').val('');
    $('#surname').val('');
    $('#dob').val('');
    $('#gender').val('M');
    $('#group').val('PZ-21');
})

var currentRow;

$('table').on('click', '.edit-btn', function() {
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
    $('#gender').val(gender);
    $('#dob').val(dob);
    $('#group').val(group);
				
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

    const json = {
        id: $("#id_student").val(),
        group: $("#group").val(), 
        firstName: $("#name").val(), 
        lastName: $("#surname").val(),
        gender: $("#gender").val(), 
        birthday: $("#dob").val()
    };

    var user_id = $("#id_student").val();
    var name = $('#name').val();
    var surname = $('#surname').val();
    var dob = $('#dob').val();
    var gender = $('#gender').val();
    var group = $('#group').val();


    clearModal();

    fetch('server.php', {
        method: 'POST',
        body: JSON.stringify(json)
    }).then(responce => responce.text())
    .then(data => {
        const responceObject = JSON.parse(data);
        console.log(responceObject);

        if (responceObject.success === false) {
            if (responceObject.errors.group) {
                $("#group").addClass('is-invalid');
                $("#group-error").text(responceObject.errors.group);
                $("#group-error").prop('hidden', false);
            } else {
                $("#group").addClass('is-valid');
            }
            
            if (responceObject.errors.firstName) {
                $("#name").addClass('is-invalid');
                $("#first-name-error").text(responceObject.errors.firstName);
                $("#first-name-error").prop('hidden', false);
            } else {
                $("#name").addClass('is-valid');
            }

            if (responceObject.errors.lastName) {
                $("#surname").addClass('is-invalid');
                $("#last-name-error").text(responceObject.errors.lastName);
                $("#last-name-error").prop('hidden', false);
            } else {
                $("#surname").addClass('is-valid');
            }

            if (responceObject.errors.gender) {
                $("#gender").addClass('is-invalid');
                $("#gender-error").text(responceObject.errors.gender);
                $("#gender-error").prop('hidden', false);
            } else {
                $("#gender").addClass('is-valid');
            }

            if (responceObject.errors.birthday) {
                $("#dob").addClass('is-invalid');
                $("#birthday-error").text(responceObject.errors.birthday);
                $("#birthday-error").prop('hidden', false);
            } else {
                $("#dob").addClass('is-valid');
            }
        }
        
        if (responceObject.success === true) {
            if (user_id)
            {  
                currentRow.find('td:nth-child(3)').text(name + ' ' + surname);
                currentRow.find('td:nth-child(4)').text(gender);
                currentRow.find('td:nth-child(5)').text(dob);
                currentRow.find('td:nth-child(2)').text(group);
                        
                $('#addModal').modal('hide');
            }
            else
            {
                id++;
                new_user_id = id;
                var html =  '<tr class="text-center" data-id="' + new_user_id + '">' +
                    '<td><input type="checkbox" name="select"></td>\
                    <td>' + group + '</td>\
                    <td>' + name + " " + surname + '</td>\
                    <td>' + gender + '</td>\
                    <td>' + dob + '</td>\
                    <td><figure class="circle-green"></figure></td>' 
                    + '<td><button class="btn bg-transparent edit-btn"><i class=" far fa-edit edit-btn"></i></button>\
                    <button class="btn bg-transparent delete-btn"><i class="fas fa-trash-alt "></i></button></td></tr>';

                $('table tbody').append(html);
                $('#addModal').modal('hide');
            }
        }  
    }).catch(error => {
        console.error(error);
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