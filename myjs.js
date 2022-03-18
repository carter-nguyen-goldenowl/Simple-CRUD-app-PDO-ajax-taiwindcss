$(document).ready(function() {

    $('#create').click(function() {

        $('#contact_form')[0].reset();
        $('.modal-title').text("Create Contacts");
        $('#action').val("create");
        $('#operation').val("create");

    });

    $(document).on('submit', '#contact_form', function(event){
        event.preventDefault();
        var name = $('#name').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var title = $('#title').val();
        var created = $('#created').val();
        if(name && email && phone && title && created != '')
        {
            $.ajax({
                url:"create.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data){
                    $('#contact_form')[0].reset();
                    $("#contactModal").modal("hide");
                    $("#contacts_table").load("http://localhost/pdo/crud_action.php #contacts_table")
                    swal("Thank You!", "Successfully!", "success", {
                        button: "Okay!",
                    });
                }
            });
        }
        else{
            alert("Both Fields are Required");
        }

    });

    $(document).on('click', '.edit_data', function(){
        var contacts_id = $(this).attr("id");
        alert(contacts_id);
        $('.modal-title').text("Edit Contacts");
        $('#operation').val("edit");
        $('#action').val("Update");

         $.ajax({
                url:"update.php",
                method:'POST',
                data:{contacts_id:contacts_id},
                dataType:"json",
                success:function(data){
                    $('#name').val(data.name);
                    $("#email").val(data.email);
                    $("#phone").val(data.phone);
                    $("#title").val(data.title);
                    $("#created").val(data.created);
                    $("#contacts_id").val(data.id);
                }
            });
    });

    $(document).on('click', '.delete_data', function(){
        var contacts_id = $(this).attr("id");
        alert("deleted");
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url:"delete.php",
                        method:"POST",
                        data:{contacts_id:contacts_id},
                        success:function(data){
                            $("#contacts_table").load("http://localhost/pdo/crud_action.php #contacts_table")
                        }
                    })
                    swal("Poof! Your imaginary file has been deleted!", {
                    icon: "success",
                });
                } else {
                    return false;
                }
        });
    });
});