<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Login - DebugTIK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-slate-900 border border-slate-800 p-8 rounded-2xl shadow-xl space-y-6">
        <div class="text-center space-y-2">
            <div class="w-12 h-12 bg-indigo-600 rounded-xl mx-auto flex items-center justify-center font-bold text-xl text-white shadow-lg shadow-indigo-500/30">SA</div>
            <h1 class="text-xl font-bold">Super Admin Portal</h1>
            <p class="text-xs text-slate-400">Masuk untuk mengelola akun guru</p>
        </div>

        @if($errors->any())
            <div class="p-3 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400 text-xs text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Email</label>
                <input type="email" name="email" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-sm text-white focus:outline-none focus:border-indigo-500" value="{{ old('email') }}">
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-800 text-sm text-white focus:outline-none focus:border-indigo-500">
            </div>
            <button type="submit" class="w-full py-3 rounded-xl bg-indigo-600 hover:bg-indigo-500 font-semibold text-sm text-white transition shadow-lg shadow-indigo-600/30">
                Masuk sebagai Admin
            </button>
        </form>
    </div>
</body>
</html>
