<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export PDF</title>
    <style>
        p{
        font-size:18px;
        }
        table {
        border-collapse: collapse; 
        position:absolute;
        min-width:10px;
        font-size:18px; 
        }
        /* Zebra striping */
        tr:nth-of-type(odd) {
        background: #eee; 
        }
        th { 
        background: #333; 
        color: white; 
        font-weight: bold;
        }
        td, th { 
        padding: 6px; 
        border: 1px solid #ccc; 
        
        }
        .data{
            text-align: center; 
        }
        .text-center{
            text-align:center;
        }
        .text-left{
            text-align:left;
        }
        .table0{
            margin-top:10px;
        }
        .table1{
            margin-top:1px;
            margin-left:441px;
        }
    </style>
</head>
<body>
    <div class="text-center">
        <h2>Laporan Bulanan Pelayana KB</h2>
        <h3>Desa Lokasari</h3>
    </div>
    <div class="text-left">
        <p>Kabupaten    : Karangasem</p>
        <p>Bulan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:{{$keterangan_laporan}}</p>
    </div>

    <div class="text-center">
        <table class="table0">
            <thead>
                <tr>
                    <th rowspan="2" class="data">No </th>
                    <th rowspan="2">Nama Dusun</th>
                    <th colspan="2" class="data">Peserta KB Baru</th>
                    <th rowspan="2" class="data">Total MKJP + NON MKJP</th>
                </tr>
                <tr>
                    <th class="data">MKJP</th>
                    <th class="data">NON MKJP</th>
                </tr>
            </thead>
            <tbody>
            @foreach($laporanK as $laporanK)
            @if($laporanK['nama_dusun'] != "Luar Desa Lokasari")
                <tr>
                    <td class="data">{{$loop->iteration}}</td>
                    <td>{{$laporanK['nama_dusun']}}</td>
                    <td class="data">{{$laporanK['MKJP']}}</td>
                    <td class="data">{{$laporanK['NON_MKJP']}}</td>
                    <td class="data">{{$laporanK['MKJP']+$laporanK['NON_MKJP']}}</td>
                </tr>
            @endif
            @endforeach
                <tr>
                    <td colspan="2" class="data">TOTAL</td>
                    <td class="data">{{$jmlhKB_baru_mkjp}}</td>
                    <td class="data">{{$jmlhKB_baru_nonmkjp}}</td>
                    <td class="data">{{$jmlhKB_baru_mkjp+$jmlhKB_baru_nonmkjp}}</td>
                </tr>
            </tbody>
        </table>

        <table class="table1">
            <thead>
                <tr>
                    <th colspan="2" class="data">Peserta KB Aktif</th>
                    <th rowspan="2" class="data">Total MKJP + NON MKJP</th>
                </tr>
                <tr>
                    <th class="data">MKJP</th>
                    <th class="data">NON MKJP</th>
                </tr>
            </thead>
            <tbody>
            @foreach($laporanL as $laporanL)
            @if($laporanL['nama_dusun'] != "Luar Desa Lokasari")
                <tr>
                    <td class="data">{{$laporanL['MKJP']}}</td>
                    <td class="data">{{$laporanL['NON_MKJP']}}</td>
                    <td class="data">{{$laporanL['MKJP']+$laporanL['NON_MKJP']}}</td>
                </tr>
            @endif
            @endforeach
                <tr>
                    <td class="data">{{$jmlhKB_lama_mkjp}}</td>
                    <td class="data">{{$jmlhKB_lama_nonmkjp}}</td>
                    <td class="data">{{$jmlhKB_lama_mkjp+$jmlhKB_lama_nonmkjp}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>




