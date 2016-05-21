/** Categorieën **/

INSERT INTO categorie (categorie)
VALUES ('Woning'),
	   ('Computer'),
       ('Administratie'),
       ('Solliciteren'),
       ('Overheid'),
       ('Handwerk'),
       ('Sanitair'),
       ('Vervoer'),
       ('Koken'),
       ('Sociaal');
       

/** Diensten **/
INSERT INTO dienst (dienst, omschijving, Categorie_Categorie)
VALUES 
	   ('Woningnet','Hulp bij het zoeken van een woning bij woningnet.','Woning'),
       ('Bezichtigingen','Hulp bij het reageren op bezichtigingen m.a.v. een datum prikken.','Woning'),
       ('E-mail gebruiken','Hulp bij het gebruik maken van email.','Computer'),
       ('Internet configureren','Hulp bij het leren opzetten van een internet verbinding op de computer of telefoon.','Computer'),
       ('Social media','Hulp bij het leren grbuiken van social media.','Computer'),
       ('Computer aanschaffen','Hulp bij het uitkiezen van een nieuwe computer.','Computer');
       
/** Diensten **/
INSERT INTO dienst (dienst, omschijving, Categorie_Categorie)
VALUES 
       ('Virus verwijderen','Het laten verwijderen van een virus op de computer.','Computer'),
       ('Mobiele telefoon','De basics van de mobiele telefoon zoals een sms versturen of applicaties installeren uitgelegd krijgen.','Computer'),
       ('Post lezen','Leren hoe u de post moet lezen en waar u op moet letten.','Administratie'),
       ('Post afhandelen','Hulp bij het Post afhandelen van bijv. instanties.','Administratie'),
       ('Instanties bellen','Leer hoe je een gesprek kan voeren met instanties.','Administratie'),
       ('Formulieren invullen','Formulieren laten invullen voor aanvragen.','Administratie'),
       ('CV-opstellen','Leer hoe u een mooie cv kunt opstellen.','Solliciteren');

/** Diensten **/
INSERT INTO dienst (dienst, omschijving, Categorie_Categorie)
VALUES 
       ('Online solliciteren','Leer hoe u kunt reageren op online sollicitaties.','Solliciteren'),
       ('Inschrijven uitzendbureau','Laat u Inschrijven uitzendbureau om zo aan een baan te komen.','Solliciteren'),
       ('Verlof aanvragen','Leer hoe u verlof aan kunt vragen bij uw werkgever.','Solliciteren'),
       ('Sollicitatiegesprek','Leren hoe u een sollicitatiegesprek moet voeren.','Solliciteren'),
       ('Aanvragen DigiD','Hulp bij het aanvragen van een DigdiD.','Overheid'),
       ('Websites met DigiD','Hulp bij gebruik maken van websites waar DigiD vereist is.','Overheid'),
       ('Belasting','Hulp bij alles rondom de belastingdienst of toeslagen.','Overheid'),
       ('SVB','Hulp bij alles rondom SVB.','Overheid'),
       ('Zorgverzekering','Hulp bij inloggen bij de zorgverzekering dmv DigiD.','Overheid'),
       ('MijnOverheid','Hulp bij het gebruken maken van MijnOverheid.','Overheid'),
       ('Timmeren','Leer hoe u veilig en efficient kunt timmeren.','Handwerk'),
       ('Monteren','Leer hoe u bepaalde objecten kunt monteren.','Handwerk');

/** Diensten **/
INSERT INTO dienst (dienst, omschijving, Categorie_Categorie)
VALUES 
       ('Verven','Hulp in het verven zodat u kunt verven zonder spetters op de grond.','Handwerk'),
       ('Verhuizen','Hulp nodig bij het verhuizen.','Handwerk'),
       ('Tuinieren','Leer hoe u kunt tuinieren zodat uw tuin er verzorgd uit ziet.','Handwerk'),
       ('Boren','Leer veilig boren.','Handwerk'),
       ('Kast bouwen','Een kast in elkaar leren zetten.','Handwerk'),
       ('Schuur opknappen','u schuur opruimen en aanpassingen maken aan de inrichting.','Handwerk'),
       ('Ramen lappen','Hulp bij het lappen van ramen.','Handwerk'),
       ('Knippen','Krijg hulp bij het knippen van uw haar.','Handwerk'),
       ('Elektriciteit','Hulp bij bedradingen e.d. in uw huis.','Handwerk'),
       ('Afwassen','Hulp bij het afwassen van uw serviesgoed.','Sanitair'),
       ('Badkamer schoonmaken','Hulp bij het schoonmaken van uw badkamer en uw WC.','Sanitair'),
       ('Hogedrukspuit','Laat uw keuken badkamer of toilet weer stralen door met een hogedrukspuit alles grondig schoon te maken.','Sanitair'),
       ('Openbaar vervoer','Hulp bij het gebruik maken van openbaar vervoer.','Vervoer'),
       ('Fietsen','Hulp in het leren fietsen zodat je zelf veilig met de fiets over straat kan.','Vervoer'),
       ('Eenvoudige gerechten','Leer eenvoudige gerechten maken zoals bijv. pasta of rijst.','Koken'),
       ('Ingewikkelde gerechten','Leer ingewikkelde gerechten maken voor u bezoek.','Koken'),
       ('Ontbijt','Hulp bij een gezond ontbijtje.','Koken'),
       ('Meal-preppen','Eten voor de hele week in bakjes zodat u niet meer hoeft te koken','Koken'),
       ('BBQ','Leer veilig te BBQen.','Koken'),
       ('Vissen','Gezellig samen op pad om een dagje te vissen.','Sociaal'),
       ('Thee drinken','Samen lekker kopje thee drinken met gegarandeerd leuke gesprekstof.','Sociaal'),
       ('Uit eten gaan','Gezellig Uit eten gaan met zn 2en of in een groep.','Sociaal'),
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
	   ('1', 'Internet configureren'),
       ('1', 'Woningnet'),
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
       ('3', 'Badkamer schoonmaken'),
	   ('3', 'Sporten'),
	   ('3', 'Hogedrukspuit');

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
       ('5', 'Elektriciteit'),
       ('5', 'Openbaar vervoer');
       


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
       ('2', 'Kast bouwen'),
       ('2', 'Schuur opknappen'),
       ('2', 'Ramen lappen'),
       ('2', 'Elektriciteit'),
       
       ('3', 'Openbaar vervoer'),
       ('3', 'Eenvoudige gerechten'),
       ('3', 'Meal-preppen'),
       
       ('4', 'Instanties bellen'),
       ('4', 'Formulieren invullen'),
       ('4', 'MijnOverheid'),
       
       ('5', 'Badkamer schoonmaken'),
	   ('5', 'Afwassen'),
       ('5', 'Ramen lappen');
