//会員登録
$('.user-create').click(function() {
  const user_id     = $('input[name="user_id"]').val();
  const newName     = $('input[name="newName"]').val();
  const newEmail     = $('input[name="newEmail"]').val();
  const newPassword     = $('input[name="newPassword"]').val();
  const newPassword2     = $('input[name="newPassword2"]').val();
  const postCode     = $('input[name="postCode"]').val();
  $('.err_msg').empty();
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
  $('.err_msg').empty();
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
  $('.err_msg').empty();
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

$('.clear_search_button').click(function() {
  $('input[name="search_text"]').val("");
  return false;  
});

$(function() {
  // 表示用ボタン押下処理
  $('input[name^="button"]').on('click', function () {
    let button = $(this).prop('name');
    let airi = button.replace('button', 'ueno_airi');
    let yuri = button.replace('button', 'ueno_yuri');
    let ryu = button.replace('button', 'ueno_ryu');
    let moji_airi = button.replace('button', 'moji_airi');
    let moji_yuri = button.replace('button', 'moji_yuri');
    let moji_ryu = button.replace('button', 'moji_ryu');

    $('input[name="' + airi + '"]').show();
    $('input[name="' + yuri + '"]').show();
    $('input[name="' + ryu + '"]').show();
    $(this).hide();
    $('span[name="' + moji_airi + '"]').show();
    $('span[name="' + moji_yuri + '"]').show();
    $('span[name="' + moji_ryu + '"]').show();

  });

  $("input[id^='chkbox_']").click(function(){
    var flag = $(this).prop('checked');
    $("input[id^='chkbox_']").prop('checked', false);
    if (flag) $(this).prop('checked', true);
  });

  // チェックボックス排他制御
  $('input[name^="ueno_"]').change(function() {
    let flag = $(this).prop('checked');

    let name = $(this).prop('name');
    let disName;

    if($(this).prop('checked')){
      if (name.indexOf('ueno_airi') >= 0) {
        let ryu = name.replace('ueno_airi', 'ueno_ryu');
        $('input[name="' + ryu + '"]').prop("checked", false);
      }

      if (name.indexOf('ueno_yuri') >= 0) {
        let ryu = name.replace('ueno_yuri', 'ueno_ryu');
        $('input[name="' + ryu + '"]').prop("checked", false);
      }

      if (name.indexOf('ueno_ryu') >= 0) {
        let airi = name.replace('ueno_ryu', 'ueno_airi');
        $('input[name="' + airi + '"]').prop("checked", false);
        yuri = name.replace('ueno_ryu', 'ueno_yuri');
        $('input[name="' + yuri + '"]').prop("checked", false);
      }
    }

    // ①空の配列を用意
    // let airi = [];
    // let yuri = [];
    // let ryu = [];

    // // ②チェックが入ったらループ処理
    // // $('input[name="airi[]"]:checked').each(function(index) {
    // $('input[name^="ueno_airi"]').each(function(index) {
    //   let name2 = $(this).prop('name');
    //   if (index % 2 === 1){
    //     // ③value値を配列に格納
    //     airi.push($(this).prop('checked'));
    //     if($(this).prop('checked')){
    //       row = (index - 1) / 2 ;
    //       $('input[name="ueno_ryu[' + row + ']"]').prop("checked", false);
    //     }
    //   }
    // });

    // if (flag) $(this).prop('checked', true);

        // 格納した配列を表示

  });

  // チェックボックスをチェックしたら発動
  $('input[name="ueno[]"]').change(function() {

    // ①空の配列を用意
    var uenos = [];

    // ②チェックが入ったらループ処理
    $('input[name="ueno[]"]:checked').each(function(index) {
      // ③value値を配列に格納
      uenos.push($(this).val());
    });

    // 格納した配列を表示
    $('#p00').text(uenos);

  });

  // チェックボックスをチェックしたら発動
  $('input[name="check"]').change(function() {
    var flag = $(this).prop('checked');

    // airi()でチェックの状態を取得
    var airi = $('#airi').prop('checked');
    // var prop = $('#prop:checked').val();
    // val()でチェックの状態を取得
    var val = $('#val:checked').val();
    // is()でチェックの状態を取得
    var papa = $('#papa').is(':checked');

    
    // もしairiがチェック状態だったら
    if (airi) {
      $("#papa").prop("checked", false);
    }
 
    // もしyurinaがチェック状態だったら
    if (val) {
      $("#papa").prop("checked", false);
    }
 
    // もしpapaがチェック状態だったら
    if (papa) {
      // $("#papa").prop("checked", true);
      $("#airi").prop("checked", false);
      $("#val").prop("checked", false);
    }

    if (flag) $(this).prop('checked', true);
 
  });

  $("#tblLocations").sortable({
    // 見出しである一番上の行以外をドラッグできるように設定
    items: 'tr:not(tr:first-child)',
    // マウスカーソルの形状を変える
    cursor: 'pointer',
    // ドラッグできる方向は縦方向のみなのでaxissに（y）を設定
    axis: 'y',
    // ドラッグされた行が明確に見えるようにstartイベントにselectedクラスを設定
    start: function (e, ui) {
        ui.item.addClass("selected");
    },
    // ドロップした行のselectedクラスを解除して並び替え列を更新
    // stop: function (e, ui) {
    //     ui.item.removeClass("selected");
    //     $(this).find("tr").each(function (index) {
    //         // index = 0は見出しの行ですから更新しない
    //         if (index > 0) {
    //             $(this).find("td").eq(2).html(index);
    //         }
    //     });
    // }
  });

  $("#sort").sortable({
    update: function () {
      $("#log").text($('#sort').sortable("toArray"));
      var i = 1;
      $(".seq").each(function () {
        var seq = $(this).val(i);
        i++;
      });
    }
  });


});
