/** Categorieën **/

INSERT INTO categorie (categorie)
VALUES ('Woning gerelateerd'),
	   ('Computer gerelateerde vragen' ),
       ('Administratie'),
       ('Vragen rondom sollicitatie'),
       ('Vragen rondom overheid'),
       ('Handwerk'),
       ('Sanitair'),
       ('Vervoer'),
       ('Koken'),
       ('Sociaal');
       

/** Diensten **/
INSERT INTO dienst (dienst, omschijving, Categorie_Categorie)
VALUES 
	   ('Hulp bij zoeken woningnet','Hulp bij het zoeken van een woning bij woningnet.','Woning gerelateerd'),
       ('Reageren op bezichtigingen','Hulp bij het reageren op bezichtigingen m.a.v. een datum prikken.','Woning gerelateerd'),
       ('Gebruiken van e-mail','Hulp bij het gebruik maken van email.','Computer gerelateerde vragen'),
       ('Installeren van internet','Hulp bij het leren installeren van internet op de computer of telefoon.','Computer gerelateerde vragen'),
       ('Gebruiken van social media','Hulp bij het leren grbuiken van social media.','Computer gerelateerde vragen'),
       ('Hulp bij uitkiezen nieuwe computer','Hulp bij het uitkiezen van een nieuwe computer.','Computer gerelateerde vragen');
       
/** Diensten **/
INSERT INTO dienst (dienst, omschijving, Categorie_Categorie)
VALUES 
       ('Virus gerelateerd','Het laten verwijderen van een virus op de computer.','Computer gerelateerde vragen'),
       ('Basics mobiele telefoon','De basics van de mobiele telfoon zoals een sms versturen of applicaties installeren uitgelegd krijgen.','Computer gerelateerde vragen'),
       ('Hulp bij lezen van post','Leren hoe U de post moet lezen en waar U op moet letten.','Administratie'),
       ('Afhandelen van post','Hulp bij het afhandelen van post van bijv. instanties.','Administratie'),
       ('Bellen van instanties','Leer hoe je een gesprek kan voeren met instanties.','Administratie'),
       ('Formulieren invullen','Formulieren laten invullen voor aanvragen.','Administratie'),
       ('CV-opstellen','Leer hoe U een mooie cv kunt opstellen.','Vragen rondom sollicitatie');

/** Diensten **/
INSERT INTO dienst (dienst, omschijving, Categorie_Categorie)
VALUES 
       ('Reageren op (online) sollicitaties','Leer hoe U kunt reageren op online sollicitaties.','Vragen rondom sollicitatie'),
       ('Inschrijven bij uitzendbureaus','Laat U inschrijven bij uitendbureaus om zo aan een baan te komen.','Vragen rondom sollicitatie'),
       ('Doorgeven van verlof','Leer hoe U verlof kan vragen bij U werkgever.','Vragen rondom sollicitatie'),
       ('Oefenen/Leren sollicitatiegesprek','Leren hoe U een sollicitatiegesprek moet voeren.','Vragen rondom sollicitatie'),
       ('Aanvragen en activeren DigiD code','Hulp bij aanvragen DigdiD.','Vragen rondom overheid'),
       ('Gebruik websites met behulp van Digid','Hulp bij gebruik maken van websites waar DigiD vereist is.','Vragen rondom overheid'),
       ('Belastingdienst/toeslagen','Hulp bij alles rondom de belastingdienst of toeslagen.','Vragen rondom overheid'),
       ('SVB','Hulp bij alles rondom SVB.','Vragen rondom overheid'),
       ('Zorgverzekering','Hulp bij inloggen bij de zorgverzekering dmv DigiD.','Vragen rondom overheid'),
       ('Mijn Overheid','Hulp bij het gebruken maken van MijnOverheid.','Vragen rondom overheid'),
       ('Timmeren','Leer hoe U veilig en efficient kunt timmeren.','Handwerk'),
       ('Monteren','Leer hoe U bepaalde objecten kunt monteren.','Handwerk');

