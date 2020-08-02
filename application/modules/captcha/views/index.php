<!DOCTYPE html>
<html>
<head>
    <title>Captcha implement in CodeIgniter by CodexWorld</title>
  
</head>
<body>
    <p>Submit the word you see below:</p>
    <p id="captImg"><?php echo $captchaImg; ?></p>
 
    <form method="post">
        <input type="text" name="captcha" value=""/>
        <input type="submit" name="submit" value="SUBMIT"/>
    </form>
</body>
</html>