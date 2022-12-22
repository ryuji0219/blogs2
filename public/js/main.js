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
      url: "/loginCheck",
      dataType: "json",
      data: {
        name: name,
        password: password
      },
  
    })
      //通信が成功したとき
      .then((res) => {
        console.log(res);
        // loginDsp.removeClass('active');
      })
      //通信が失敗したとき
      .fail((error) => {
        // loginDsp.removeClass('active');
        console.log(error.statusText);
      });
      // $(this).parents('.modal').removeClass('active');
      // $(this).parents('.form-signin').removeClass('active');
    });

// $("#bt").click(function () {
//     $.ajax({
//       type: "get", //HTTP通信の種類
//       url: "/getuser",
//       dataType: "json",
//     })
//       //通信が成功したとき
//       .done((res) => { // resの部分にコントローラーから返ってきた値 $users が入る
//         $.each(res, function (index, value) {
//           html = `
//                         <tr class="user-list">
//                             <td class="col-xs-2">ユーザー名：${value.name}</td>
//                         </tr>
//            `;
//         $(".user-table").append(html); //できあがったテンプレートを user-tableクラスの中に追加
//         });
//       })
//       //通信が失敗したとき
//       .fail((error) => {
//         console.log(error.statusText);
//       });
//   });


// $('.modal-login').click(function() {

//     const name     = $('input[name="name"]').val();
//     const password     = $('input[name="password"]').val();

//     // name
//     // 必須
//     if (name == '' || name == null) {
//       $('.attention-name').show().text('お名前は必須項目です。');
//       error = true;
//     }

//     if (password == '' || password == null) {
//         $('.attention-name').show().text('お名前は必須項目です。');
//         error = true;
//     }


//     // 10文字以内
//     if (name.length > 12) {
//       $('.attention-name').show().text('お名前は12文字以内で入力してください。');
//       error = true;
//     }


    // const email    = $('input[name="email"]').val();
    // const tel      = $('input[name="tel"]').val();
    // const gender   = $('input[name="gender"]:checked').val();
    // const checkbox = $('input[name="checkbox"]:checked').val();
    // const contents = $('textarea[name="contents"]').val();
    // const inputContents = contents.replace( /\r?\n/g, '<br />' );
    // let error = false;
  
    // $('.attention-name').text('');
    // $('.attention-email').text('');
    // $('.attention-tel').text('');
    // $('.attention-gender').text('');
    // $('.attention-checkbox').text('');
    // $('.attention-contents').text('');
  
    // // name
    // // 全角
    // if (!name.match(/^[^\x01-\x7E\xA1-\xDF]+$/)) {
    //   $('.attention-name').show().text('お名前は全角で入力してください。');
    // //   error = true;
    // }
    // // 10文字以内
    // if (name.length > 10) {
    //   $('.attention-name').show().text('お名前は10文字以内で入力してください。');
    // //   error = true;
    // }
    // // 必須
    // if (name == '' || name == null) {
    //   $('.attention-name').show().text('お名前は必須項目です。');
    // //   error = true;
    // }
  
    // // email
    // // 英数字のみ、@を含む
    // if (!email.match(/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/)) {
    //   $('.attention-email').show().text('メールアドレスは正しく入力してください。');
    // //   error = true;
    // }
    // // 必須
    // if (email == '' || email == null) {
    //   $('.attention-email').show().text('メールアドレスは必須項目です。');
    // //   error = true;
    // }
  
    // // tel
    // // 半角数字のみ（ハイフンOK）
    // if (tel.length > 0) {
    //   if (!tel.match(/^[0-9\-]+$/)) {
    //     $('.attention-tel').show().text('電話番号は半角数字で入力してください。');
    //     // error = true;
    //   }
    // }
  
    // // gender
    // // 必須
    // if (gender == '' || gender == null) {
    //   $('.attention-gender').show().text('性別は必須項目です。');
    // //   error = true;
    // }
  
    // // checkbox
    // // 必須
    // if (checkbox == '' || checkbox == null) {
    //   $('.attention-checkbox').show().text('選択は必須項目です。');
    // //   error = true;
    // }
  
    // // contents
    // // 必須
    // if (contents == '') {
    //   $('.attention-contents').show().text('お問い合わせ内容は必須項目です。');
    // //   error = true;
    // }
  
    // if (error == false) {
    //   $('.form-btn').attr('data-toggle', 'modal');
    //   $('.form-btn').attr('data-target', '#exampleModalCenter');
  
    //   $('.modal-name').text(name).val(name);
    //   $('.modal-email').text(email).val(email);
    //   $('.modal-tel').text(tel).val(tel);
    //   $('.modal-gender').text(gender).val(gender);
    //   $('.modal-contents').html(inputContents).val(contents);
    // }
  
    // const inputCheckbox = [];
    // $('input[name="checkbox"]:checked').each(function() {
    //   inputCheckbox.push($(this).val());
    //   $('.modal-checkbox').text(inputCheckbox).val(inputCheckbox);
    // });
//   });