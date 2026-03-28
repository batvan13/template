<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; color: #111827; background: #ffffff; max-width: 580px; margin: 0 auto; padding: 32px 24px;">

    <h2 style="font-size: 18px; font-weight: 600; margin: 0 0 24px;">Ново запитване от сайта</h2>

    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
        <tr>
            <td style="padding: 10px 0; color: #6b7280; width: 90px; vertical-align: top;">Име</td>
            <td style="padding: 10px 0; color: #111827;">{{ $data['name'] }}</td>
        </tr>
        <tr style="border-top: 1px solid #f3f4f6;">
            <td style="padding: 10px 0; color: #6b7280; vertical-align: top;">Имейл</td>
            <td style="padding: 10px 0;">
                <a href="mailto:{{ $data['email'] }}" style="color: #111827;">{{ $data['email'] }}</a>
            </td>
        </tr>
        @if(!empty($data['phone']))
        <tr style="border-top: 1px solid #f3f4f6;">
            <td style="padding: 10px 0; color: #6b7280; vertical-align: top;">Телефон</td>
            <td style="padding: 10px 0; color: #111827;">{{ $data['phone'] }}</td>
        </tr>
        @endif
    </table>

    <div style="margin-top: 20px; padding: 16px; background: #f9fafb; border-radius: 8px; font-size: 14px; line-height: 1.7; color: #374151; white-space: pre-wrap;">{{ $data['message'] }}</div>

    <p style="margin-top: 32px; font-size: 12px; color: #9ca3af;">
        Това съобщение е изпратено от контактната форма на вашия сайт.
    </p>

</body>
</html>
