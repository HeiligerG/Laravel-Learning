Ja! Du kannst dein **Oracle VM Deployment automatisch ausführen**, sobald Änderungen auf den `oracle-deploy`-Branch gepusht werden. Dafür gibt es verschiedene Methoden:

---

# **✅ Methode 1: Automatische GitHub Actions (Empfohlen)**
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
name: Oracle VM Deployment

on:
    push:
        branches:
            - oracle-deploy

jobs:
    deploy:
        runs-on: ubuntu-latest
        steps:
            - name: Checkout Repository
              uses: actions/checkout@v3
              with:
                  sparse-checkout: |
                      projects/FoodFlow
                  sparse-checkout-cone-mode: false

            - name: Move FoodFlow to deployment location
              run: |
                  cd projects
                  mv FoodFlow/* ..
                  cd ..
                  rm -rf projects

            - name: Setup SSH
              run: |
                  mkdir -p ~/.ssh
                  echo -e "${{ secrets.SSH_PRIVATE_KEY }}" | sed 's/\r$//' > ~/.ssh/id_rsa
                  chmod 600 ~/.ssh/id_rsa
                  ssh-keyscan -H 140.238.222.190 >> ~/.ssh/known_hosts

            - name: Deploy to Oracle VM
              run: |
                  # Sichern der vorhandenen .env wenn sie existiert
                  ssh -i ~/.ssh/id_rsa ubuntu@140.238.222.190 'cd /var/www/laravel/FoodFlow && [ -f .env ] && cp .env /tmp/backup.env || true'

                  # Verzeichnisstruktur vorbereiten
                  ssh -i ~/.ssh/id_rsa ubuntu@140.238.222.190 'sudo rm -rf /var/www/laravel/FoodFlow && sudo mkdir -p /var/www/laravel/FoodFlow && sudo chown -R ubuntu:ubuntu /var/www/laravel/FoodFlow'

                  # Dateien synchronisieren in den FoodFlow Ordner
                  rsync -av --delete ./ ubuntu@140.238.222.190:/var/www/laravel/FoodFlow/

                  # Deployment ausführen
                  ssh -i ~/.ssh/id_rsa ubuntu@140.238.222.190 << 'EOF'
                    set -e  # Stop execution if any command fails
                    trap 'cd /var/www/laravel/FoodFlow && php artisan up' EXIT  # Ensure app goes back online

                    cd /var/www/laravel/FoodFlow

                    # Wiederherstellen der .env aus dem Backup
                    [ -f /tmp/backup.env ] && cp /tmp/backup.env .env

                    # Install Composer dependencies
                    composer install --no-dev --no-interaction --optimize-autoloader

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

                    # Set final permissions for web server
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

---

## **✅ Methode 2: Deployment per Webhook & Git Hooks**
Falls du GitHub Actions nicht nutzen möchtest, kannst du **Webhooks** oder **Git Hooks** direkt auf deiner VM verwenden.

### **📌 Schritt 1: Webhook auf der VM einrichten**
1. **Auf der VM ein Skript erstellen (`/var/www/webhook.sh`)**
   ```sh
   #!/bin/bash
   cd /var/www/Laravel-Learning
   git pull origin oracle-deploy
   rsync -av --delete projects/FoodFlow/ /var/www/laravel/
   cd /var/www/laravel
   php artisan down
   composer install --no-dev --optimize-autoloader
   php artisan migrate --force
   php artisan db:seed --class=PatchNotesSeeder
   php artisan cache:clear
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   sudo chown -R www-data:www-data /var/www/laravel
   sudo systemctl restart php8.3-fpm
   sudo systemctl restart nginx
   php artisan up
   ```
   **Speichern und ausführbar machen:**
   ```sh
   chmod +x /var/www/webhook.sh
   ```

2. **Einen kleinen Webserver für Webhooks einrichten**
   ```sh
   sudo apt install socat
   socat TCP-LISTEN:9001,fork EXEC:/var/www/webhook.sh &
   ```
   📌 **Warum?**
    - `socat` lauscht auf **Port 9001**, wenn GitHub den Webhook auslöst.

3. **Gehe zu GitHub → Repository → Settings → Webhooks**
    - **Payload URL:** `http://oracle-vm-ip:9001/`
    - **Content type:** `application/json`
    - **Trigger:** `Just the push event`
    - **Add Webhook**

---

## **🚀 Fazit: Vollautomatisches Deployment auf deiner Oracle VM**
### 🔥 **Beste Methode?**
| Methode | Vorteile | Nachteile |
|---|---|---|
| **GitHub Actions (Methode 1)** | Einfach zu verwalten, sicher & automatisiert | Erfordert GitHub Secrets |
| **Webhook & Git Hooks (Methode 2)** | Direkt auf der VM, kein GitHub Actions nötig | Webhook-Server muss laufen |

✅ **Für Einsteiger empfehle ich GitHub Actions** – damit hast du eine **saubere, sichere Lösung**, die **automatisch läuft**, wenn du pusht.
