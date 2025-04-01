# TP Noté - PHP

### Poisson d'avril
![Poisson d'avril](https://image.over-blog.com/y7Rlwfcuj4PMZrHV_v3-DVz8Ui0=/filters:no_upscale()/image%2F0946180%2F20220331%2Fob_72d1bf_poisson-d-avril-gif-anime-a.gif)


---

## Installation et mise en place

---

### Prérequis 
- Installer Git ([Git](https://git-scm.com/downloads))
- Installer PHP ([PHP](https://www.php.net/downloads.php))
- Installer Composer ([Composer](https://getcomposer.org/download/))
- Installer un IDE ([VS Code](https://code.visualstudio.com/download) | [PHP Storm](https://www.jetbrains.com/fr-fr/phpstorm/download/#section=windows))

**Suivez les instructions d'installation respectives des logiciels ci-dessus pour préparer votre environnement de développement.**

### Vérifier l'installation de Git, PHP et Composer
1. Ouvrez un CLI (Interface en ligne de commande) comme un Shell ou un Terminal
2. Vérifier l'installation de Git en utilisant la commande pour afficher sa version :
```
git -v
```
Si Git est bien installé, vous devriez pouvoir voir un message similaire à celui-ci (qui changera en fonction de votre version de Git):
```
git version 2.45.2.windows.1
```
**Dans le cas contraire, Git n'est pas installé sur votre ordinateur.**
- [Télécharger Git ici](https://git-scm.com/downloads)

3. Vérifier l'installation de PHP en utilisant la commande pour afficher sa version :
```
php -v
```
Si PHP est bien installé, vous devriez pouvoir voir un message similaire à celui-ci (qui changera en fonction de votre version de PHP):
```
PHP 8.2.21 (cli) (built: Jul  2 2024 14:02:29) (ZTS Visual C++ 2019 x64)
Copyright (c) The PHP Group
Zend Engine v4.2.21, Copyright (c) Zend Technologies
```
**Dans le cas contraire, PHP n'est pas installé sur votre ordinateur.**
- [Télécharger PHP](https://www.php.net/downloads.php)

4. Vérifier l'installation de Composer en utilisant la commande pour afficher sa version :
```
composer -V
```
Si Composer est bien installé, vous devriez pouvoir voir un message similaire à celui-ci (qui changera en fonction de votre version de Composer):
```
Composer version 2.7.7 2024-06-10 22:11:12
PHP version 8.2.21 (C:\PHP8\php.exe)
Run the "diagnose" command to get more detailed diagnostics output.
```
**Dans le cas contraire, Composer n'est pas installé sur votre ordinateur.**
- [Télécharger Composer ici](https://getcomposer.org/download/)

### Mettre en place le projet
1. Cloner le projet avec Git :
- Par HTTPS :
```
git clone https://forge.univ-lyon1.fr/mathieu.corne/finanzen.git
```
- Par SSH (si configuré) :
```
git clone git@forge.univ-lyon1.fr:mathieu.corne/finanzen.git
```
2. Installer les dépendances de Symfony avec Composer
```
composer i
```
3. Dans un terminal dédié, lancer le serveur PHP sur le port 5500 dans le dossier public du projet :
```
cd public
php -S 127.0.0.1:5500

```
**Le terminal devra rester en cours d'exécution tant que l'on souhaite utiliser le serveur PHP**

ou bien lancer WAMPP Server et créer une base de donnée :
```
finanzen

```
Pour créer l'architecture de la base de données il faut effectuer la commande suivante dans un terminal de commande 

```
php bin/console do:mi:mi

```
Pour remplir la base de données, il faut effectuer la commande suivante dans un terminal de commande 

```
php bin/console doctrine:fixtures:loa
```
En cas d'erreur (sur le do:mi:mi), supprimer votre base de données et recréer la, puis enlevez toutes les versions dans le dossier migration/ et effectuer ces commandes :

```
php bin/console do:mi:di
php bin/console do:mi:mi
php bin/console doctrine:fixtures:loa


```
Pour remplir la base de données, il faut effectuer la commande suivante dans un terminal de commande 

```
php bin/console doctrine:fixtures:loa
```
---

## Connexion

---
Le compte déja créé grâce à la fixture est un compte admin :

```
mail : minh@ad.fr
mot de passe : admin12
```

## Espace admin

---
Pour la sécurité du /admin, il y a un url different et caché :
```
/admin-x7y2z9w4

```
/admin-x7y2z9w4
---

## Notation

---

- [ ] **18 points - Fonctionnalités**
- [ ] **1 point - CSS**
- [ ] **1 point - Qualité du code : Structure globale, nommage des variables, etc.**

**BONUS - 1 point max (sans dépasser 20)**
- Compréhension du framework et de ses possibilités
- Implication dans le cours

**Présentation orale notée séparément**

---

## Fonctionnalités (18 points)

---

- [ ] **3 points - Système d'authentification**
- [ ] **9 points - Deuxième écran - Page avec l'ensemble des listes de courses**
- [ ] **3 points - 3ème écran - Page de la liste de course**
- [ ] **3 points - Système d'administration**

### Système d'authentification (3 points)

**(2 points/form + 1 point pour la redirection du pseudo )**

#### Inscription (2 points)
- [ ] Champs Adresse email + mot de passe obligatoires 
- [ ] Redirection vers un formulaire pour renseigner le pseudo

#### Connexion (1 point)
- [ ] Champs Adresse email + mot de passe obligatoires

---

### Deuxième écran - Page avec l'ensemble des listes de courses (9 points)


#### Consultation des listes de course (2 point)
- [ ] Pouvoir consulter l'ensemble de ses propres listes de course
- [ ] Pour chaque liste de course, voir le détail des 3 premiers articles
- [ ] **Après l'authentification, redirection vers cette page**

#### Ajout et suppression d'une liste de course (2 point)
- [ ] Bouton d'ajout d'une nouvelle liste de course + Redirection vers le 3ème écran avec input pour le nom de la liste
- [ ] Bouton de suppression d'une nouvelle liste de course

#### Statistiques (5 points)
- [ ] Totalité des sommes dépensées
- [ ] Moyenne du coût par article
- [ ] Article le plus cher
- [ ] Article le moins cher
- [ ] Répartition des dépenses par type d’article

---

### 3ème écran - Page de la liste de course (3 points)

#### Gérer sa liste de course (3 points)
- [ ] Pouvoir sélectionner puis ajouter un article déjà défini par l'admin dans une certaine quantité
- [ ] Pouvoir supprimer un article de sa liste de course
- [ ] Pouvoir indiquer un article comme "acheté"

---

### Système d'administration (3 points)

**(2 points/CRUD + 1 point gestion admin)**

- [ ] CRUD pour les articles
- [ ] CRUD pour les types d'articles