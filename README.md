# InternLink

InternLink est une plateforme de gestion de stages et d'offres d'emploi développée avec Laravel.

## Installation

### Prérequis

- PHP 8.1 ou supérieur
- Composer
- Node.js et npm
- MySQL ou autre base de données compatible

### Installation

1. Clonez le repository :
```bash
git clone https://github.com/Lbourdi/InternLink.git
cd InternLink
```

2. Installez les dépendances PHP :
```bash
composer install
```

3. Installez les dépendances JavaScript :
```bash
npm install
```

4. Copiez le fichier d'environnement :
```bash
cp .env.example .env
```

5. Générez la clé d'application :
```bash
php artisan key:generate
```

6. Configurez votre base de données dans le fichier `.env`

7. Exécutez les migrations :
```bash
php artisan migrate
```

## Lancer l'application

### Serveur de développement

1. Démarrez le serveur Laravel :
```bash
php artisan serve
```

2. Dans un autre terminal, démarrez Vite pour le développement frontend :
```bash
npm run dev
```

3. Accédez à l'application sur [http://localhost:8000](http://localhost:8000)

## À propos de Laravel

Laravel est un framework d'application web avec une syntaxe expressive et élégante. Nous pensons que le développement doit être une expérience agréable et créative pour être vraiment épanouissante. Laravel simplifie le développement en facilitant les tâches courantes utilisées dans de nombreux projets web, telles que :

- [Moteur de routage simple et rapide](https://laravel.com/docs/routing).
- [Conteneur d'injection de dépendances puissant](https://laravel.com/docs/container).
- Plusieurs backends pour le stockage de [session](https://laravel.com/docs/session) et de [cache](https://laravel.com/docs/cache).
- [ORM de base de données](https://laravel.com/docs/eloquent) expressif et intuitif.
- [Migrations de schéma](https://laravel.com/docs/migrations) agnostiques de la base de données.
- [Traitement robuste des tâches en arrière-plan](https://laravel.com/docs/queues).
- [Diffusion d'événements en temps réel](https://laravel.com/docs/broadcasting).

Laravel est accessible, puissant et fournit les outils nécessaires pour de grandes applications robustes.ons robustes.

## Apprendre Laravel

Laravel possède la [documentation](https://laravel.com/docs) et la bibliothèque de tutoriels vidéo les plus complètes de tous les frameworks d'applications web modernes, ce qui facilite la prise en main du framework. Vous pouvez également consulter [Laravel Learn](https://laravel.com/learn), où vous serez guidé dans la création d'une application Laravel moderne.

Si vous n'avez pas envie de lire, [Laracasts](https://laracasts.com) peut vous aider. Laracasts contient des milliers de tutoriels vidéo sur une variété de sujets incluant Laravel, PHP moderne, les tests unitaires et JavaScript. Améliorez vos compétences en explorant notre bibliothèque vidéo complète.mplète.

## Sponsors Laravel

Nous tenons à remercier les sponsors suivants pour le financement du développement de Laravel. Si vous souhaitez devenir sponsor, veuillez visiter le [programme Laravel Partners](https://partners.laravel.com).

### Partenaires Premium

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contribuer

Merci d'envisager de contribuer au framework Laravel ! Le guide de contribution se trouve dans la [documentation Laravel](https://laravel.com/docs/contributions).

## Code de conduite

Afin de garantir que la communauté Laravel soit accueillante pour tous, veuillez consulter et respecter le [Code de conduite](https://laravel.com/docs/contributions#code-of-conduct).

## Vulnérabilités de sécurité

Si vous découvrez une vulnérabilité de sécurité dans Laravel, veuillez envoyer un e-mail à Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). Toutes les vulnérabilités de sécurité seront traitées rapidement.

## Licence

Le framework Laravel est un logiciel open source sous licence [MIT](https://opensource.org/licenses/MIT).
