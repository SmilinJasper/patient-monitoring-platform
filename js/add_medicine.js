const medicineTableBody = document.getElementById('medicine-table-body');
const addMedicineButton = document.getElementById('add-medicine-button');
const submitMedicineListButton = document.getElementById('submit-medicine-list-button');

addMedicineButton.addEventListener('click', () => addMedicineInput(event));

function addMedicineInput(event) {

    //Prevnt form submission when clicking on add medicine button

    event.preventDefault();

    // Create table elements to append

    const newMedicineRowTemplate = document.getElementById('new-medicine-row-template');
    const newMedicineRow = newMedicineRowTemplate.content.cloneNode(true);

    medicineTableBody.appendChild(newMedicineRow);

    // Focus the medicine name text input

    const newMedicineInput = document.getElementById('new-medicine-input');
    newMedicineInput.focus();

    // Make submit button visible with right alignment

    submitMedicineListButton.style.display = 'block';
    addMedicineButton.style.display = 'none';
}