<?php

// Fungsi untuk enkripsi dan dekripsi
function encrypt($message, $key, $cipher) {
    switch ($cipher) {
        case 'vigenere':
            return vigenereCipher($message, $key, true);
        case 'auto_vigenere':
            return autoKeyVigenereCipher($message, $key, true);
        case 'playfair':
            return playfairCipher($message, $key, true);
        case 'hill':
            return hillCipher($message, $key, true);
        case 'super_encryption':
            return superEncryption($message, $key, true);
        default:
            return "Invalid cipher selected.";
    }
}

function decrypt($message, $key, $cipher) {
    switch ($cipher) {
        case 'vigenere':
            return vigenereCipher($message, $key, false);
        case 'auto_vigenere':
            return autoKeyVigenereCipher($message, $key, false);
        case 'playfair':
            return playfairCipher($message, $key, false);
        case 'hill':
            return hillCipher($message, $key, false);
        case 'super_encryption':
            return superEncryption($message, $key, false);
        default:
            return "Invalid cipher selected.";
    }
}

// Vigenere Cipher
function vigenereCipher($text, $key, $encrypt = true) {
    $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $text = strtoupper($text);
    $key = strtoupper($key);
    $keyLength = strlen($key);
    $result = '';
    $j = 0;

    for ($i = 0; $i < strlen($text); $i++) {
        if (ctype_alpha($text[$i])) {
            $textLetter = strpos($alphabet, $text[$i]);
            $keyLetter = strpos($alphabet, $key[$j % $keyLength]);
            if ($encrypt) {
                $newLetter = ($textLetter + $keyLetter) % 26;
            } else {
                $newLetter = ($textLetter - $keyLetter + 26) % 26;
            }
            $result .= $alphabet[$newLetter];
            $j++;
        } else {
            $result .= $text[$i];
        }
    }
    return $result;
}

// Auto-Key Vigenere Cipher
function autoKeyVigenereCipher($text, $key, $encrypt = true) {
    if ($encrypt) {
        $key .= $text;  // Key extends with the text
    }
    return vigenereCipher($text, $key, $encrypt);
}

// Playfair Cipher
function playfairCipher($text, $key, $encrypt = true) {
    // Implementasi dasar Playfair Cipher
    // (Belum diimplementasikan secara penuh karena kerumitan)
    return "Playfair Cipher is a bit complex and not implemented fully here.";
}

// Hill Cipher
function hillCipher($text, $key, $encrypt = true) {
    // Implementasi dasar Hill Cipher
    // (Belum diimplementasikan secara penuh karena kerumitan)
    return "Hill Cipher is a bit complex and not implemented fully here.";
}

// Super Encryption (Vigenere + Transposition)
function superEncryption($text, $key, $encrypt = true) {
    // Step 1: Vigenere Cipher
    $vigenereResult = vigenereCipher($text, $key, $encrypt);

    // Step 2: Columnar Transposition Cipher (diimplementasikan secara sederhana)
    return columnTranspositionCipher($vigenereResult, $key, $encrypt);
}

function columnTranspositionCipher($text, $key, $encrypt = true) {
    $text = str_replace(' ', '', $text);
    $keyLength = strlen($key);
    $textLength = strlen($text);
    $columns = array_fill(0, $keyLength, '');

    if ($encrypt) {
        // Enkripsi Kolom
        for ($i = 0; $i < $textLength; $i++) {
            $columns[$i % $keyLength] .= $text[$i];
        }
        return implode('', $columns);
    } else {
        // Dekripsi Kolom
        $rowLength = ceil($textLength / $keyLength);
        $result = '';

        // Sederhana dekripsi dengan pendekatan dasar
        return "Decryption not fully implemented.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = '';

    // Cek apakah file diunggah
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        // Membaca konten file
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $message = file_get_contents($fileTmpPath);
    } elseif (!empty($_POST['message'])) {
        // Jika tidak ada file, ambil pesan dari input teks
        $message = $_POST['message'];
    }

    // Mendapatkan kunci dan cipher
    $key = $_POST['key'];
    $cipher = $_POST['cipher'];
    $action = $_POST['action'];

    if ($message) {
        if ($action == "Encrypt") {
            $result = encrypt($message, $key, $cipher);
            echo "<h3>Encrypted Message: $result</h3>";
        } else {
            $result = decrypt($message, $key, $cipher);
            echo "<h3>Decrypted Message: $result</h3>";
        }
    } else {
        echo "<h3>Error: Please provide a message or upload a file.</h3>";
    }
}
?>
