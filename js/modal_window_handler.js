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

$(document).on('click', '#addData', function() 
{
    var user_id = $("#id_student").val();
    var name = $('#name').val();
    var surname = $('#surname').val();
    var dob = $('#dob').val();
    var gender = $('#gender').val();
    var group = $('#group').val();
    var student = {
        "pk": user_id,
        "name": name,
        "surname": surname,
        "dob": dob,
        "gender": gender,
        "group": group,
    };
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