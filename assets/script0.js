$(function(){
    var province0Object = $('#province0');
    var amphure0Object = $('#amphure0');
    var district0Object = $('#district0');

    // on change province
    province0Object.on('change', function(){
        var province0Id = $(this).val();

        amphure0Object.html('<option value="">เลือกอำเภอ</option>');
        district0Object.html('<option value="">เลือกตำบล</option>');

        $.get('get_amphure0.php?province0_id=' + province0Id, function(data){
            var result = JSON.parse(data);
            $.each(result, function(index, item){
                amphure0Object.append(
                    $('<option></option>').val(item.id).html(item.name_th)
                );
            });
        });
    });

    // on change amphure
    amphure0Object.on('change', function(){
        var amphure0Id = $(this).val();

        district0Object.html('<option value="">เลือกตำบล</option>');
        
        $.get('get_district.php?amphure_id=' + amphure0Id, function(data){
            var result = JSON.parse(data);
            $.each(result, function(index, item){
                district0Object.append(
                    $('<option></option>').val(item.id).html(item.name_th)
                );
            });
        });
    });
});