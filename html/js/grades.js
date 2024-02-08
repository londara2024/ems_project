
$(document).ready(function(){
    $('#add_grade').click(function (){
        $('#modalCenterTitle').text("Save Subject");
        $('#updateId').css('display', 'none');

        $('#nameWithTitle').val('');
        $('#emailWithTitle').val('');
        $('#IDWithTitle').val('');
    });
});


function fn_update(ele){
    console.log(ele);

    let className = $(ele).data('name');
    let status = $(ele).data('status');
    let id = $(ele).data('id');

    console.log(className + " || " + status + " || " + id);

    $('#updateId').css('display', 'block');

    $('#nameWithTitle').val(className);
    $('#emailWithTitle').val(status);
    $('#IDWithTitle').val(id);

    $('#modalCenterTitle').text("Update Subject");
}
