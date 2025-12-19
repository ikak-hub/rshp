<!-- Ini Home
<a href="/">rooot</a> -->

@props(['title'=>'null'])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @vite('resources/css/app2.css')
</head>
<body>
    <x-nv/>
    <div class="upper"></div>
    {{ $slot }}
</body>
     <!-- Ini untuk menampilkan konten dari komponen lain -- Jangan hapus -->
</html>