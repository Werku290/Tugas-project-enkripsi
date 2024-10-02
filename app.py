from flask import Flask, request, render_template
import ciphers

app = Flask(__name__)

@app.route('/', methods=['GET', 'POST'])
def index():
    if request.method == 'POST':
        plaintext = request.form['plaintext']
        algorithm = request.form['algorithm']
        if algorithm == 'vigenere':
            ciphertext = ciphers.vigenere_cipher(plaintext, request.form['keyword'])
        elif algorithm == 'auto_key_vigenere':
            ciphertext = ciphers.auto_key_vigenere_cipher(plaintext)
        elif algorithm == 'playfair':
            ciphertext = ciphers.playfair_cipher(plaintext)
        elif algorithm == 'hill':
            key = [int(x) for x in request.form['key'].split(',')]
            ciphertext = ciphers.hill_cipher(plaintext, key)
        elif algorithm == 'super':
            keyword = request.form['keyword']
            ciphertext = ciphers.super_encryption(plaintext, keyword)
        return render_template('index.html', ciphertext=ciphertext)
    return render_template('index.html')

if __name__ == '__main__':
    app.run(debug=True)