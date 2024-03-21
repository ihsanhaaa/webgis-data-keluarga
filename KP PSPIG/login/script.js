var email = document.getElementById("email");
var password = document.getElementById("password");
var login = document.getElementById("login");

login.addEventListener("click", function() {
  if (email.value == "") {
    alert("Email tidak boleh kosong");
    return false;
  }
  if (password.value == "") {
    alert("Password tidak boleh kosong");
    return false;
  }
  alert("Data berhasil dikirim");
});