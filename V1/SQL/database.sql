
-- Création de la table vmembre (ENUM remplacé par VARCHAR)
CREATE TABLE vmembre (
    id_membre INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50),
    date_naissance DATE,
    genre VARCHAR(10), -- Remplacement de ENUM par VARCHAR
    email VARCHAR(100) UNIQUE,
    ville VARCHAR(50),
    mdp VARCHAR(255),
    image_profil VARCHAR(255)
);

-- Création de la table vcategorie_objet
CREATE TABLE vcategorie_objet (
    id_categorie INT PRIMARY KEY AUTO_INCREMENT,
    nom_categorie VARCHAR(50)
);

-- Création de la table vobjet
CREATE TABLE vobjet (
    id_objet INT PRIMARY KEY AUTO_INCREMENT,
    nom_objet VARCHAR(100),
    id_categorie INT,
    id_membre INT,
    FOREIGN KEY (id_categorie) REFERENCES vcategorie_objet(id_categorie),
    FOREIGN KEY (id_membre) REFERENCES vmembre(id_membre)
);

-- Création de la table vimages_objet
CREATE TABLE vimages_objet (
    id_image INT PRIMARY KEY AUTO_INCREMENT,
    id_objet INT,
    nom_image VARCHAR(255),
    FOREIGN KEY (id_objet) REFERENCES vobjet(id_objet)
);

-- Création de la table vemprunt
CREATE TABLE vemprunt (
    id_emprunt INT PRIMARY KEY AUTO_INCREMENT,
    id_objet INT,
    id_membre INT,
    date_emprunt DATE,
    date_retour DATE,
    FOREIGN KEY (id_objet) REFERENCES vobjet(id_objet),
    FOREIGN KEY (id_membre) REFERENCES vmembre(id_membre)
);

-- Création d'une vue pour lister les objets avec leur catégorie et statut d'emprunt
CREATE VIEW vue_objets AS
SELECT 
    o.id_objet,
    o.nom_objet,
    c.nom_categorie,
    m.nom AS proprietaire,
    e.date_retour
FROM vobjet o
JOIN vcategorie_objet c ON o.id_categorie = c.id_categorie
JOIN vmembre m ON o.id_membre = m.id_membre
LEFT JOIN vemprunt e ON o.id_objet = e.id_objet AND e.date_retour >= CURDATE();

-- Insertion des données de test : 4 membres
INSERT INTO vmembre (id_membre, nom, date_naissance, genre, email, ville, mdp, image_profil) VALUES
(1, 'Jean Dupont', '1990-05-15', 'Homme', 'jean.dupont@email.com', 'Paris', 'motdepasse123', 'profil1.jpg'),
(2, 'Marie Curie', '1985-11-22', 'Femme', 'marie.curie@email.com', 'Lyon', 'motdepasse456', 'profil2.jpg'),
(3, 'Paul Martin', '1995-03-10', 'Homme', 'paul.martin@email.com', 'Marseille', 'motdepasse789', 'profil3.jpg'),
(4, 'Sophie Lefevre', '1992-07-30', 'Femme', 'sophie.lefevre@email.com', 'Toulouse', 'motdepasse101', 'profil4.jpg');

-- Insertion des données de test : 4 catégories
INSERT INTO vcategorie_objet (id_categorie, nom_categorie) VALUES
(1, 'Esthétique'),
(2, 'Bricolage'),
(3, 'Mécanique'),
(4, 'Cuisine');

-- Insertion des données de test : 40 objets (10 par membre, répartis sur les catégories)
INSERT INTO vobjet (id_objet, nom_objet, id_categorie, id_membre) VALUES
-- Membre 1 (Jean Dupont)
(1, 'Miroir', 1, 1), (2, 'Parfum', 1, 1), (3, 'Pinceau maquillage', 1, 1),
(4, 'Perceuse', 2, 1), (5, 'Marteau', 2, 1), (6, 'Tournevis', 2, 1),
(7, 'Clé à molette', 3, 1), (8, 'Pistolet à peinture', 3, 1),
(9, 'Mixeur', 4, 1), (10, 'Poêle', 4, 1),
-- Membre 2 (Marie Curie)
(11, 'Sèche-cheveux', 1, 2), (12, 'Lisseur', 1, 2), (13, 'Vernis', 1, 2),
(14, 'Scie', 2, 2), (15, 'Niveau à bulle', 2, 2), (16, 'Pince', 2, 2),
(17, 'Pompe à vélo', 3, 2), (18, 'Clé dynamométrique', 3, 2),
(19, 'Blender', 4, 2), (20, 'Couteau de chef', 4, 2),
-- Membre 3 (Paul Martin)
(21, 'Maquillage', 1, 3), (22, 'Crème', 1, 3), (23, 'Brosse', 1, 3),
(24, 'Visseuse', 2, 3), (25, 'Cutter', 2, 3), (26, 'Mètre ruban', 2, 3),
(27, 'Cric', 3, 3), (28, 'Clé à pipe', 3, 3),
(29, 'Grill', 4, 3), (30, 'Moule à gâteau', 4, 3),
-- Membre 4 (Sophie Lefevre)
(31, 'Palette maquillage', 1, 4), (32, 'Épilateur', 1, 4), (33, 'Masque visage', 1, 4),
(34, 'Ponceuse', 2, 4), (35, 'Clous', 2, 4), (36, 'Perforateur', 2, 4),
(37, 'Compresseur', 3, 4), (38, 'Clé plate', 3, 4),
(39, 'Robot cuiseur', 4, 4), (40, 'Planche à découper', 4, 4);

-- Insertion des données de test : 10 emprunts (en utilisant les id_objet et id_membre valides)
INSERT INTO vemprunt (id_emprunt, id_objet, id_membre, date_emprunt, date_retour) VALUES
(1, 1, 2, '2025-07-01', '2025-07-15'), -- Marie emprunte le miroir de Jean
(2, 5, 3, '2025-07-02', '2025-07-20'), -- Paul emprunte le marteau de Jean
(3, 10, 4, '2025-07-03', '2025-07-18'), -- Sophie emprunte la poêle de Jean
(4, 12, 1, '2025-07-04', '2025-07-16'), -- Jean emprunte le lisseur de Marie
(5, 15, 4, '2025-07-05', '2025-07-19'), -- Sophie emprunte le niveau à bulle de Marie
(6, 20, 3, '2025-07-06', '2025-07-22'), -- Paul emprunte le couteau de chef de Marie
(7, 25, 1, '2025-07-07', '2025-07-17'), -- Jean emprunte le cutter de Paul
(8, 30, 2, '2025-07-08', '2025-07-21'), -- Marie emprunte le moule à gâteau de Paul
(9, 35, 3, '2025-07-09', '2025-07-23'), -- Paul emprunte les clous de Sophie
(10, 40, 1, '2025-07-10', '2025-07-24'); -- Jean emprunte la planche à découper de Sophie