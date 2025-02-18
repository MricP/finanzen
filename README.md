# TP Noté - PHP

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