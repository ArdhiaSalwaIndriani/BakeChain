
@extends('pemilik.layout')

@section('title', 'Pengaturan Akun')
@section('heading', 'Pengaturan Akun')
@section('subtitle', 'Atur keamanan akun pemilik.')

@section('content')
<style>
.settings-page {
    max-width: 760px;
    color: #302727;
}

.settings-card {
    background: #FFFFFF;
    border: 1px solid #EFDADA;
    border-radius: 0;
    box-shadow: 0 6px 20px rgba(93, 0, 0, 0.05);
    overflow: hidden;
}

.settings-head {
    padding: 20px;
    border-bottom: 1px solid #F1E1E1;
    background: #FFFAFA;
}

.settings-head h2 {
    font-size: 17px;
    color: #8C0000;
    margin-bottom: 5px;
    font-weight: 600;
}

.settings-head p {
    font-size: 12px;
    color: #777777;
    margin: 0;
}

.settings-body {
    padding: 22px;
}

.field {
    margin-bottom: 19px;
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
    background: #F9F7FA;
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

.security-note {
    background: #FFF5F5;
    border: 1px solid #F1DADA;
    border-left: 3px solid #B60000;
    border-radius: 0;
    padding: 13px;
    margin-bottom: 20px;
    font-size: 11px;
    line-height: 1.7;
    color: #665B5B;
}

@media (max-width: 600px) {
    .settings-body {
        padding: 16px;
    }

    .settings-head {
        padding: 16px;
    }

    .btn-save {
        width: 100%;
    }
}
</style>

<div class="settings-page">
    <div class="settings-card">
        <div class="settings-head">
            <h2>Keamanan Akun</h2>
            <p>Perbarui password untuk menjaga keamanan akunmu.</p>
        </div>

        <div class="settings-body">
            @if(session('success'))
                <div class="notice">
                    {{ session('success') }}
                </div>
            @endif

            <div class="security-note">
                Gunakan password minimal 8 karakter. Jangan bagikan password
                akunmu kepada orang lain.
            </div>

            <form action="{{ route('pemilik.pengaturan.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="field">
                    <label for="password_lama">Password Saat Ini</label>
                    <input
                        id="password_lama"
                        name="password_lama"
                        type="password"
                        required
                        autocomplete="current-password"
                    >
                    @error('password_lama')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label for="password_baru">Password Baru</label>
                    <input
                        id="password_baru"
                        name="password_baru"
                        type="password"
                        required
                        minlength="8"
                        autocomplete="new-password"
                    >
                    @error('password_baru')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label for="password_baru_confirmation">
                        Konfirmasi Password Baru
                    </label>
                    <input
                        id="password_baru_confirmation"
                        name="password_baru_confirmation"
                        type="password"
                        required
                        minlength="8"
                        autocomplete="new-password"
                    >
                </div>

                <button class="btn-save" type="submit">
                    Ubah Password
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
