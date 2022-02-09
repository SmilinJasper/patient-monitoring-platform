const medicineTableBody = document.getElementById('medicine-table-body');
const addMedicineButton = document.getElementById('add-medicine-button');
const submitMedicineListButton = document.getElementById('submit-medicine-list-button');
const medicineIds = document.getElementsByClassName('medicine-id');
const lastMedicineId = medicineIds[medicineIds.length - 1].innerHTML;
const newMedicineId = lastMedicineId + 1;

addMedicineButton.addEventListener('click', () => addMedicineInput());

function addMedicineInput() {

    // Create table elements to append

    const tableRow = document.createElement('tr');
    const medicineIdTableDivision = document.createElement('td');
    const medicineNameTableDivision = document.createElement('td');
    const toTakeMorningTableDivision = document.createElement('td');
    const toTakeAfternoonTableDivision = document.createElement('td');
    const toTakeEveningTableDivision = document.createElement('td');
    const toTakeNightTableDivision = document.createElement('td');

    // Add content to elements

    const tableDivisions = [];

    medicineIdTableDivision.innerHTML = `${newMedicineId}`;
    medicineNameTableDivision.innerHTML = `<input type='text' id='medicine-name-input'>`
    toTakeMorningTableDivision.innerHTML = `<input type='checkbox' value='Prescribed'>`
    toTakeAfternoonTableDivision.innerHTML = `<input type='checkbox' value='Prescribed'>`
    toTakeEveningTableDivision.innerHTML = `<input type='checkbox' value='Prescribed'>`
    toTakeNightTableDivision.innerHTML = `<input type='checkbox' value='Prescribed'>`

    tableDivisions.push(medicineIdTableDivision, medicineNameTableDivision, toTakeMorningTableDivision, toTakeAfternoonTableDivision, toTakeEveningTableDivision, toTakeNightTableDivision);

    tableRow.append(...tableDivisions);

    medicineTableBody.append(tableRow);

    // Focus the medicine name text input

    const medicineNameInput = document.getElementById('medicine-name-input');
    medicineNameInput.focus();

    // Make submit button visible with right alignment

    submitMedicineListButton.style.display = 'block';
    submitMedicineListButton.style.marginBottom = '-8px';
    addMedicineButton.style.marginBottom = '19px';
}