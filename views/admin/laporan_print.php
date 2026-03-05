<!DOCTYPE html>
<html>
<head>
    <title>Laporan Peminjaman Buku</title>
    <style>
        body { font-family: sans-serif; padding: 30px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .footer { margin-top: 50px; text-align: right; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h2>LAPORAN PEMINJAMAN BUKU</h2>
        <h3>Perpustakaan Digital Sekolah</h3>
        <p>Dicetak pada: <?php echo date('d-m-Y H:i'); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Anggota</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
$no = 1;
foreach ($transactions as $t):
?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $t['nama']; ?></td>
                    <td><?php echo $t['judul']; ?></td>
                    <td><?php echo $t['tanggal_pinjam']; ?></td>
                    <td><?php echo $t['tanggal_kembali'] ? $t['tanggal_kembali'] : '-'; ?></td>
                    <td><?php echo ucfirst($t['status']); ?></td>
                </tr>
            <?php
endforeach; ?>
        </tbody>
    </table>

    <div class="footer">
         <p>Petugas Perpustakaan,</p>
         <br><br><br>
         <p><strong>( ________________ )</strong></p>
    </div>
</body>
</html>
