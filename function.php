<?php

$conn = mysqli_connect("localhost", "root", "", "stockbarang");

//menambah barang baru

if (isset($_POST['addnewbarang'])) {
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    //soal gambar
    $allowed_extension = array('png', 'jpg');
    $nama = $_FILES['file']['name']; //ngambil nama file gambar
    $dot = explode('.', $nama);
    $ekstensi = strtolower(end($dot));
    $ukuran = $_FILES['file']['size'];
    $file_tmp = $_FILES['file']['tmp_name'];

    //penamaan file 
    $image = md5(uniqid($nama, true) . time()) . '.' . $ekstensi; //menggabungkan nama file dengan nama
    if (in_array($ekstensi, $allowed_extension) === true) {
        if ($ukuran < 15000000) {
            move_uploaded_file($file_tmp, 'images/' . $image);
            $addtotable = mysqli_query($conn, "insert into stock (namabarang, deskripsi, stock, image ) values ('$namabarang', '$deskripsi', '$stock', '$image')");

            if ($addtotable) {
                header('location: index.php');
            } else {
                echo 'gagal';
                header('location: index.php');
            }
        } else {
            // kalau lebih dari 15 mb
            echo '
                <script>
                    alert("gambar kebesaran");
                    window.location.href="keluar.php";
                </script>';
        }
    } else {
        //kalau tidak support
        echo '
                <script>
                    alert("File harus png/jpg");
                    window.location.href="index.php";
                </script>';
    }
};

if (isset($_POST['barangmasuk'])) {
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang = '$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang + $qty;

    $addautomasuk = mysqli_query($conn, "insert into masuk (idbarang, keterangan, qty) values ('$barangnya', '$penerima', '$qty')");
    $updatestockmasuk = mysqli_query($conn, "update stock set stock = '$tambahkanstocksekarangdenganquantity' where idbarang = '$barangnya'");
    if ($addautomasuk && $updatestockmasuk) {
        header('location: masuk.php');
    } else {
        echo 'gagal';
        header('location: masuk.php');
    }
}
//menambah barang keluar
if (isset($_POST['addbarangkeluar'])) {
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang = '$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    if ($stocksekarang >= $qty) {
        // kalau barangnya cukup
        $tambahkanstocksekarangdenganquantity = $stocksekarang - $qty;

        $addautomasuk = mysqli_query($conn, "insert into keluar (idbarang, penerima, qty) values ('$barangnya', '$penerima', '$qty')");
        $updatestockmasuk = mysqli_query($conn, "update stock set stock = '$tambahkanstocksekarangdenganquantity' where idbarang = '$barangnya'");
        if ($addautomasuk && $updatestockmasuk) {
            header('location: keluar.php');
        } else {
            echo 'gagal';
            header('location: keluar.php');
        }
    } else {
        echo '
                <script>
                    alert("Stock saat ini tidak mencukupi");
                    window.location.href="keluar.php";
                </script>';
    }
}

//update barang
if (isset($_POST['updatebarang'])) {
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];

    //soal gambar
    $allowed_extension = array('png', 'jpg');
    $nama = $_FILES['file']['name']; //ngambil nama file gambar
    $dot = explode('.', $nama);
    $ekstensi = strtolower(end($dot));
    $ukuran = $_FILES['file']['size'];
    $file_tmp = $_FILES['file']['tmp_name'];

    //penamaan file 
    $image = md5(uniqid($nama, true) . time()) . '.' . $ekstensi; //menggabungkan nama file dengan nama

    if ($ukuran == 0) {
        //jika tidak ingin diupload
        $update = mysqli_query($conn, "update stock set namabarang='$namabarang', deskripsi= '$deskripsi' where idbarang = '$idb'");
        if ($update) {
            header('location: index.php');
        } else {
            echo 'gagal';
            header('location: index.php');
        }
    }else {
        //jika ingin upload
        move_uploaded_file($file_tmp, 'images/' . $image);
        $update = mysqli_query($conn, "update stock set namabarang='$namabarang', deskripsi= '$deskripsi', image ='$image'  where idbarang = '$idb'");
        if ($update) {
            header('location: index.php');
        } else {
            echo 'gagal';
            header('location: index.php');
        }
    }
}

