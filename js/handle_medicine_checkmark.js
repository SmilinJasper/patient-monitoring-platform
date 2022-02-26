const medicineCheckmark = document.getElementById('medicine-checkmark');
const medicineCheckmarkLabel = document.getElementById('medicine-checkmark-label');
const markMedicineForm = document.getElementById('mark-medicine-form');

medicineCheckmark.addEventListener('change', handleMedicineCheckmark());

function handleMedicineCheckmark() {

    if (medicineCheckmark.checked) {
        medicineCheckmarkLabel.innerHTML = `<img class='ui-icon' src='img/check-mark-tick-green.png' alt='Taken'>`

        console.log('Medicine is taken');


        return;
    }

    medicineCheckmarkLabel.innerHTML = `<img class='ui-icon' src='img/check-mark-tick-blue.png' alt='Taken'>`
    console.log('Medicine is not taken');

}