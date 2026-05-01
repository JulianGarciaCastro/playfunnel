<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 | PlayFunnel</title>

    <style>
        :root {
            --ink: #09163f;
            --text: #1d2d59;
            --card: rgba(255, 255, 255, 0.72);
            --line: rgba(9, 22, 63, 0.16);
            --shadow: rgba(8, 20, 56, 0.2);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            color: var(--text);
            font-family: "Open Sans", Arial, sans-serif;
            background-image:
                linear-gradient(145deg, rgba(245, 248, 255, 0.52), rgba(233, 238, 247, 0.68)),
                url('{{ asset('images/errors/gemini-404-bg.png') }}');
            background-size: cover;
            background-position: center;
        }

        .error-card {
            width: min(720px, 100%);
            text-align: center;
            padding: 36px 26px;
            border-radius: 22px;
            background: var(--card);
            border: 1px solid var(--line);
            box-shadow: 0 18px 52px -26px var(--shadow);
            backdrop-filter: blur(5px);
        }

        .logo {
            width: min(300px, 74vw);
            height: auto;
            margin-bottom: 16px;
        }

        h1 {
            margin: 0 0 12px;
            color: var(--ink);
            font-size: clamp(1.75rem, 3.7vw, 2.35rem);
            line-height: 1.15;
            letter-spacing: 0.01em;
        }

        p {
            margin: 0 auto;
            max-width: 560px;
            font-size: clamp(1rem, 2.2vw, 1.12rem);
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <main class="error-card">
        <img class="logo" src="{{ asset('images/SVG/logo-playFunnel.svg') }}" alt="PlayFunnel">
        <h1>404 - Esta pagina no existe</h1>
        <p>
            La direccion que intentas abrir ya no esta disponible o fue movida.
            Revisa el enlace y vuelve al flujo principal de PlayFunnel.
        </p>
    </main>
</body>
</html>
