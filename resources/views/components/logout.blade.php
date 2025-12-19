
 @php
    $userRole = session()->get('user_role');
    $dashboard_route = '';

    switch ($userRole) {
            case '1':
                $dashboard_route = '/admin/dashboard';
                break;
            case '2':
                $dashboard_route = '/dokter/dashboard';
                break;
            case '3':
                $dashboard_route = '/perawat/dashboard';
                break;
            case '4':
                $dashboard_route = '/resepsionis/dashboard';
                break;
            default:
                $dashboard_route = '/pemilik/dashboard';
                break;
        }
 @endphp

<header class="navbar p-10">
        <img src="https://rshp.unair.ac.id/wp-content/uploads/2024/06/UNIVERSITAS-AIRLANGGA-scaled.webp" alt="Universitas Airlangga Logo" class="left-logo">
        <nav>
            <ul>
                <li>
                    <form action="/logout" method="post">
                        @csrf

                        <button type="submit" class="btn-dashboard btn-logout">Logout</button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>

