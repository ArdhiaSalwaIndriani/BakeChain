
@extends('pemilik.layout')

@section('title', 'Profil Saya')
@section('heading', 'Profil Saya')
@section('subtitle', 'Perbarui informasi pemilik usaha.')

@section('content')
<style>
.profile-page {
    max-width: 760px;
    color: #302727;
}

.profile-card {
    background: #FFFFFF;
    border: 1px solid #EFDADA;
    border-radius: 0;
    margin-bottom: 20px;
    box-shadow: 0 6px 20px rgba(93, 0, 0, 0.05);
    overflow: hidden;
}

.profile-card-head {
    padding: 20px;
    border-bottom: 1px solid #F1E1E1;
    background: #FFFAFA;
}

.profile-card-head h2 {
    font-size: 17px;
    color: #8C0000;
    margin-bottom: 5px;
    font-weight: 600;
}

.profile-card-head p {
    font-size: 12px;
    color: #777777;
    margin: 0;
}

.profile-body {
    padding: 22px;
}

.profile-hero {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 25px;
    padding-bottom: 20px;
    border-bottom: 1px solid #E8E4E4;
}

.profile-avatar {
    width: 58px;
    height: 58px;
    flex-shrink: 0;
    background: #B60000;
    color: #FFFFFF;
    border: 1px solid #8C0000;
    border-radius: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    font-weight: 600;
}

.profile-hero strong {
    font-size: 14px;
    color: #302727;
}

.profile-hero p {
    font-size: 11px;
    color: #777777;
    margin-top: 5px;
    margin-bottom: 0;
}

.field {
    margin-bottom: 18px;
}

.field label {
    display: block;
    font-size: 12px;
    font-weight: 500;
    color: #302727;
    margin-bottom: 7px;
}

.field input {
    width: 100%;
    box-sizing: border-box;
    padding: 11px 12px;
    border: 1px solid #D5D0D0;
    border-radius: 0;
    background: #FFFFFF;
    color: #302727;
    font: 12px 'Inter', sans-serif;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.field input:focus {
    outline: none;
    border-color: #D40000;
    box-shadow: 0 0 0 2px rgba(212, 0, 0, 0.10);
}

.btn-save {
    display: inline-block;
    padding: 11px 18px;
    background: #B60000;
    color: #FFFFFF;
    border: 1px solid #B60000;
    border-radius: 0;
    font: 12px 'Inter', sans-serif;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.2s, border-color 0.2s;
}

.btn-save:hover {
    background: #8C0000;
    border-color: #8C0000;
}

.notice {
    padding: 12px 14px;
    margin-bottom: 18px;
    font-size: 12px;
    line-height: 1.6;
    background: #F2F8F1;
    color: #28652B;
    border: 1px solid #D9E5D8;
    border-left: 3px solid #28652B;
    border-radius: 0;
}

.error {
    font-size: 11px;
    color: #B60000;
    margin-top: 5px;
    margin-bottom: 0;
}

@media (max-width: 600px) {
    .profile-body {
        padding: 16px;
    }

    .profile-card-head {
        padding: 16px;
    }

    .btn-save {
        width: 100%;
    }
}
</style>

<div class="profile-page">
    <div class="profile-card">
        <div class="profile-card-head">
            <h2>Informasi Profil</h2>
            <p>Kelola informasi dasar akun Pemilik UMKM BakeChain.</p>
        </div>

        <div class="profile-body">
            @if(session('success'))
                <div class="notice">
                    {{ session('success') }}
                </div>
            @endif

            <div class="profile-hero">
                <div class="profile-avatar">
                    {{ strtoupper(substr($nama, 0, 1)) }}
                </div>

                <div>
                    <strong>{{ $nama }}</strong>
                    <p>Pemilik UMKM</p>
                </div>
            </div>

            <form action="{{ route('pemilik.profil.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="field">
                    <label for="nama">Nama Lengkap</label>
                    <input
                        id="nama"
                        name="nama"
                        type="text"
                        value="{{ old('nama', $nama) }}"
                        required
                        maxlength="100"
                    >
                    @error('nama')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label for="email">Alamat Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email', $email) }}"
                        required
                        maxlength="150"
                    >
                    @error('email')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <button class="btn-save" type="submit">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
