<?php

/**
 * Return translated index.
 *
 * @param	string	$index
 * @return	string
 */
function i18n($index) {
	global $translations;

	if (!isset($translations[$index])) {
		return $index;
	}

	$language = $_SESSION['language'];

	$translation = htmlentities($translations[$index][$language]);

	$args = func_get_args();
	$args = array_slice($args, 1);
	if ($args) {
		return vsprintf($translation, $args);
	}

	return $translation;
}

// [index][language] => text
$translations = array(
	/*****************************************************
	 * Starships
	 ****************************************************/

	'nameRagnarokMkI' => array(
		'de' => 'Ragnarök Mk I',
		'en' => 'Ragnarok Mk I'
	),
	'descRagnarokMkI' => array(
		'de' => "Dieser leichte Raumjäger ist high-end Technologie... aus der Zeit der ersten Weltraum Konflikte. Man sollte jetzt nicht unbedingt sagen er sei eine Rostlaube, aber mit irgendwas musst Du das Spiel ja beginnen, oder?",
		'en' => "This light fighter is high-end technology... from the age of first space conflicts. One shouldn't say this is a rust bucket, but you gotta start the game with something, right?"
	),

	'nameGenesisSC4' => array(
		'de' => 'Genesis SC-4',
		'en' => 'Genesis SC-4'
	),
	'descGenesisSC4' => array(
		'de' => "Ein Flug mit dieser Fähre fühlt sich an, als hätte sie den Bau der ersten Raumstationen miterlebt. Immerhin bietet sie etwas Laderaum.",
		'en' => "A flight with this shuttle feels like it saw the creation of the first space stations. At least it provides some cargo space."
	),
/*
	'cargoNameCargoModule' => array(
		'de' => 'Frachtmodul',
		'en' => 'Cargo module'
	),
	'cargoDescCargoModule' => array(
		'de' => "Dieses Frachtmodul ist speziell für kleine Raumfähren entwickelt worden. Darin kannst Du ein paar Bilder von Mutti oder zufällig herum fliegenden Weltraumschrott verstauen.",
		'en' => "This cargo module has been developed specifically for small space shuttles. You can store some pictures of mommy or randomly flying around space junk in it."
	),
*/

	/*****************************************************
	 * Status block
	 ****************************************************/

	'shipCondition' => array(
		'de' => 'Schiffszustand',
		'en' => 'Ship Condition'
	),
	'endurance' => array(
		'de' => 'Ausdauer',
		'en' => 'Endurance'
	),
	'actionPoints' => array(
		'de' => 'Aktionspunkte',
		'en' => 'Action Points'
	),
	'currently' => array(
		'de' => 'Aktuell',
		'en' => 'Currently'
	),

	/*****************************************************
	 * Items
	 ****************************************************/

	'nameJunkCollector' => array(
		'de' => 'Schrottsammler',
		'en' => 'Junk collector'
	),
	'descJunkCollector' => array(
		'de' => "Mit diesem Modul kannst Du kleine Mengen Weltraumschrott einsammeln. Wozu das gut ist? Was Du selbst nicht gebrauchen kannst lässt sich bestimmt irgend ein Idiot auf dem Flohmarkt andrehen.",
		'en' => "With this module you can collect small amounts of space junk. What this is good for? Well, on the jumble sale some idiot surely will buy what you don't need for your self."
	),

	'nameImpactArmor' => array(
		'de' => 'Einschlagpanzerung',
		'en' => 'Impact plating'
	),
	'descImpactArmor' => array(
		'de' => "Einfache Stahlplatten schützen die Schiffshülle vor Partikel Einschlägen. Sie werden aber auch als Billigpanzerung genutzt; und wo ist schon der Unterschied zwischen Mikro-Meteoriten und infernalen Höllenlasern?",
		'en' => "Simple steel plates protect the hull from particle strikes. But they are also used as cheap armor; and who could even tell where the difference between micro-meteorites and infernal hell lasers is?"
	),

	'nameKineticShield' => array(
		'de' => 'Kinetischer Schild',
		'en' => 'Kinetic shield'
	),
	'descKineticShield' => array(
		'de' => "Dieser Schild hat schon so manches Schiff von Schäden durch herumfliegendem Weltraumschrott bewahrt.",
		'en' => "This shield quite protected some ships from damage through travelling space junk."
	),

	'nameEnergyShield' => array(
		'de' => 'Energieschild',
		'en' => 'Energy shield'
	),
	'descEnergyShield' => array(
		'de' => "@TODO",
		'en' => "@TODO"
	),

	'nameDistortionShield' => array(
		'de' => 'Distorsionsschild',
		'en' => 'Distortion shield'
	),
	'descDistortionShield' => array(
		'de' => "Beschützt um das Schiff, was sich im Schiff befindet.",
		'en' => "Protects around the ship, what's inside the ship."
	),

	'nameSmallBlaster' => array(
		'de' => 'Kleiner Blaster',
		'en' => 'Small blaster'
	),
	'descSmallBlaster' => array(
		'de' => "Blaster könnte man zwar als die Weiterentwicklung handelsüblicher Feuerwaffen bezeichnen, doch dieses kleine Modell ist schon mehr als überholt.",
		'en' => "Blaster can be described as the further development of marketable guns, but this small model is already far beyond outdated."
	),

	'nameLightLaser' => array(
		'de' => 'Leichter Laser',
		'en' => 'Light laser'
	),
	'descLightLaser' => array(
		'de' => 'Dies ist ein hochentwickelter Hitzestrahl, wir nennen es einen "Laser"... naja, oder doch eher sein kleiner Bruder.',
		'en' => 'This is a sophisticated heat beam which we call a "Laser"... well, or more like his little brother.'
	),

	'nameBlasterAmmunition' => array(
		'de' => 'Blaster Munition',
		'en' => 'Blaster Ammunition'
	),
	'descBlasterAmmunition' => array(
		'de' => "Hier ist der Name Programm: Das Hocherhitzte Plasma sengt dem Gegner nicht nur den Bürzel an, sondern ist auch kostengünstig in der Anschaffung.",
		'en' => "Here the name says it: The high heated plasma not only burns your opponent's rump, but is also a cheap acquisition."
	),

	'nameNuclearBatteries' => array(
		'de' => 'Atombatterie',
		'en' => 'Nuclear batteries'
	),
	'descNuclearBatteries' => array(
		'de' => "Mit diesen Batterien im Gepäck hat man immer ein strahlendes lächeln auf den Lippen.",
		'en' => "With this batteries in the luggage one always has a radiation smile on his lips."
	),

	'nameCombustionDrive' => array(
		'de' => 'Verbrennungsantrieb',
		'en' => 'Combustion drive'
	),
	'descCombustionDrive' => array(
		'de' => "@TODO",
		'en' => "@TODO"
	),
	'nameIonDrive' => array(
		'de' => 'Ionenantrieb',
		'en' => 'Ion drive'
	),
	'descIonDrive' => array(
		'de' => "@TODO",
		'en' => "@TODO"
	),
	'namePulseDrive' => array(
		'de' => 'Impulsantrieb',
		'en' => 'Pulse drive'
	),
	'descPulseDrive' => array(
		'de' => "@TODO",
		'en' => "@TODO"
	),

	/*****************************************************
	 * Ingredients
	 ****************************************************/

	'nameIron' => array(
		'de' => 'Eisen',
		'en' => 'Iron'
	),
	'nameCrystals' => array(
		'de' => 'Kristalle',
		'en' => 'Crystals'
	),
	'nameElectronics' => array(
		'de' => 'Elektronik',
		'en' => 'Electronics'
	),
	'nameEnergyCells' => array(
		'de' => 'Energiezellen',
		'en' => 'EnergyCells'
	),
	'nameSpaceJunk' => array(
		'de' => 'Weltraumschrott',
		'en' => 'SpaceJunk'
	),
	'nameTechnicalComponents' => array(
		'de' => 'Technische Komponenten',
		'en' => 'TechnicalComponents'
	),

	/*****************************************************
	 * Starship
	 ****************************************************/

	'partShield' => array(
		'de' => 'Schilde',
		'en' => 'Shields'
	),
	'partCockpit' => array(
		'de' => 'Kanzel',
		'en' => 'Cockpit'
	),
	'partWeaponry' => array(
		'de' => 'Waffenphalanx',
		'en' => 'Weapon phalanx'
	),
	'partBody' => array(
		'de' => 'Rumpf',
		'en' => 'Body'
	),
	'partEngine' => array(
		'de' => 'Antrieb',
		'en' => 'Engine'
	),

	/*****************************************************
	 * Technology
	 ****************************************************/

	'kinetic' => array(
		'de' => 'kinetisch',
		'en' => 'kinetic'
	),
	'energy' => array(
		'de' => 'Energie',
		'en' => 'energy'
	),

	/*****************************************************
	 * Navigation
	 ****************************************************/

	'quarters' => array(
		'de' => 'Quartiere',
		'en' => 'Quarters'
	),
	'tradeDeck' => array(
		'de' => 'Handelsdeck',
		'en' => 'Trade Deck'
	),
	'jumpGate' => array(
		'de' => 'Sprungtor',
		'en' => 'Jump Gate'
	),
	'academy' => array(
		'de' => 'Akademie',
		'en' => 'Academy'
	),
	'hangar' => array(
		'de' => 'Hangar',
		'en' => 'Hangar'
	),
	'factory' => array(
		'de' => 'Fabrik',
		'en' => 'Factory'
	),
	'lounge' => array(
		'de' => 'Lounge',
		'en' => 'Lounge'
	),
	'map' => array(
		'de' => 'Karte',
		'en' => 'Map'
	),
	'missions' => array(
		'de' => 'Missionen',
		'en' => 'Missions'
	),
	'status' => array(
		'de' => 'Status',
		'en' => 'Status'
	),

	/*****************************************************
	 * Designer
	 ****************************************************/

	'garage' => array(
		'de' => 'Werkstatt',
		'en' => 'Garage'
	),
	'garageDescription' => array(
		// Refers to the movie "crank".
		'de' => 'Bastle herum und stelle das cränkeste Schiff zusammen.',
		'en' => 'Handicraft around and assemble the crankest ship.'
	),
	'yourStarship' => array(
		'de' => 'Dein Raumschiff',
		'en' => 'Your starship'
	),
	'weaponry' => array(
		'de' => 'Bewaffnung',
		'en' => 'Weaponry'
	),
	'ammunition' => array(
		'de' => 'Munition',
		'en' => 'Ammunition'
	),
	'equipment' => array(
		'de' => 'Ausrüstung',
		'en' => 'Equipment'
	),
	'cargo' => array(
		'de' => 'Fracht',
		'en' => 'Cargo'
	),
	'engine' => array(
		'de' => 'Antriebssysteme',
		'en' => 'Engines'
	),
	'stock' => array(
		'de' => 'Lager',
		'en' => 'Stock'
	),
	'yourStuff' => array(
		'de' => 'Dein Kram',
		'en' => 'Your stuff'
	),

	'empty' => array(
		'de' => 'leer',
		'en' => 'empty'
	),
	'equip' => array(
		'de' => 'Ausrüsten',
		'en' => 'Equip'
	),
	'remove' => array(
		'de' => 'Entfernen',
		'en' => 'Remove'
	),

	'payload' => array(
		'de' => 'Beladung',
		'en' => 'Payload'
	),
	'tonnage' => array(
		'de' => 'Tragfähigkeit',
		'en' => 'Tonnage'
	),
	'technicalData' => array(
		'de' => 'Technische Daten',
		'en' => 'Technical data'
	),
	'energyManagement' => array(
		'de' => 'Energieversorgung',
		'en' => 'Energy management'
	),
	'internalStructure' => array(
		'de' => 'Struktur',
		'en' => 'Structure'
	),
	'additionalArmor' => array(
		'de' => 'Panzerung',
		'en' => 'Plating'
	),
	'possibleDamagePerRound' => array(
		'de' => 'Schaden pro Runde',
		'en' => 'Damage per round'
	),
	'drainPerRound' => array(
		'de' => 'Bedarf pro Runde',
		'en' => 'Drain per round'
	),
	'rechargePerRound' => array(
		'de' => 'Aufladung pro Runde',
		'en' => 'Recharge per round'
	),
	'capacity' => array(
		'de' => 'Kapazität',
		'en' => 'Capacity'
	),
	'howMany' => array(
		'de' => 'Wie viele?',
		'en' => 'How many?'
	),

	/*****************************************************
	 * Crafter
	 ****************************************************/

	'fiddle' => array(
		'de' => 'Tüfteln',
		'en' => 'Fiddle'
	),
	'craft' => array(
		'de' => 'Herstellen',
		'en' => 'Craft'
	),
	'disassemble' => array(
		'de' => 'Zerlegen',
		'en' => 'Disassemble'
	),
	'newRecipeMessage' => array(
		'de' => "Glückwunsch! Du hast herausgefunden wie %s hergestellt wird.",
		'en' => "Gratulation! You found out how to craft %s."
	),
	'fiddleSuccessMessage' => array(
		'de' => "Du hast %s hergestellt.",
		'en' => "You crafted %s."
	),
	'fiddleFailMessage' => array(
		'de' => "Daraus konntest Du leider nichts herstellen.",
		'en' => "You could not create something out of that."
	),
	'tryIt' => array(
		'de' => 'Probier`s!',
		'en' => 'Try it!'
	),
	'fiddlingAround' => array(
		'de' => 'Herumtüfteln',
		'en' => 'Fiddling around'
	),
	'fiddleDescription' => array(
		'de' => 'So mancher Schrott ist mehr wert als es scheint. Verbinde Deine Objekte und schaffe nützliche Dinge daraus.',
		'en' => 'Some junk is worth more than it seems. Combine your objects and create useful things out of them.'
	),
	'fiddleFiddle' => array(
		'de' => '*tüftel tüftel*',
		'en' => '*fiddle fiddle*'
	),
	'noRecipes' => array(
		'de' => 'Du kennst noch keine Herstellungrezepte. Finde beim tüfteln heraus, was sich zu neuen Objekten verbinden lässt.',
		'en' => 'You know no crafting recipes yet. Fiddle out what can be combined to new objects.'
	),
	'needed' => array(
		'de' => 'Benötigt',
		'en' => 'Needed'
	),
	'itemCrafted' => array(
		'de' => 'Du hast %s (1) hergestellt.',
		'en' => 'You crafted %s (1).'
	),

	/*****************************************************
	 * Profile
	 ****************************************************/

	'level' => array(
		'de' => 'Level',
		'en' => 'Level'
	),
	'experience' => array(
		'de' => 'Erfahrung',
		'en' => 'Experience'
	),
	'inflictedDamage' => array(
		'de' => 'Ausgeteilter Schaden',
		'en' => 'Inflicted damage'
	),
	'spaceDoctor' => array(
		'de' => 'Weltraum Arzt',
		'en' => 'Space doctor'
	),
	'spaceDoctorDescription' => array(
		'de' => 'Weltraumfieber und Schwerelosigkeitskrankheit sind wirklich üble Gesellen, aber wer geht schon freiwillig zum Arzt? Darum erhälst Du bei jedem Arztbesuch eine Kleinigkeit.',
		'en' => 'Space fever and zero gravtity disease are really bad companions, but who visits a doctor voluntarily? Thus you`ll get something nice for each visit at the doctor.'
	),
	'startCheck' => array(
		'de' => 'Jetzt checken',
		'en' => 'Start check'
	),
	'spaceDoctorAlreadyVisited' => array(
		'de' => 'Alles ist in bester Ordnung, komm doch morgen wieder.',
		'en' => 'Everything is as well as it could be, come again tomorrow.'
	),
	'healthCareNotAvailableYet' => array(
		'de' => 'Du warst heute schon beim Onkel Doktor.',
		'en' => 'You already visited the nice doctor toady.'
	),
	'back' => array(
		'de' => 'Zurück',
		'en' => 'Back'
	),

	/*****************************************************
	 * Academy
	 ****************************************************/

	'academyWelcome' => array(
		'de' => 'Willkommen in der Weltraum-Akademie',
		'en' => 'Welcome to the space academy'
	),
	'academyDescription' => array(
		'de' => 'Hier gibt es zwar keinen Kobayashi-Maru-Test, jedoch einige interessante Kurse, welche Dich als aufstrebenden Weltraum-Pionier weiter bringen könnten.',
		'en' => 'You can`t take a Kobayashi-Maru-Test here, but some other interesting courses, that could bring you forth as an ambitious space-pioneer.'
	),
	'courses' => array(
		'de' => 'Kurse',
		'en' => 'Courses'
	),
	'coursesText' => array(
		'de' => 'Besuche die Akademie Kurse um Deine Aktionspunkte zu steigern. Für je 2 Zertifikate erhälst Du einen weiteren Punkt.',
		'en' => 'Take academy courses to raise your action points. Every 2 certificates will grant you an additional point.'
	),
	'courseLevel' => array(
		'de' => 'Kurs Stufe %s',
		'en' => 'Course grade %s'
	),
	'startCourseText' => array(
		'de' => 'Du kannst Dich an einem Kurs einschreiben.',
		'en' => 'You can participate at a course.'
	),
	'startCourse' => array(
		'de' => 'Beginnen',
		'en' => 'Begin'
	),
	'cannotStartCourse' => array(
		'de' => 'Du kannst den Kurs nicht beginnnen.',
		'en' => 'You cannot start the course.'
	),
	'cannotFinishCourse' => array(
		'de' => 'Du musst zuerst einen Kurs bestehen.',
		'en' => 'You have to pass a course first.'
	),
	'courseStarted' => array(
		'de' => 'Und schon geht`s los!',
		'en' => 'And here we go!'
	),
	'takingCourse' => array(
		'de' => 'Du nimmst gerade am Kurs teil.',
		'en' => 'You are participating at the course.'
	),
	'courseFinished' => array(
		'de' => 'Du hast den Kurs erfolgreich beendet und kannst Dein Zertifikat abholen.',
		'en' => 'You finished the course successful and can collect your certificate.'
	),
	'gotCourseCertificate' => array(
		'de' => 'Dein Kurs Level hat sich um 1 erhöht!',
		'en' => 'Your course level increased by 1!'
	),
	'timeLeft' => array(
		'de' => 'Verbleibend',
		'en' => 'Time left'
	),
	'collect' => array(
		'de' => 'Abholen',
		'en' => 'Collect'
	),
	'price' => array(
		'de' => 'Preis',
		'en' => 'Price'
	),
	'duration' => array(
		'de' => 'Dauer',
		'en' => 'Duration'
	),
	'training' => array(
		'de' => 'Training',
		'en' => 'Training'
	),
	'cannotStartTraining' => array(
		'de' => 'Du bist fix und fertig!',
		'en' => 'You`re all run down!'
	),
	'tactics' => array(
		'de' => 'Taktik',
		'en' => 'Tactics'
	),
	'defense' => array(
		'de' => 'Abwehr',
		'en' => 'Defense'
	),
	'crafting' => array(
		'de' => 'Basteln',
		'en' => 'Crafting'
	),
	'train' => array(
		'de' => 'Trainieren',
		'en' => 'Train'
	),
	'trainDescription' => array(
		'de' => 'Zeig` den verweichlichten Kadetten, was Du drauf hast!',
		'en' => 'Show the mollycoddled cadets, what you`re about!'
	),
	'youGo' => array(
		'de' => 'Trau Dich!',
		'en' => 'You go!'
	),
	'experienceGain' => array(
		'de' => 'Du hast %s Erfahrung erhalten!',
		'en' => 'You gained %s experience!'
	),
	'levelGain' => array(
		'de' => 'Dein Level ist um 1 gestiegen!',
		'en' => 'Your level increased by one!'
	),

	/*****************************************************
	 * Tech info
	 ****************************************************/

	'weight' => array(
		'de' => 'Gewicht',
		'en' => 'Weight'
	),
	'ton' => array(
		'de' => 'Tonne',
		'en' => 'ton'
	),
	'tons' => array(
		'de' => 'Tonnen',
		'en' => 'tons'
	),
	'energyDrain' => array(
		'de' => 'Energiebedarf',
		'en' => 'Energy drain'
	),
	'perShot' => array(
		'de' => 'pro Schuss',
		'en' => 'per shot'
	),
	'burst' => array(
		'de' => 'Feuerstoß',
		'en' => 'Burst'
	),
	'damage' => array(
		'de' => 'Schaden',
		'en' => 'damage'
	),
	'reloadCycle' => array(
		'de' => 'Nachladezyklus',
		'en' => 'Reload cycle'
	),
	'rounds' => array(
		'de' => 'Runden',
		'en' => 'rounds'
	),
	'armor' => array(
		'de' => 'Panzerung',
		'en' => 'Armor'
	),
	'perBuildUp' => array(
		'de' => 'pro Aufbau',
		'en' => 'per build up'
	),
	'perEnergyUnit' => array(
		'de' => 'pro Energie Einheit',
		'en' => 'per energy unit'
	),
	'shieldStrength' => array(
		'de' => 'Schildstärke',
		'en' => 'Shield strength'
	),
	'maxShieldStrength' => array(
		'de' => 'Max. Schildstärke',
		'en' => 'Max. shield strength'
	),
	'maxShieldRecharge' => array(
		'de' => 'Max. Aufladung',
		'en' => 'Max. recharge'
	),
	'energyPerRound' => array(
		'de' => 'Energie pro Runde',
		'en' => 'Energy per round'
	),
	'absorbs' => array(
		'de' => 'Absorbiert (bis zu)',
		'en' => 'Absorbs (up to)'
	),
	'recharge' => array(
		'de' => 'Aufladung',
		'en' => 'Recharge'
	),
	'perRound' => array(
		'de' => 'pro Runde',
		'en' => 'per round'
	),
	'maxCapacity' => array(
		'de' => 'Max. Kapazität',
		'en' => 'Max. capacity'
	),

	/*****************************************************
	 * Battle
	 ****************************************************/

	'fight' => array(
		'de' => 'Kämpfen',
		'en' => 'Fight'
	),
	'insufficientEnergyWeapon' => array(
		'de' => "Energielevel zu niedrig um %s abzufeuern.",
		'en' => "Energy level too low to fire %s."
	),
	'insufficientEnergyShield' => array(
		'de' => "Energielevel zu niedrig um %s aufzubauen.",
		'en' => "Energy level too low to build up %s."
	),
	'firingWeapon' => array(
		'de' => "Feuert mit %s.",
		'en' => "Fires with %s."
	),
	'shieldActivated' => array(
		'de' => "%s aktiviert.",
		'en' => "%s activated."
	),
	'shieldCollapsed' => array(
		'de' => "%s versagt!",
		'en' => "%s collapsed!"
	),
	'energyLevel' => array(
		'de' => "Energielevel: %s%%",
		'en' => "Energy level: %s%%"
	),
	'missed' => array(
		'de' => "Verfehlt!",
		'en' => "Missed!"
	),
	'hitOnce' => array(
		'de' => "Ein Treffer!",
		'en' => "Hit once!"
	),
	'hitSeveralTimes' => array(
		'de' => "%s mal getroffen!",
		'en' => "Hit %s times!"
	),
	'xDamage' => array(
		'de' => "%s Schaden (%s)",
		'en' => "%s damage (%s)"
	),

	/*****************************************************
	 * Sidebar / Star Base
	 ****************************************************/

	'menu' => array(
		'de' => 'Menü',
		'en' => 'Menu'
	),
	'profile' => array(
		'de' => "Profil",
		'en' => "Profile"
	),
	'enigmaStarbase' => array(
		'de' => 'Enigma Sternenbasis',
		'en' => 'Enigma Starbase'
	),
	'pirateNews' => array(
		'de' => 'Piraten News',
		'en' => 'Pirate News'
	),
	'pilot' => array(
		'de' => 'Pilot',
		'en' => 'Pilot'
	),
	'messages' => array(
		'de' => 'Nachrichten',
		'en' => 'Messages'
	),
	'events' => array(
		'de' => 'Ereignisse',
		'en' => 'Events'
	),
	'moneyName' => array(
		'de' => 'Space Pfund',
		'en' => 'Space Pounds'
	),
	'moneySign' => array(
		'de' => 's£',
		'en' => 's£'
	),
	'premiumCoins' => array(
		'de' => 'Seltsame Materie',
		'en' => 'Awkward Materia'
	),

	/*****************************************************
	 * Missions
	 ****************************************************/

	'starTrip' => array(
		'de' => 'Sternentour',
		'en' => 'Star Trip'
	),
	'starTripDescription' => array(
		'de' => 'Starte zu einer Sternentour und sammle Objekte, bevor die Zeit abläuft.',
		'en' => 'Take off to a star trip and collect objects, before time runs out.'
	),
	'startMission' => array(
		'de' => 'Mission starten',
		'en' => 'Start mission'
	),
	'notEnoughEndurance' => array(
		'de' => 'Nicht genug Ausdauer.',
		'en' => 'Not enough endurance'
	),
	'notEnoughActionPoints' => array(
		'de' => 'Nicht genug Aktionspunkte.',
		'en' => 'Not enough action points.'
	),
	'go' => array(
		'de' => 'Los!',
		'en' => 'Go!'
	),
	'youStartAMission' => array(
		'de' => 'Du beginnst eine Mission',
		'en' => 'You start a mission'
	),
	'missionSuccess' => array(
		'de' => 'Mission erfolgreich!',
		'en' => 'Mission successful!'
	),

	'missionStrollAround' => array(
		'de' => 'Herumschlendern',
		'en' => 'Stroll Around'
	),
	'missionFoundMoney' => array(
		'de' => 'Du hast %s Kreditkarten gefunden!',
		'en' => 'You found %s credit cards!'
	),
	'missionTalkedWithPilots' => array(
		'de' => 'Du hast Dich mit einem anderen Piloten unterhalten.',
		'en' => 'You talked to another pilot.'
	),

	'missionExploration' => array(
		'de' => 'Erkundung',
		'en' => 'Exploration'
	),
	'missionCollectJunk' => array(
		'de' => 'Schrott sammeln',
		'en' => 'Collect Junk'
	),

	/*****************************************************
	 * Login
	 ****************************************************/

	'login' => array(
		'de' => 'Login',
		'en' => 'Login'
	),
	'username' => array(
		'de' => 'Username',
		'en' => 'Username'
	),
	'password' => array(
		'de' => 'Passwort',
		'en' => 'Password'
	)
);