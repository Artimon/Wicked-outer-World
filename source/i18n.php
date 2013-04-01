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
		'de' => 'Ragnar�k Mk I',
		'en' => 'Ragnarok Mk I'
	),
	'descRagnarokMkI' => array(
		'de' => "Dieser leichte Raumj�ger ist high-end Technologie... aus der Zeit der ersten Weltraum Konflikte. Man sollte jetzt nicht unbedingt sagen er sei eine Rostlaube, aber mit irgendwas musst Du das Spiel ja beginnen, oder?",
		'en' => "This light fighter is high-end Technology... from the age of first space conflicts. One shouldn't say this is a rust bucket, but you gotta start the game with something, right?"
	),

	'nameGenesisSC4' => array(
		'de' => 'Genesis SC-4',
		'en' => 'Genesis SC-4'
	),
	'descGenesisSC4' => array(
		'de' => "Ein Flug mit dieser F�hre f�hlt sich an, als h�tte sie den Bau der ersten Raumstationen miterlebt. Immerhin bietet sie etwas Laderaum.",
		'en' => "A flight with this shuttle feels like it saw the creation of the first space stations. At least it provides some cargo space."
	),

	'nameGremlin' => array(
		'de' => "Gremlin",
		'en' => "Gremlin"
	),
	'descGremlin' => array(
		'de' => "Dieser Gremlin ist klein und gemein. Ein leichter Erkundungsj�ger mit einer angenehmen Menge Stauraum.",
		'en' => "This gremlin is small and nasty. A light scout machine with comfortable stowage."
	),

	'nameNightfallCb55' => array(
		'de' => 'Nightfall Cb55',
		'en' => 'Nightfall Cb55'
	),
	'descNightfallCb55' => array(
		'de' => 'Der Prototyp dieses J�gers war eigentlich als F�hre geplant, doch durch sein hervorragendes Design stellte sich schnell heraus, dass man besser Waffen anstelle von Frachkisten einbaut.',
		'en' => 'The prototype of this fighter was intentionally planned as shuttle, but due to its excellent design it emergend that it better should be equipped with weapons instead of transport boxes.'
	),

	'nameRelentless' => array(
		'de' => 'Relentless',
		'en' => 'Relentless'
	),
	'descRelentless' => array(
		'de' => 'Relentless-Klasse Raumgleiter sind durch ihre vielen Zusatzmodul-Slots speziell f�r Erkundungsmissionen ausgelegt.',
		'en' => 'Relentless-Class space gliders have many supplement-slots and thus are specially designed for exploration missions.'
	),

