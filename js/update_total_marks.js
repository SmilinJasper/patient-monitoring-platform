//Get HTML ELements for input and output marks
const sectionMarksInput = document.getElementsByClassName("section-marks-input");
const totalMarks = document.getElementsByClassName("total-marks");

//Funtion to add values of section marks and display it as total marks
function updateTotalMarks() {
    let marks = 0;
    for (let i = 0; i < sectionMarksInput.length; i++) {
        marks += parseInt(sectionMarksInput[i].value);
    }
    totalMarks[0].value = marks;
}

//Event listener to run updateTotalMarks() everytime section marks are changed
for (let i = 0; i < sectionMarksInput.length; i++) {
    sectionMarksInput[i].addEventListener("change", updateTotalMarks);
}