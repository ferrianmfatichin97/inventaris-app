<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Inventaris</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .image-placeholder {
            width: 100%;
            height: 180px;
            background-color: #eee;
            background-image: url('https://via.placeholder.com/600x300?text=Asset+Image');
            background-position: center;
            background-repeat: no-repeat;
            background-size: contain;
            border-radius: 10px;
        }

        .label {
            font-size: 0.85rem;
            color: #6c757d;
            font-weight: 600;
        }

        .value {
            font-size: 1rem;
            color: #212529;
        }
    </style>
</head>
<body class="bg-white">
    <div class="container py-3">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="fw-semibold">Asset Bank DP Taspen</div>
            <img src="https://bankdptaspen.co.id/wp-content/uploads/2024/01/Logo-Bank-DP-Taspen-Version-New.png" alt="Logo" class="img-fluid" style="height: 25px;">
        </div>

        <div class="image-placeholder mb-4">    Image Asset</div>

        <div class="card shadow-sm border-0">
            <div class="card-body">

                <h5 class="fw-bold mb-3">{{ $data->inv_nama }}</h5>

                <div class="row g-3">
                    <div class="col-6">
                        <div class="label">No Rekening</div>
                        <div class="value">{{ $data->inv_rekening }}</div>
                    </div>
                    <div class="col-6">
                        <div class="label">Serial Number</div>
                        <div class="value"><p>{{ $data->inv_seri }}</p></div>
                    </div>
                    <div class="col-6">
                        <div class="label">Department</div>
                        <div class="value">
                            @switch($data->inv_kantor)
                                @case('00') KP. Manajemen @break
                                @case('01') KP. Operasional @break
                                @case('02') KC. Bogor @break
                                @case('03') KC. Depok @break
                                @case('04') KC. Tangerang @break
                                @case('05') KC. Jakarta Timur @break
                                @case('06') KC. Karawang @break
                                @case('07') KC. Cikarang @break
                                @case('08') KC. Purwokerto @break
                                @default -
                            @endswitch
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="label">Lokasi Barang</div>
                        <div class="value">-</div>
                    </div>
                    <div class="col-6">
                        <div class="label">Tanggal Perolehan</div>
                        <div class="value">{{ \Carbon\Carbon::parse($data->inv_peroleh_tanggal)->translatedFormat('d F Y') }}</div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</body>
</html>
