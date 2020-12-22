
// capslock detection
// input field to check
let inputField = document.getElementById("wachtwoord");
// paragraph in which we show the warning text
let warning = document.getElementById("warning-text");

inputField.addEventListener("keyup", function(event) {
    if (event.getModifierState("CapsLock")) {
        warning.style.display = "block";
    } else {
        warning.style.display = "none";
    }
});