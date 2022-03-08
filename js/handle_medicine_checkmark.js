const medicineCheckmark = document.getElementById('medicine-checkmark');
const medicineCheckmarkLabel = document.getElementById('medicine-checkmark-label');
const markMedicineForm = document.getElementById('mark-medicine-form');

medicineCheckmark.addEventListener('change', () => {
    markMedicineForm.submit();

});