
@extends('supplier.layout')

@section('title', 'Profil Supplier')

@section('heading', 'Profil Supplier')

@section('subtitle', 'Perbarui foto, informasi usaha, dan detail akun supplier.')

@push('styles')
    <style>
        .profile-page {
            display: grid;
            gap: 20px;
        }

        .profile-hero {
            position: relative;
            display: flex;
            align-items: center;
            gap: 22px;
            padding: 28px;
            background: linear-gradient(120deg, #fff 0%, #fff8f8 100%);
            border: 1px solid #e6e9ef;
            border-radius: 22px;
            box-shadow: 0 8px 28px #18223008;
            overflow: hidden;
        }

        .profile-hero:after {
            content: "";
            position: absolute;
            width: 190px;
            height: 190px;
            right: -70px;
            top: -90px;
            border-radius: 50%;
            background: #a91d2a0b;
            pointer-events: none;
        }

        .profile-photo {
            width: 104px;
            height: 104px;
            flex: 0 0 104px;
            border-radius: 24px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff1f2;
            color: #a91d2a;
            font-size: 34px;
            font-weight: 800;
            border: 4px solid #fff;
            box-shadow: 0 5px 18px #18223012;
        }

        .profile-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .profile-hero-copy {
            min-width: 0;
            flex: 1;
            position: relative;
            z-index: 1;
        }

        .profile-eyebrow {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.4px;
            color: #a91d2a;
            text-transform: uppercase;
        }

        .profile-hero h2 {
            font-size: 22px;
            line-height: 1.3;
            color: #202938;
            margin: 5px 0;
        }

        .profile-hero p {
            font-size: 13px;
            color: #667085;
            margin: 0 0 14px;
        }

        .photo-input {
            display: block;
            width: 100%;
            max-width: 390px;
            padding: 9px;
            background: #fff;
            border: 1px solid #e1e5ec;
            border-radius: 12px;
            font-size: 13px;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .profile-card {
            padding: 24px;
            background: #fff;
            border: 1px solid #e6e9ef;
            border-radius: 20px;
            box-shadow: 0 5px 20px #18223007;
            min-width: 0;
        }

        .profile-card-heading {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 22px;
        }

        .profile-card-icon {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: #fff1f2;
            color: #a91d2a;
            font-size: 19px;
        }

        .profile-card-heading h3 {
            font-size: 17px;
            color: #202938;
            margin: 0;
        }

        .profile-card-heading p {
            font-size: 12px;
            color: #667085;
            margin: 2px 0 0;
        }

        .profile-fields {
            display: grid;
            gap: 18px;
        }

        .profile-field label {
            display: block;
            margin-bottom: 7px;
            font-size: 13px;
            font-weight: 700;
            color: #344054;
        }

        .profile-field input,
        .profile-field textarea,
        .role-value {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #dfe4ec;
            border-radius: 12px;
            background: #fff;
            color: #202938;
            font: 400 14px Inter, sans-serif;
            transition: border-color .2s, box-shadow .2s;
        }

        .profile-field input:focus,
        .profile-field textarea:focus {
            outline: none;
            border-color: #b72b39;
            box-shadow: 0 0 0 4px #a91d2a12;
        }

        .profile-field textarea {
            resize: vertical;
            min-height: 112px;
        }

        .profile-field input[type=file] {
            padding: 8px;
            font-size: 12px;
        }

        .profile-field small {
            display: block;
            margin-top: 6px;
            color: #b42332;
            font-size: 12px;
        }

        .role-value {
            background: #f8f9fb;
            color: #667085;
        }

        .profile-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            padding: 20px 24px;
            background: #fff;
            border: 1px solid #e6e9ef;
            border-radius: 20px;
        }

        .profile-hint {
            margin: 0;
            color: #667085;
            font-size: 13px;
        }

        .profile-action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .profile-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 44px;
            padding: 10px 18px;
            border: 1px solid #dfe4ec;
            border-radius: 12px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: transform .2s, background .2s;
        }

        .profile-button:hover {
            transform: translateY(-1px);
        }

        .profile-button-secondary {
            background: #fff;
            color: #344054;
        }

        .profile-button-primary {
            background: #a91d2a;
            border-color: #a91d2a;
            color: #fff;
            box-shadow: 0 5px 12px #a91d2a22;
        }

        .profile-button-primary:hover {
            background: #8f1824;
        }

        .profile-alert {
            padding: 14px 16px;
            border-radius: 14px;
            font-size: 13px;
        }

        .profile-alert ul {
            padding-left: 20px;
            margin: 6px 0 0;
        }

        .profile-alert-success {
            background: #effaf3;
            border: 1px solid #b8e5c8;
            color: #17663a;
        }

        .profile-alert-error {
            background: #fff1f2;
            border: 1px solid #fecdd3;
            color: #9f1239;
        }

        @media (max-width: 850px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }

            .profile-hero {
                align-items: flex-start;
            }
        }

        @media (max-width: 520px) {
            .profile-hero {
                padding: 20px;
                flex-direction: column;
                gap: 15px;
            }

            .profile-photo {
                width: 88px;
                height: 88px;
                flex-basis: 88px;
                border-radius: 20px;
            }

            .profile-hero h2 {
                font-size: 19px;
            }

            .profile-card {
                padding: 19px;
            }

            .profile-actions {
                padding: 18px;
            }

            .profile-action-buttons {
                width: 100%;
            }

            .profile-button {
                flex: 1;
            }
        }
    </style>
