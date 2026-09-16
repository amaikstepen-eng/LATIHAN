<?php
// Data pesawat: kode => [nama, harga per kelas]
$dataPesawat = [
    'GRD' => [
        'nama'  => 'Garuda',
        'harga' => ['Eksekutif' => 1500000, 'Bisnis' => 900000, 'Ekonomi' => 500000],
    ],
    'MPT' => [
        'nama'  => 'Merpati',
        'harga' => ['Eksekutif' => 1200000, 'Bisnis' => 800000, 'Ekonomi' => 400000],
    ],
    'BTV' => [
        'nama'  => 'Batavia',
        'harga' => ['Eksekutif' => 1000000, 'Bisnis' => 700000, 'Ekonomi' => 300000],
    ],
];

$hasilSimpan = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan'])) {
    $nama        = trim($_POST['nama'] ?? '');
    $kodePesawat = $_POST['kode_pesawat'] ?? '';
    $kelas       = $_POST['kelas'] ?? '';
    $jumlahTiket = (int)($_POST['jumlah_tiket'] ?? 0);

    if ($nama !== '' && isset($dataPesawat[$kodePesawat]) && isset($dataPesawat[$kodePesawat]['harga'][$kelas]) && $jumlahTiket > 0) {
        $namaPesawat = $dataPesawat[$kodePesawat]['nama'];
        $hargaTiket  = $dataPesawat[$kodePesawat]['harga'][$kelas];
        $totalBayar  = $hargaTiket * $jumlahTiket;

        $hasilSimpan = [
            'nama'         => $nama,
            'kode_pesawat' => $kodePesawat,
            'nama_pesawat' => $namaPesawat,
            'kelas'        => $kelas,
            'jumlah_tiket' => $jumlahTiket,
            'harga_tiket'  => $hargaTiket,
            'total_bayar'  => $totalBayar,
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tiket Online Jakarta - Malaysia</title>
</head>
<body>

<h3>TIKET ONLINE JAKARTA - MALAYSIA</h3>

<form method="POST" action="">
    <table>
        <tr>
            <td>Nama</td>
            <td><input type="text" name="nama" required
                value="<?php echo htmlspecialchars($_POST['nama'] ?? ''); ?>"></td>
        </tr>
        <tr>
            <td>Pilih Kode Pesawat</td>
            <td>
                <select name="kode_pesawat" required>
                    <option value="">-- pilih --</option>
                    <?php foreach ($dataPesawat as $kode => $d): ?>
                        <option value="<?php echo $kode; ?>"
                            <?php echo (($_POST['kode_pesawat'] ?? '') === $kode) ? 'selected' : ''; ?>>
                            <?php echo $kode; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Pilih Kelas</td>
            <td>
                <?php foreach (['Eksekutif', 'Bisnis', 'Ekonomi'] as $k): ?>
                    <input type="radio" name="kelas" value="<?php echo $k; ?>"
                        <?php echo (($_POST['kelas'] ?? 'Eksekutif') === $k) ? 'checked' : ''; ?>>
                    <?php echo $k; ?><br>
                <?php endforeach; ?>
            </td>
        </tr>
        <tr>
            <td>Jumlah Tiket</td>
            <td>
                <select name="jumlah_tiket">
                    <?php for ($i = 1; $i <= 10; $i++): ?>
                        <option value="<?php echo $i; ?>"
                            <?php echo (($_POST['jumlah_tiket'] ?? '2') == $i) ? 'selected' : ''; ?>>
                            <?php echo $i; ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </td>
        </tr>
    </table>
    <br>
    <button type="submit" name="simpan" value="1">SIMPAN</button>
    <button type="reset">BATAL</button>
</form>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan']) && !$hasilSimpan): ?>
    <p style="color:red;">Data belum lengkap, silakan isi semua field.</p>
<?php endif; ?>

<?php if ($hasilSimpan): ?>
<hr>
<h4>Hasil</h4>
<table border="1" cellpadding="5">
    <tr><td>Nama</td><td><?php echo htmlspecialchars($hasilSimpan['nama']); ?></td></tr>
    <tr><td>Kode Pesawat</td><td><?php echo $hasilSimpan['kode_pesawat']; ?></td></tr>
    <tr><td>Nama Pesawat</td><td><?php echo $hasilSimpan['nama_pesawat']; ?></td></tr>
    <tr><td>Kelas</td><td><?php echo $hasilSimpan['kelas']; ?></td></tr>
    <tr><td>Jumlah Tiket</td><td><?php echo $hasilSimpan['jumlah_tiket']; ?></td></tr>
    <tr><td>Harga Tiket</td><td>Rp <?php echo number_format($hasilSimpan['harga_tiket'], 0, ',', '.'); ?></td></tr>
    <tr><td><b>Total Bayar</b></td><td><b>Rp <?php echo number_format($hasilSimpan['total_bayar'], 0, ',', '.'); ?></b></td></tr>
</table>
<?php endif; ?>

</body>
</html>
