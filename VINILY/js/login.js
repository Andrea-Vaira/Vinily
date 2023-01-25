'use strict'

$(function () {
  $('#btnLogin').on('click', function () {
    let email = $('input').prop('type', 'mail').val();
    let password = $('input').eq(1).val();
    let param = { email, password };
    let request = inviaRichiesta('POST', 'server/login.php', param);
    request.fail(errore);
    request.done(function (ris) {
      if (ris.nome == 'admin')
        window.location.href = 'addProduct.html';
      else
        window.location.href = 'index.html';
    })
  })

  $(document).find('a').on('click', function () {
    window.location.href = 'signin.html';
  })
});