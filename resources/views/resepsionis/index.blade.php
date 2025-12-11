<x-template title="RSHP - Dashboard">
 <div class="page-container">
        <div class="page-header">
            <h1>REGISTRASI</h1>
            <p>Silahkan melakukan registrasi.</p>
        </div>

        <div class="nav-grid">
        <a href="{{ route('resepsionis.pasien.index') }}" class="nav-card">
            <h3>Registrasi</h3>
            <p>Kelola data pasien.</p>
        </a>
        <div class="nav-grid">
        <a href="{{ route('resepsionis.pet.index') }}" class="nav-card">
            <h3>Data Hewan</h3>
            <p>Kelola data hewan.</p>
        </a>
        <div class="nav-grid">