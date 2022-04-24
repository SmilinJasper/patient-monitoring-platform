const editButton = document.getElementById('edit-button');
const editableInfoValues = document.getElementsByClassName('editable-info-value');

editButton.addEventListener('click', (event) => {

    event.preventDefault();

    console.log(editableInfoValues);

    for (let i = 0; i < editableInfoValues.length; i++) {
        editableInfoValues[i].removeAttribute('disabled');
        editableInfoValues[i].style.textDecoration = 'underline #BDBDBD';
    }

});