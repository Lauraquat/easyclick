// stocke les informations utiles (id et description du plat) récupérées à partir du bouton sur lequel on a cliqué
$('#confirmation_modal').on('show.bs.modal', function (e) {
    let clickedButton = $(e.relatedTarget);
    let id = clickedButton.data('id');
    let text = clickedButton.parents('.contenu').find('h3').html();
    
    $('#confirmation_modal .text').html(text);
    $('#confirmation_modal .id').val(id);
})


// décrémente la quantité quand on clique sur moins
$('#confirmation_modal').on('click', '.minus', function(e) {
    let value = parseInt($('#confirmation_modal .quantite').val()) - 1;

    $('#confirmation_modal .quantite').val((value < 1 ? 1 : value));
});


// incrémente la quantité quand on clique sur plus
$('#confirmation_modal').on('click', '.plus', function(e) {
    let value = parseInt($('#confirmation_modal .quantite').val()) + 1;

    $('#confirmation_modal .quantite').val(value);
});


// ferme la modale quand on clique sur la flèche
$('#confirmation_modal').on('click', '.hide', function(e) {
    $('#confirmation_modal').modal('hide');
});


// quand on clique sur ajouter, on appelle le controleur en ajax
$('#confirmation_modal').on('click', '.ajout', function(e) {
    let url = $(this).data('url') + '/' + $('#confirmation_modal .id').val() + '?quantite=' +  $('#confirmation_modal .quantite').val();
    $.get(url).done( function() {
        $('#confirmation_modal').modal('hide');
        $('#success_modal').modal('show');

        $('.panier_compte').html(parseInt($('.panier_compte').html()) + 1);

    }).fail(function(error) {
        $('#confirmation_modal').modal('hide');
        $('#error_modal').modal('show');
    });
});