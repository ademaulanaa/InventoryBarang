<?php
    // Pastikan file controller.php tersedia dan berisi kelas oop dengan metode selectBetween()
    include 'controller.php';

    // Membuat objek dari kelas oop
    $dos = new oop();

    // Memeriksa apakah tombol pencarian telah ditekan
    if (isset($_POST['carie'])) {
        // Mendefinisikan parameter pencarian
        $whereparam = "tanggal_masuk";
        $dot = $_POST['dateAwal'];
        $dot1 = $_POST['dateAkhir'];

        // Memanggil metode selectBetween() dari objek $dos
        $dataB = $dos->selectBetween("detailbarang", $whereparam, $dot, $dot1);
    }
?>

<div class="panel panel-default">
    <div class="panel-heading main-color-bg">
        <div class="panel-title">Laporan Barang</div>
    </div>
    <div class="panel-body">
        <form method="post">
            <div class="row">
                <div class="col-sm-4">
                    <label for="#">Dari Tanggal</label>
                    <input class="form-control" type="date" placeholder="Select Date" name="dateAwal" required>    
                </div>
                <div class="col-sm-4">
                    <label for="#">Ke Tanggal</label>
                    <input class="form-control" type="date" placeholder="Select Date" name="dateAkhir" required>    
                </div>
            </div>
            <br>
            <button class="btn" name="carie"><i class="fa fa-search"></i> Cari</button>
            <a href="?menu=lap_pertanggal" class="btn">Reload</a>
        </form>

        <!-- Menampilkan hasil pencarian dalam tabel -->
        <table class="table table-striped table-hover" id="sampleTable">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Distributor</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Keterangan</th>
                    <th>Tgl Masuk</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Memeriksa apakah data hasil pencarian tersedia
                if (isset($dataB['data']) && count($dataB['data']) > 0) {
                    foreach ($dataB['data'] as $doss) { ?>
                        <tr>
                            <td><?php echo $doss['kd_barang'] ?></td>
                            <td><?php echo $doss['nama_barang'] ?></td>
                            <td><?= $doss['nama_distributor'] ?></td>
                            <td><?php echo "Rp." . number_format($doss['harga_barang']) ?></td>
                            <td><?php echo $doss['stok_barang'] ?></td>
                            <td><?= $doss['keterangan'] ?></td>
                            <td><?= $doss['tanggal_masuk'] ?></td>
                        </tr>
                    <?php }
                } else { ?>
                    <!-- Menampilkan pesan jika tidak ada data yang ditemukan -->
                    <tr>
                        <td colspan="7">Tidak ada barang</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
