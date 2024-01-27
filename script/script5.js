$(function(){
    var province2Object = $('#province2');
    var opt2Object = $('#opt2');

    // on change province
    province2Object.on('change', function(){
        var province2Id = $(this).val();

        opt2Object.html('<option value="">-เลือก อบต./เทศบาล-</option>');
        
        $.get('get_opt.php?tcode=' + province2Id, function(data){
            var result = JSON.parse(data);
            $.each(result, function(index, item){
                opt2Object.append(
                    $('<option></option>').val(item.tcode).html("[" + item.ampname + "] " + item.hospname)
                );
            });
        });
    });
});