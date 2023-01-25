$(function () {
    $(document).find('button').on('click', function () {
        let email = $(document).find('input').eq(0).val();
        let phone = $(document).find('input').eq(1).val();
        let pwd = $(document).find('input').eq(2).val();
        let pwd2 = $(document).find('input').eq(3).val();
        if(pwd == pwd2){
            let request = inviaRichiesta('GET', 'server/resetPassword.php', {email, phone, pwd});
            request.fail(errore);
            request.done(function(ris){
                console.log(ris)
                window.location.href = 'login.html';
            })
        }
        else
            alert('Passwords are different');
    })
})