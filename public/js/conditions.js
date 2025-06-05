
//----------- ADD COMPLEMENTS ---------------------------------------------------------------
function addComplement(id, internalName) {
    //complement = '<div id="complement' + id + '"><button type="button" name="close" class="btn btn-icon" onclick="deleteComplement(' + id + ')"><i class="fa fa-times btn-outline-hover-danger"></i></button><b>CODE: </b>' + id + ' <b>INTERNAL NAME:</b> ' + internalName + '</div>';
    var condition = $('#modal-add-complement #conditionInfo').val();
    var complement = '<tr>' +
        '<td>' + id + '<input name=\"conditions['+condition+'][complementList][]\" value='+id+' class=\"d-none\"></td>' +
        '<td>' + internalName + '</td>' +
        '<td><button type="button" name="close" class="btn btn-icon borrar" ><i class="fa fa-times btn-outline-hover-danger"></i></button></td>' +
        '</tr>';

    $("#condition_"+condition+" #complementList_"+condition+" tbody").append(complement);

}
