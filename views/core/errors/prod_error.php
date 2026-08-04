<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CTRX · Server Error</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        body {
            background: #0f172a;
            color: #f1f5f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            margin: 0;
        }

        .card {
            text-align: center;
            max-width: 700px;
            width: 100%;
            padding: 2rem 1.5rem;
            animation: fadeUp 0.9s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeUp {
            0% {
                opacity: 0;
                transform: translateY(40px) scale(0.97);
            }

            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .error-code {
            font-size: 8rem;
            font-weight: 800;
            color: #ef4444;
            text-shadow: 0 0 40px rgba(239, 68, 68, 0.35);
            animation: breathe 2.6s ease-in-out infinite;
            line-height: 1;
            letter-spacing: -0.04em;
        }

        @keyframes breathe {

            0%,
            100% {
                transform: scale(1);
                text-shadow: 0 0 40px rgba(239, 68, 68, 0.35);
            }

            50% {
                transform: scale(1.04);
                text-shadow: 0 0 60px rgba(239, 68, 68, 0.55);
            }
        }

        .req-id {
            color: #e2e8f0;
            font-size: 1.1rem;
            font-weight: 500;
            font-family: 'JetBrains Mono', 'Fira Code', monospace;
            letter-spacing: 0.04em;
            background: rgba(255, 255, 255, 0.04);
            padding: 0.4rem 1.5rem;
            border-radius: 40px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            display: inline-block;
            margin: 0.5rem 0 1rem;
            user-select: all;
        }

        h1 {
            font-size: 2.2rem;
            font-weight: 700;
            margin: 0.25rem 0 0.5rem;
            letter-spacing: -0.02em;
            color: #f8fafc;
        }

        .subhead {
            font-size: 1.2rem;
            color: #94a3b8;
            margin-bottom: 1rem;
            font-weight: 450;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 0.3rem 0.5rem;
        }

        .subhead strong {
            color: #e2e8f0;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.04);
            padding: 0.1rem 0.9rem;
            border-radius: 40px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .description {
            color: #94a3b8;
            font-size: 1.05rem;
            line-height: 1.7;
            margin: 0.5rem auto 1.8rem;
        }

        .info-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.8rem 1rem;
            margin: 1.8rem 0 2.2rem;
        }

        .info-item {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            background: rgba(255, 255, 255, 0.03);
            padding: 0.45rem 1.2rem 0.45rem 0.8rem;
            border-radius: 60px;
            border: 1px solid rgba(255, 255, 255, 0.06);
            font-size: 0.85rem;
            font-weight: 500;
            color: #cbd5e1;
            backdrop-filter: blur(2px);
        }

        .info-item .icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 1.8rem;
            height: 1.8rem;
            background: rgba(239, 68, 68, 0.12);
            border-radius: 40px;
            border: 1px solid rgba(239, 68, 68, 0.15);
            color: #ef4444;
            font-size: 0.9rem;
            font-weight: 600;
            flex-shrink: 0;
        }

        .card-actions {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 1rem;
            padding: 1.5rem 1.2rem;
            text-align: left;
            margin-bottom: 2rem;
            transition: border-color 0.2s;
        }

        .card-actions:hover {
            border-color: rgba(255, 255, 255, 0.12);
        }

        .card-actions .title {
            color: #94a3b8;
            font-size: 0.8rem;
            font-weight: 500;
            letter-spacing: 0.02em;
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-actions .title .icon-small {
            font-size: 1rem;
        }

        .card-actions ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }

        .card-actions li {
            color: #cbd5e1;
            font-size: 0.95rem;
            padding-left: 1.4rem;
            position: relative;
            line-height: 1.5;
        }

        .card-actions li::before {
            content: "▹";
            position: absolute;
            left: 0;
            color: #ef4444;
            font-weight: 300;
        }

        .card-actions li .highlight {
            color: #f1f5f9;
            font-weight: 500;
            background: rgba(255, 255, 255, 0.04);
            padding: 0.05rem 0.6rem;
            border-radius: 4px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.85rem;
        }

        .card-actions li .action-link {
            color: #ef4444;
            text-decoration: none;
            font-weight: 500;
            border-bottom: 1px dashed rgba(239, 68, 68, 0.3);
            transition: border-color 0.2s;
        }

        .card-actions li .action-link:hover {
            border-bottom-color: #ef4444;
        }

        .btn-group {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.8rem 1rem;
            margin: 0.5rem 0 1.5rem;
        }

        .btn {
            display: inline-block;
            padding: 0.8rem 2.4rem;
            background: #ef4444;
            color: white;
            text-decoration: none;
            border-radius: 60px;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 8px 24px rgba(239, 68, 68, 0.25);
            letter-spacing: 0.01em;
            font-family: inherit;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 34px rgba(239, 68, 68, 0.4);
            background: #dc2626;
        }

        .btn:active {
            transform: scale(0.96);
        }

        .btn-outline {
            background: transparent;
            box-shadow: none;
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #cbd5e1;
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.2);
            box-shadow: none;
            transform: translateY(-3px);
        }

        .footer-meta {
            margin-top: 2.8rem;
            font-size: 0.75rem;
            color: #475569;
            border-top: 1px solid rgba(255, 255, 255, 0.04);
            padding-top: 1.6rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 0.4rem 0.9rem;
        }

        .footer-meta span {
            background: rgba(255, 255, 255, 0.02);
            padding: 0.1rem 1rem;
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.03);
            color: #64748b;
            font-weight: 450;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: #94a3b8;
        }

        .dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
            box-shadow: 0 0 12px rgba(239, 68, 68, 0.3);
            animation: dotPulse 2.2s ease-in-out infinite;
        }

        @keyframes dotPulse {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.5;
                transform: scale(0.75);
            }
        }

        .badge-top {
            color: #ef4444;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.25em;
            display: inline-block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        @media (max-width: 500px) {
            .error-code {
                font-size: 5.5rem;
            }

            .card {
                padding: 1.2rem 0.8rem;
            }

            h1 {
                font-size: 1.8rem;
            }

            .subhead {
                font-size: 1rem;
            }

            .info-grid {
                gap: 0.6rem;
            }

            .btn {
                padding: 0.7rem 2rem;
                width: 100%;
                text-align: center;
            }

            .btn-group {
                flex-direction: column;
                gap: 0.7rem;
            }

            .req-id {
                font-size: 0.9rem;
                padding: 0.3rem 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="card">
        <span class="badge-top">CTRX Framework</span>
        <div class="error-code">500</div>

        <div class="req-id"><?= $reqid ?></div>

        <h1>Internal Server Error</h1>

        <p class="description">
            Something went wrong while processing your request.<br>
            Our team has been notified. In the meantime, you can:
        </p>

        <div class="btn-group">
            <a href="<?= prev_page ?>" class="btn">← Go Back</a>
            <button onclick="location.reload()" class="btn btn-outline">↻ Retry</button>
        </div>
    </div>
</body>

</html>