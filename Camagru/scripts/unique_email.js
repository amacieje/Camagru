var email = document.getElementById("email");

email.onkeyup = function() {

  var xhr = new XMLHttpRequest();

  check_email = 0;
  document.getElementById("signup_button").disabled = true;

  xhr.onreadystatechange = function() {

    if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
      document.getElementById("email_pattern").style.display = "none";
      if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.value)))
        document.getElementById("email_pattern").style.display = "block";
      else if (xhr.response.match("Email already exists"))
        document.getElementById("unique_email").style.display = "block";
      else {
        document.getElementById("unique_email").style.display = "none";
        if (email.value != "")
          check_email = 1;
        if (check_email == 1 && check_username == 1 && check_password == 1)
          document.getElementById("signup_button").disabled = false;
      }
    }

  };

  xhr.open("GET", "unique_email.php?email=" + escape(email.value), true);
  xhr.send(null);

}
