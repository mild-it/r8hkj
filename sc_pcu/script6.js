$(function(){
    var province_pcu1Object = $('#province_pcu1');
    var pcu1Object = $('#hosp_pcu1');

    // on change province
    province_pcu1Object.on('change', function(){
        var province6Id = $(this).val();

        pcu1Object.html('<option value="">เลือกหน่วยงาน</option>');

        $.get('get_pcu1.php?provid=' + province6Id, function(data){
            var result6 = JSON.parse(data);
            $.each(result6, function(index, item){
                pcu1Object.append(
                    $('<option></option>').val(item.off_id).html((item.off_id)+":"+(item.off_name))
                );
            });
        });
    });
});
