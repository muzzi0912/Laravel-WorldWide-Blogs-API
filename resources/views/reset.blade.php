<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td style="padding: 20px;">
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" style="background-color: #007bff; padding: 20px; border-radius: 5px;">
                            <h1 style="color: #fff;">Reset Your Password</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color: #fff; padding: 20px;">
                            <p>Hello,</p>
                            <p>We received a request to reset your password. Click the button below to reset it:</p>
                            <p style="text-align: center;">
                                <a href="http://127.0.0.1:3000/api/reset/{{ $token }}"
                                    style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px;">Reset
                                    Password</a>
                            </p>
                            <p>If you didn't request a password reset, you can ignore this email. Your password will
                                remain unchanged.</p>
                            <p>Best regards,<br>Your Website Team</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
