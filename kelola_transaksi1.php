<?php
include 'controller.php';
$dos = new oop();
$datat = $dos->select("transaksi_terbaru");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $dataDetail = $dos->edit("view_transaksi", "kd_transaksi", $id);
    $dataD = $dos->edit("table_transaksi", "kd_transaksi", $id);
    $total = $dos->selectSumWhere("transaksi", "sub_total", "kd_transaksi='$id'");
    $jumlah_barang = $dos->selectSumWhere("transaksi", "jumlah", "kd_transaksi='$id'");
}
?>
<div class="panel panel-default">
    <div class="panel-heading main-color-bg">
        <div class="panel-title">Laporan Penjualan</div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-9">
                <?php if (isset($_GET['id'])): ?>
                    <h4>Struk</h4>
                    <p>Inventory Me</p>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">Kode Transaksi : <?php echo htmlspecialchars($id); ?></div>
                        <div class="col-sm-6">
                            <p class="text-right"><span><?php echo "Tanggal Cetak : " . date("Y-m-d"); ?></span></p>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered" width="80%">
                        <thead>
                            <tr>
                                <th>Kode Antrian</th>
                                <th>Nama Barang</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah</th>
                                <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dataDetail as $dd): ?>
                                <tr>
                                    <td><?= htmlspecialchars($dd['kd_pretransaksi']); ?></td>
                                    <td><?= htmlspecialchars($dd['nama_barang']); ?></td>
                                    <td><?= htmlspecialchars($dd['harga_barang']); ?></td>
                                    <td><?= htmlspecialchars($dd['jumlah']); ?></td>
                                    <td><?= "Rp." . number_format($dd['sub_total']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="2"></td>
                                <td>Jumlah Pembelian</td>
                                <td><?php echo htmlspecialchars($jumlah_barang['sum']); ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td colspan="2">Total</td>
                                <td><?= "Rp." . number_format($total['sum']); ?></td>
                            </tr>
                            <?php foreach ($dataD as $bos): ?>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2">Bayar</td>
                                    <td><?= "Rp." . number_format($bos['bayar']); ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2">Kembalian</td>
                                    <td><?= "Rp." . number_format($bos['kembalian']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <p>Tanggal Beli : <?php echo htmlspecialchars($dd['tanggal_beli']); ?></p>
                    <br>
                    <a target="output" class="btn btn-primary" href="printstruk.php?id=<?php echo htmlspecialchars($id); ?>">Print</a>
                <?php endif; ?>
                <?php if (!isset($_GET['id'])): ?>
                    <h4>Data Semua Transaksi</h4>
                    <p><b><i>Inventory ME</i></b></p>
                    <hr>
                    <p class="text-right"><?php echo "Tanggal Cetak : " . date("Y-m-d"); ?></p>
                    <table class="table table-hover table-bordered" width="100%;" align="center">
                        <thead>
                            <tr>
                                <th>Kode Transaksi</th>
                                <th>Jumlah Beli</th>
                                <th>Total Harga</th>
                                <th>Tanggal Beli</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($datat as $dts): ?>
                                <tr>
                                    <td><?= htmlspecialchars($dts['kd_transaksi']); ?></td>
                                    <td><?= htmlspecialchars($dts['jumlah_beli']); ?></td>
                                    <td><?= "Rp." . number_format($dts['total_harga']) . ",-"; ?></td>
                                    <td><?= htmlspecialchars($dts['tanggal_beli']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php 
                            $grand = $dos->selectSum("transaksi", "sub_total");
                            ?>
                            <tr>
                                <td colspan="2"></td>
                                <td>Grand Total</td>
                                <td><?php echo "Rp." . number_format($grand['sum']) . ",-"; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="printtransaksi.php" target="output" type="submit" class="btn btn-primary">Print</a>
                <?php endif; ?>
            </div>
            <!-- Mencari Data Transaksi  -->
            <div class="col-sm-3">
                <div class="tile">
                    <h4>Cari Transaksi</h4>
                    <hr>
                    <form method="post">
                        <div class="form-group">
                            <a class="btn btn-primary btn-block" href="#modaldos" data-toggle="modal">Pilih Barang</a>
                        </div>
                        <a href="?menu=kelola_transaksi" class="btn btn-danger btn-block"><i class="fa fa-repeat"></i> Reload</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pilih Transaksi -->
<div class="modal fade bd-example-modal-lg" id="modaldos">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Pilih Transaksi</h3>
            </div>
            <div class="modal-body modal-lg">
                <table class="table table-hover table-bordered" id="sampleTable" width="100%;" align="center">
                    <thead>
                        <tr>
                            <th>Kode Transaksi</th>
                            <th>Nama Penjual</th>
                            <th>Jumlah Beli</th>
                            <th>Total Harga</th>
                            <th>Tanggal Beli</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($datat as $key): ?>
                            <tr>
                                <td><a href="admin.php?menu=datstruk&id=<?php echo htmlspecialchars($key['kd_transaksi']); ?>"><?php echo htmlspecialchars($key['kd_transaksi']); ?></a></td>
                                <td><?= htmlspecialchars($key['nama_user']); ?></td>
                                <td><?= htmlspecialchars($key['jumlah_beli']); ?></td>
                                <td><?= "Rp." . number_format($key['total_harga']); ?></td>
                                <td><?= htmlspecialchars($key['tanggal_beli']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
