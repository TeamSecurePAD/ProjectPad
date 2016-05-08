/** Categorieën **/
INSERT INTO categorie (categorie)
VALUES ('Advies');

INSERT INTO categorie (categorie)
VALUES ('Communicatie');

INSERT INTO categorie (categorie)
VALUES ('Handwerk');

INSERT INTO categorie (categorie)
VALUES ('Koken');

INSERT INTO categorie (categorie)
VALUES ('Overheid');

INSERT INTO categorie (categorie)
VALUES ('Sanitair');

INSERT INTO categorie (categorie)
VALUES ('Sociaal');

INSERT INTO categorie (categorie)
VALUES ('Vervoer');



/** Diensten **/
INSERT INTO dienst (dienst, omschijving, Afbeelding, Categorie_Categorie)
VALUES ('Afwassen', 'Handigheid krijgen in afwassen.', NULL, 'Sanitair');

INSERT INTO dienst (dienst, omschijving, Afbeelding, Categorie_Categorie)
VALUES ('Badkamer schoonmaken', 'Een badkamer schoon maken en schoon houden.', NULL, 'Sanitair');

INSERT INTO dienst (dienst, omschijving, Afbeelding, Categorie_Categorie)
VALUES ('Hout zagen', 'Leren hout efficiënt te zagen met verschillende gereedschappen en houtsoorten.', NULL, 'Handwerk');

INSERT INTO dienst (dienst, omschijving, Afbeelding, Categorie_Categorie)
VALUES ('Kast bouwen', 'Een kast in elkaar leren zetten.', NULL, 'Handwerk');

INSERT INTO dienst (dienst, omschijving, Afbeelding, Categorie_Categorie)
VALUES ('Leren fietsen', 'Hulp in het leren fietsen zodat je zelf veilig met de fiets over straat kan.', NULL, 'Vervoer');

INSERT INTO dienst (dienst, omschijving, Afbeelding, Categorie_Categorie)
VALUES ('Pasta maken', 'Lekker pasta leren koken.', NULL, 'Koken');

INSERT INTO dienst (dienst, omschijving, Afbeelding, Categorie_Categorie)
VALUES ('Persoonsvervoer: auto', 'Met de auto naar een locatie gebracht worden.', NULL, 'Koken');

INSERT INTO dienst (dienst, omschijving, Afbeelding, Categorie_Categorie)
VALUES ('Schuur opknappen', 'Je schuur opruimen en aanpassingen maken aan de inrichting.', NULL, 'Handwerk');

INSERT INTO dienst (dienst, omschijving, Afbeelding, Categorie_Categorie)
VALUES ('Vlees braden', 'Vlees leren braden.', NULL, 'Koken');