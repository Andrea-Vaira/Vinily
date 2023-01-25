$(function () {
    $(document).find('button').on('click', function () {
        let nome = $(document).find('input').eq(0).val();
        let autore = $(document).find('input').eq(1).val();
        let prezzo = $(document).find('input').eq(2).val();
        let foto = $(document).find('input').eq(3).val();
        let genere = $(document).find('input[type=radio]:checked').eq(0).val();
        console.log(genere);
        let request = inviaRichiesta('GET', 'server/addProduct.php', {
            nome, autore, prezzo, foto, genere
        })
        request.fail(errore);
        request.done(function(){
            window.location.href = 'login.html';
        })
    })

})