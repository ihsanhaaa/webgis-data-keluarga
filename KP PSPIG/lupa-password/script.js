var email = document.getElementById("email");
var reset = document.getElementById("reset");

reset.addEventListener("click", function() {
  if (email.value == "") {
    alert("Email tidak boleh kosong");
    return false;
  }
  alert("Tautan reset password telah dikirim ke email Anda");
});