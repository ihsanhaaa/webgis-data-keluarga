var nama = document.getElementById("nama");
var email = document.getElementById("email");
var password = document.getElementById("password");
var konfirmasi = document.getElementById("konfirmasi");
var daftar = document.getElementById("daftar");

daftar.addEventListener("click", function() {
  if (nama.value == "") {
    alert("Nama tidak boleh kosong");
    return false;
  }
  if (email.value == "") {
    alert("Email tidak boleh kosong");
    return false;
  }
  if (password.value == "") {
    alert("Password tidak boleh kosong");
    return false;
  }
  if (konfirmasi.value == "") {
    alert("Konfirmasi password tidak boleh kosong");
    return false;
  }
  if (password.value != konfirmasi.value) {
    alert("Password dan konfirmasi password tidak sama");
    return false;
  }
  alert("Data berhasil dikirim");
});