@endpush

@section('content')
    @if (session('success'))
        <div class="profile-alert profile-alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="profile-alert profile-alert-error">
            <strong>Profil belum berhasil disimpan.</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($supplier)
        <form
            class="profile-page"
            action="{{ route('supplier.profil.update') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            <section class="profile-hero">
                <div class="profile-photo">
                    @if ($user->profile_photo_path)
                        <img
                            src="{{ asset('storage/' . $user->profile_photo_path) }}"
                            alt="Foto profil {{ $user->name }}"
                            onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"
                        >

                        <span class="avatar-fallback" style="display:none">
                            {{ mb_strtoupper(mb_substr(trim($user->name), 0, 1)) }}
                        </span>
                    @else
                        <span class="avatar-fallback">
                            {{ mb_strtoupper(mb_substr(trim($user->name), 0, 1)) }}
                        </span>
                    @endif
                </div>

                <div class="profile-hero-copy">
                    <span class="profile-eyebrow">Pengaturan akun</span>

                    <h2>{{ $user->name }}</h2>

                    <p>
                        Gunakan foto yang jelas agar akun supplier mudah dikenali.
                        JPG, JPEG, PNG, atau WEBP, maksimal 2 MB.
                    </p>

                    <input
                        class="photo-input"
                        type="file"
                        name="profile_photo"
                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                    >

                    @error('profile_photo')
                        <small style="display:block;color:#b42332;margin-top:6px">
                            {{ $message }}
                        </small>
                    @enderror
                </div>
            </section>

            <div class="profile-grid">
                <section class="profile-card">
                    <div class="profile-card-heading">
                        <span class="profile-card-icon">▤</span>

                        <div>
                            <h3>Data Supplier</h3>
                            <p>Informasi usaha dan kontak untuk pengiriman bahan.</p>
                        </div>
                    </div>

                    <div class="profile-fields">
                        <div class="profile-field">
                            <label for="nama_supplier">Nama Supplier</label>

                            <input
                                id="nama_supplier"
                                type="text"
                                name="nama_supplier"
                                value="{{ old('nama_supplier', $supplier->nama_supplier) }}"
                                required
                                maxlength="255"
                                autocomplete="organization"
                            >

                            @error('nama_supplier')
                                <small>{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="profile-field">
                            <label for="kontak">Nomor Kontak</label>

                            <input
                                id="kontak"
                                type="text"
                                name="kontak"
                                value="{{ old('kontak', $supplier->kontak) }}"
                                maxlength="255"
                                autocomplete="tel"
                                placeholder="Masukkan nomor telepon aktif"
                            >

                            @error('kontak')
                                <small>{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="profile-field">
                            <label for="alamat">Alamat Supplier</label>

                            <textarea
                                id="alamat"
                                name="alamat"
                                rows="4"
                                maxlength="1000"
                                autocomplete="street-address"
                                placeholder="Masukkan alamat lengkap supplier"
                            >{{ old('alamat', $supplier->alamat) }}</textarea>

                            @error('alamat')
                                <small>{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </section>

                <section class="profile-card">
                    <div class="profile-card-heading">
                        <span class="profile-card-icon">♙</span>

                        <div>
                            <h3>Akun Login</h3>
                            <p>Informasi akun yang digunakan untuk masuk ke BakeChain.</p>
                        </div>
                    </div>

                    <div class="profile-fields">
                        <div class="profile-field">
                            <label for="name">Nama Akun</label>

                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                required
                                maxlength="255"
                                autocomplete="name"
                            >

                            @error('name')
                                <small>{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="profile-field">
                            <label for="email">Email</label>

                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                required
                                maxlength="255"
                                autocomplete="email"
                            >

                            @error('email')
                                <small>{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="profile-field">
                            <label for="role">Role</label>

                            <div class="role-value" id="role">
                                {{ $user->roleLabel() }}
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="profile-actions">
                <p class="profile-hint">
                    Periksa kembali data sebelum menyimpan perubahan.
                </p>

                <div class="profile-action-buttons">
                    <a
                        class="profile-button profile-button-secondary"
                        href="{{ route('supplier.dashboard') }}"
                    >
                        Batal
                    </a>

                    <button
                        class="profile-button profile-button-primary"
                        type="submit"
                    >
                        Simpan Perubahan
                        <span aria-hidden="true">→</span>
                    </button>
                </div>
            </div>
        </form>
    @else
        <div class="profile-card">
            <div class="profile-card-heading">
                <span class="profile-card-icon">!</span>

                <div>
                    <h3>Data supplier belum terhubung</h3>
                    <p>Akun kamu belum ditautkan ke data supplier.</p>
                </div>
            </div>

            <p>
                Hubungi Admin atau Pemilik UMKM untuk menghubungkan akun
                dengan data supplier.
            </p>
        </div>
    @endif
@endsection
