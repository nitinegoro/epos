    $('.addButton').on('click', function() {
        var index = $(this).data('index');
        if (!index) {
            index = 1;
            $(this).data('index', 1);
        }
        index++;
        $(this).data('index', index);

        var template     = $(this).attr('data-template'),
            $templateEle = $('#' + template + 'Template'),
            $row         = $templateEle.clone().removeAttr('id').insertBefore($templateEle).removeClass('hide'),
            $el          = $row.find('input').eq(0).attr('name', template + '['+index+']');
        $('#form-add-category').formValidation('addField', $el);
        $el.attr('placeholder', 'Kategori #' + index);

        $row.on('click', '.removeButton', function(e) {
            $('#form-add-category').formValidation('removeField', $el);
            $row.remove();
        });
    });
    $('#form-add-category')
        .formValidation({
            message: 'This value is not valid',
            icon: {valid: 'glyphicon glyphicon-ok',invalid: 'glyphicon glyphicon-remove',validating: 'glyphicon glyphicon-refresh'},
            fields: {
                'cat_add[1]': { validators: {  notEmpty: { message: 'Harap diisi!' } } }
            }
    });
$('#table-category').tableCheckbox({
    selectedRowClass: 'danger',
    checkboxSelector: 'td:first-of-type input[type="checkbox"],th:first-of-type input[type="checkbox"]',
    isChecked: function($checkbox) {
        return $checkbox.is(':checked');
    }
});

/* UPDATE CATEGORY */
function update_category(id, name_category) {
    $('#modal-edit-cat').modal('show');
    $('#name_category').val(name_category);
    $('#edit-category').click( function () {
       $('#form-edit-category').attr('action', base_domain + '/category/update_category/' + id);
    });
    return false;
}

function delete_category(id, name_category) {
    $('#modal-del-cat').modal('show');
    $('#category_name').html(name_category);
    $('#hapus-category').click( function () {
        $.ajax({
            url : base_domain + "/category/delete_category/" + id,
            type: "GET",
            dataType:"JSON",
            success: function(data) {
                if (data.status) {
                    $('#category-'+id).remove();
                    $('#modal-del-cat').modal('hide');
                } else {
                    $.notify("Error!", "error");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.notify("Error!", "error");
            }
        });
    });
    return false;
}