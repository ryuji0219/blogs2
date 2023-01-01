//会員登録
$('.user-create').click(function() {
  const user_id     = $('input[name="user_id"]').val();
  const newName     = $('input[name="newName"]').val();
  const newEmail     = $('input[name="newEmail"]').val();
  const newPassword     = $('input[name="newPassword"]').val();
  const newPassword2     = $('input[name="newPassword2"]').val();
  const postCode     = $('input[name="postCode"]').val();
  $('.err_msg_user').empty();
  let ret = false;
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });
  $.ajax({
    type: "post",
    url: "userCheck",
    dataType: "json",
    async: false,
    data: {
      user_id: user_id,
      newName: newName,
      newPassword: newPassword,
      newEmail: newEmail,
      newPassword2: newPassword2,
      postCode: postCode
    }  
  }).done(function(res){
    if(res.result == 'OK'){
      ret = true;
    }
    else if(res.result == 'NG'){
      $('.err_msg_user').append('<div class="text-danger">' + res.errMsg + '</div>');
      ret = false;
    }
    else{
      $('.err_msg_user').append('<div class="text-danger">システムエラー</div>');
      ret = false;
    }
  }).fail(function(res){
    let errors = res.responseJSON;
    Object.keys(errors).forEach(function (key){
        $('.err_msg_user').append( '<div class="text-danger">' + errors[key] + '</div>');
    });
    ret = false;
  });

  return ret;
});

//ログイン
$('.modal-login').click(function() {
  const name     = $('input[name="name"]').val();
  const password     = $('input[name="password"]').val();
  $('.err_msg_login').empty();
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
      ret = true;
    }
    else if(res.result == 'NG'){
      $('.err_msg_login').append('<div class="text-danger">' + res.errMsg + '</div>');
      ret = false;
    }
    else{
      $('.err_msg_login').append('<div class="text-danger">システムエラー</div>');
      ret = false;
    }
  }).fail(function(res){
    let errors = res.responseJSON;
    Object.keys(errors).forEach(function (key){
        $('.err_msg_login').append( '<div class="text-danger">' + errors[key] + '</div>');
    });
    ret = false;
  });

  return ret;
});

//住所検索
$('.address-search').click(function() {
  const postCode     = $('input[name="postCode"]').val();
  $('.err_msg_address').empty();
  let ret = false;

  if(postCode == null || postCode == ""){
    $('.err_msg_address').append('<div class="text-danger">' + '郵便番号を入力して下さい。' + '</div>');
    return false;
  }

  $.ajax({
    type: "get",
    url: "searchAddress/" + postCode,
    data: {
      'postCode': postCode
    },
    dataType: 'json',
  }).done(function(res){
    if(res.result == 'OK'){
      $("#address1").val(res.address);
    }
    else if(res.result == 'NG'){
      $('.err_msg_address').append('<div class="text-danger">' + res.errMsg + '</div>');
    }
    else{
      $('.err_msg_address').append('<div class="text-danger">システムエラー</div>');
    }
    return false;
  }).fail(function(res){
    $('.err_msg_address').append('<div class="text-danger">システムエラー</div>');
    return false;
  });
 
  return false;
});
