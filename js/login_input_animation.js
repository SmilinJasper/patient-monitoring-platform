// Get HTML input eLements

const inputs = document.querySelectorAll(".input");

// Focus animation on input fields

function addcl() {
    let parent = this.parentNode.parentNode;
    parent.classList.add("focus");
}

function remcl() {
    let parent = this.parentNode.parentNode;
    if (this.value == "") parent.classList.remove("focus");
}

inputs.forEach(input => {
    input.addEventListener("focus", addcl);
    input.addEventListener("input", addcl);
    input.addEventListener("blur", remcl);
});