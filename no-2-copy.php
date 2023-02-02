<!-- PHP Function -->
<?php
if (isset($_POST['submit'])){
    function secureInput($input, $attack_mode, $should_strip, $validate_only) {
 // Initialize an array of dangerous tokens
 $dangerous_tokens = [
    "DROP", "SELECT", "INSERT", "DELETE", "UPDATE", "--", "\"", "\'", "<", ">", "\\"
  ];

  // Initialize an array of allowed characters
  $allowed_chars = [
    "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z",
    "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",
    "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", " ", ".", ",", "-", "_", "(", ")", "+", "=", "/", "!", "@", "#", "$", "%", "^", "&", "*", ":", ";", "?", "[", "]", "{", "}", "|"
  ];

  // Check if the input contains any dangerous tokens
  $contains_dangerous_token = false;
  if ($attack_mode == 'ALL' || $attack_mode == 'SQLI' || $attack_mode == 'XSS') {
    foreach ($dangerous_tokens as $token) {
      if (strpos($input, $token) !== false) {
        $contains_dangerous_token = true;
        break;
      }
    }
  }

  // If the input contains any dangerous tokens
  if ($contains_dangerous_token) {
    // If validate only is true, throw an exception
    if ($validate_only) {
      throw new Exception("The input contains dangerous tokens");
    }

    // If should strip is true, remove the dangerous tokens from the input
    if ($should_strip) {
      $input = str_replace($dangerous_tokens, "", $input);
    }
    // If should strip is false, escape the dangerous tokens in the input
    else {
      $input = htmlspecialchars($input, ENT_QUOTES);
    }
  }

  // Return the sanitized input
  return $input;
    $input = $_POST['message'];
    $input = secureInput($input, "ALL", true, false);
    echo $input;
}
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