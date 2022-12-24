
$('.btn-close').on(
  'click', function() {
    $('.form-signin').removeClass('active');
});

$('.modal-login').click(function() {
    const name     = $('input[name="name"]').val();
    const password     = $('input[name="password"]').val();
    // const loginDsp     = $('.loginDsp');
    console.log(name);
    console.log(password);

    $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });
    $.ajax({
      //POST通信
      type: "post",
      //ここでデータの送信先URLを指定します。
      url: "loginCheck",
      dataType: "json",
      data: {
        name: name,
        password: password
      }  
    }).done(function(){
      console.log('成功');
   }).fail(function(XMLHttpRequest, textStatus, errorThrown){
      console.log(XMLHttpRequest.status);
      console.log(textStatus);
      console.log(errorThrown);
   });
});