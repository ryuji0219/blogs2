$('.modal-login').click(function() {
  const name     = $('input[name="name"]').val();
  const password     = $('input[name="password"]').val();
  let $errMsg = $('.err_msg');
  $errMsg.empty()
  let ret = false;
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });
  $.ajax({
    type: "post",
    url: "loginCheck",
    dataType: "json",
    async: false,
    data: {
      name: name,
      password: password
    }  
  }).done(function(res){
    if(res.result == 'OK'){
      $("#form-login").removeClass('active');
      ret = true;
      return true;
    }
    else if(res.result == 'NG'){
      $errMsg.append('<div class="text-danger">' + res.errMsg + '</div>');
      ret = false;
      // return false;
    }
    else{
      $errMsg.append('<div class="text-danger">システムエラー</div>');
      ret = false;
    }
  }).fail(function(res){
    let errors = res.responseJSON;
    Object.keys(errors).forEach(function (key){
        $errMsg.append('<div class="text-danger">' + errors[key] + '</div>');
    });

    ret = false;
  });

  return ret;
});

// $('.btn-close').on(
//   'click', function() {
//     $('.form-login').removeClass('active');
// });