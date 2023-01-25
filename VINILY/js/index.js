'use strict'

$(function () {

  /*let requestSession = inviaRichiesta('GET', 'server/controllaSessione.php');
  requestSession.fail(errore);
  requestSession.done(function(ris){
    console.log(ris);
  })*/

  openPage(['navbarContainer', 'header', 'image', 'footer', 'categories']);

  $('#btnShopNow').on('click', function () {
    let request = inviaRichiesta('GET', 'server/elencoProdotti.php');
    request.fail(errore);
    request.done(function (prodotti) {
      caricaShop(prodotti);
      openPage(['navbarContainer', 'header', 'image', 'footer', 'shop']);
    })

  })

  function caricaShop(prodotti) {
    let newProd = $('#productContainer').children('div').eq(0).clone();
    let modal = $('#singleProductModal');
    $('#productContainer').empty();
    modal.appendTo($('#productContainer'));
    for (const prodotto of prodotti) {
      newProd = newProd.clone();
      newProd.prop('id', '');
      newProd.prependTo($('#productContainer'));
      newProd.find('img').prop('src', prodotto.foto_prodotto).css({ 'width': '360px', 'height': '350px' });//360 350
      newProd.find('h2').text(prodotto.nome_prodotto);
      newProd.find('h4').text(prodotto.autore_prodotto);
      newProd.find('p').text('€ ' + prodotto.prezzo_prodotto + ',00');
      newProd.find('li').eq(0).prop('record', prodotto).click(function () {
        let modal = $('#singleProductModal');
        let prod = $(this).prop('record');
        modal.find('img').prop('src', prod.foto_prodotto);
        modal.find('h2').text(prod.nome_prodotto);
        modal.find('h3').text(prod.autore_prodotto);
        modal.find('p').text('€ ' + prod.prezzo_prodotto + ',00');
        modal.find('a').prop('idProdotto', prod.id_prodotto).click(function () {
          aggiungiAlCarrello($(this).prop('idProdotto'))
        });
      });
      newProd.find('a').eq(0).prop('idProdotto', prodotto.id_prodotto).click(function () {
        aggiungiAlCarrello($(this).prop('idProdotto'))
      });

    }
  }

  $('#btnCarrello').on('click', function () {
    let request = inviaRichiesta('GET', 'server/elencoProdottiCarrello.php');
    request.fail(errore);
    request.done(function (prodotti) {
      if (prodotti.length == 0) {
        openPage(['navbar', 'header', 'image', 'footer', 'emptyCart']);
      }
      else {
        console.log(prodotti);
        let tbody = $('#tbodyCart');
        let totale = 0;
        tbody.empty();
        for (const prod of prodotti) {
          let tr = $('<tr>').appendTo(tbody);
          let td = $('<td>').appendTo(tr);
          let div = $('<div>').appendTo(td).addClass("product-info");
          $('<img>').appendTo(div).prop({
            'width': '80',
            'src': prod.foto_prodotto
          })
          $('<a>').appendTo(div).text(prod.nome_prodotto);
          td = $('<td>').appendTo(tr).text(prod.qta_acquisto + ' X € ' + prod.prezzo_prodotto + ',00');
          totale += (parseInt(prod.prezzo_prodotto) * parseInt(prod.qta_acquisto));
          td = $('<td>').appendTo(tr);
          $('<a>').appendTo(td).text('Remove').addClass('product-remove')
            .prop('idOrdine', prod.id_ordine)
            .css('cursor', 'pointer')
            .on('click', function () {
              let idOrdine = $(this).prop('idOrdine');
              let param = { idOrdine };
              let request = inviaRichiesta('GET', 'server/rimuoviProdotto.php', param);
              request.fail(errore);
              request.done(function (ris) {
                $('#btnCarrello').trigger('click');
              })
            });
        }
        let tr = $('<tr>').appendTo(tbody);
        let td = $('<td>').appendTo(tr);
        let div = $('<div>').appendTo(td).addClass("product-info");
        $('<h1>').appendTo(div).text('Total');
        td = $('<td>').appendTo(tr);
        $('<h4>').appendTo(td).text('€ ' + totale + ',00');
        td = $('<td>').appendTo(tr);
        openPage(['navbarContainer', 'header', 'image', 'footer', 'cart']);
      }
    })

  })

  $('#btnBuyCart').on('click', function () {
    let request = inviaRichiesta('GET', 'server/acquistaProdotti.php');
    request.fail(errore);
    request.done(function (ris) {
      openPage(['navbarContainer', 'header', 'footer', 'confirmation']);
    })
  })

  $('#btnGoShop').on('click', function () {
    $('#btnShopNow').trigger('click');
    window.location.href = '#shop';
  })

  $('#btnGoCart').on('click', function () {
    $('#btnCarrello').trigger('click');
    window.location.href = '#cart';
  })

  $('#btnGoProfileDetails').on('click', function(){
    let request = inviaRichiesta('GET', 'server/datiUtente.php');
    request.fail(errore);
    request.done(function(data){
      //console.log(data);
      let container = $('#containerProfileDetails');
      container.empty();
      let li = $(`<li><span>Username:</span>${data[0].nome_utente}</li>`).appendTo(container);
      li = $(`<li><span>Email:</span>${data[0].email_utente}</li>`).appendTo(container);
      li = $(`<li><span>Phone:</span>${data[0].phone_utente}</li>`).appendTo(container);
      li = $(`<li><span>Address:</span>${data[0].indirizzo_utente}</li>`).appendTo(container);
      openPage(['navbarContainer', 'header',  'userDetail', 'footer']);
    })
  })

  $('#btnUser').on('click', function(){
    window.location.href = 'login.html'
  })

  $('#btnChangeAddress').on('click', function(){
    let container = $('#containerProfileDetails');
    let li = $(`<li><span>New Address:</span><input type='text'></li>`).appendTo(container);
    $('<a>').text('Change').appendTo(li).css({
      'margin-left':'10px',
      'cursor': 'pointer'
    })
    .on('click', function(){
      let indirizzo = $('#containerProfileDetails').find('input').eq(0).val();
      let request = inviaRichiesta('GET', 'server/cambiaIndirizzo.php', {indirizzo});
      request.fail(errore);
      request.done(function(ris){
        $('#btnGoProfileDetails').trigger('click');
      })
    })
  })

  $('#confirmation').find('a').on('click', function () {
    $('#btnShopNow').trigger('click');
    window.location.href = '#shop';
  })

  $('#emptyCart').find('a').on('click', function () {
    $('#btnShopNow').trigger('click');
    window.location.href = '#shop';
  })

  /*$('#aggiungiAlCarrelloModal').on('click', function () {
    let idProdotto = $(this).prop('idProdotto');
    aggiungiAlCarrello(idProdotto);
  })*/

  function aggiungiAlCarrello(idProdotto) {
    let param = { idProdotto }
    let request = inviaRichiesta('GET', 'server/aggiungiAlCarrello.php', param);
    request.fail(errore);
    request.done(function (ris) {
    })
  }

  $('#btnRock').on('click', function () {
    let param = { 'categoria': 1 };
    let request = inviaRichiesta('GET', 'server/elencoProdottiCategoria.php', param);
    request.fail(errore);
    request.done(function (prodotti) {
      caricaShop(prodotti);
      openPage(['navbarContainer', 'header', 'image', 'footer', 'shop']);
    })
  })

  $('#btnPop').on('click', function () {
    let param = { 'categoria': 2 };
    let request = inviaRichiesta('GET', 'server/elencoProdottiCategoria.php', param);
    request.fail(errore);
    request.done(function (prodotti) {
      caricaShop(prodotti);
      openPage(['navbarContainer', 'header', 'image', 'footer', 'shop']);
    })
  })

  $('#btnJazz').on('click', function () {
    let param = { 'categoria': 3 };
    let request = inviaRichiesta('GET', 'server/elencoProdottiCategoria.php', param);
    request.fail(errore);
    request.done(function (prodotti) {
      caricaShop(prodotti);
      openPage(['navbarContainer', 'header', 'image', 'footer', 'shop']);
    })
  })

  $('#btnOther').on('click', function () {
    let param = { 'categoria': 4 };
    let request = inviaRichiesta('GET', 'server/elencoProdottiCategoria.php', param);
    request.fail(errore);
    request.done(function (prodotti) {
      caricaShop(prodotti);
      openPage(['navbarContainer', 'header', 'image', 'footer', 'shop']);
    })
  })

  /*HELPER FUNCTION*/
  //Hero Slider
  $('.hero-slider').slick({
    // autoplay: true,
    infinite: true,
    arrows: true,
    prevArrow: '<button type=\'button\' class=\'heroSliderArrow prevArrow tf-ion-chevron-left\'></button>',
    nextArrow: '<button type=\'button\' class=\'heroSliderArrow nextArrow tf-ion-chevron-right\'></button>',
    dots: true,
    autoplaySpeed: 7000,
    pauseOnFocus: false,
    pauseOnHover: false
  });
  $('.hero-slider').slickAnimation();

  function openPage(arrayPage) {
    let collection = $('body').children('section, footer');
    let collectionLenght = collection.length;
    for (let i = 0; i < collectionLenght; i++) {
      collection.eq(i).hide();
    }

    for (const string of arrayPage) {
      let idPage = "#" + string;
      $(idPage).show();
    }
  }

});

