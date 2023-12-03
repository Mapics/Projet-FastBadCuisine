# Projet-FastBadCuisine

Fast Bad Cuisine est une application web de référencement de recettes. Ajoutez vos propres recettes, recherchez des recettes, et bien plus encore !

## Installation

Pour installer et exécuter ce projet, suivez les instructions ci-dessous.

### Prérequis

* Serveur web (tel que Wamp)
* PHP 7.4+
* Système de base de données (MariaDB/MySQL)

### Étapes d'installation

1. Clonez ce dépôt dans le répertoire de votre serveur web en utilisant la commande `git clone https://github.com/your_username/fast_bad_cuisine.git`
2. Assurez-vous que votre serveur est en cours d'exécution et accédez à localhost/your_server_location dans votre navigateur.
3. Importez le fichier SQL `database_setup.sql` pour configurer votre base de données.

### Configuration de la base de données

Modifiez le fichier `config_db.php` en spécifiant le nom de votre serveur, le nom de votre base de données, votre nom d'utilisateur et votre mot de passe.

```php
define('DB_SERVER', 'your_server'); 
define('DB_NAME', 'your_database_name'); 
define('DB_USER', 'your_username'); 
define('DB_PASSWORD', 'your_password');
```

## Exécution des tests

Pour exécuter les tests unitaires, vous devez avoir PHPUnit installé.

Installez PHPUnit via Composer en utilisant la commande `composer require --dev phpunit/phpunit ^9`

Ensuite, pour exécuter les tests, accédez au répertoire du projet dans votre terminal et tapez `./vendor/bin/phpunit tests`

PHPUnit commencera ensuite à exécuter tous les tests unitaires dans le répertoire `tests`.