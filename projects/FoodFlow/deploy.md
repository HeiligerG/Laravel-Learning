# **Automatische GitHub Actions (Empfohlen)**
GitHub Actions kann dein Deployment automatisch ausführen, wenn du Änderungen an `oracle-deploy` pushst.

### **📌 Schritt 1: SSH-Zugang zur VM vorbereiten**
1. **Öffne die VM und erstelle einen SSH-Schlüssel:**
   ```sh
   ssh-keygen -t rsa -b 4096 -C "github@oracle-vm"
   ```
    - Gib keinen **Passphrase** ein, wenn du danach gefragt wirst.
    - Es wird ein Schlüssel **`~/.ssh/id_rsa`** und **`~/.ssh/id_rsa.pub`** erstellt.

2. **Zeige den öffentlichen Schlüssel an:**
   ```sh
   cat ~/.ssh/id_rsa.pub
   ```
    - Kopiere den kompletten Schlüssel.

3. **Gehe zu GitHub → Repository → Einstellungen → Secrets → "New Secret"**
    - **Name:** `SSH_PRIVATE_KEY`
    - **Wert:** Öffne die Datei `~/.ssh/id_rsa` und kopiere den gesamten Inhalt.

4. **Füge die GitHub-SSH-Schlüssel zur VM hinzu:**
   ```sh
   echo "SSH_PUBLIC_KEY_HIER_EINFÜGEN" >> ~/.ssh/authorized_keys
   chmod 600 ~/.ssh/authorized_keys
   ```

---

### **📌 Schritt 2: GitHub Actions Workflow (`.github/workflows/deploy.yml`)**
Erstelle in deinem Repository die Datei **`.github/workflows/deploy.yml`** und füge diesen Code ein:

```yaml
- name: Deploy to Oracle VM
  run: |
      # Sichern der vorhandenen .env
      ssh -i ~/.ssh/id_rsa ubuntu@140.238.222.190 'cd /var/www/laravel/FoodFlow && [ -f .env ] && cp .env /tmp/backup.env || true'

      # Verzeichnisstruktur vorbereiten
      ssh -i ~/.ssh/id_rsa ubuntu@140.238.222.190 'sudo rm -rf /var/www/laravel/FoodFlow && sudo mkdir -p /var/www/laravel/FoodFlow && sudo chown -R ubuntu:ubuntu /var/www/laravel/FoodFlow'

      # Dateien synchronisieren
      rsync -av --delete ./ ubuntu@140.238.222.190:/var/www/laravel/FoodFlow/

      # Deployment ausführen
      ssh -i ~/.ssh/id_rsa ubuntu@140.238.222.190 << 'EOF'
        set -e
        cd /var/www/laravel/FoodFlow

        # Wiederherstellen der .env
        [ -f /tmp/backup.env ] && cp /tmp/backup.env .env

        # Install Composer dependencies
        composer install --no-dev --no-interaction --optimize-autoloader

        # Install NPM dependencies and build assets
        npm install
        npm run build

        # Take application down for maintenance
        php artisan down --render="errors::503"

        # Run database migrations and seeds
        php artisan migrate --force
        php artisan db:seed --class=PatchNotesSeeder

        # Clear and rebuild cache
        php artisan optimize:clear
        php artisan config:cache
        php artisan route:cache
        php artisan view:cache

        # Set final permissions
        sudo chown -R www-data:www-data .
        sudo chmod -R 775 .
        sudo chmod -R 775 storage bootstrap/cache

        # Restart services
        sudo systemctl restart php8.3-fpm
        sudo systemctl restart nginx

        # Bring application back online
        php artisan up

        # Clean up
        rm -f /tmp/backup.env
    EOF
```

---

### **📌 Schritt 3: Deployment testen**
1. **Pushe Änderungen auf den Branch `oracle-deploy`**
   ```sh
   git add .
   git commit -m "Automatisches Deployment"
   git push origin oracle-deploy
   ```
2. **Gehe zu GitHub → Actions → Oracle VM Deployment**
3. **Sieh dir die Logs an, ob das Deployment funktioniert hat.**
