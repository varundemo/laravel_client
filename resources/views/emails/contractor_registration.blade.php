<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to Our Website</title>
</head>
<body>
    <h2>Welcome to Our Website</h2>
    
    <p>Dear {{ $user->name }},</p>
    
    <p>Congratulations! Your registration as a contractor on our website was successful.</p>
    
    <p>Here are your login details:</p>
    
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>

    <p>You can Login from here:</p>
    <a href="https://web.contractoruniverse.com/login">https://web.contractoruniverse.com/login</a>
    
    <p>Please keep your login details secure and do not share them with anyone.</p>
    
    <p>Thank you for joining our platform. We look forward to working with you!</p>
    
    <p>Best regards,<br>
    Contractor Universe Team</p>
</body>
</html>