//menhapus barang dari stock
if (isset($_POST['hapusbarang'])) {
    $idb = $_POST['idb'];

    $gambar = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $get = mysqli_fetch_array($gambar);
    $img = 'images/'.$get['image'];
    unlink($img);

    $hapus = mysqli_query($conn, "delete from stock  where idbarang = '$idb'");
    if ($hapus) {
        header('location: index.php');
    } else {
        echo 'gagal';
        header('location: index.php');
    }
};
//mengubah barang masuk
if (isset($_POST['updatebarangmasuk'])) {
    $idb  = $_POST['idb'];
    $idm  = $_POST['idm'];
    $keterangan = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "select * from stock where idbarang = '$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($conn, "select * from masuk where idmasuk = '$idm'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if ($qty > $qtyskrg) {
        $selisih = $qty - $qtyskrg;
        $kurangin = $stockskrg + $selisih;
        $kurangistock = mysqli_query($conn, "update stock set stock = '$kurangin' where idbarang ='$idb' ");
        $updatenya = mysqli_query($conn, "update masuk set qty = '$qty', keterangan = '$keterangan' where idmasuk = '$idm'");

        if ($kurangistock && $updatenya) {
            header('location: masuk.php');
        } else {
            echo 'gagal';
            header('location: masuk.php');
        }
    } else {
        $selisih = $qtyskrg - $qty;
        $kurangin = $stockskrg - $selisih;
        $kurangistock = mysqli_query($conn, "update stock set stock = '$kurangin' where idbarang = '$idb'");
        $updatenya = mysqli_query($conn, "update masuk set qty = '$qty', keterangan = '$keterangan' where idm = '$idm'");
        if ($kurangistock && $updatenya) {
            header('location: masuk.php');
        } else {
            echo 'gagal';
            header('location: masuk.php');
        }
    }
}

//hapus barang masuk
if (isset($_POST['hapusbarangmasuk'])) {
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];
    $getdatastock = mysqli_query($conn, "select * from stock where idbarang = '$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock - $qty;
    $update = mysqli_query($conn, "update stock set stock= '$selisih' where idbarang = '$idb' ");
    $hapusdata = mysqli_query($conn, "delete from masuk where idmasuk ='$idm'");
    if ($update && $hapusdata) {
        header('location: masuk.php');
    } else {
        echo 'gagal';
        header('location: masuk.php');
    }
}

//menambah barang keluar
if (isset($_POST['updatebarangkeluar'])) {
    $idb  = $_POST['idb'];
    $idk  = $_POST['idk'];

    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "select * from stock where idbarang = '$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($conn, "select * from keluar where idkeluar = '$idk'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if ($qty > $qtyskrg) {
        $selisih = $qty - $qtyskrg;
        $kurangin = $stockskrg - $selisih;
        $kurangistock = mysqli_query($conn, "update stock set stock = '$kurangin' where idbarang ='$idb' ");
        $updatenya = mysqli_query($conn, "update keluar set qty = '$qty', penerima = '$penerima' where idkeluar = '$idk'");

        if ($kurangistock && $updatenya) {
            header('location: keluar.php');
        } else {
            echo 'gagal';
            header('location: keluar.php');
        }
    } else {
        $selisih = $qtyskrg - $qty;
        $kurangin = $stockskrg + $selisih;
        $kurangistock = mysqli_query($conn, "update stock set stock = '$kurangin' where idbarang = '$idb'");
        $updatenya = mysqli_query($conn, "update keluar set qty = '$qty', penerima = '$penerima' where idkeluar = '$idk'");
        if ($kurangistock && $updatenya) {
            header('location: keluar.php');
        } else {
            echo 'gagal';
            header('location: keluar.php');
        }
    }
}