/*
	'cargoNameCargoModule' => array(
		'de' => 'Frachtmodul',
		'en' => 'Cargo module'
	),
	'cargoDescCargoModule' => array(
		'de' => "Dieses Frachtmodul ist speziell f�r kleine Raumf�hren entwickelt worden. Darin kannst Du ein paar Bilder von Mutti oder zuf�llig herum fliegenden Weltraumschrott verstauen.",
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
		'de' => "Mit diesem Modul kannst Du kleine Mengen Weltraumschrott einsammeln. Wozu das gut ist? Was Du selbst nicht gebrauchen kannst l�sst sich bestimmt irgend ein Idiot auf dem Flohmarkt andrehen.",
		'en' => "With this module you can collect small amounts of space junk. What this is good for? Well, on the jumble sale some idiot surely will buy what you don't need for your self."
	),

	'nameImpactArmor' => array(
		'de' => 'Einschlagpanzerung',
		'en' => 'Impact plating'
	),
	'descImpactArmor' => array(
		'de' => "Einfache Stahlplatten sch�tzen die Schiffsh�lle vor Partikel Einschl�gen. Sie werden aber auch als Billigpanzerung genutzt; und wo ist schon der Unterschied zwischen Mikro-Meteoriten und infernalen H�llenlasern?",
		'en' => "Simple steel plates protect the hull from particle strikes. But they are also used as cheap armor; and who could even tell where the difference between micro-meteorites and infernal hell lasers is?"
	),

	'nameKineticShield' => array(
		'de' => 'Kinetischer Schild',
		'en' => 'Kinetic shield'
	),
	'descKineticShield' => array(
		'de' => "Dieser Schild hat schon so manches Schiff von Sch�den durch herumfliegendem Weltraumschrott bewahrt.",
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
		'de' => "Besch�tzt um das Schiff, was sich im Schiff befindet.",
		'en' => "Protects around the ship, what's inside the ship."
	),

	'nameSmallBlaster' => array(
		'de' => 'Kleiner Blaster',
		'en' => 'Small blaster'
	),
	'descSmallBlaster' => array(
		'de' => "Blaster k�nnte man zwar als die Weiterentwicklung handels�blicher Feuerwaffen bezeichnen, doch dieses kleine Modell ist schon mehr als �berholt.",
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
		'de' => "Hier ist der Name Programm: Das Hocherhitzte Plasma sengt dem Gegner nicht nur den B�rzel an, sondern ist auch kosteng�nstig in der Anschaffung.",
		'en' => "Here the name says it: The high heated plasma not only burns your opponent's rump, but is also a cheap acquisition."
	),

	'nameNuclearBatteries' => array(
		'de' => 'Atombatterie',
		'en' => 'Nuclear batteries'
	),
	'descNuclearBatteries' => array(
		'de' => "Mit diesen Batterien im Gep�ck hat man immer ein strahlendes l�cheln auf den Lippen.",
		'en' => "With this batteries in the luggage one always has a radiation smile on his lips."
	),
	'nameSolarArray' => array(
		'de' => 'Solarmodul',
		'en' => 'Solar Array'
	),
	'descSolarArray' => array(
		'de' => 'Schon verr�ckt, wir sammeln solare Energie um dann wieder Laserstrahlen daraus zu machen.',
		'en' => 'Quite loony, we collect solar energy to create laser beams from it.'
	),
	'nameSmallFusionReactor' => array(
		'de' => 'Kleiner Fusionsreaktor',
		'en' => 'Small Fusion Reactor'
	),
	'descSmallFusionReactor' => array(
		'de' => 'Die Energie der Sonne lodert in diesem Kern!',
		'en' => 'The sun�s energy blazes in this core!'
	),

	'nameSmallCapacitor' => array(
		'de' => 'Kleiner Kondensator',
		'en' => 'Small Capacitor'
	),
	'descSmallCapacitor' => array(
		'de' => 'Dieser bl�de Reaktor liefert einfach nicht genug Energie? Ein paar Kondensatoren k�nnten hier ein kleines Polster schaffen.',
		'en' => 'That stupid reactor just does not provide enough energy? A few condensators could act as a buffer here.'
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
	'descIron' => array(
		'de' => 'Die meisten Ausr�stungsteile werden aus Eisen gebaut. Dummerweise muss man das Eisen erst aus dem vielen Weltraumschrott herausschmelzen.',
		'en' => 'Most equipment parts are made from iron. Unforunately you got to melt that iron out of all that space junk.'
	),
	'nameMagnetCoil' => array(
		'de' => 'Magnetspule',
		'en' => 'Magnet Coil'
	),
	'descMagnetCoil' => array(
		'de' => 'Damit lassen sich Projektile und Teilchen wunderbar Beschleunigen.',
		'en' => 'Projectiles and particles can be wonderfully accellerated with it.'
	),
	'namePlastics' => array(
		'de' => 'Plastik',
		'en' => 'Plastics'
	),
	'descPlastics' => array(
		'de' => 'Damit l�sst sich doch gewiss etwas anfangen?',
		'en' => 'For sure this must be useful for something?'
	),
	'nameWater' => array(
		'de' => 'Wasser',
		'en' => 'Water'
	),
	'descWater' => array(
		'de' => 'Wasser kann zum Reinigen oder Mischen anderer Fl�ssigkeiten verwandt werden.',
		'en' => 'Water can be used for cleaning or mixing with other fluids.'
	),
	'nameDeuterium' => array(
		'de' => 'Deuterium',
		'en' => 'Deuterium'
	),
	'descDeuterium' => array(
		'de' => 'Der Brennstoff moderner Fusionsreaktoren.',
		'en' => 'The fuel of modern fusion reactors.'
	),
	'nameCoolant' => array(
		'de' => 'K�hlfl�ssigkeit',
		'en' => 'Coolant'
	),
	'descCoolant' => array(
		'de' => 'Hochleistungsk�hler kommen nicht mehr ohne K�hlfl�ssigkeit aus.',
		'en' => 'High performance coolers can�t get along without coolant.'
	),
	'nameNobleGas' => array(
		'de' => 'Edelgas',
		'en' => 'Noble Gas'
	),
	'descNobleGas' => array(
		'de' => 'Gase k�nnen als Plasma erstaunliche Wirkungen entfalten.',
		'en' => 'Gases can develop amazing effects as plasma.'
	),
	'nameCrystals' => array(
		'de' => 'Kristalle',
		'en' => 'Crystals'
	),
	'descCrystals' => array(
		'de' => 'Kristalle sehen nicht nur h�bsch aus, sondern sind auch wichtiger Bestandteil elektronischer Bauteile und dienen dem Fokusieren von Licht.',
		'en' => 'Crystals do not only look nice, they are also important for electronic components and can be used to focus light.'
	),
	'nameElectronics' => array(
		'de' => 'Elektronik',
		'en' => 'Electronics'
	),
	'descElectronics' => array(
		'de' => 'Naja... besser als alles von Hand zu bedinen, oder?',
		'en' => 'Well... better than handling everything ba hand, right?'
	),
	'nameEnergyCells' => array(
		'de' => 'Energiezellen',
		'en' => 'EnergyCells'
	),
	'descEnergyCells' => array(
		'de' => 'Hier stecken einige Pferde drin. Damit l�sst sich vermutlich auch etwas schmelzen?',
		'en' => 'Quite some horses are within. They may even be able to melt some stuff?'
	),
	'nameSpaceJunk' => array(
		'de' => 'Weltraumschrott',
		'en' => 'SpaceJunk'
	),
	'descSpaceJunk' => array(
		'de' => '"Zuf�llig" herumfliegender Weltraumschrott.',
		'en' => '"Accidential" flying aroung space junk.'
	),
	'nameToxicWaste' => array(
		'de' => 'Giftabf�lle',
		'en' => 'Toxic Waste'
	),
	'descToxicWaste' => array(
		'de' => 'Ich sollte mich davon fern halten, doch welche Sch�tze k�nnten darin stecken?',
		'en' => 'I should stay away from it, but what kind of treasures may be hidden within?'
	),
	'nameTechnicalComponents' => array(
		'de' => 'Technische Komponenten',
		'en' => 'TechnicalComponents'
	),
	'descTechnicalComponents' => array(
		'de' => 'Sehr praktisch diese allgemeingebr�uchlichen Bauteile.',
		'en' => 'Very handy those universally usable parts.'
	),
	'nameCooler' => array(
		'de' => 'K�hler',
		'en' => 'Cooler'
	),
	'descCooler' => array(
		'de' => 'K�hler sind zum Schutz allen Hitzerzeugenden Komponenten im Einsatz.',
		'en' => 'Cooler are used to protect all heat generating components.'
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
	'thrust' => array(
		'de' => 'Schubkraft',
		'en' => 'Thrust'
	),
	'movability' => array(
		'de' => 'Beweglichkeit',
		'en' => 'Movability'
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
	'reactors' => array(
		'de' => 'Reaktoren',
		'en' => 'Reactors'
	),
	'capacitors' => array(
		'de' => 'Kondensatoren',
		'en' => 'Capacitors'
	),
	'drives' => array(
		'de' => 'Antriebe',
		'en' => 'Drives'
	),
	'ingredients' => array(
		'de' => 'Ingredienzien',
		'en' => 'Ingredients'
	),
	'neededLevel' => array(
		'de' => 'Ben�tigtes Level: %s',
		'en' => 'Needed level: %s'
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
	'hangarDescription' => array(
		'de' => 'Das Paradies eines jeden Piloten, hier kannst Du an Deinem Raumschiff herum schrauben und zu Missionen starten.',
		'en' => 'The paradise of every pilot, here you can work on your spaceship and start to missions.'
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
		'de' => 'Bastle herum und stelle das cr�nkeste Schiff zusammen.',
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
		'de' => 'Ausr�stung',
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
		'de' => 'Ausr�sten',
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
		'de' => 'Tragf�higkeit',
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
		'de' => 'Kapazit�t',
		'en' => 'Capacity'
	),
	'howMany' => array(
		'de' => 'Wie viele?',
		'en' => 'How many?'
	),
	'slots' => array(
		'de' => 'Slots',
		'en' => 'Slots'
	),

	/*****************************************************
	 * Trade Deck
	 ****************************************************/

	'tradeDeckDescription' => array(
		'de' => 'Ein Shopping Zentrum im Weltraum? Na, warum nicht!',
		'en' => 'A shopping centre  out in space? Well, why not!'
	),
	'shop' => array(
		'de' => 'Laden',
		'en' => 'Shop'
	),
	'shopDescription' => array(
		'de' => 'Du suchst nach der besten Ausr�stung in diesem gro�en schwarzen nichts? Sieh Dich einfach etwas um.',
		'en' => 'Searching for the finest hardware out in that big black room? Just take a look around.'
	),
	'grocer' => array(
		'de' => 'Kr�mer',
		'en' => 'Grocer'
	),
	'grocerDescription' => array(
		'de' => 'Die Vorbereitungen zur Er�ffnung sind in vollem Gange.',
		'en' => 'The preparations for the opening are ongoing.'
	),
	'starships' => array(
		'de' => 'Raumschiffe',
		'en' => 'Starships'
	),
	'airlock' => array(
		'de' => 'Luftschleuse',
		'en' => 'Airlock'
	),
	'airlockDescription' => array(
		'de' => 'Du hast ein paar Dinge, die der Gr�ne Punkt nicht annimmt? Diese Luftschleuse k�nnte bei der Entsorgung behilflich sein...',
		'en' => 'You got some stuff the Green Dot does not accept? This airlock may be helpful for your waste disposal...'
	),
	'buy' => array(
		'de' => 'Kaufen',
		'en' => 'Buy'
	),
	'depollute' => array(
		'de' => 'Entsorgen',
		'en' => 'Depollute'
	),
	'itemBought' => array(
		'de' => 'Du hast %s in Dein Lager gelegt.',
		'en' => 'You put %s to you stock'
	),
	'itemsDepolluted' => array(
		'de' => 'Du hast %s %s entsorgt.',
		'en' => 'You depolluted %s %s.'
	),
	'youArePoor' => array(
		'de' => 'Du bist arm wie eine Kirchenmaus',
		'en' => 'You are as poor as a church mouse'
	),
	'buyStarshipNotice' => array(
		'de' => 'Bevor Du ein neues Schiff kaufst, solltest Du alle Objekte, die Du behalten m�chtest, aus Deinem alten Schiff ausbauen.',
		'en' => 'Before you buy a new ship, you should unequip all items, you want to keep, from your old ship.'
	),
	'attention' => array(
		'de' => 'Achtung',
		'en' => 'Attention'
	),
	'shipBought' => array(
		'de' => 'Gratulation! Viel Spa� mit Deinem neuen Schiff.',
		'en' => 'Congratulation! Have fun with your new ship.'
	),

	/*****************************************************
	 * Crafter
	 ****************************************************/

	'fiddle' => array(
		'de' => 'T�fteln',
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
		'de' => "Gl�ckwunsch! Du hast herausgefunden wie %s hergestellt wird.",
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
		'de' => 'Herumt�fteln',
		'en' => 'Fiddling around'
	),
	'fiddleDescription' => array(
		'de' => 'So mancher Schrott ist mehr wert als es scheint. Verbinde Deine Objekte und schaffe n�tzliche Dinge daraus.',
		'en' => 'Some junk is worth more than it seems. Combine your objects and create useful things out of them.'
	),
	'fiddleFiddle' => array(
		'de' => '*t�ftel t�ftel*',
		'en' => '*fiddle fiddle*'
	),
	'noRecipes' => array(
		'de' => 'Du kennst noch keine Herstellungrezepte. Finde beim t�fteln heraus, was sich zu neuen Objekten verbinden l�sst.',
		'en' => 'You know no crafting recipes yet. Fiddle out what can be combined to new objects.'
	),
	'needed' => array(
		'de' => 'Ben�tigt',
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
		'de' => 'Weltraumfieber und Schwerelosigkeitskrankheit sind wirklich �ble Gesellen, aber wer geht schon freiwillig zum Arzt? Darum erh�lst Du bei jedem Arztbesuch eine Kleinigkeit.',
		'en' => 'Space fever and zero gravtity disease are really bad companions, but who visits a doctor voluntarily? Thus you`ll get something nice for each visit at the doctor.'
	),
	'healthCareReward' => array(
		'de' => 'Du hast %s erhalten!',
		'en' => 'You got %s!'
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
		'de' => 'Zur�ck',
		'en' => 'Back'
	),

	/*****************************************************
	 * Quarters
	 ****************************************************/

	'quarter' => array(
		'de' => 'Quartier',
		'en' => 'Quarter'
	),
	'quartersDescription' => array(
		'de' => 'Hier kannst Du Dich von den Strapazen des Weltraum-Lebens erholen.',
		'en' => 'Here you can relax from the exertions of the outer-space-life.'
	),
	'loungeDescription' => array(
		'de' => 'In der Space Lounge kannst Du mal so richtig ph�t abchillen.',
		'en' => 'In the space lounge you can have a wicked chillout.'
	),
	'restCureHeadline' => array(
		'de' => 'Erholungskur',
		'en' => 'Rest cure'
	),
	'restCureDescription' => array(
		'de' => 'Das wird Deine morschen Glieder wieder auf Schwung bringen.',
		'en' => 'This will bring your rotten limbs back to life.'
	),
	'youFeelBetter' => array(
		'de' => 'Du f�hlst Dich gleich viel besser!',
		'en' => 'You feel a lot better now!'
	),

	/*****************************************************
	 * Academy
	 ****************************************************/

	'academyWelcome' => array(
		'de' => 'Willkommen in der Weltraum-Akademie',
		'en' => 'Welcome to the space academy'
	),
	'academyDescription' => array(
		'de' => 'Hier gibt es zwar keinen Kobayashi-Maru-Test, jedoch einige interessante Kurse, welche Dich als aufstrebenden Weltraum-Pionier weiter bringen k�nnten.',
		'en' => 'You can`t take a Kobayashi-Maru-Test here, but some other interesting courses, that could bring you forth as an ambitious space-pioneer.'
	),
	'courses' => array(
		'de' => 'Kurse',
		'en' => 'Courses'
	),
	'coursesText' => array(
		'de' => 'Besuche die Akademie Kurse um Deine Aktionspunkte zu steigern. F�r je 2 Zertifikate erh�lst Du einen weiteren Punkt.',
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
		'de' => 'Dein Kurs Level hat sich um 1 erh�ht!',
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
	'tacticsHelp' => array(
		'de' => 'Taktisches K�nnen verbessert Deine Treffsicherheit.',
		'en' => 'Tactical skills improve your accuracy.'
	),
	'defense' => array(
		'de' => 'Abwehr',
		'en' => 'Defense'
	),
	'defenseHelp' => array(
		'de' => 'Gute Abwehrman�ver verbessern Deine Ausweichf�higkeit.',
		'en' => 'Well defense maneuvers improve your evasion capability.'
	),
	'crafting' => array(
		'de' => 'Basteln',
		'en' => 'Crafting'
	),
	'craftingHelp' => array(
		'de' => 'Mit besseren Handwerksf�higkeiten kannst Du neue Objekte herstellen.',
		'en' => 'With better crafting skills you can craft new objects.'
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
		'de' => 'Feuersto�',
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
		'de' => 'Schildst�rke',
		'en' => 'Shield strength'
	),
	'maxShieldStrength' => array(
		'de' => 'Max. Schildst�rke',
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
		'de' => 'Max. Kapazit�t',
		'en' => 'Max. capacity'
	),

	/*****************************************************
	 * Battle
	 ****************************************************/

	'number' => array(
		'de' => 'Nummer',
		'en' => 'Number'
	),
	'fight' => array(
		'de' => 'K�mpfen',
		'en' => 'Fight'
	),
	'skirmish' => array(
		'de' => 'K�mpfen',
		'en' => 'Fight'
	),
	'pirateBay' => array(
		'de' => 'Piratenhort',
		'en' => 'Pirate bay'
	),
	'showHim' => array(
		'de' => 'Zeig`s ihm!',
		'en' => 'Show him!'
	),
	'pirateBayDescription' => array(
		'de' => 'Lust auf ein K�mpfchen? Die Sonntagsflieger dort draussen haben gewiss noch ein paar M�nzen zuviel.',
		'en' => 'You want a little quarrel? Those sunday pilots out there for sure have some spare coins.'
	),
	'badBoys' => array(
		'de' => 'B�se Buben',
		'en' => 'Bad boys'
	),
	'shieldUp' => array(
		'de' => 'Schilde!',
		'en' => 'Shields!'
	),
	'shieldPlus' => array(
		'de' => 'Schilde',
		'en' => 'Shields'
	),
	'shieldDown' => array(
		'de' => 'Schilde kollabiert!',
		'en' => 'Shields collapsed!'
	),
	'missed' => array(
		'de' => 'Vorbei!',
		'en' => 'Missed!'
	),
	'skirmishLost' => array(
		'de' => 'Was f�r eine Entt�uschung, %s hat es Dir ganzsch�n gegeben!',
		'en' => 'What a swizz, %s really punished you!'
	),
	'skirmishCloseWon' => array(
		'de' => 'Das war aber recht knapp. F�r %s l�sst Du %s ziehen.',
		'en' => 'That was quite close. For %s you let %s go.'
	),
	'skirmishWellWon' => array(
		'de' => 'Du hast %s ziemlich zerlegt und %s erbeutet.',
		'en' => 'You really tore %s apart and took %s.'
	),
	'outOfFuel' => array(
		'de' => 'Schnell zur�ck, bevor der Treibstoff ausgeht!',
		'en' => 'Hurry back home before fuel runs out!'
	),
	'noWeaponsInfo' => array(
		'de' => 'Keine Waffe ausger�stet!',
		'en' => 'No weapon equipped yet!'
	),


	// Old
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
//	'missed' => array(
//		'de' => "Verfehlt!",
//		'en' => "Missed!"
//	),
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
		'de' => 'Men�',
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
		'de' => 's�',
		'en' => 's�'
	),
	'premiumCoins' => array(
		'de' => 'Seltsame Materie',
		'en' => 'Awkward Materia'
	),
	'engineer' => array(
		'de' => 'Ingenieur',
		'en' => 'Engineer'
	),
	'engineerDescription' => array(
		'de' => 'Du hast einen zuf�llig herumschlendernden Ingenieur mit Langeweile gefunden, er sagt...',
		'en' => 'You found a bored, randomly lingering around engineer, he says...'
	),
	'haveYouTriedFiddle' => array(
		'de' => '"Hast Du schon versucht %s zu kombinieren?"',
		'en' => '"Have you tried combining %s?"'
	),
	'lookForAnEngineer' => array(
		'de' => '*schaue nach einem Ingenieur*',
		'en' => '*look for an engineer*'
	),
	'noFiddleHint' => array(
		'de' => 'Heute habe ich leider keinen neuen Tipp f�r Dich.',
		'en' => 'Unfortunately I got no hint for you today.'
	),

	/*****************************************************
	 * Missions
	 ****************************************************/

	'starTrip' => array(
		'de' => 'Sternentour',
		'en' => 'Star Trip'
	),
	'starTripDescription' => array(
		'de' => 'Starte zu einer Sternentour und sammle Objekte, bevor die Zeit abl�uft.',
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
	'noDriveNotice' => array(
		'de' => 'Du solltest zuerst einen Antrieb ausr�sten.',
		'en' => 'You should equip an engine first.'
	),

	'missionStrollAround' => array(
		'de' => 'Herumschlendern',
		'en' => 'Stroll Around'
	),
	'missionFoundMoney' => array(
		'de' => 'Gl�ckstag! Du hast %s s� gefunden!',
		'en' => 'Lucky day! You found %s s�!'
	),
	'missionTalkedWithPilots' => array(
		'de' => 'Du hast Dich mit einem anderen Piloten unterhalten.',
		'en' => 'You talked to another pilot.'
	),
	'missionThoughtAboutLife' => array(
		'de' => 'Du hast �ber Dein Leben nachgedacht.',
		'en' => 'You thought about your life.'
	),

	'missionCollectJunk' => array(
		'de' => 'Schrott sammeln',
		'en' => 'Collect Junk'
	),
	'missionMetWithJunkers' => array(
		'de' => 'Du hast Dich mit anderen Schrottsammlern unterhalten.',
		'en' => 'You talked to other junkers.'
	),
	'missionBlindedByTheSun' => array(
		'de' => 'Du wurdest von der Sonne geblendet.',
		'en' => 'You have been blinded by the sun.'
	),
	'missionFoundSpaceJunk' => array(
		'de' => 'Du hast Weltraumschrott gefunden!',
		'en' => 'You found some space junk!'
	),
	'missionFoundEnergyCell' => array(
		'de' => 'Du hast eine Energiezelle gefunden!',
		'en' => 'You found a energy cell!'
	),
	'missionFoundElectronics' => array(
		'de' => 'Du hast Elektronikbauteile gefunden!',
		'en' => 'You found some electronic parts!'
	),

	'missionExploration' => array(
		'de' => 'Erkundung',
		'en' => 'Exploration'
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
	),
	'logout' => array(
		'de' => 'Logout',
		'en' => 'Logout'
	),
	'logoutHeadline' => array(
		'de' => 'Fehler: Seite nicht gefunden',
		'en' => 'Error: Page not found'
	),
	'logoutDescription' => array(
		'de' => 'Sie m�ssen sich einloggen, um diese Aktion ausf�hren zu k�nnen.',
		'en' => 'You must log in to perform this action.'
	),
	'logoutFootNote' => array(
		'de' => 'Nein Quatsch, wir machen nur Spa�. Bis zum n�chsten mal! ;)',
		'en' => 'No, just kidding. See you next time! ;)'
	),
	'developmentHeadline' => array(
		'de' => 'Baustelle - in Entwicklung',
		'en' => 'Construction site - development'
	),
	'developmentMessage' => array(
		'de' => 'Du kannst Dich bereits registrieren, das Spiel ist jedoch noch in der Alpha-Entwicklung.',
		'en' => 'You may already register, but the game is still under alpha construction.'
	),

	/*****************************************************
	 * Register
	 ****************************************************/

	'register' => array(
		'de' => 'Registrieren',
		'en' => 'Register'
	),
	'registerIntro' => array(
		'de' => 'Du willst also ein tollk�hner Weltraumcowboy werden? Dann hol` Dir Deine Pilotenlizenz und erhalte Deinen ersten Raumj�ger!',
		'en' => 'So you want to become a foolhardy space cowboy? Get your pilot license now and get your first space fighter!'
	),
	'coolName' => array(
		'de' => 'Cooler Name',
		'en' => 'Cool Name'
	),
	'nameTip' => array(
		'de' => 'Du kannst Buchstaben, Zahlen und Binde-/Unterstriche verwenden.',
		'en' => 'You may use letters, numbers, dash and underscore.'
	),
	'usernameTaken' => array(
		'de' => 'Dieser Name ist leider schon vergeben.',
		'en' => 'Unfortunately this name is already taken.'
	),
	'crazyPassword' => array(
		'de' => 'Irres Passwort',
		'en' => 'Crazy password'
	),
	'email' => array(
		'de' => 'Email',
		'en' => 'email'
	),
	'leaveEmpty' => array(
		'de' => 'Bitte frei lassen.',
		'en' => 'Leave empty, please.'
	),
	'yourShip' => array(
		'de' => 'Dein Schiff',
		'en' => 'Your ship'
	),
	'wtfIsThis' => array(
		'de' => 'WTF is this??? (klick)',
		'en' => 'WTF is this??? (click)'
	),

	/*****************************************************
	 * Custom
	 ****************************************************/

	'leaveFeedback' => array(
		'de' => 'Gib Feedback',
		'en' => 'Leave feedback'
	)
);