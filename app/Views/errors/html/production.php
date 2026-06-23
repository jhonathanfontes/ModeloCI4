<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <title>Erro — ModeloBF2</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body {
            height: 100%;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 14px;
            color: #1e293b;
            background: #f1f5f9;
        }
        .error-page {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100%;
            padding: 24px;
        }
        .error-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08), 0 4px 12px rgba(0,0,0,0.1);
            padding: 48px;
            max-width: 620px;
            width: 100%;
            text-align: center;
        }
        .error-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #fef2f2;
            color: #ef4444;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
        }
        .error-icon svg { width: 28px; height: 28px; }
        .brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 18px;
            font-weight: 700;
            color: #4f46e5;
            margin-bottom: 24px;
        }
        .brand svg { width: 22px; height: 22px; stroke: #4f46e5; }
        h1 {
            font-size: 20px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 8px;
        }
        p {
            font-size: 14px;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 24px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            font-family: inherit;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.15s, transform 0.1s;
        }
        .btn-primary {
            background: #4f46e5;
            color: #ffffff;
            border: none;
        }
        .btn-primary:hover { background: #3730a3; }
        .btn-outline {
            background: transparent;
            color: #64748b;
            border: 1px solid #e2e8f0;
            margin-left: 8px;
        }
        .btn-outline:hover { background: #f1f5f9; }
        hr { border: none; border-top: 1px solid #e2e8f0; margin: 24px 0; }
        .error-details { font-size: 12px; color: #94a3b8; }
        .debug-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
            margin-top: 16px;
            text-align: left;
            font-family: 'SF Mono', 'Fira Code', monospace;
            font-size: 13px;
            line-height: 1.6;
            overflow-x: auto;
        }
        .debug-box .label {
            font-weight: 600;
            color: #64748b;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .debug-box .value {
            color: #1e293b;
            word-break: break-all;
            margin-bottom: 12px;
        }
        .debug-box .value:last-child { margin-bottom: 0; }
        .debug-box .file { color: #64748b; font-size: 12px; }
    </style>
</head>
<body>
    <div class="error-page">
        <div class="error-card">
            <div class="brand">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7" rx="1"/>
                    <rect x="14" y="3" width="7" height="7" rx="1"/>
                    <rect x="3" y="14" width="7" height="7" rx="1"/>
                    <rect x="14" y="14" width="7" height="7" rx="1"/>
                </svg>
                ModeloBF2
            </div>

            <div class="error-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>

            <?php if (ENVIRONMENT !== 'production') : ?>
                <h1><?= esc($message) ?></h1>

                <?php if (! empty($exception)) : ?>
                    <div class="debug-box">
                        <div class="label">URL</div>
                        <div class="value"><?= esc(current_url()) ?></div>

                        <div class="label">Mensagem</div>
                        <div class="value"><?= esc($message) ?></div>

                        <div class="label">Arquivo</div>
                        <div class="value file"><?= esc($exception->getFile()) ?>:<?= $exception->getLine() ?></div>

                        <div class="label">Método</div>
                        <div class="value"><?= esc(service('request')->getMethod()) ?></div>
                    </div>
                <?php endif; ?>

                <div style="margin-top:20px;">
                    <a href="javascript:history.back()" class="btn btn-outline">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="19" y1="12" x2="5" y2="12"/>
                            <polyline points="12 19 5 12 12 5"/>
                        </svg>
                        Voltar
                    </a>
                </div>
            <?php else : ?>
                <h1>Ops! Algo deu errado.</h1>
                <p>Ocorreu um erro inesperado. Nossa equipe já foi notificada e estamos trabalhando para resolver o mais rápido possível.</p>

                <div>
                    <a href="javascript:history.back()" class="btn btn-outline">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="19" y1="12" x2="5" y2="12"/>
                            <polyline points="12 19 5 12 12 5"/>
                        </svg>
                        Voltar
                    </a>
                    <a href="/admin" class="btn btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                        Ir para o Dashboard
                    </a>
                </div>

                <hr>

                <div class="error-details">
                    Se o problema persistir, entre em contato com o suporte técnico.
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
