$(document).ready(function () {
  $(document).ajaxError(function (e, xhr, settings, exception) {
    //alert('error in: ' + settings.url + ' \n' + 'error:\n' + xhr.responseText);
    $("#content2").html('error in: ' + settings.url + ' \n' + 'error:\n' + xhr.responseText);
  });
  function newMonth(idd){
    var today = new Date();
    var mm = today.getMonth();//January is 0!
    var MMM='<select id="month_select" class="form-control" style="float:left;background-color: #ffffff;border: 1px solid #cccccc;">';
    var month_text = new Array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
    var i=0;
    for(i=0;i<12;i++){
      MMM+="<option value='"+(i+1)+"'";
      if((i)==mm){MMM+="selected='selected'";}
        MMM+=">";
        MMM+=month_text[i];
        MMM+="</option>";
    }
    MMM+="</select>";
    $(MMM).insertAfter('#month');
  }
  function newYear(){
    var today = new Date();
    var yy = today.getFullYear();//January is 0!
    var yyy='<select id="year_select" class="form-control" style="float:left;background-color: #ffffff;border: 1px solid #cccccc;">';
    var i=0;
    for(i=2010;i<=yy;i++){
      yyy+="<option value='"+(i)+"'";
      if((i)==yy){yyy+="selected='selected'";}
      yyy+=">";
      yyy+=(i+543);
      yyy+="</option>";
    }
    yyy+="</select>";
    $(yyy).insertAfter('#year');
  }
  $.getdata=function(_u,_a,_y,_m,_e,_t){
    $.ajax({
      type:"POST",url:_u,
      data:({'ampur'  : _a,'year' : _y,'month'  : _m}),
      dataType: _t,
      beforeSend:function(){
        if(_e=="#content2"){$(_e).html('<img src="../themes/img/loadding4.gif"/>');}
      },
      success: function (data) {
        // console.log(data[0].sql);
        if(_e=="#content2" && _t=="json"){$(_e).html(data[0].contents);}
        if(_e=="#importdetial" && _t=="html"){
          if(data==""){$(_e).hide();}else{$(_e).show();}
        }
      }
    });
  }
  //$.getdata("43file_daily_getimportList.php","","","","#importdetial","html");
  $.fn.fancyBOX = function () {
    $.fancybox({
      helpers: {
        overlay: {
          locked: true
        }
      },
      maxWidth: 600,
      minWidth: '30%',
      width: 500,
      maxHeight: 680,
      minHeight: '30%',
      height: 'auto',
      fitToView: false,
      autoSize: false,
      closeClick: false,
      type: "ajax",
      href: "43file_daily_getimportList.php",
      beforeLoad: function () {
        $.fancybox.showLoading();
      },
      afterShow: function () {
        $.fancybox.hideLoading();
        $(".fancybox-wrap a").css({
          'color': '',
          'border-color': '',
          'border': 'none'
        });

        $(".fancybox-wrap").on("change", ".popover-content select", function () {

        });
      },
      beforeClose:function(){}
    })
  };
  $(".site_container").on("change", "select", function () {
    $.getdata("./43file_daily_getreport.php",$("#ampur_select").val(),$("#year_select").val(),$("#month_select").val(),"#content2","json");
  });
  $(".site_container").on("click", "#importdetial", function () {$.fn.fancyBOX();});
  newMonth();
  newYear();
  $.getdata("./43file_daily_getreport.php",$("#ampur_select").val(),$("#year_select").val(),$("#month_select").val(),"#content2","json");
  // $(".site_container").on("mouseover", ".datarow", function () {
  //  $(this).css('bgcolor', '#77FF99');
  // });
  $(".site_container").on({
    mouseenter: function(){$(this).css({'background-color':'#F0F0F0'});},
    mouseleave: function(){$(this).css({'background-color':'#FFFFFF'});}
  },'.datarow');
});