# 🚗 Touche pas au Klaxon - Application de Covoiturage

Bienvenue sur le dépôt du projet **Touche pas au Klaxon**, une application web de covoiturage interne destinée aux employés d'une entreprise multi-sites. 

Ce projet a été développé en **PHP orienté objet** en respectant l'architecture **MVC (Modèle-Vue-Contrôleur)**. Il permet aux employés de proposer et de réserver des trajets entre différentes agences, tout en offrant une interface d'administration sécurisée pour la gestion globale de la plateforme.

## 🛠️ Stack Technique

* **Back-end :** PHP 8.x (Architecture MVC, requêtes préparées PDO)
* **Base de données :** MySQL / MariaDB
* **Front-end :** HTML5, Bootstrap 5, Sass (compilé en CSS)
* **Qualité & Tests :** PHPUnit (Tests unitaires), PHPStan (Analyse statique)
* **Serveur web recommandé :** Apache (via XAMPP)

## ⚙️ Prérequis

Avant de commencer, assurez-vous de disposer des éléments suivants sur votre machine :
- [PHP](https://www.php.net/) (version 8.0 ou supérieure)
- [Composer](https://getcomposer.org/) (gestionnaire de dépendances)
- Un serveur web local avec MySQL (ex: [XAMPP](https://www.apachefriends.org/fr/index.html))

## 🚀 Guide d'Installation

**1. Récupération du projet**
Ouvrez votre terminal et placez-vous dans le répertoire racine de votre serveur web (par défaut `C:\xampp\htdocs` sous Windows). Clonez ensuite ce dépôt :
```bash
cd C:\xampp\htdocs
git clone [https://github.com/votre-nom-utilisateur/touche-pas-au-klaxon.git](https://github.com/votre-nom-utilisateur/touche-pas-au-klaxon.git)
cd touche-pas-au-klaxon
```

**2. Installation des dépendances**
Installez les bibliothèques requises pour le développement et les tests via Composer :
```bash
composer install
```

**3. Configuration de la Base de Données**
- Ouvrez phpMyAdmin (ou votre client SQL favori).
- Créez une nouvelle base de données nommée `touche_pas_au_klaxon`.
- Importez le fichier SQL fourni à la racine du projet (`creation_bdd.sql`) pour générer les tables et les jeux de données de démonstration.
- *(Optionnel)* Si vos identifiants SQL locaux diffèrent de `root` (sans mot de passe), mettez à jour la configuration dans le fichier `models/Database.php`.

**4. Lancement de l'application**
Accédez à l'application via votre navigateur web en tapant l'URL suivante :
`http://localhost/touche-pas-au-klaxon/`

## 🧪 Tests et Qualité du Code

Ce projet respecte les standards de qualité professionnels. Les commandes suivantes peuvent être exécutées depuis la racine du projet (`C:\xampp\htdocs\touche-pas-au-klaxon`) :

**Tests Unitaires (PHPUnit)**
Les tests vérifient la fiabilité des opérations d'écriture en base de données.
```bash
./vendor/bin/phpunit tests/
```

**Analyse Statique (PHPStan)**
Le typage et la structure du code ont été validés au niveau 5 de sévérité.
```bash
./vendor/bin/phpstan analyse models --level=5
```

**Documentation**
L'ensemble des fonctions métiers et des requêtes SQL sont documentées selon la norme standard **DocBlock**.

## 📂 Livrables de Conception Architecturale

Les schémas modélisant l'architecture de la base de données sont inclus dans les livrables du projet :
- **MCD (Modèle Conceptuel de Données) :** Fourni au format image (fichier `.png`), illustrant les entités et les cardinalités.
- **MLD (Modèle Logique de Données) :** Format textuel définissant les clés primaires et étrangères.

---
*Projet réalisé dans le cadre de la formation Développeur Web (Centre Européen de Formation).*