/** Diensten **/
INSERT INTO dienst (dienst, omschijving, Categorie_Categorie)
VALUES 
       ('Verven','Hulp in het verven zodat U kunt verven zonder spetters op de grond.','Handwerk'),
       ('Verhuizen','Hulp nodig bij het verhuizen.','Handwerk'),
       ('Tuinieren','Leer hoe U kunt tuinieren zodat uw tuin er verzorgd uit ziet.','Handwerk'),
       ('Boren','Leer veilig boren.','Handwerk'),
       ('Kast in elkaar zetten','Een kast in elkaar leren zetten.','Handwerk'),
       ('Schuur opknappen','U schuur opruimen en aanpassingen maken aan de inrichting.','Handwerk'),
       ('Ramen lappen','Hulp bij het lappen van ramen.','Handwerk'),
       ('Knippen','Krijg hulp bij het knippen van uw haar.','Handwerk'),
       ('Elektriciteit gerelateerd','Hulp bij bedradingen e.d. in uw huis.','Handwerk'),
       ('Afwassen','Hulp bij het afwassen van uw serviesgoed.','Sanitair'),
       ('Schoonmaken van badkamer en WC','Hulp bij het schoonmaken van uw badkamer en uw WC.','Sanitair'),
       ('Verwijderen van bacterien dmv hoge druk spuit','Laat uw keuken badkamer of toilet weer stralen.','Sanitair'),
       ('Openbaarvervoer (bus/trein/metro)','Hulp bij het gebruik maken van openbaar vervoer.','Vervoer'),
       ('Fietsen','Hulp in het leren fietsen zodat je zelf veilig met de fiets over straat kan.','Vervoer'),
       ('Eenvoudige gerechten','Leer eenvoudige gerechten maken zoals bijv pasta/rijst.','Koken'),
       ('Ingewikkelde gerechten','Leer ingewikkelde gerechten maken voor U bezoek.','Koken'),
       ('Ontbijt','Hulp bij een gezond ontbijtje.','Koken'),
       ('Meal-preppen','Eten voor de hele week in bakjes zodat u niet meer hoeft te koken','Koken'),
       ('BBQ','Leer veilig te BBQen.','Koken'),
       ('Vissen','Gezellig samen op pad om een dagje te vissen.','Sociaal'),
       ('Gezellig kopje thee drinken','Samen lekker kopje thee drinken met gegarandeerd leuke gesprekstof.','Sociaal'),
       ('Uit eten gaan','Gezellig uit eten gaan met zn 2en of in een groep.','Sociaal'),
       ('Luisterend oor','Het luisterend oor voor uw problemen of juist een gezellig gesprek.','Sociaal'),
       ('Activiteiten','Gezellig samen of in een groepsverband activiteiten houden zoals bowlen of hardlopen.','Sociaal'),
       ('Sporten','Samen elkaar motiveren om je doel te behalen!','Sociaal'),
       ('Bordspel spelen','Elkaar gezelschap houden door samen een bordspel te spelen.','Sociaal'),
       ('Film kijken','Samen gezellig een fimpje kijken, dat kan zowel thuis als in de bioscoop.','Sociaal');

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
VALUES ('1', 'Formulieren invullen'),
	   ('1', 'Installeren van internet'),
       ('1', 'Hulp bij zoeken woningnet'),
       ('1', 'Knippen');
       
/** Diensten aanbieden **/
INSERT INTO gebruiker_bied_dienst_aan (gebruiker_id, dienst_dienst)
VALUES
       ('2', 'BBQ'),
	   ('2', 'Meal-preppen'),
       ('2', 'Vissen'),
       ('2', 'Activiteiten');
       
/** Diensten aanbieden **/
INSERT INTO gebruiker_bied_dienst_aan (gebruiker_id, dienst_dienst)
VALUES
       ('3', 'Schoonmaken van badkamer en WC'),
	   ('3', 'Sporten'),
	   ('3', 'Verwijderen van bacterien dmv hoge druk spuit');

/** Diensten aanbieden **/
INSERT INTO gebruiker_bied_dienst_aan (gebruiker_id, dienst_dienst)
VALUES
       ('4', 'Vissen'),
	   ('4', 'Fietsen'),
       ('4', 'Timmeren'),
       ('4', 'Monteren');

/** Diensten aanbieden **/
INSERT INTO gebruiker_bied_dienst_aan (gebruiker_id, dienst_dienst)
VALUES
       ('5', 'Elektriciteit gerelateerd'),
       ('5', 'Openbaarvervoer (bus/trein/metro)');
       


/** Gebruikers kwaliteiten **/
INSERT INTO gebruiker_is_goed_in_categorie (gebruiker_id, categorie_categorie)
VALUES ('1', 'Administratie'),
       
       ('2', 'Koken'),
       
       ('3', 'Sanitair'),
       
       ('4', 'Koken'),
       
       ('5', 'Vervoer');



/** Gebruikers slechte categorieën **/
INSERT INTO gebruiker_is_slecht_in_categorie (gebruiker_id, categorie_categorie)
VALUES ('1', 'Koken'),
       
       ('2', 'Handwerk'),
       
       ('3', 'Vervoer'),
       
       ('4', 'Administratie'),
       
       ('5', 'Sanitair');



/** Gebruikers diensten vragen **/
INSERT INTO gebruiker_vraagt_dienst (gebruiker_id, dienst_dienst)
VALUES ('1', 'Vissen'),
	   ('1', 'BBQ'),
       ('1', 'Afwassen');
       
       /** Gebruikers diensten vragen **/
INSERT INTO gebruiker_vraagt_dienst (gebruiker_id, dienst_dienst)
VALUES
       ('2', 'Kast in elkaar zetten'),
       ('2', 'Schuur opknappen'),
       ('2', 'Ramen lappen'),
       ('2', 'Elektriciteit gerelateerd'),
       
       ('3', 'Openbaarvervoer (bus/trein/metro)'),
       ('3', 'Eenvoudige gerechten'),
       ('3', 'Meal-preppen'),
       
       ('4', 'Bellen van instanties'),
       ('4', 'Formulieren invullen'),
       ('4', 'Mijn Overheid'),
       
       ('5', 'Schoonmaken van Badkamer en WC'),
	   ('5', 'Afwassen'),
       ('5', 'Ramen lappen');
