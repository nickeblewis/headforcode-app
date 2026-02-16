<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contact Form Submission</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <h1 style="color: #1b1b18; border-bottom: 2px solid #f53003; padding-bottom: 10px;">
        New Contact Form Submission
    </h1>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <tr>
            <td style="padding: 10px; font-weight: bold; width: 100px; vertical-align: top;">Name:</td>
            <td style="padding: 10px;">{{ $data['name'] }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; font-weight: bold; vertical-align: top;">Email:</td>
            <td style="padding: 10px;">
                <a href="mailto:{{ $data['email'] }}" style="color: #f53003;">{{ $data['email'] }}</a>
            </td>
        </tr>
        <tr>
            <td style="padding: 10px; font-weight: bold; vertical-align: top;">Subject:</td>
            <td style="padding: 10px;">{{ $data['subject'] }}</td>
        </tr>
        <tr>
            <td style="padding: 10px; font-weight: bold; vertical-align: top;">Message:</td>
            <td style="padding: 10px; white-space: pre-wrap;">{{ $data['message'] }}</td>
        </tr>
    </table>

    <hr style="margin-top: 30px; border: none; border-top: 1px solid #e3e3e0;">
    <p style="color: #706f6c; font-size: 12px;">
        This email was sent from the Headforcode contact form.
    </p>
</body>
</html>