//hapus barang keluar
if (isset($_POST['hapusbarangkeluar'])) {
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idk = $_POST['idk'];
    $getdatastock = mysqli_query($conn, "select * from stock where idbarang = '$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock + $qty;
    $update = mysqli_query($conn, "update stock set stock= '$selisih' where idbarang = '$idb' ");
    $hapusdata = mysqli_query($conn, "delete from keluar where idkeluar ='$idk'");
    if ($update && $hapusdata) {
        header('location: keluar.php');
    } else {
        echo 'gagal';
        header('location: keluar.php');
    }
}
//menambah admin baru 
if (isset($_POST['addnewadmin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $queryinsert = mysqli_query($conn, "insert into login (email,password) values ('$email','$password')");
    if ($queryinsert) {
        header('location: admin.php');
    } else {
        header('locaton: admin.php');
    }
}
if (isset($_POST['updateadmin'])) {
    $emailbaru = $_POST['emailadmin'];
    $passwordbaru = $_POST['passwordbaru'];
    $idnya = $_POST['id'];

    $queryupdate = mysqli_query($conn, "update login set email='$emailbaru' , password='$passwordbaru' where iduser= '$idnya'");
    if ($queryupdate) {
        header('location: admin.php');
    } else {
        header('locaton: admin.php');
    }
}

//hapus admin
if (isset($_POST['hapusadmin'])) {
    $id = $_POST['id'];

    $querydelete = mysqli_query($conn, "delete from login where iduser='$id'");
    if ($querydelete) {
        header('location: admin.php');
    } else {
        header('locaton: admin.php');
    }
}


//meninjam barang
if (isset($_POST['pinjam'])) {
    $idbarang = $_POST['barangnya'];
    $qty = $_POST['qty'];
    $penerima = $_POST['penerima'];

    //ambil stock
    $stock_saat_ini = mysqli_query($conn, "select * from stock where idbarang = '$idbarang'");
    $stocknya = mysqli_fetch_array($stock_saat_ini);
    $stock = $stocknya ['stock'];

    //kurangin stocknya 
    $new_stock = $stock - $qty;


    $insertpinjam = mysqli_query($conn,"insert into peminjaman (idbarang, qty, peminjam) values ('$idbarang','$qty','$penerima')");

    //mengurangi stock ditable stock
    $kurangistock = mysqli_query($conn, "update stock set stock ='$new_stock' where idbarang = '$idbarang'");
    // var_dump($insertpinjam && $kurangistock);die;
    if ($insertpinjam && $kurangistock) {
        echo '
        <script>
            alert("berhasil");
            window.location.href="peminjaman.php";
        </script>';
    }else {
        echo '
                <script>
                    alert("Gagal");
                    window.location.href="peminjaman.php";
                </script>';
    }
}

if (isset($_POST['barangkembali'])) {
    $idpinjam = $_POST ['idpinjam'];
    $idbarang = $_POST ['idbarang'];

    //eksekusi
    $updatestatus = mysqli_query($conn,"update peminjaman set status= 'Kembali' where idpeminjaman = '$idpinjam' ");

    //ambil stock sekarang 
    $stock_saat_ini = mysqli_query($conn, "select * from stock where idbarang = '$idbarang'");
    $stocknya = mysqli_fetch_array($stock_saat_ini);
    $stock = $stocknya ['stock'];

    //ambil qty dari idpeminjam stocknya 
    $stock_saat_ini1 = mysqli_query($conn, "select * from peminjaman where idpeminjaman = '$idpinjam'");
    $stocknya1 = mysqli_fetch_array($stock_saat_ini1);
    $stock1 = $stocknya1 ['qty'];

    $new_stock = $stock1 + $stock;

    //kembalikan stock
    $kembalikanstock = mysqli_query($conn, "update stock set stock = '$new_stock' where idbarang='$idbarang' ");
    //kurangin stocknya 
    
    // var_dump($updatestatus && $kembalikanstock);die;
    if ($updatestatus && $kembalikanstock) {
        echo '
        <script>
            alert("berhasil");
            window.location.href="peminjaman.php";
        </script>';
    }else {
        echo '
                <script>
                    alert("Gagal");
                    window.location.href="peminjaman.php";
                </script>';
    }
}