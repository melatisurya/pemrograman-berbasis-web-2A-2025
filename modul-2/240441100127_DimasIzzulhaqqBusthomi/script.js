function openPopup(event) {
    event.preventDefault()
    document.querySelector('.overlay').style.display = 'block';
    document.querySelector('.card-pop').style.display = 'block';
}

function closePopup() {
    document.querySelector('.overlay').style.display = 'none';
    document.querySelector('.card-pop').style.display = 'none';
}