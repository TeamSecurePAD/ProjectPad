/** Categorieën **/
INSERT INTO afbeelding
VALUES (''),

INSERT INTO categorie (categorie)
VALUES ('Communicatie'),
	   ('Creatief'),
       ('Handwerk'),
       ('Koken'),
       ('Overheid'),
       ('Sanitair'),
       ('Sociaal'),
       ('Vervoer');
       


/** Diensten **/
INSERT INTO dienst (dienst, omschijving, Afbeelding, Categorie_Categorie)
VALUES ('Afwassen', 'Handigheid krijgen in afwassen.', NULL, 'Sanitair'),
	   ('Badkamer schoonmaken', 'Een badkamer schoon maken en schoon houden.', NULL, 'Sanitair'),
       ('DigiD aanvragen', 'Hulp met het aanvragen van een DigiD', NULL, 'Overheid'),
       ('Hout zagen', 'Leren hout efficiënt te zagen met verschillende gereedschappen en houtsoorten.', NULL, 'Handwerk'),
       ('Kast bouwen', 'Een kast in elkaar leren zetten.', NULL, 'Handwerk'),
       ('Leren fietsen', 'Hulp in het leren fietsen zodat je zelf veilig met de fiets over straat kan.', NULL, 'Vervoer'),
       ('Pasta maken', 'Lekker pasta leren koken.', NULL, 'Koken'),
       ('Persoonsvervoer: auto', 'Met de auto naar een locatie gebracht worden.', NULL, 'Vervoer'),
       ('Schuur opknappen', 'Je schuur opruimen en aanpassingen maken aan de inrichting.', NULL, 'Handwerk'),
       ('Vissen', 'Gezellig samen op pad om een dagje te vissen.', NULL, 'Sociaal'),
       ('Vlees braden', 'Vlees leren braden.', NULL, 'Koken');



/** Gebruikers **/
INSERT INTO gebruiker (achternaam, email, naam, omschrijving, postcode, straat, telefoonnummer, tussenvoegsel, wachtwoord, woonplaats)
VALUES ('Sickenga', 'g.sickenga@gmail.com', 'Gijs', 'Ik ben Gijs en ik hou van ijs.', '3741PC', 'Frans Halslaan 3', '0620503160', '', 'fiets', 'Baarn'),
	   ('Langeveld', 'rik_langeveld@hotmail.com', 'Rik', 'Ik ben Rik het database beest. DATABEEST HAHAHA.', '2251LH', 'Leidseweg 128c', '0644965087', '', 'kikker', 'Voorschoten'),
       ('Jenkins', 'l.jenkins@rush_in.com', 'Leeroy', 'LET\'S DO THIS', '1337LJ', 'Welp Road 69', '0606060606', '', 'wow', 'Azaroth'),
       ('Test_Achternaam', 'test', 'Test_Voornaam', 'Test_Beschrijving', '1234TE', 'Test_Straat 1', '0699999999', 'Test_Tussenvoegsel', 'test', 'Test_Stad'),
       ('Test2_Achternaam', 'test2', 'Test2_Voornaam', 'Test2_Beschrijving', '1234TE', 'Test_Straat 2', '0699999999', 'Test2_Tussenvoegsel', 'test2', 'Test2_Stad'),
       ('Diensten', 'test3', 'Gebruiker', 'Test3_Beschrijving', '1234TE', 'Test_Straat 3', '0699999999', 'zonder', 'test3', 'Test3_Stad');
       


/** Diensten aanbieden **/
INSERT INTO gebruiker_bied_dienst_aan (gebruiker_id, dienst_dienst)
VALUES ('1', 'DigiD aanvragen'),
	   ('1', 'Hout zagen'),
       ('1', 'Kast bouwen'),
       ('1', 'Schuur opknappen'),
       
       ('2', 'Vissen'),
	   ('2', 'Vlees braden'),
       ('2', 'Pasta maken'),
       ('2', 'DigiD aanvragen'),
       
       ('3', 'Badkamer schoonmaken'),
	   ('3', 'Afwassen'),
       
       ('4', 'Vissen'),
	   ('4', 'Vlees braden'),
       ('4', 'Pasta maken'),
       ('4', 'Persoonsvervoer: auto'),
       
       ('5', 'Hout zagen'),
       ('5', 'Pasta maken');
       


/** Gebruikers kwaliteiten **/
INSERT INTO gebruiker_is_goed_in_categorie (gebruiker_id, categorie_categorie)
VALUES ('1', 'Handwerk'),
       
       ('2', 'Koken'),
       
       ('3', 'Sanitair'),
       
       ('4', 'Koken'),
       
       ('5', 'Vervoer');



/** Gebruikers slechte categorieën **/
INSERT INTO gebruiker_is_slecht_in_categorie (gebruiker_id, categorie_categorie)
VALUES ('1', 'Koken'),
       
       ('2', 'Handwerk'),
       
       ('3', 'Vervoer'),
       
       ('4', 'Handwerk'),
       
       ('5', 'Sanitair');



/** Gebruikers diensten vragen **/
INSERT INTO gebruiker_vraagt_dienst (gebruiker_id, dienst_dienst)
VALUES ('1', 'Vissen'),
	   ('1', 'Vlees braden'),
       ('1', 'Afwassen'),
       
       ('2', 'Kast bouwen'),
       ('2', 'Schuur opknappen'),
       
       ('3', 'Hout zagen'),
       ('3', 'Pasta maken'),
       
       ('4', 'Hout zagen'),
       ('4', 'Kast bouwen'),
       
       ('5', 'Badkamer schoonmaken'),
	   ('5', 'Afwassen');