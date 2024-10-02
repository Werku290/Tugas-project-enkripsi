def vigenere_cipher(plaintext, keyword):
    ciphertext = ""
    for i, c in enumerate(plaintext):
        shift = ord(keyword[i % len(keyword)]) - 65
        ciphertext += chr((ord(c) - 65 + shift) % 26 + 65)
    return ciphertext

def auto_key_vigenere_cipher(plaintext):
    ciphertext = ""
    keyword = plaintext
    for i, c in enumerate(plaintext):
        shift = ord(keyword[i % len(keyword)]) - 65
        ciphertext += chr((ord(c) - 65 + shift) % 26 + 65)
    return ciphertext

def playfair_cipher(plaintext):
    matrix = []
    for i in range(5):
        row = []
        for j in range(5):
            row.append(chr(65 + i * 5 + j))
        matrix.append(row)

    ciphertext = ""
    for i in range(0, len(plaintext), 2):
        c1, c2 = plaintext[i:i+2]
        r1, c1 = divmod(ord(c1) - 65, 5)
        r2, c2 = divmod(ord(c2) - 65, 5)
        if r1 == r2:
            ciphertext += matrix [r1][(c1 + 1) % 5] + matrix[r2][(c2 + 1) % 5]
        elif c1 == c2:
            ciphertext += matrix[(r1 + 1) % 5][c1] + matrix[(r2 + 1) % 5][c2]
        else:
            ciphertext += matrix[r1][c2] + matrix[r2][c1]
    return ciphertext

def hill_cipher(plaintext, key):
    matrix = []
    for i in range(2):
        row = []
        for j in range(2):
            row.append(key[i * 2 + j])
        matrix.append(row)

    ciphertext = ""
    for i in range(0, len(plaintext), 2):
        c1, c2 = plaintext[i:i+2]
        vector = [ord(c1) - 65, ord(c2) - 65]
        result = [0, 0]
        for i in range(2):
            for j in range(2):
                result[i] += matrix[i][j] * vector[j]
        ciphertext += chr(result[0] % 26 + 65) + chr(result[1] % 26 + 65)
    return ciphertext

def super_encryption(plaintext, keyword):
    ciphertext = vigenere_cipher(plaintext, keyword)
    return columnar_transposition(ciphertext)

def columnar_transposition(ciphertext):
    columns = 5
    rows = len(ciphertext) // columns
    if len(ciphertext) % columns != 0:
        rows += 1

    matrix = []
    for i in range(rows):
        row = []
        for j in range(columns):
            index = i * columns + j
            if index < len(ciphertext):
                row.append(ciphertext[index])
            else:
                row.append('X')
        matrix.append(row)

    ciphertext = ""
    for j in range(columns):
        for i in range(rows):
            ciphertext += matrix[i][j]

    return ciphertext
