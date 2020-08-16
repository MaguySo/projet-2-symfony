// ajouter des images - création de sous-formulaire
$("#add-image").click(function () {
  const index = parseInt($("#widget-counter").val());
  // Replace '__name__' in the prototype's HTML to
  // instead be a number based on how many items we have - Symfony-doc.
  // g pour mener l'action plusieurs fois
  const template = $("#fruit_images")
    .data("prototype")
    .replace(/__name__/g, index);

  $("#fruit_images").append(template);
  $("#widget-counter").val(index + 1);

  // Appeler la fonction à chaque création de sous-formulaire
  deleteBtn();
});

// Bouton de suppression d'images
function deleteBtn() {
  $('button[data-action="delete"]').click(function () {
    const target = this.dataset.target;
    $(target).remove();
  });
}

function updateCounter() {
  const count = parseInt($("#fruit_images div.form-group").length);
  $("#widget-counter").val(count);
}

// Appeler les fonctions à chaque rechargement de page
updateCounter();
deleteBtn();
