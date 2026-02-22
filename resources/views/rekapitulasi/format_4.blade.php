<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Format 5 - Register Ibu Hamil</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact;
        }

        .header-section {
            text-align: center;
            margin-bottom: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .meta-info {
            margin-bottom: 10px;
            font-size: 11px;
            width: 100%;
        }
        
        .meta-info table {
            border: none;
            width: 60%;
            margin: 0 auto;
        }
        
        .meta-info td {
            border: none;
            padding: 1px;
            text-align: left;
        }

        table.main-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        table.main-table th, 
        table.main-table td {
            border: 1px solid #000;
            padding: 2px;
            text-align: center;
            vertical-align: middle;
            font-size: 9px;
            overflow: hidden;
        }

        table.main-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        /* --- PERBAIKAN ROTASI TEKS --- */
        /* Menggunakan div wrapper untuk rotasi sempurna -90 derajat */
        .th-vertical {
            height: 110px; /* Tinggi header dimaksimalkan untuk teks panjang */
            vertical-align: bottom; /* Agar teks mulai dari bawah */
            padding-bottom: 5px;
            position: relative;
        }

        .vertical-text {
            transform: rotate(-90deg); /* Putar 90 derajat ke kiri */
            transform-origin: center;
            display: inline-block;
            white-space: nowrap;
            width: 20px; /* Lebar sempit agar tidak memakan tempat horizontal */
            /* Trik centering setelah rotasi */
            margin-bottom: 15px; 
        }

        /* Kelas khusus untuk mengatur lebar kolom */
        .col-no { width: 20px; }
        .col-nama { width: 100px; text-align: left !important; padding-left: 4px !important; }
        .col-umur { width: 25px; }
        .col-dasa { width: 25px; }
        .col-date { width: 35px; }
        .col-check { width: 20px; }
        .col-bulan { width: 16px; }

        /* Styling baris nomor */
        .row-number th {
            font-size: 8px;
            background-color: #ddd;
            height: 15px;
            vertical-align: middle;
            padding: 0;
        }

        .data-row td {
            height: 20px;
        }
    </style>
</head>
<body>

    <div class="header-section">
        FORMAT - 4 : REGISTER IBU HAMIL DALAM WILAYAH KERJA POSYANDU<br>
        JANUARI S.D DESEMBER {{ $tahun  }}
    </div>

    <div class="meta-info">
        <table>
            <tr>
                <td width="100">POSYANDU</td>
                <td>: {{ $posyandu }}</td>
            </tr>
            <tr>
                <td>DESA/KEL</td>
                <td>: {{ $kelurahan }}</td>
            </tr>
            <tr>
                <td>KECAMATAN</td>
                <td>: {{ $kecamatan }}</td>
            </tr>
            <tr>
                <td>KAB/KODYA</td>
                <td>: Cimahi</td>
            </tr>
        </table>
    </div>

    <table class="main-table">
        <thead>
            <tr>
                <th rowspan="3" class="col-no">NO</th>
                <th rowspan="3" class="col-nama">NAMA<br>IBU HAMIL</th>
                
                <th rowspan="3" class="col-umur th-vertical">
                    <div class="vertical-text">UMUR</div>
                </th>
                <th rowspan="3" class="col-dasa th-vertical">
                    <div class="vertical-text">KELOMPOK DASA WISMA</div>
                </th>
                
                <th colspan="2">PENDAF<br>TARAN</th>
                
                <th rowspan="3" class="col-umur th-vertical">
                    <div class="vertical-text">HAMIL KE</div>
                </th>
                
                <th colspan="3">PIL TAMBAH<br>DARAH</th>
                <th colspan="2">IMUNI<br>SASI TT</th>
                
                <th rowspan="3" class="col-check th-vertical">
                    <div class="vertical-text">KAPSUL YODIUM</div>
                </th>
                
                <th colspan="12">HASIL PENIMBANGAN</th>
                
                <th rowspan="3" class="col-check th-vertical">
                    <div class="vertical-text">RESIKO</div>
                </th>
                
                <th colspan="3">MELAHIRKAN</th>
                <th colspan="4">BAYI</th>
                
                <th rowspan="3" class="col-check">IBU<br>ME<br>NING<br>GAL</th>
            </tr>

            <tr>
                <th rowspan="2" class="col-date">TGL</th>
                <th rowspan="2" class="col-umur">UK<br>(bln)</th>
                
                <th rowspan="2" class="col-check">I</th>
                <th rowspan="2" class="col-check">II</th>
                <th rowspan="2" class="col-check">III</th>

                <th rowspan="2" class="col-check">I</th>
                <th rowspan="2" class="col-check">II</th>

                <th rowspan="2" class="col-bulan">J</th>
                <th rowspan="2" class="col-bulan">F</th>
                <th rowspan="2" class="col-bulan">M</th>
                <th rowspan="2" class="col-bulan">A</th>
                <th rowspan="2" class="col-bulan">M</th>
                <th rowspan="2" class="col-bulan">J</th>
                <th rowspan="2" class="col-bulan">J</th>
                <th rowspan="2" class="col-bulan">A</th>
                <th rowspan="2" class="col-bulan">S</th>
                <th rowspan="2" class="col-bulan">O</th>
                <th rowspan="2" class="col-bulan">N</th>
                <th rowspan="2" class="col-bulan">D</th>

                <th rowspan="2" class="col-date">TGL</th>
                <th colspan="2">DITOLONG<br>OLEH</th>

                <th colspan="3">HIDUP</th>
                <th rowspan="2" class="col-check">MA<br>TI</th>
            </tr>

            <tr>
                <th class="col-check">NA<br>KES</th>
                <th class="col-check">DU<br>KUN</th>
                
                <th class="col-check">&lt;2kg</th>
                <th class="col-check">2-<br>2,5</th>
                <th class="col-check">&gt;2,5</th>
             </tr>

             <tr class="row-number">
                 <th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th>
                 <th>11</th><th>12</th><th>13</th><th>14</th><th>15</th><th>16</th><th>17</th><th>18</th><th>19</th><th>20</th>
                 <th>21</th><th>22</th><th>23</th><th>24</th><th>25</th><th>26</th><th>27</th><th>28</th><th>29</th><th>30</th>
                 <th>31</th><th>32</th><th>33</th><th>34</th>
             </tr>
        </thead>
        <tbody>
            <tr class="data-row">
                <td>1</td>
                <td class="col-nama">Silvia</td>
                <td>22</td>
                <td>Binangkit</td>
                <td>10/1</td>
                <td>6</td>
                <td>1</td>
                <td>v</td>
                <td></td>
                <td></td>
                <td>v</td>
                <td></td>
                <td>v</td>
                <td>45</td><td>46</td><td>47</td><td>48</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                <td></td> 
                <td>23/4</td>
                <td>v</td>
                <td></td>
                <td></td>
                <td></td>
                <td>v</td>
                <td></td>
                <td></td>
            </tr>

            <tr class="data-row">
                <td>2</td>
                <td class="col-nama">Intan</td>
                <td>25</td>
                <td>Mawar</td>
                <td>12/1</td>
                <td>8</td>
                <td>2</td>
                <td>v</td>
                <td>v</td>
                <td></td>
                <td></td>
                <td>v</td>
                <td></td>
                <td>50</td><td>51</td><td>52</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                <td>v</td>
                <td>15/3</td>
                <td>v</td>
                <td></td>
                <td></td>
                <td></td>
                <td>v</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            
             <tr class="data-row">
                <td>3</td>
                <td class="col-nama">Ika P.</td>
                <td>28</td>
                <td>Melati</td>
                <td>5/2</td>
                <td>5</td>
                <td>3</td>
                <td>v</td>
                <td></td>
                <td></td>
                <td>v</td>
                <td></td>
                <td>v</td>
                <td></td><td>55</td><td>56</td><td>57</td><td>58</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr class="data-row"><td>4</td><td class="col-nama"></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr class="data-row"><td>5</td><td class="col-nama"></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr class="data-row"><td>6</td><td class="col-nama"></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr class="data-row"><td>7</td><td class="col-nama"></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr class="data-row"><td>8</td><td class="col-nama"></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>

        </tbody>
    </table>

</body>
</html>