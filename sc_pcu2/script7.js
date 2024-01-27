$(function(){
    var province_pcu2Object = $('#province_pcu2');
    var pcu2Object = $('#hosp_pcu2');

    // on change province
    province_pcu2Object.on('change', function(){
        var provincepcu2Id = $(this).val();

        pcu2Object.html('<option value="">เลือกหน่วยงาน</option>');

        $.get('get_pcu2.php?provid=' + provincepcu2Id, function(data){
            var result2 = JSON.parse(data);
            $.each(result2, function(index, item){
                pcu2Object.append(
                    $('<option></option>').val(item.off_id).html((item.off_id)+":"+(item.off_name))
                );
            });
        });
    });
});
