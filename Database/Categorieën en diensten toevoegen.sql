/** Categorieën **/
INSERT INTO afbeelding
VALUES ('programmer.png'),
	   ('accountant.png'),
       ('journalist.png'),
       ('carpenter-1.png'),
       ('cyclist.png'),
       ('cooker.png'),
       ('ailurophile.png')
       ;

INSERT INTO categorie (categorie, afbeelding_Afbeelding)
VALUES ('Woning gerelateerd'),
	   ('Computer gerelateerde vragen','programmer.png' ),
       ('Administratie','accountant.png'),
       ('Vragen rondom sollicitatie','journalist.png'),
       ('Vragen rondom overheid'),
       ('Handwerk','carpenter-1.png'),
       ('Sanitair'),
       ('Vervoer', 'cyclist.png'),
       ('Koken', 'cooker.png'),
       ('Sociaal', 'ailurophile.png');
       

/** Diensten **/
INSERT INTO dienst (dienst, omschijving, afbeelding_Afbeelding, Categorie_Categorie)
VALUES 
	   ('Hulp bij zoeken woningnet','Hulp bij het zoeken van een woning bij woningnet.',NULL,'Woning gerelateerd'),
       ('Reageren op bezichtigingen','Hulp bij het reageren op bezichtigingen m.a.v. een datum prikken.', NULL ,'Woning gerelateerd'),
       ('Gebruiken van e-mail','Hulp bij het gebruik maken van email.','programmer.png','Computer gerelateerde vragen'),
       ('Installeren van internet','Hulp bij het leren installeren van internet op de computer of telefoon.','programmer.png','Computer gerelateerde vragen'),
       ('Gebruiken van social media','Hulp bij het leren grbuiken van social media.','programmer.png','Computer gerelateerde vragen'),
       ('Hulp bij uitkiezen nieuwe computer','Hulp bij het uitkiezen van een nieuwe computer.','programmer.png','Computer gerelateerde vragen'),
       ('Virus gerelateerd','Het laten verwijderen van een virus op de computer.','programmer.png','Computer gerelateerde vragen'),
       ('Basics mobiele telefoon','De basics van de mobiele telfoon zoals een sms versturen of applicaties installeren uitgelegd krijgen.','programmer.png','Computer gerelateerde vragen'),
       ('Hulp bij lezen van post','Leren hoe U de post moet lezen en waar U op moet letten.','accountant.png','Administratie'),
       ('Afhandelen van post','Hulp bij het afhandelen van post van bijv. instanties.','accountant.png','Administratie'),
       ('Bellen van instanties','Leer hoe je een gesprek kan voeren met instanties.','accountant.png','Administratie'),
       ('Formulieren invullen','Formulieren laten invullen voor aanvragen.','accountant.png','Administratie'),
       ('CV-opstellen','Leer hoe U een mooie cv kunt opstellen.','journalist.png','Vragen rondom sollicitatie'),
       ('Reageren op (online) sollicitaties','Leer hoe U kunt reageren op online sollicitaties.','journalist.png','Vragen rondom sollicitatie'),
       ('Inschrijven bij uitzendbureaus','Laat U inschrijven bij uitendbureaus om zo aan een baan te komen.','journalist.png','Vragen rondom sollicitatie'),
       ('Doorgeven van verlof','Leer hoe U verlof kan vragen bij U werkgever.','journalist.png','Vragen rondom sollicitatie'),
       ('Oefenen/Leren sollicitatiegesprek','Leren hoe U een sollicitatiegesprek moet voeren.','journalist.png','Vragen rondom sollicitatie'),
       ('Aanvragen en activeren DigiD code','Hulp bij aanvragen DigdiD.',NULL,'Vragen rondom overheid'),
       ('Gebruik maken van (overheid) websites met behulp van Digid','Hulp bij gebruik maken van websites waar DigiD vereist is.',NULL,'Vragen rondom overheid'),
       ('Belastingdienst/toeslagen','Hulp bij alles rondom de belastingdienst of toeslagen.',NULL,'Vragen rondom overheid'),
       ('SVB','Hulp bij alles rondom SVB.',NULL,'Vragen rondom overheid'),
       ('Zorgverzekering','Hulp bij inloggen bij de zorgverzekering dmv DigiD.',NULL,'Vragen rondom overheid'),
       ('Mijn Overheid','Hulp bij het gebruken maken van MijnOverheid.',NULL,'Vragen rondom overheid'),
       ('Timmeren','Leer hoe U veilig en efficient kunt timmeren.','carpenter-1.png','Handwerk'),
       ('Monteren','Leer hoe U bepaalde objecten kunt monteren.','carpenter-1.png','Handwerk'),
       ('Verven','Hulp in het verven zodat U kunt verven zonder spetters op de grond.','carpenter-1.png','Handwerk'),
       ('Verhuizen','Hulp nodig bij het verhuizen.','carpenter-1.png','Handwerk'),
       ('Tuinieren','Leer hoe U kunt tuinieren zodat uw tuin er verzorgd uit ziet.','carpenter-1.png','Handwerk'),
       ('Boren','Leer veilig boren.','carpenter-1.png','Handwerk'),
       ('Kast in elkaar zetten','Een kast in elkaar leren zetten.','carpenter-1.png','Handwerk'),
       ('Schuur opknappen','U schuur opruimen en aanpassingen maken aan de inrichting.','carpenter-1.png','Handwerk'),
       ('Ramen lappen','Hulp bij het lappen van ramen.','carpenter-1.png','Handwerk'),
       ('Knippen','Krijg hulp bij het knippen van uw haar.','carpenter-1.png','Handwerk'),
       ('Electriciteit gerelateerd','Hulp bij bedradingen e.d. in uw huis.','carpenter-1.png','Handwerk'),
       ('Afwassen','Hulp bij het afwassen van uw serviesgoed.',NULL,'Sanitair'),
       ('Schoonmaken van badkamer en WC','Hulp bij het schoonmaken van uw badkamer en uw WC.',NULL,'Sanitair'),
       ('Verwijderen van bacterien dmv hoge druk spuit','Laat uw keuken badkamer of toilet weer stralen.',NULL,'Sanitair'),
       ('Openbaarvervoer (bus/trein/metro)','Hulp bij het gebruik maken van openbaar vervoer.','cyclist.png','Vervoer'),
       ('Fietsen','Hulp in het leren fietsen zodat je zelf veilig met de fiets over straat kan.','cyclist.png','Vervoer'),
       ('Eenvoudige gerechten','Leer eenvoudige gerechten maken zoals bijv pasta/rijst.','cooker.png','Koken'),
       ('Ingewikkelde gerechten','Leer ingewikkelde gerechten maken voor U bezoek.','cooker.png','Koken'),
       ('Ontbijt','Hulp bij een gezond ontbijtje.','cooker.png','Koken'),
       ('Meal-preppen','Eten voor de hele week in bakjes zodat u niet meer hoeft te koken','cooker.png','Koken'),
       ('BBQ','Leer veilig te BBQen.','cooker.png','Koken'),
       ('Vissen','Gezellig samen op pad om een dagje te vissen.','ailurophile.png','Sociaal'),
       ('Gezellig kopje thee drinken','Samen lekker kopje thee drinken met gegarandeerd leuke gesprekstof.','ailurophile.png','Sociaal'),
       ('Uit eten gaan','Gezellig uit eten gaan met zn 2en of in een groep.','ailurophile.png','Sociaal'),
       ('Luisterend oor','Het luisterend oor voor uw problemen of juist een gezellig gesprek.','ailurophile.png','Sociaal'),
       ('Activiteiten','Gezellig samen of in een groepsverband activiteiten houden zoals bowlen of hardlopen.','ailurophile.png','Sociaal'),
       ('Sporten','Samen elkaar motiveren om je doel te behalen!','ailurophile.png','Sociaal'),
       ('Bordspel spelen','Elkaar gezelschap houden door samen een bordspel te spelen.','ailurophile.png','Sociaal'),
       ('Film kijken','Samen gezellig een fimpje kijken, dat kan zowel thuis als in de bioscoop.','ailurophile.png','Sociaal');

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