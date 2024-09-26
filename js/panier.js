// Validation de la quantité avec JavaScript à supprimer si celle de PHP marche pas sûr 
function validateQuantity() {
    var newQty = document.getElementById('new_qty').value;
    if (isNaN(newQty) || newQty <= 0) {
        alert('Veuillez saisir une quantité valide (numérique et positive).');
        return false;
    }
    return true;
}


