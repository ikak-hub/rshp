<x-teemplate title="Struktur Organisasi - RSHP Unair">

    <div class="table-container">
        <div class="header-section">
            <div class="header-logos">
                <img src="http://localhost/rshp/img/rshp.jpg" alt="Logo RSHP" class="logo">
                <div class="header-title">
                    STRUKTUR PIMPINAN<br>
                    RUMAH SAKIT HEWAN PENDIDIKAN<br>
                    UNIVERSITAS AIRLANGGA
                </div>
                <img src="http://localhost/rshp/img/uner.png" alt="Logo Unair" class="logo">
            </div>
        </div>
        <table class="org-table">
            <tr>
                <td colspan="2">
                    <div class="director-section">
                        <div class="director-title">DIREKTUR</div>
                        <img src="https://unair.ac.id/wp-content/uploads/2024/04/Direktur-RSHP.webp" class="profile-photo">
                        <div class="name">Dr. Ira Sari Yudaniayanti, M.P., drh.</div>
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    <div class="wakdir-section">
                        <div class="wakdir-title">WAKIL DIREKTUR 1</div>
                        <div class="wakdir-subtitle">PELAYANAN MEDIS, PENDIDIKAN DAN PENELITIAN</div>
                        <img src="https://cybercampus.unair.ac.id/foto_pegawai/196805051997021001.JPG" alt="Dr. Nusdianto Triakoso" class="wakdir-photo">
                        <div class="name">Dr. Nusdianto Triakoso, M.P., drh.</div>
                    </div>
                </td>
                <td>
                    <div class="wakdir-section">
                        <div class="wakdir-title">WAKIL DIREKTUR 2</div>
                        <div class="wakdir-subtitle">SUMBER DAYA MANUSIA, SARANA PRASARANA DAN KEUANGAN</div>
                        <img src="https://cybercampus.unair.ac.id/foto_pegawai/197602222015043201-1625241368.JPG" alt="Dr. Miyayu Soneta S." class="wakdir-photo">
                        <div class="name">Dr. Miyayu Soneta S., M.Vet., drh.</div>
                    </div>
                </td>
            </tr>
        </table>
        <div class="smart-services">
            S M A R T &nbsp;&nbsp; S E R V I C E S
        </div>
    </div>
    <div class="footer-top">
        <div class="footer-top-left">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSstffxwrpwFBBgo7-0naVJIo__D6FFNifshw&s" alt="Hewan RSHP" class="dog-img">
            <p class="slogan">
                sayangi <br>
                hewan kesayangan anda <br>
                dengan periksa rutin
            </p>
            <h2>Rumah Sakit Hewan Pendidikan</h2>
        </div>
        <div class="footer-top-right">
            <img src="https://rshp.unair.ac.id/wp-content/uploads/2021/10/zona-integritas-unair.png" alt="Zona Integritas" class="integritas-logo">
        </div>
    </div>

    <div class="footer-bottom">
        <p>Copyright 2024 Universitas Airlangga. All Rights Reserved</p>
        <div class="footer-contact">
            <h3>RUMAH SAKIT HEWAN PENDIDIKAN</h3>
            <p>GEDUNG RS HEWAN PENDIDIKAN</p>
            <p>rshp@fkh.unair.ac.id</p>
            <p>Telp : 031 5927832</p>
            <p>Kampus C Universitas Airlangga</p>
            <p>Surabaya 60115, Jawa Timur</p>
        </div>
    </div>

    <footer>
    <p>&copy; Copyright 2024 Universitas Airlangga. All Rights Reserved</p>
    </footer>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.navbar{ /* List table header Struktur dkk*/
    display: flex;
    gap: 20px;
    padding: 10px;
    list-style: none;
    margin: 0;
    align-items: right;
    justify-content: right;
    text-align: right;
    width: 100%;
}

div nav{
    background-color: #2980b9; /* Warna biru yang lebih gelap */
    overflow: hidden;
    position: fixed; /* Membuat navbar tetap di atas saat di-scroll */
    top: 0;
    width: 100%;
    font-family: Arial, sans-serif;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    justify-content: right;
}

.table-container {
    max-width: 800px;
    margin: 0 auto;
    background-color: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.org-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

.org-table td {
    padding: 1rem;
    text-align: center;
    vertical-align: top;
}

/* Director Section */
.director-section {
    background-color: #ecf0f1;
    border-radius: 10px;
    padding: 1.5rem;
}

.director-title {
    font-weight: bold;
    font-size: 1.1rem;
    margin-bottom: 1rem;
    color: #2c3e50;
}

/* Wakil Direktur Sections */
.wakdir-section {
    background-color: #f8f9fa;
    border-radius: 10px;
    padding: 1rem;
    margin: 0 0.5rem;
}

.wakdir-title {
    font-weight: bold;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    color: #2c3e50;
}

.wakdir-subtitle {
    font-size: 0.8rem;
    color: #34495e;
    margin-bottom: 1rem;
    line-height: 1.3;
}

/* Photo Styles */
.profile-photo {
    width: 120px;
    height: 150px;
    object-fit: cover;
    border-radius: 8px;
    margin: 1rem 0;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.wakdir-photo {
    width: 100px;
    height: 125px;
    object-fit: cover;
    border-radius: 8px;
    margin: 1rem 0;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Name Styles */
.name {
    font-weight: bold;
    color: #2c3e50;
    margin-top: 0.5rem;
}

/* Smart Services Footer */
.smart-services {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    text-align: center;
    padding: 1rem;
    margin-top: 2rem;
    border-radius: 10px;
    font-size: 1.5rem;
    font-weight: bold;
    letter-spacing: 3px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.header-section {
    text-align: center;
    margin-bottom: 2rem;
}

.header-logos {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.logo {
    width: 80px;
    height: 80px;
    border-radius: 50%;
}

.header-title {
    font-size: 1.2rem;
    font-weight: bold;
    color: #2c3e50;
    line-height: 1.4;
}
.footer-top {
    background-color: #f4a62a; /* kuning */
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 40px;
}

.dog-img {
    width: 200px;
    display: block;
    margin: 0 auto;
}

.slogan {
    font-weight: bold;
    text-align: center;
    color: white;
    margin-top: 10px;
    font-size: 18px;
}

.footer-top-left h2 {
    text-align: center;
    font-family: serif;
    font-size: 20px;
    color: #fff;
    margin-top: 5px;
}

.integritas-logo {
    width: 200px;
}

.footer-bottom {
    background-color: #3b3b3b; /* abu tua */
    color: white;
    display: flex;
    justify-content: space-between;
    padding: 20px 40px;
    flex-wrap: wrap;
}

.footer-contact {
    text-align: left;
    max-width: 300px;
}

.footer-contact h3 {
    font-size: 16px;
    margin-bottom: 8px;
}
</style>
</x-teemplate>