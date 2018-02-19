var myInput = document.getElementById("psw");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
    document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
    document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate length
  if (myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
    check_password = 1;
    if (check_username == 1 && check_email == 1)
      document.getElementById("signup_button").disabled = false;
  }

  else {
    length.classList.remove("valid");
    length.classList.add("invalid");
    document.getElementById("signup_button").disabled = true;
    check_password = 0;
  }

}
