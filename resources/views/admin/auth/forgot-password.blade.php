<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Забравена парола · Admin</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: system-ui, -apple-system, sans-serif;
            background: #f1f5f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 24px rgba(0,0,0,.08);
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 380px;
        }
        h1 { font-size: 1.25rem; font-weight: 600; color: #0f172a; margin-bottom: .5rem; text-align: center; }
        .subtitle { font-size: .85rem; color: #64748b; text-align: center; margin-bottom: 1.75rem; line-height: 1.5; }
        label { display: block; font-size: .8rem; font-weight: 500; color: #475569; margin-bottom: .35rem; }
        input[type="email"] {
            width: 100%; padding: .6rem .75rem;
            border: 1px solid #cbd5e1; border-radius: 6px;
            font-size: .95rem; color: #0f172a; outline: none; transition: border-color .15s;
        }
        input:focus { border-color: #6366f1; }
        .field { margin-bottom: 1.1rem; }
        .field-error { color: #b91c1c; font-size: .8rem; margin-top: .3rem; }
        .alert-success {
            background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 6px;
            color: #15803d; font-size: .85rem; padding: .6rem .75rem; margin-bottom: 1.1rem;
        }
        .alert-error {
            background: #fef2f2; border: 1px solid #fecaca; border-radius: 6px;
            color: #b91c1c; font-size: .85rem; padding: .6rem .75rem; margin-bottom: 1.1rem;
        }
        button[type="submit"] {
            width: 100%; padding: .65rem; background: #6366f1; color: #fff;
            border: none; border-radius: 6px; font-size: .95rem; font-weight: 500;
            cursor: pointer; transition: background .15s; margin-top: .25rem;
        }
        button[type="submit"]:hover { background: #4f46e5; }
        .back-link { text-align: center; margin-top: 1.25rem; font-size: .85rem; color: #64748b; }
        .back-link a { color: #6366f1; text-decoration: none; }
        .back-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Забравена парола</h1>
        <p class="subtitle">Въведете имейла си и ще изпратим линк за смяна на паролата.</p>

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.password.email') }}">
            @csrf
            <div class="field">
                <label for="email">Имейл</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="email"
                >
            </div>
            <button type="submit">Изпрати линк</button>
        </form>

        <p class="back-link">
            <a href="{{ route('admin.login') }}">&larr; Обратно към вход</a>
        </p>
    </div>
</body>
</html>
