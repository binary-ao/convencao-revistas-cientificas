<!doctype html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="margin:0; padding:0; background:#F5F7F6; font-family: -apple-system, 'Segoe UI', Roboto, Arial, sans-serif; color:#14181A;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#F5F7F6; padding: 32px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="560" cellpadding="0" cellspacing="0" style="background:#FFFFFF; border:1px solid #DCE1E2;">
                    <tr>
                        <td style="padding: 28px 32px; border-bottom:1px solid #DCE1E2;">
                            <div style="font-size:11px; letter-spacing:1px; text-transform:uppercase; color:#A8672E; font-weight:bold;">
                                Confirmação de Inscrição
                            </div>
                            <div style="font-size:16px; font-weight:bold; color:#1F3B57; margin-top:4px;">
                                1ª Convenção Nacional de Revistas Científicas Angolanas
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 28px 32px;">
                            <p style="margin:0 0 16px 0; font-size:14px; line-height:1.6;">
                                Olá, {{ $registration->participant->full_name }}.
                            </p>
                            <p style="margin:0 0 16px 0; font-size:14px; line-height:1.6; color:#5A6266;">
                                A sua inscrição na {{ $registration->event->name }} foi registada com sucesso.
                                O comprovativo em PDF segue em anexo a este email.
                            </p>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="border:1px solid #1F3B57; margin: 20px 0;">
                                <tr>
                                    <td align="center" style="padding: 16px;">
                                        <div style="font-size:10px; text-transform:uppercase; letter-spacing:1px; color:#5A6266;">
                                            Código da Inscrição
                                        </div>
                                        <div style="font-size:20px; font-weight:bold; color:#1F3B57; letter-spacing:1px; margin-top:4px;">
                                            {{ $registration->code }}
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0 0 16px 0; font-size:13px; line-height:1.6; color:#5A6266;">
                                Guarde este código — é o único dado, junto com o seu email, necessário para consultar
                                a sua inscrição a qualquer momento, sem necessidade de criar conta.
                            </p>

                            <table role="presentation" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="background:#1F3B57;">
                                        <a href="{{ route('registration.lookup') }}"
                                            style="display:inline-block; padding: 12px 24px; color:#ffffff; font-size:13px; font-weight:bold; text-decoration:none;">
                                            Consultar Inscrição
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px 32px; border-top:1px solid #DCE1E2; font-size:11px; color:#5A6266;">
                            &copy; {{ now()->year }} 1ª Convenção Nacional de Revistas Científicas Angolanas.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
