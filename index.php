<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cipher Encryption</title>
    <style>
        /* Reset CSS untuk menghilangkan margin/padding default */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        /* Style untuk form */
        form {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        /* Hover efek 3D form */
        form:hover {
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
            transform: translateY(0px);
        }

        /* Heading style */
        h2 {
            color: #34495e;
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: 700;
        }

        /* Label untuk elemen form */
        label {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 8px;
            display: inline-block;
        }

        /* Input styling */
        input[type="text"], input[type="file"], select {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            margin-bottom: 20px;
            border: 2px solid #bdc3c7;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);
        }

        /* Fokus pada input */
        input[type="text"]:focus, input[type="file"]:focus, select:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 10px rgba(52, 152, 219, 0.4);
        }

        /* Container untuk tombol */
        .button-container {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        /* Styling untuk tombol submit */
        input[type="submit"], input[type="reset"] {
            width: 120px;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
            margin-right: 4%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            position: relative;
            top: 0;
        }

        /* Tombol reset */
        input[type="reset"] {
            background-color: #e67e22;
        }

        /* Hover efek 3D pada tombol */
        input[type="submit"]:hover, input[type="reset"]:hover {
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
            top: -2px;
        }

        /* Klik efek 3D (menekan tombol) */
        input[type="submit"]:active, input[type="reset"]:active {
            top: 1px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        /* Hasil encrypted/decrypted */
        .result {
            text-align: center;
            color: #16a085;
            margin-top: 20px;
            font-size: 18px;
        }

        /* Responsif untuk layar kecil */
        @media (max-width: 768px) {
            form {
                padding: 20px;
            }

            .button-container {
                flex-direction: column;
                gap: 10px;
            }

            input[type="submit"], input[type="reset"] {
                width: 100%;
            }
        }

        /* Transisi dan animasi halus untuk elemen interaktif */
        input[type="submit"], input[type="text"], input[type="file"], select {
            transition: all 0.3s ease-in-out;
        }

        /* Shadow hover untuk form */
        form:hover {
            transition: all 0.4s ease;
        }

        /* Efek transisi pada input text dan select */
        input[type="text"]:hover, input[type="file"]:hover, select:hover {
            border-color: #2980b9;
        }

        /* Tombol saat hover */
        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        /* Tombol reset saat hover */
        input[type="reset"]:hover {
            background-color: #d35400;
        }

        /* Fokus pada elemen form */
        input:focus, select:focus {
            border-color: #3498db;
            box-shadow: 0 0 10px rgba(52, 152, 219, 0.5);
        }

        /* Efek untuk pergerakan form */
        form:hover {
            transform: translateY(0);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <h2>Encryption and Decryption KLMPK 4</h2>
        
        <!-- Input pesan atau unggah file -->
        <label for="message">Message (Text Input):</label><br>
        <input type="text" id="message" name="message" value="<?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?>"><br>
        
        <label for="file">or Upload a File:</label><br>
        <input type="file" id="file" name="file"><br>

        <label for="key">Key:</label><br>
        <input type="text" id="key" name="key" value="<?php echo isset($_POST['key']) ? htmlspecialchars($_POST['key']) : ''; ?>" required><br>

        <label for="cipher">Select Cipher:</label><br>
        <select id="cipher" name="cipher">
            <option value="vigenere" <?php echo isset($_POST['cipher']) && $_POST['cipher'] == 'vigenere' ? 'selected' : ''; ?>>Vigenere Cipher</option>
            <option value="auto_vigenere" <?php echo isset($_POST['cipher']) && $_POST['cipher'] == 'auto_vigenere' ? 'selected' : ''; ?>>Auto-Key Vigenere Cipher</option>
            <option value="playfair" <?php echo isset($_POST['cipher']) && $_POST['cipher'] == 'playfair' ? 'selected' : ''; ?>>Playfair Cipher</option>
            <option value="hill" <?php echo isset($_POST['cipher']) && $_POST['cipher'] == 'hill' ? 'selected' : ''; ?>>Hill Cipher</option>
            <option value="super_encryption" <?php echo isset($_POST['cipher']) && $_POST['cipher'] == 'super_encryption' ? 'selected' : ''; ?>>Super Encryption (Vigenere + Column Transposition)</option>
        </select><br>

        <div class="button-container">
            <input type="submit" name="action" value="Encrypt">
            <input type="submit" name="action" value="Decrypt">
            <input type="reset" value="Reset">
        </div>
    </form>

    <?php
    include 'cipher.php';

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
                echo "<div class='result'><h3>Encrypted Message: $result</h3></div>";
            } else {
                $result = decrypt($message, $key, $cipher);
                echo "<div class='result'><h3>Decrypted Message: $result</h3></div>";
            }
        } else {
            echo "<div class='result'><h3>Error: Please provide a message or upload a file.</h3></div>";
        }
    }
    ?>
</body>
</html>
