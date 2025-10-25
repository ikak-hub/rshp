<!-- Ini Home
<a href="/">rooot</a> -->

@props(['title'=>'null'])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
    *, html {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    body { 
        background-color: white;
    }

    nav {
        background-color: #3ea2c7;
        display: flex;
        justify-content: space-between;
        padding: 1rem 2rem;
    }

    nav ul {
        display: flex;
        align-items: center;
        gap: 3rem;
        list-style: none;
    }

    nav div img {
        width: 600px;
    }

    .header-logo {
        display: flex;
        align-items: center;
    }

    .sub-header{
        color: #191919;
        list-style: none;
        background-color: #f7bb17;
        display: flex;
        justify-content: right;
        padding: 10px;
        gap: 1rem;
        margin-top: 2px;
    }

    div li a:hover {
        color:  #fc1111;
        border-bottom: 1px solid  #f7bb17;
    }

    nav ul li a {
        text-decoration: none;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #191919;
        font-size: 16px;
        font-weight: 700;
        padding: 8px 0;
        transition: all;
        transition-duration: 300ms;
        border-bottom: 1px solid  #ffd50000;
    }

    nav ul li a:hover {
        color:  #FFD500;
        border-bottom: 1px solid  #FFD500;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }
    tr {
        height: 100%;
    }

    td { 
        vertical-align: middle;
        text-align: center;
        padding: 20px;
    }

    h3, h4 {
        display: inline-block;
        background-color: #FFD500;
        color: black;
        font-weight: bold;
        font-size: 14px;
        padding: 10px 20px;
        border-radius: 5px;
        text-align: center;
    }
    h3:hover, h4:hover {
        background-color: rgb(169.169.169);
        color: white;
    }

    td:hover {
        background-color: rgb(32, 178, 170);
        color: white;
    }

    h4 {
        display: inline-block;
        background-color: #3EA2C7;
        color: black;
        font-weight: bold;
        font-size: 14px;
        padding: 10px 20px;
        border-radius: 5px;
        text-align: center;
    }

    p {
        font-size: 14px;
        line-height: 1.5;
        margin: 15px 0;
    }

    iframe {
        border: none;
        border-radius: 5px;
    }

    .jam-operasional{
        display: flex;
        justify-content: center;
        margin-bottom: 10px;
        gap: 10px;
    }

    footer {
        background-color:black ; 
        color: white; 
        text-align: center;
        padding: 10px 0; 
        position: relative;
        bottom: 0; 
        width: 100%;
    }
    /* Menghapus margin dan padding default dari browser */
    html, body {
        margin: 0;
        padding: 0;
        height: 100%; /* Penting agar body bisa mengisi seluruh tinggi layar */
    }

    body {
        display: flex; /* Mengaktifkan Flexbox */
        flex-direction: column; /* Mengatur item agar tersusun vertikal (atas ke bawah) */
        min-height: 100vh; /* Tinggi minimal body adalah 100% dari tinggi viewport/layar */
    }

    main {
        flex-grow: 1; /* Bagian paling penting! Ini membuat <main> mengisi semua ruang kosong yang tersedia, sehingga mendorong <footer> ke bawah. */
    }

    footer {
        background-color: #333; /* Contoh warna latar belakang */
        color: white; /* Contoh warna teks */
        text-align: center;
        padding: 15px 0;
        width: 100%; /* Memastikan footer membentang selebar layar */
    }

    /* --- Styling tambahan agar mirip gambar Anda (Opsional) --- */
    .login-container {
        width: 350px;
        margin: 50px auto; /* Membuat form di tengah secara horizontal */
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    </style>
</head>
<body>
    <x-nav/>
    {{ $slot }}
</body>
     <!-- Ini untuk menampilkan konten dari komponen lain -- Jangan hapus -->
</html>