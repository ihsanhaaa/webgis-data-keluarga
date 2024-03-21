const menuMobileOpen = document.getElementById("menu-mobile-open");
const menuMobileClose = document.getElementById("menu-mobile-close");
const menuMobile = document.getElementById("menu-mobile");

menuMobileOpen.addEventListener("click", () => {
  menuMobile.classList.toggle("menu-opened");
});

menuMobileClose.addEventListener("click", () => {
  menuMobile.classList.toggle("menu-opened");
});

new DataTable('#example', {
  ajax: '../list-data-keluarga/arrays.txt'
});

<td>
        <a href="<?=base_url('admin/barang/tambah?id='.$row['barang_id'].'&status=1')?>"
        class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
        <button class="btn btn-danger btn-sm" onClick="hapus(<?=$row['barang_id']?>)">
        <i class="fa fa-trash"></i></button>
</td>