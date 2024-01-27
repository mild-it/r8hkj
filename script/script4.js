$(function(){
    var provinceObject = $('#province');
    var hospObject = $('#hosp');

    // on change province
    provinceObject.on('change', function(){
        var province3Id = $(this).val();

        hospObject.html('<option value="">เลือก รพ.</option>');

        $.get('get_hosp.php?provid=' + province3Id, function(data){
            var result1 = JSON.parse(data);
            $.each(result1, function(index, item){
                hospObject.append(
                    $('<option></option>').val(item.off_id).html(item.off_name)
                );
            });
        });
    });

    
});