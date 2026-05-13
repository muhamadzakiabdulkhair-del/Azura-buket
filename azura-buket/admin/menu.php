<?php
if(isset($_GET['menu'])){
    $menu = $_GET['menu'] ?? 'dashboard';;
} else {
    $menu = "";
}

if($menu == "produk"){
    include "produk.php";
}
else if($menu == "staf"){
    include "staf.php";
}
else if($menu == "edit_produk"){
    include "edit_produk.php";
}
else if($menu == "tambah_produk"){
    include "tambah_produk.php";
}
else if($menu == "tambah_staf"){
    include "tambah_staf.php";
}
else if($menu == "edit_staf"){
    include "edit_staf.php";
}
else if($menu == "laporan_pembelian"){
    include "laporan_pembelian.php";
}
else if($menu == "laporan_penjualan"){
    include "laporan_penjualan.php";
}
else if($menu == "laporan_produk"){
    include "laporan_produk.php";
}
else if($menu == "pesanan"){
    include "pesanan.php";
}
else if($menu == "detail_pesanan"){
    include "detail_pesanan.php";
}
else{
    include "home.php";
}
?>
