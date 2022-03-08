const medicineCheckmarkElements = document.getElementsByClassName('medicine-checkmark');

for (let i = 0; i < medicineCheckmarkElements.length; i++) {
    medicineCheckmarkElements[i].addEventListener('change', () => {
        medicineCheckmarkElements[i].closest('form').submit();
    });
}