<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - TOKO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <?php 
    function curl(){ 
        $curl = curl_init(); 
        
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => true, 
            CURLOPT_CUSTOMREQUEST => "GET", 
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: random123678abcghi", // Sesuaikan jika key Anda berbeda
            ),
        ));
            
        $output = curl_exec($curl); 	
        curl_close($curl);      
        $data = json_decode($output, true);   
        
        return $data;
    } 
    ?>
    <div class="p-3 pb-md-4 mx-auto text-center">
        <h1 class="display-4 fw-normal text-body-emphasis">Dashboard - TOKO</h1>
        <p class="fs-5 text-body-secondary"><?= date("l, d-m-Y") ?> <span id="jam"></span>:<span id="menit"></span>:<span id="detik"></span></p>
    </div> 
    <hr>

    <div class="table-responsive card m-5 p-5">
    <h3 class="text-center mb-4">Transaksi Pembelian</h3>
    <table class="table text-center">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 10%;">Username</th>
                <th style="width: 25%;">Alamat</th>
                <th style="width: 15%;">Total Harga</th>
                <th style="width: 10%;">Ongkir</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 20%;">Tanggal Transaksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $hasil = curl();
                if(!empty($hasil)){
                    $i = 1; 
                    foreach($hasil as $item){ 
            ?>
                        <tr>
                            <td scope="row" class="text-start"><?= $i++ ?></td>
                            <td><?= $item['username']; ?></td>
                            <td class="text-start"><?= $item['alamat']; ?></td>
                            <td>Rp <?= number_format($item['total_harga'], 0, ',', '.'); ?></td>
                            <td>Rp <?= number_format($item['ongkir'], 0, ',', '.'); ?></td>
                            <td>
                                <?php 
                                if ($item['status'] == 0) {
                                    echo '<span class="badge bg-warning text-dark">Belum Selesai</span>';
                                } else {
                                    echo '<span class="badge bg-success">Selesai</span>';
                                }
                                ?>
                            </td>
                            <td><?= date('d M Y, H:i:s', strtotime($item['created_at'])); ?></td>
                        </tr> 
            <?php
                    } 
                } else {
                    echo '<tr><td colspan="8" class="text-center">Tidak ada data transaksi.</td></tr>';
                }
            ?> 
        </tbody>
    </table>
</div> 

    <script>
        window.setTimeout("waktu()", 1000);
        function waktu() {
            var waktu = new Date();
            var jam = waktu.getHours();
            var menit = waktu.getMinutes();
            var detik = waktu.getSeconds();
            // Tambahkan nol di depan jika angka < 10
            document.getElementById("jam").innerHTML = (jam < 10 ? "0" : "") + jam;
            document.getElementById("menit").innerHTML = (menit < 10 ? "0" : "") + menit;
            document.getElementById("detik").innerHTML = (detik < 10 ? "0" : "") + detik;
            setTimeout("waktu()", 1000);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>