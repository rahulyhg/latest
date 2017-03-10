
    
    var tableName = $('#table_name').attr('value');
    var idName = $('#id_name').attr('value');
   
    $(function() {
    $('#sortable').sortable({
        // axis: 'y',
        // opacity: 0.7,
        // handle: 'span',
        update: function(event, ui) {
            //var list_sortable = $(this).sortable('toArray').toString();
            var list_sortable = $(this).sortable('toArray').toString();
            // change order in the database using Ajax
            $.ajax({
                url: '/admincontrol/'+'country/updateOrder',
                type: 'POST',
                data: {list_order:list_sortable,
                table_name:tableName,
                id_name:idName,
            },
                success: function(data) {
                    //finished
                }
            });
        }
    }); // fin sortable
});

