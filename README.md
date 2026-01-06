# InternLink

Guide rapide pour mettre en place le projet Laravel, préparer la base de données, insérer les données par défaut, compiler et lancer l'application.

## 1. Prérequis
- PHP 8.4+
- Composer
- Node.js & npm (ou yarn)
- MySQL (ou autre SGBD supporté)
- Git

## 2. Cloner le projet
```bash
git clone https://github.com/Lbourdi/InternLink.git
cd InternLink
```

## 3. Installer les dépendances
```bash
composer install
npm install
```

## 4. Configuration de l'environnement
1. Copier le fichier d'exemple :
```bash
cp .env.example .env
```
2. Générer la clé d'application :
```bash
php artisan key:generate
```
3. Modifier `.env` pour configurer la base de données :
- DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
- DB_PORT=3306
- DB_DATABASE=internlink
- DB_USERNAME=your_user
- DB_PASSWORD=your_password

Si vous devez créer la base MySQL manuellement :
```bash
# adapte user et password selon ton système
mysql -u root -p -e "CREATE DATABASE internlink;"
```

## 5. Migrations et données par défaut (seed)
Exécuter les migrations puis insérer les données par défaut :
```bash
php artisan migrate --seed
```
Repartir d'une base de données vide :
```bash
php artisan migrate:fresh --seed
```
- Vérifie `database/seeders/DatabaseSeeder.php` pour connaître les enregistrements insérés par défaut (comptes, rôles, exemples).

## 6. Compiler les assets (frontend)
Développement (watch) :
```bash
npm run dev
```
Production (build optimisé) :
```bash
npm run build
```
Lance `npm run dev` dans un terminal pendant que tu développes.

## 7. Lancer l'application
Serveur Laravel (développement) :
```bash
php artisan serve
```
Accéder à : http://127.0.0.1:8000

Si tu utilises Valet / Docker / un serveur web, configure le virtual host en conséquence.

## 8. Commandes utiles en cas de problème
- Vider le cache de configuration :
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```
- Recréer la BDD et reseeder :
```bash
php artisan migrate:fresh --seed
```

## 9. Où regarder pour les données par défaut
- `database/seeders/DatabaseSeeder.php`
- les seeders individuels dans `database/seeders/` pour connaître les comptes (admin/utilisateur) créés et mots de passe par défaut éventuels.

## 10. Notes rapides
- Si tu vois des erreurs liées aux packages : exécute `composer update` puis retente.
- Pour les fichiers uploadés : vérifie `storage/app/public` et le lien symbolique `public/storage`.
- Pour changer le port du serveur artisan : `php artisan serve --port=8080`

---

Pour toute adaptation particulière (Docker, configuration CI, credentials par défaut), indique la configuration souhaitée et je fournis les commandes spécifiques.
