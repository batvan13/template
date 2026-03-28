<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin · Вход</title>
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

        h1 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 1.75rem;
            text-align: center;
        }

        label {
            display: block;
            font-size: .8rem;
            font-weight: 500;
            color: #475569;
            margin-bottom: .35rem;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: .6rem .75rem;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: .95rem;
            color: #0f172a;
            outline: none;
            transition: border-color .15s;
        }

        input:focus { border-color: #6366f1; }

        .field { margin-bottom: 1.1rem; }

        .error-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 6px;
            color: #b91c1c;
            font-size: .85rem;
            padding: .6rem .75rem;
            margin-bottom: 1.1rem;
        }

        .field-error {
            color: #b91c1c;
            font-size: .8rem;
            margin-top: .3rem;
        }

        button[type="submit"] {
            width: 100%;
            padding: .65rem;
            background: #6366f1;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: .95rem;
            font-weight: 500;
            cursor: pointer;
            transition: background .15s;
            margin-top: .25rem;
        }

        button[type="submit"]:hover { background: #4f46e5; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Admin Panel</h1>

        @if ($errors->any())
            <div class="error-box">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
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
                @error('email')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label for="password">Парола</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    autocomplete="current-password"
                >
            </div>

            <button type="submit">Вход</button>
        </form>

        <p style="text-align:center;margin-top:1.1rem;font-size:.85rem;color:#64748b;">
            <a href="{{ route('admin.password.request') }}" style="color:#6366f1;text-decoration:none;">
                Забравена парола?
            </a>
        </p>
    </div>
</body>
</html>
