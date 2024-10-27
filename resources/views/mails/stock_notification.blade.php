<!DOCTYPE html>
<html>

<head>
    <title>STOK {{ $jenis }}!!!!</title>
</head>

<body>
    <h1>Stok {{ $jenis }} pada : {{ $productName }}</h1>
    @if ($jenis == 'Baru')
        <p>Kini {{ $productName }} terdapat penambahan stok dan tersedia sebanyak {{ $jumlah }} stok </p>
    @else
        <p>Mohon maaf, stok pada {{ $productName }} telah habis.. </p>
    @endif
</body>

</html>
