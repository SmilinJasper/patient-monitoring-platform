const viewScheduleButton = document.getElementById('view-schedule-button');
const scheduleModal = document.getElementById('schedule-modal');
const scheduleModalContent = document.getElementById('schedule-modal-content');

viewScheduleButton.onclick = () => {
    scheduleModal.style.display = 'grid';
    document.getElementsByTagName('body')[0].style.overflow = 'hidden';
    scheduleModalContent.focus();
};

scheduleModalContent.addEventListener('blur', () => {
    console.log('blur');
    scheduleModal.style.display = 'none';
    document.getElementsByTagName('body')[0].style.overflow = 'auto';
}, true);