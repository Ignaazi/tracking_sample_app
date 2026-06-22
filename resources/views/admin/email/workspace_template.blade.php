<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Workspace Email</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333333; background-color: #f4f6f9; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #eef2f5;">
        
        <h2 style="color: #4154f1; margin-top: 0; border-bottom: 2px solid #f4f5f7; padding-bottom: 15px;">
            NiceAdmin Workspace Alert
        </h2>
        
        <div style="margin-bottom: 20px;">
            <p style="margin: 5px 0;"><strong>From:</strong> {{ $senderName }}</p>
            <p style="margin: 5px 0;"><strong>Subject:</strong> {{ $subjectText }}</p>
        </div>

        <div style="background-color: #f8fafc; padding: 20px; border-left: 4px solid #4154f1; border-radius: 4px; margin-bottom: 25px; white-space: pre-line;">
            {{ $bodyMessage }}
        </div>

        <p style="font-size: 12px; color: #899bbd; border-top: 1px solid #eef2f5; padding-top: 15px; margin-bottom: 0;">
            This is an automated operational system message from your NiceAdmin Tracking Module.
        </p>
    </div>
</body>
</html>