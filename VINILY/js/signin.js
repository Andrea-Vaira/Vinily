'use strict'

$(function(){
    $('button').on('click', function(){
        let username = $(document).find('input').eq(0).val();
        let email = $(document).find('input').eq(1).val();
        let password = $(document).find('input').eq(2).val();

        let request = inviaRichiesta('GET', 'server/nuovoAccount.php', {username, email, password});
        request.fail(errore);
        request.done(function(ris){
            window.location.href = 'login.html';
        })
    })
})