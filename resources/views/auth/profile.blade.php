@extends('layouts.app')

@section('content')
<div style="
    max-width: 720px;
    margin: 40px auto;
    background: #fff;
    padding: 28px;
    border-radius: 14px;
    box-shadow: 0 6px 14px rgba(0,0,0,0.08);
    font-family: 'Segoe UI', sans-serif;
">

    <h1 style="margin-bottom: 20px; font-size: 26px;">Profil Saya</h1>

    {{-- Header --}}
    <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 28px;">
        @if ($user->avatar)
            <img src="{{ asset($user->avatar) }}"
                 alt="Avatar"
                 style="width: 110px; height: 110px; border-radius: 12px; object-fit: cover;">
        @else
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D8ABC&color=fff"
                 alt="Avatar"
                 style="width: 110px; height: 110px; border-radius: 12px; object-fit: cover;">
        @endif

        <div>
            <h2 style="margin: 0; font-size: 22px;">{{ $user->name }}</h2>
            <p style="margin: 6px 0 0; color: #555;">{{ $user->email }}</p>
        </div>
    </div>

    <hr style="margin: 25px 0; border-color: #eee;">

    {{-- Informasi Akun --}}
    <h3 style="margin-bottom: 12px; font-size: 20px;">Informasi Akun</h3>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">

        <div>
            <p style="margin: 0; font-weight: 600;">Nama</p>
            <p style="margin: 4px 0 0; color: #444;">{{ $user->name }}</p>
        </div>

        <div>
            <p style="margin: 0; font-weight: 600;">Email</p>
            <p style="margin: 4px 0 0; color: #444;">{{ $user->email }}</p>
        </div>

        <div>
            <p style="margin: 0; font-weight: 600;">Role</p>
            <p style="margin: 4px 0 0; color: #444;">{{ $user->role }}</p>
        </div>

        <div>
            <p style="margin: 0; font-weight: 600;">Tanggal Bergabung</p>
            <p style="margin: 4px 0 0; color: #444;">
                {{ $user->created_at->format('d M Y') }}
            </p>
        </div>

    </div>

    <hr style="margin: 25px 0; border-color: #eee;">

    {{-- Tombol Aksi --}}
    <div style="display: flex; gap: 14px;">
        <a href="#"
           data-bs-toggle="modal" 
           data-bs-target="#editProfileModal"
           style="
                background: #007bff;
                color: #fff;
                padding: 10px 18px;
                border-radius: 10px;
                text-decoration: none;
                font-weight: 600;
           ">
            Edit Profil
        </a>

        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           style="
                background: #dc3545;
                color: #fff;
                padding: 10px 18px;
                border-radius: 10px;
                text-decoration: none;
                font-weight: 600;
           ">
            Logout
        </a>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
    </form>

</div>

{{-- Modal Edit Profil --}}
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content" style="border-radius: 14px;">

            <div class="modal-header">
                <h5 class="modal-title">Edit Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-body" style="padding: 22px;">

                    {{-- Foto Profil --}}
                    <div class="mb-3">
                        <label class="form-label" style="font-weight:600;">Foto Profil</label>
                        <input type="file" name="avatar" class="form-control">

                        @if ($user->avatar)
                            <img src="{{ asset($user->avatar) }}"
                                 style="width:90px;border-radius:10px;margin-top:10px;">
                        @endif
                    </div>

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label class="form-label" style="font-weight:600;">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label class="form-label" style="font-weight:600;">Password Baru (opsional)</label>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak mengubah">
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection
