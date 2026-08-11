<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Entrar — Administração CNRCA</title>
    <meta name="robots" content="noindex, nofollow">
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>
<body class="d-flex align-items-center min-vh-100" style="background: var(--color-surface);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-11 col-sm-7 col-md-5 col-lg-4">
                <div class="bg-white border p-4 p-lg-5" style="border-color: var(--color-border);">
                    <div class="eyebrow">CNRCA</div>
                    <h1 class="h4 mb-4">Acesso administrativo</h1>

                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.login.submit') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label small">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="{{ old('email') }}" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label small">Palavra-passe</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <div class="form-check mb-4">
                            <input type="checkbox" name="remember" id="remember" class="form-check-input">
                            <label for="remember" class="form-check-label small">Manter sessão iniciada</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
