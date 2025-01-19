# Jak uruchomić Laravel Sail w WSL

Aby uruchomić Laravel Sail w środowisku WSL, wykonaj poniższe kroki:

1. **Sklonuj repozytorium projektu:**
   ```bash
   git clone https://github.com/KacperBarszczewski/petstore.git
   cd petstore
   ```

2. **Zainstaluj zależności przy użyciu kontenera Sail:**
   ```bash
   docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/var/www/html" -w /var/www/html laravelsail/php84-composer:latest composer install --ignore-platform-reqs
   ```

3. **Skopiuj plik środowiskowy `.env`:**
   ```bash
   cp .env.example .env
   ```

4. **Uruchom kontenery Sail:**
   ```bash
   ./vendor/bin/sail up -d
   ```

5. **Wygeneruj klucz aplikacji:**
   ```bash
   ./vendor/bin/sail artisan key:generate
   ```

6. **Uruchom migracje bazy danych:**
   ```bash
   ./vendor/bin/sail artisan migrate
   ```

7. **Zainstaluj zależności npm:**
   ```bash
   ./vendor/bin/sail npm install
   ```

8. **Zbuduj zasoby frontendu:**
   ```bash
   ./vendor/bin/sail npm run dev
   ```

Po wykonaniu powyższych kroków aplikacja powinna być dostępna w Twoim środowisku lokalnym. Możesz ją otworzyć w przeglądarce pod adresem `http://localhost`.

![Zrzut ekranu 2025-01-19 220220](https://github.com/user-attachments/assets/d38a8432-51cf-426b-9750-1397ddf92444)
![Zrzut ekranu 2025-01-19 220122](https://github.com/user-attachments/assets/f3fad8cf-55f6-41d1-b791-39491b98075d)
![Zrzut ekranu 2025-01-19 215705](https://github.com/user-attachments/assets/aeb0499c-09a6-42fa-9e99-16a2b31545e7)
