@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Pemilik Dashboard') }}</div>

                <div class="card-body">
                    <p>Selamat datang, <strong>{{ session('user_name') }}</strong>! Anda login sebagai <strong>{{ session('user_role_name') }}</strong>.</p>
                    <hr>

                    <div class="mt-4">
                        <h5>Data Hewan Peliharaan Anda</h5>
                        @if($pets->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nama Hewan</th>
                                            <th>Ras</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Tanggal Lahir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pets as $pet)
                                            <tr>
                                                <td>{{ $pet->nama_pet }}</td>
                                                <td>{{ $pet->ras->nama_ras ?? 'N/A' }}</td>
                                                <td>{{ $pet->jenis_kelamin }}</td>
                                                <td>{{ $pet->tanggal_lahir }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">Anda belum memiliki data hewan peliharaan yang terdaftar.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection