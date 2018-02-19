var username = document.getElementById("username");

username.onblur = function(){

  var xhr = new XMLHttpRequest();

  check_username = 0;
  document.getElementById("signup_button").disabled = true;

  xhr.onreadystatechange = function() {

    if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
      if (xhr.response.match("Username already exists"))
        document.getElementById("valid_username").style.display = "block";
      else {
        document.getElementById("valid_username").style.display = "none";
        if (username.value != "")
          check_username = 1;
        if (check_username == 1 && check_email == 1 && check_password == 1)
          document.getElementById("signup_button").disabled = false;
      }
    }

  };

  xhr.open("GET", "unique_username.php?name=" + escape(username.value), true);
  xhr.send(null);

}
