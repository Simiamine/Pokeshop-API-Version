

document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById('search-input');
    const cards = document.querySelectorAll('.card');
    
    searchInput.addEventListener('input', function() {
        const searchText = this.value.toLowerCase();
        
        cards.forEach(card => {
            const name = card.querySelector('.card-title').textContent.toLowerCase();
            if (name.includes(searchText)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
});



document.addEventListener("DOMContentLoaded", function() {
    const cards = document.querySelectorAll('.card');
    const popup = document.getElementById('pokemonPopup');
    const popupName = document.getElementById('pokemonName');
    const popupImage = document.getElementById('pokemonImage');
    const popupDescription = document.getElementById('pokemonDescription');
    const closePopup = document.querySelector('.popup .close');

 // Fonction pour ouvrir la pop-up
function openPopup(name, image, description, generation, legendaire, price, discountedPrice) {
    popupName.textContent = name;
    popupImage.src = image;
    popupDescription.textContent = description;
    document.getElementById('generation').textContent = generation;
    document.getElementById('legendaire').textContent = legendaire === '1' ? 'Oui' : 'Non';
    // Set price and discounted price
    document.getElementById('initialPrice').textContent = price + '€';
    document.getElementById('discountedPrice').textContent = discountedPrice + '€';
    popup.style.display = 'block';
}


cards.forEach(card => {
    card.addEventListener('click', function() {
        const name = this.getAttribute('data-name');
        const image = this.getAttribute('data-image');
        const description = this.getAttribute('data-description');
        const generation = this.getAttribute('generation');
        const legendaire = this.getAttribute('legendaire');
        const priceElement = this.querySelector('.price') || this.querySelector('.original-price');
        const discountedPriceElement = this.querySelector('.discounted-price');
    
        const price = priceElement ? priceElement.textContent : 'N/A';
        const discountedPrice = discountedPriceElement ? discountedPriceElement.textContent : 'N/A';

        openPopup(name, image, description, generation, legendaire, price, discountedPrice);
    });
});

    // Gestionnaire de clic pour fermer la pop-up
    closePopup.addEventListener('click', function() {
        popup.style.display = 'none';
    });
});

