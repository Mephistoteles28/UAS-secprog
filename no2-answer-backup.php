<!-- PHP Function -->
<?php
if (isset($_POST['submit'])){
    function secureInput($input, $attack_mode, $should_strip, $validate_only) {
        // $input nya dibuat lower semua supaya gampang di filter
        $output = strtolower($input);
        // define list of dangerous characters/tokens untuk setiap attack mode
        $sqli_tokens = array("--", ";", "'", '"', "xp_", "union", "UNION","=", "0x00", "%", "_");
        $xss_tokens = array("<", ">", "(", ")", "script", "alert", "onload", "$");
        $rce_tokens = array("&&", "||", ";", "`", "|", "&", ">", "<", "\\", "//");
        // check for all attack modes
        if ($attack_mode === "ALL") {
            // if "ALL" maka semua tokens akan di merge ke $dangerous_tokens
            $dangerous_tokens = array_merge($sqli_tokens, $xss_tokens, $rce_tokens);
        } else if ($attack_mode === "SQLI") {
            $dangerous_tokens = $sqli_tokens;
        } else if ($attack_mode === "XSS") {
            $dangerous_tokens = $xss_tokens;
        } else if ($attack_mode === "RCE") {
            $dangerous_tokens = $rce_tokens;
        } else {
            throw new Exception("Invalid attack mode.");
        }
        // check for dangerous tokens
        foreach ($dangerous_tokens as $token) {
            // if $output ada yang berbahaya
            if (strpos($output, $token) !== false) {
                    echo "<script> alert('Dangerous input detected!') </script>";
                    $validate_only === true;
                    die;
                    // if ($should_strip === true) {
                    //     $output = str_replace($token, "", $output);
                    // } else {
                    //     $output = str_replace($token, "\\" . $token, $output);
                    // }
            }
        }
        return $output;
    }
    $input = $_POST['message'];
    $input = secureInput($input, "ALL", true, false);
    echo $input;
}

?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nomor 2 UAS Secure Programming</title>
</head>

<body>
    <form action="" method="post">
        <label for="message">Input your message here</label>
        <br>
        <input type="text" name="message" id="message">
        <button name="submit" type="submit">
            Send here!
        </button>
    </form>
</body>

</html>