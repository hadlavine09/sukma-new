<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tunggu Verifikasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <section class="py-5">
        <div class="container py-5 text-center">
            <div class="alert alert-danger">
                <h2>Verifikasi Ditolak</h2>
            <p>Maaf, data toko Anda <strong>tidak diizinkan</strong> oleh admin.</p>
            <p>Silakan periksa kembali informasi atau hubungi admin untuk keterangan lebih lanjut.</p>
        </div>
        <a href="{{ route('verifikasitoko') }}" class="btn btn-warning">Ubah Data & Ajukan Ulang</a>
    </div>
</section>
</body>

</html>
