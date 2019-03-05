function addDeleteLink($entry) {

    var $removeFormButton = jQuery('<button type="button" class="btn btn-success" >Supprimer</button>');

    $entry.append($removeFormButton);

    $removeFormButton.on('click', function (e) {
        $entry.remove();
    });
}


$(document).ready(function () {
    var $collectionHolders = jQuery('div[data-prototype]');

    $collectionHolders.each(function (index, element) {
        console.log(index);
        var $collectionHolder = jQuery(element);

        $collectionHolder.data('index', $collectionHolder.find('.form-group').length);
        $collectionHolder.children('.form-group').each(function (index, element) {
            console.log(index);
            addDeleteLink(jQuery(element));
        });

        var $addButton = jQuery('<button type="button" class="btn btn-success" >Ajouter</button>');


        $addButton.on('click', function () {
            addEntryForm($collectionHolder, $addButton);
        });

        $collectionHolder.append($addButton);
    });

});

function addEntryForm($collectionHolder, $newLinkLi) {
    var prototype = $collectionHolder.data('prototype');
    var index = $collectionHolder.find('input').length;
    var newForm = prototype;
    newForm = newForm.replace(/__name__/g, index);
    newForm = newForm.replace(/label__/g, '');
    $collectionHolder.data('index', index + 1);

    var $newForm = jQuery(newForm);

    $newLinkLi.before($newForm);
    addDeleteLink($newForm);
}