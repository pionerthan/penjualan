<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
<h2>Daftar Akun Pembeli</h2>
<form method="POST" action="/register">
    @csrf
    <input type="text" name="name" placeholder="Nama" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required><br>
    <button type="submit">Daftar</button>
</form>
<a href="/login">Sudah punya akun? Login</a>
</body>
</html>
