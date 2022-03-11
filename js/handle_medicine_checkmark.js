// Get all medicine checkmark elements

const medicineCheckmarkElements = document.getElementsByClassName('medicine-checkmark');

// Add submit function to all medicine checkmark elements on change

for (let i = 0; i < medicineCheckmarkElements.length; i++) {
    medicineCheckmarkElements[i].addEventListener('change', () => {
        medicineCheckmarkElements[i].closest('form').submit();
    });
}