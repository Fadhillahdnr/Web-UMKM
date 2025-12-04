<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User - Super Admin UMKM Makanan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .navbar { background: #E91E63; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
        .navbar a { color: white; text-decoration: none; margin-right: 20px; }
        .navbar a:hover { text-decoration: underline; }
        .container { max-width: 600px; margin: 30px auto; padding: 0 20px; }
        h1 { color: #333; margin-bottom: 30px; }
        .form-container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; color: #555; font-weight: bold; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; font-family: Arial, sans-serif; }
        input:focus, select:focus { outline: none; border-color: #E91E63; }
        .btn { padding: 10px 20px; border-radius: 4px; text-decoration: none; cursor: pointer; border: none; font-size: 16px; }
        .btn-primary { background: #E91E63; color: white; }
        .btn-primary:hover { background: #7b1fa2; }
        .btn-secondary { background: #666; color: white; }
        .btn-secondary:hover { background: #555; }
        .error { color: red; font-size: 12px; margin-top: 5px; }
        .back-link { color: #E91E63; text-decoration: none; display: inline-block; margin-bottom: 20px; }
        .back-link:hover { text-decoration: underline; }
        .logout-btn { background: #f44336; padding: 8px 15px; border-radius: 4px; color: white; cursor: pointer; border: none; }
    </style>
</head>
<body>
    <div class="navbar">
        <div>
            <h2>UMKM Makanan - Super Admin</h2>
        </div>
        <div>
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('super_admin.users.index') }}">Kelola User</a>
            <span>{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        <a href="{{ route('super_admin.users.index') }}" class="back-link">← Kembali ke User</a>
        
        <div class="form-container">
            <h1>Tambah User Baru</h1>
            
            <form method="POST" action="{{ route('super_admin.users.store') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>

                <div class="form-group">
                    <label for="role_id">Role</label>
                    <select id="role_id" name="role_id" required>
                        <option value="">-- Pilih Role --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan User</button>
                <a href="{{ route('super_admin.users.index') }}" class="btn btn-secondary" style="margin-left: 10px;">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>
