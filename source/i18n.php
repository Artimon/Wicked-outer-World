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

	$translation = htmlentities(
		$translations[$index][$language],
		ENT_COMPAT | ENT_QUOTES
	);

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
		'en' => "This light fighter is high-end Technology... from the age of first space conflicts. One shouldn't say this is a rust bucket, but you gotta start the game with something, right?"
	),

	'nameGenesisSC4' => array(
		'de' => 'Genesis SC-4',
		'en' => 'Genesis SC-4'
	),
	'descGenesisSC4' => array(
		'de' => "Ein Flug mit dieser Fähre fühlt sich an, als hätte sie den Bau der ersten Raumstationen miterlebt. Immerhin bietet sie etwas Laderaum.",
		'en' => "A flight with this shuttle feels like it saw the creation of the first space stations. At least it provides some cargo space."
	),

	'nameGremlin' => array(
		'de' => "Gremlin",
		'en' => "Gremlin"
	),
	'descGremlin' => array(
		'de' => "Dieser Gremlin ist klein und gemein. Ein leichter Erkundungsjäger mit einer angenehmen Menge Stauraum.",
		'en' => "This gremlin is small and nasty. A light scout machine with comfortable stowage."
	),

	'nameNightfallCb55' => array(
		'de' => 'Nightfall Cb55',
		'en' => 'Nightfall Cb55'
	),
	'descNightfallCb55' => array(
		'de' => 'Der Prototyp dieses Jägers war eigentlich als Fähre geplant, doch durch sein hervorragendes Design stellte sich schnell heraus, dass man besser Waffen anstelle von Frachkisten einbaut.',
		'en' => 'The prototype of this fighter was intentionally planned as shuttle, but due to its excellent design it emergend that it better should be equipped with weapons instead of transport boxes.'
	),

	'nameRelentless' => array(
		'de' => 'Relentless',
		'en' => 'Relentless'
	),
	'descRelentless' => array(
		'de' => 'Relentless-Klasse Raumgleiter sind durch ihre vielen Zusatzmodul-Slots speziell für Erkundungsmissionen ausgelegt.',
		'en' => 'Relentless-Class space gliders have many supplement-slots and thus are specially designed for exploration missions.'
	),

	'nameEdinburgV5' => array(
		'de' => 'Edinburg v5',
		'en' => 'Edinburg v5'
	),
	'descEdinburgV5' => array(
		'de' => 'Nach einigen skandalösen Pannen bei der Inbetriebnahme ist der Konzern nun sicher, dass die 5. Version der Edinburg den Jungfernflug sicher übersteht.',
		'en' => 'After a few scandalous malfunctions during the launch, the company now is sure that the 5th version of the Edinburg will endure the maiden flight.'
	),

	'nameRevenant' => array(
		'de' => 'Revenant',
		'en' => 'Revenant'
	),
	'descRevenant' => array(
		'de' => 'Dieses Modell kann einiges einstecken, doch die hohe interne Struktur kostet Raum für Ausrüstung.',
		'en' => 'This one sure can take some bullets, but its high internal structure comes with less equipment space.'
	),

	'nameIgnis' => array(
		'de' => 'Ignis',
		'en' => 'Ignis'
	),
	'descIgnis' => array(
		'de' => 'Die Ignis, auch "Feuervogel" genannt, wurde mit einer dicken Hülle für "heisse Einsätze" gebaut... nein, keine Kampfeinsätze sondern Sonnenmessungen, daher der große Raum für Ausrüstung.',
		'en' => 'The Ignis, also called "Firebird", was designed with a thick hull for "hot missions"... no, not for battles, but for solar science, that\'s what the large equipment storage is for.'
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
		'en' => 'Junk Collector'
	),
	'descJunkCollector' => array(
		'de' => "Mit diesem Modul kannst Du kleine Mengen Weltraumschrott einsammeln. Wozu das gut ist? Was Du selbst nicht gebrauchen kannst lässt sich bestimmt irgend ein Idiot auf dem Flohmarkt andrehen.",
		'en' => "With this module you can collect small amounts of space junk. What this is good for? Well, on the jumble sale some idiot surely will buy what you don't need for your self."
	),

	'nameImpactArmor' => array(
		'de' => 'Einschlagpanzerung',
		'en' => 'Impact Plating'
	),
	'descImpactArmor' => array(
		'de' => "Einfache Stahlplatten schützen die Schiffshülle vor Partikel Einschlägen. Sie werden aber auch als Billigpanzerung genutzt; und wo ist schon der Unterschied zwischen Mikro-Meteoriten und infernalen Höllenlasern?",
		'en' => "Simple steel plates protect the hull from particle strikes. But they are also used as cheap armor; and who could even tell where the difference between micro-meteorites and infernal hell lasers is?"
	),

	'nameDeflectorPlating' => array(
		'de' => 'Deflektor Panzerung',
		'en' => 'Deflector Plating'
	),
	'descDeflectorPlating' => array(
		'de' => "Noch ein paar Veredelungsmaterialien hinzufügen und schon geht's los!",
		'en' => 'Adding some refining material and here we go!'
	),

	'nameKineticShield' => array(
		'de' => 'Kinetischer Schild',
		'en' => 'Kinetic Shield'
	),
	'descKineticShield' => array(
		'de' => "Dieser Schild hat schon so manches Schiff von Schäden durch herumfliegendem Weltraumschrott bewahrt.",
		'en' => "This shield quite protected some ships from damage through travelling space junk."
	),

	'nameEnergyShield' => array(
		'de' => 'Energieschild',
		'en' => 'Energy Shield'
	),
	'descEnergyShield' => array(
		'de' => "@TODO",
		'en' => "@TODO"
	),

	'nameDistortionShield' => array(
		'de' => 'Distorsionsschild',
		'en' => 'Distortion Shield'
	),
	'descDistortionShield' => array(
		'de' => "Beschützt um das Schiff, was sich im Schiff befindet.",
		'en' => "Protects around the ship, what's inside the ship."
	),

	'nameSmallBlaster' => array(
		'de' => 'Kleiner Blaster',
		'en' => 'Small Blaster'
	),
	'descSmallBlaster' => array(
		'de' => "Blaster könnte man zwar als die Weiterentwicklung handelsüblicher Feuerwaffen bezeichnen, doch dieses kleine Modell ist schon mehr als überholt.",
		'en' => "Blaster could be described as the further development of marketable guns, but this small model is already far beyond outdated."
	),

	'nameStingerRailgun' => array(
		'de' => 'Stinger Railgun',
		'en' => 'Stinger Railgun'
	),
	'descStingerRailgun' => array(
		'de' => "Railguns sind schöne kleine Spielzeuge. Wenn man ihnen genug Energie bereitstellt hält keine Schiffshülle dem Beschuss lange stand.",
		'en' => "Railguns are nice little toys. If provided with enough energy no ship hull can withstand them for a long time."
	),

	'nameShark2' => array(
		'de' => 'Shark-2 Werfer',
		'en' => 'Shark-2 Thrower'
	),
	'descShark2' => array(
		'de' => '"Shark"-Torpedowerfer zum simultanen Abfeuern von 2 Torpedos.',
		'en' => '"Shark"-Torpedoe-Thrower to simultaneous fire 2 torpedoes.'
	),

	'nameShark5' => array(
		'de' => 'Shark-5 Werfer',
		'en' => 'Shark-5 Thrower'
	),
	'descShark5' => array(
		'de' => 'Mehr Torpedos, mehr Treffer - ganz einfach!',
		'en' => 'More torpedoes, more hits - quite simple!'
	),

	'nameMicroLaser' => array(
		'de' => 'Mikrolaser',
		'en' => 'MicroLaser'
	),
	'descMicroLaser' => array(
		'de' => 'Ein fieser kleiner Geselle der Laser-Familie. Er "sticht" nicht stark, aber oft.',
		'en' => 'A mean little companion of the laser-family. His stings are not strong, but he stings often.'
	),

	'nameLightLaser' => array(
		'de' => 'Leichter Laser',
		'en' => 'Light Laser'
	),
	'descLightLaser' => array(
		'de' => 'Dies ist ein hochentwickelter Hitzestrahl, wir nennen es einen "Laser"... naja, oder doch eher sein kleiner Bruder.',
		'en' => 'This is a sophisticated heat beam which we call a "Laser"... well, or more like his little brother.'
	),

	'nameMediumLaser' => array(
		'de' => 'Mittlerer Laser',
		'en' => 'Medium Laser'
	),
	'descMediumLaser' => array(
		'de' => 'Dieser Laser bringt alles auf ein höheres Level, mehr Energie, mehr Schaden, mehr Bauteile.',
		'en' => 'This laser brings it all to the next level, more energy, more damage, more components.'
	),

	'nameHeavyLaser' => array(
		'de' => 'Schwerer Laser',
		'en' => 'Heavy Laser'
	),
	'descHeavyLaser' => array(
		'de' => 'Schwere Laser stoßen intensive Lichtstrahlen aus, welche Panzerung schmelzen und elektronische Komponenten überhitzen. Klingt lustig, oder?',
		'en' => 'Heavy lasers emit intense light beams that melt armor and overheat electronic components. Sounds funny, right?'
	),

	'nameLightDualLaser' => array(
		'de' => 'Leichter Dual-Laser',
		'en' => 'Leichter Dual-Laser'
	),
	'descLightDualLaser' => array(
		'de' => 'Manchmal sind die einfachsten Lösungen die besten. Ein paar Laser, technische Komponenten und voila!',
		'en' => 'Sometimes the simple ways are the best. A few lasers, technical components and voila!'
	),

	'nameLightQuadLaser' => array(
		'de' => 'Leichter Quad-Laser',
		'en' => 'Leichter Quad-Laser'
	),
	'descLightQuadLaser' => array(
		'de' => 'Warum nur zwei Laser nehmen, wenn man vier haben kann?',
		'en' => 'Why only take two lasers when you can have four?'
	),

	'nameBlasterAmmunition' => array(
		'de' => 'Blaster Munition',
		'en' => 'Blaster Ammunition'
	),
	'descBlasterAmmunition' => array(
		'de' => "Hier ist der Name Programm: Das Hocherhitzte Plasma sengt dem Gegner nicht nur den Bürzel an, sondern ist auch kostengünstig in der Anschaffung.",
		'en' => "Here the name says it: The high heated plasma not only burns your opponent's rump, but is also a cheap acquisition."
	),

	'nameRailgunAmmunition' => array(
		'de' => 'Railgun Munition',
		'en' => 'Railgun Ammunition'
	),
	'descRailgunAmmunition' => array(
		'de' => "Je komplexer der Aufbau der Waffe, desto einfacher die Munition. Eine gewöhnliche Eisenkugel genügt hier bereits.",
		'en' => "The more complex the weapon system, the simpler the ammunition. A common iron ball is just enough here."
	),

	'nameSharkTorpedoes' => array(
		'de' => 'Shark Torpedos',
		'en' => 'Shark Torpedoes'
	),
	'descSharkTorpedoes' => array(
		'de' => 'Leichte Weltraum-Torpedos die... "beissen".',
		'en' => 'Light space-torpedoes that... "bite".'
	),

	'nameNuclearBatteries' => array(
		'de' => 'Atombatterie',
		'en' => 'Nuclear Batteries'
	),
	'descNuclearBatteries' => array(
		'de' => "Mit diesen Batterien im Gepäck hat man immer ein strahlendes lächeln auf den Lippen.",
		'en' => "With this batteries in the luggage one always has a radiation smile on his lips."
	),
	'nameSolarArray' => array(
		'de' => 'Solarmodul',
		'en' => 'Solar Array'
	),
	'descSolarArray' => array(
		'de' => 'Schon verrückt, wir sammeln solare Energie um dann wieder Laserstrahlen daraus zu machen.',
		'en' => 'Quite loony, we collect solar energy to create laser beams from it.'
	),
	'nameSmallFusionReactor' => array(
		'de' => 'Kleiner Fusionsreaktor',
		'en' => 'Small Fusion Reactor'
	),
	'descSmallFusionReactor' => array(
		'de' => 'Die Energie der Sonne lodert in diesem Kern!',
		'en' => "The sun's energy blazes in this core!"
	),

	'nameSmallCapacitor' => array(
		'de' => 'Kleiner Kondensator',
		'en' => 'Small Capacitor'
	),
	'descSmallCapacitor' => array(
		'de' => 'Dieser blöde Reaktor liefert einfach nicht genug Energie? Ein paar Kondensatoren könnten hier ein kleines Polster schaffen.',
		'en' => 'That stupid reactor just does not provide enough energy? A few condensators could act as a buffer here.'
	),

	'nameCombustionDrive' => array(
		'de' => 'Verbrennungsantrieb',
		'en' => 'Combustion Drive'
	),
	'descCombustionDrive' => array(
		'de' => "Wenn Du wirklich Old School sein möchtest, solltest Du Dir diesen Antrieb zulegen. Space-Shuttle-Feeling FTW!",
		'en' => "If you really wanna be old school get yourself this drive. Space-Shuttle-feeling FTW!"
	),
	'nameIonDrive' => array(
		'de' => 'Ionenantrieb',
		'en' => 'Ion Drive'
	),
	'descIonDrive' => array(
		'de' => "Ionenantriebe funktionieren nach dem Furz-Prinzip: Das Raumschiff stößt hinten beschleunigte Gase aus um Schub zu erzeugen.",
		'en' => "Ion drives work after the fart-principle: The spaceship exhausts accelerated gas from its back to advance."
	),
	'namePulseDrive' => array(
		'de' => 'Impulsantrieb',
		'en' => 'Pulse Drive'
	),
	'descPulseDrive' => array(
		'de' => "Weisst Du was geil ist? Ionenantriebe sind geil. Aber Impulsantriebe gehören auch zur Familie magnetoplasmadynamischer Antrieb, verfügen aber über ihren eigenen Fusionsreaktor, denn mehr ist immer besser!",
		'en' => "You know what is cool? Ion drives are cool. But pulse drive belong to the family of magnetoplasmadynamic thrusters, too, but got their own fusion reactor, since more is always better!"
	),

	/*****************************************************
	 * Ingredients
	 ****************************************************/

	'nameIron' => array(
		'de' => 'Eisen',
		'en' => 'Iron'
	),
	'descIron' => array(
		'de' => 'Die meisten Ausrüstungsteile werden aus Eisen gebaut. Dummerweise muss man das Eisen erst aus dem vielen Weltraumschrott herausschmelzen.',
		'en' => 'Most equipment parts are made from iron. Unforunately you got to melt that iron out of all that space junk.'
	),
	'nameMagnetCoil' => array(
		'de' => 'Magnetspule',
		'en' => 'Magnet Coil'
	),
	'descMagnetCoil' => array(
		'de' => 'Damit lassen sich Projektile und Teilchen wunderbar beschleunigen.',
		'en' => 'Projectiles and particles can be wonderfully accellerated with it.'
	),
	'namePlastics' => array(
		'de' => 'Plastik',
		'en' => 'Plastics'
	),
	'descPlastics' => array(
		'de' => 'Damit lässt sich doch gewiss etwas anfangen?',
		'en' => 'For sure this must be useful for something?'
	),
	'nameWater' => array(
		'de' => 'Wasser',
		'en' => 'Water'
	),
	'descWater' => array(
		'de' => 'Wasser kann zum Reinigen oder Mischen anderer Flüssigkeiten verwandt werden.',
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
		'de' => 'Kühlflüssigkeit',
		'en' => 'Coolant'
	),
	'descCoolant' => array(
		'de' => 'Hochleistungskühler kommen nicht mehr ohne Kühlflüssigkeit aus.',
		'en' => "High performance coolers can't get along without coolant."
	),
	'nameNobleGas' => array(
		'de' => 'Edelgas',
		'en' => 'Noble Gas'
	),
	'descNobleGas' => array(
		'de' => 'Gase können als Plasma erstaunliche Wirkungen entfalten.',
		'en' => 'Gases can develop amazing effects as plasma.'
	),
	'nameCrystals' => array(
		'de' => 'Kristalle',
		'en' => 'Crystals'
	),
	'descCrystals' => array(
		'de' => 'Kristalle sehen nicht nur hübsch aus, sondern sind auch wichtiger Bestandteil elektronischer Bauteile und dienen dem Fokusieren von Licht.',
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
		'en' => 'Energy Cells'
	),
	'descEnergyCells' => array(
		'de' => 'Hier stecken einige Pferde drin. Damit lässt sich vermutlich auch etwas schmelzen?',
		'en' => 'Quite some horses are within. They may even be able to melt some stuff?'
	),
	'nameSpaceJunk' => array(
		'de' => 'Weltraumschrott',
		'en' => 'Space Junk'
	),
	'descSpaceJunk' => array(
		'de' => '"Zufällig" herumfliegender Weltraumschrott.',
		'en' => '"Accidential" flying aroung space junk.'
	),
	'nameToxicWaste' => array(
		'de' => 'Giftabfälle',
		'en' => 'Toxic Waste'
	),
	'descToxicWaste' => array(
		'de' => 'Ich sollte mich davon fern halten, doch welche Schätze könnten darin stecken?',
		'en' => 'I should stay away from it, but what kind of treasures may be hidden within?'
	),
	'nameExplosives' => array(
		'de' => 'Sprengstoff',
		'en' => 'Explosives'
	),
	'descExplosives' => array(
		'de' => 'Spengstoffe sind chemische Verbindungen die große Energiemengen in kurzer Zeit freisetzen können und nicht nur für Kinderfeuerwerk gut.',
		'en' => 'Explosives are chemical combinations that can free great amounts of energy an a short period of time and thus not only good for child fireworks.'
	),
	'nameTechnicalComponents' => array(
		'de' => 'Technische Komponenten',
		'en' => 'Technical Components'
	),
	'descTechnicalComponents' => array(
		'de' => 'Sehr praktisch diese allgemeingebräuchlichen Bauteile.',
		'en' => 'Very handy those universally usable parts.'
	),
	'nameCooler' => array(
		'de' => 'Kühler',
		'en' => 'Cooler'
	),
	'descCooler' => array(
		'de' => 'Kühler sind zum Schutz allen Hitzerzeugenden Komponenten im Einsatz.',
		'en' => 'Cooler are used to protect all heat generating components.'
	),
	'nameFood' => array(
		'de' => 'Nahrung',
		'en' => 'Food'
	),
	'descFood' => array(
		'de' => 'Einfache Nahrungsvorräte.',
		'en' => 'Simple food supplies.'
	),
	'nameWatch' => array(
		'de' => 'Platin Armbanduhr',
		'en' => 'Platinum Watch'
	),
	'descWatch' => array(
		'de' => 'Eine Platin Armbanduhr, welche wohl einst einem verunglückten Astronauten gehörte.',
		'en' => 'A platinum watch that once belonged to an accidentally crashed astronaut.'
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
		'en' => 'Weapon Phalanx'
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
		'de' => 'Bauteile',
		'en' => 'Components'
	),
	'neededLevel' => array(
		'de' => 'Benötigtes Level: %s',
		'en' => 'Needed level: %s'
	),
	'noLevelRequirement' => array(
		'de' => 'Keine Levelanforderung',
		'en' => 'No level requirement'
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
		'de' => 'Das Paradies eines jeden Piloten, hier kannst Du an Deinem Raumschiff herumschrauben und zu Missionen aufbrechen.',
		'en' => "Every pilot's paradise, here you can work on your spaceship and start to missions."
	),
	'imprint' => array(
		'de' => 'Impressum',
		'en' => 'Imprint'
	),
	'ranking' => array(
		'de' => 'Ränge',
		'en' => 'Ranking'
	),

	/*****************************************************
	 * Ranks
	 ****************************************************/

	'rank' => array(
		'de' => 'Rang',
		'en' => 'Rank'
	),
	'ranksDescription' => array(
		'de' => 'Was für Luschen hängen hier denn noch so herum? Der Weltraum ist auch nicht mehr das, was er mal war...',
		'en' => 'What dud do hang out all around here? Outer space by far is not what it used to be any more...'
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
		'en' => 'Your Starship'
	),
	'weaponry' => array(
		'de' => 'Bewaffnung',
		'en' => 'Armament'
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
		'en' => 'Technical Data'
	),
	'energyManagement' => array(
		'de' => 'Energieversorgung',
		'en' => 'Energy Management'
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
	'slots' => array(
		'de' => 'Slots',
		'en' => 'Slots'
	),

	/*****************************************************
	 * Bank
	 ****************************************************/

	'bank' => array(
		'de' => 'Bank',
		'en' => 'Bank'
	),
	'bankHeadline' => array(
		'de' => 'Inter-Space Bank',
		'en' => 'Inter-Space Bank'
	),
	'bankDescription' => array(
		'de' => 'Willkommen in der ISB, wie können wir Ihnen helfen?',
		'en' => 'Welcome to the ISB, how can we assist you?'
	),
	'createBankAccount' => array(
		'de' => 'Konto eröffnen',
		'en' => 'Create Account'
	),
	'create' => array(
		'de' => 'Erstellen',
		'en' => 'Create'
	),
	'bankAccountInfo' => array(
		'de' => 'Auf einem Bankkonto kannst Du Deine Ersparnisse vor fiesen Piraten in Sicherheit bringen.',
		'en' => 'On a bank account you can save your savings from nasty pirates.'
	),
	'bankAccountCreated' => array(
		'de' => 'Du hast ein Bankkonto eröffnet.',
		'en' => 'You created a bank account.'
	),
	'yourAccountBalance' => array(
		'de' => 'Dein Kontostand',
		'en' => 'Your account balance'
	),
	'bankTransferInfo' => array(
		'de' => 'Für jeden Geldtransfer erheben wir eine Gebühr von %s.',
		'en' => 'For every money transfer we charge a fee of %s.'
	),
	'notEnoughMoney' => array(
		'de' => 'Dir fehlt leider das nötige Kleingeld.',
		'en' => 'You lack the necessary change.'
	),
	'depositSuccess' => array(
		'de' => 'Du hast %s eingezahlt.',
		'en' => 'You deposited %s.'
	),
	'drawSuccess' => array(
		'de' => 'Du hast %s abgehoben.',
		'en' => 'You drew %s.'
	),
	'bankIn' => array(
		'de' => 'Einzahlen',
		'en' => 'Deposit'
	),
	'bankOut' => array(
		'de' => 'Abheben',
		'en' => 'Draw'
	),

	/*****************************************************
	 * Trade Deck
	 ****************************************************/

	'tradeDeckDescription' => array(
		'de' => 'Ein Shopping-Zentrum im Weltraum? Na, warum nicht!',
		'en' => 'A shopping centre out in space? Well, why not!'
	),
	'grocer' => array(
		'de' => 'Krämer',
		'en' => 'Grocer'
	),
	'grocerDescription' => array(
		'de' => 'Du hast ein paar gebrauchte Dinge übrig? Hmm... mal sehen ob ich damit etwas anfangen kann.',
		'en' => 'You got some things left over? Hmm... lets see if I can take use of something.'
	),
	'airlock' => array(
		'de' => 'Luftschleuse',
		'en' => 'Airlock'
	),
	'airlockDescription' => array(
		'de' => 'Du hast ein paar Dinge, die der Grüne Punkt nicht annimmt? Diese Luftschleuse könnte bei der Entsorgung behilflich sein...',
		'en' => 'You got some stuff the Green Dot does not accept? This airlock may be helpful for your waste disposal...'
	),
	'buy' => array(
		'de' => 'Kaufen',
		'en' => 'Buy'
	),
	'sell' => array(
		'de' => 'Verkaufen',
		'en' => 'Sell'
	),
	'depollute' => array(
		'de' => 'Entsorgen',
		'en' => 'Depollute'
	),
	'itemBought' => array(
		'de' => 'Du hast %s in Dein Lager gelegt.',
		'en' => 'You put %s to you stock'
	),
	'itemSold' => array(
		'de' => 'Du hast %s %s für %s verkauft.',
		'en' => 'You sold %s %s for %s.'
	),
	'itemsDepolluted' => array(
		'de' => 'Du hast %s %s entsorgt.',
		'en' => 'You depolluted %s %s.'
	),
	'youArePoor' => array(
		'de' => 'Du bist arm wie eine Kirchenmaus!',
		'en' => 'You are as poor as a church mouse!'
	),
	'attention' => array(
		'de' => 'Achtung',
		'en' => 'Attention'
	),
	'shipBought' => array(
		'de' => 'Gratulation! Viel Spaß mit Deinem neuen Schiff.',
		'en' => 'Congratulation! Have fun with your new ship.'
	),

	'inPreparation' => array(
		'de' => 'Die Vorbereitungen zur Eröffnung sind in vollem Gange.',
		'en' => 'The preparations for the opening are ongoing.'
	),

	/*****************************************************
	 * Jump Gate
	 ****************************************************/

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
		'de' => "Probier's!",
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
	'spaceDoctor' => array(
		'de' => 'Weltraum Arzt',
		'en' => 'Space Doctor'
	),
	'spaceDoctorDescription' => array(
		'de' => 'Weltraumfieber und Schwerelosigkeitskrankheit sind wirklich üble Gesellen, aber wer geht schon freiwillig zum Arzt? Darum erhälst Du bei jedem Arztbesuch eine Kleinigkeit.',
		'en' => "Space fever and zero gravity disease are really bad companions, but who visits a doctor voluntarily? Thus you'll get something nice for each visit at the doctor."
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
		'de' => 'Zurück',
		'en' => 'Back'
	),

	/*****************************************************
	 * Messages
	 ****************************************************/

	'sent' => array(
		'de' => 'Gesendet',
		'en' => 'Sent'
	),
	'deleteMessage' => array(
		'de' => 'Nachricht löschen',
		'en' => 'Delete message'
	),
	'showHideMessage' => array(
		'de' => 'Nachricht ein- / ausblenden',
		'en' => 'Show / hide message'
	),
	'reallyDeleteMessage' => array(
		'de' => 'Nachricht wirklich weghauen?',
		'en' => 'Really dump message?'
	),
	'messageDeleted' => array(
		'de' => 'Du hast die Nachricht weggehauen.',
		'en' => 'You dumped the message.'
	),
	'recipientNotFound' => array(
		'de' => 'Wir konnten den Spieler %s leider nicht finden.',
		'en' => 'We were not able to find the player %s.'
	),
	'messageSent' => array(
		'de' => 'Der Postbote macht sich auf den Weg.',
		'en' => 'The mailman is on his way.'
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
		'de' => 'In der Space Lounge kannst Du mal so richtig phät abchillen.',
		'en' => 'In the space lounge you can have a wicked chillout.'
	),
	'restCureHeadline' => array(
		'de' => 'Erholungskur',
		'en' => 'Rest Cure'
	),
	'restCureDescription' => array(
		'de' => 'Das wird Deine morschen Glieder wieder auf Schwung bringen.',
		'en' => 'This will bring your rotten limbs back to life.'
	),
	'youFeelBetter' => array(
		'de' => 'Du fühlst Dich gleich viel besser!',
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
		'de' => 'Hier gibt es zwar keinen Kobayashi-Maru-Test, jedoch einige interessante Kurse, welche Dich als aufstrebenden Weltraum-Pionier weiter bringen könnten.',
		'en' => "You can't take a Kobayashi-Maru-Test here, but some other interesting courses, that could bring you forth as an ambitious space-pioneer."
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
		'de' => 'Kurs-Stufe %s',
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
		'de' => "Und schon geht's los!",
		'en' => 'And here we go!'
	),
	'takingCourse' => array(
		'de' => 'Du nimmst gerade am Kurs teil.',
		'en' => 'You are participating at the course.'
	),
	'courseFinished' => array(
		'de' => 'Du hast den Kurs erfolgreich beendet und kannst Dein Zertifikat abholen.',
		'en' => 'You finished the course successfully and can collect your certificate.'
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
	'tactics' => array(
		'de' => 'Taktik',
		'en' => 'Tactics'
	),
	'tacticsHelp' => array(
		'de' => 'Taktisches Können verbessert Deine Treffsicherheit.',
		'en' => 'Tactical skills improve your accuracy.'
	),
	'defense' => array(
		'de' => 'Abwehr',
		'en' => 'Defense'
	),
	'defenseHelp' => array(
		'de' => 'Gute Abwehrmanöver verbessern Deine Ausweichfähigkeit.',
		'en' => 'Well defense maneuvers improve your evasion capability.'
	),
	'crafting' => array(
		'de' => 'Basteln',
		'en' => 'Crafting'
	),
	'craftingHelp' => array(
		'de' => 'Mit besseren Handwerksfähigkeiten kannst Du neue Objekte herstellen.',
		'en' => 'With better crafting skills you can craft new objects.'
	),
	'train' => array(
		'de' => 'Trainieren',
		'en' => 'Train'
	),
	'trainDescription' => array(
		'de' => "Zeig' den verweichlichten Kadetten, was Du drauf hast!",
		'en' => "Show the mollycoddled cadets, what you're about!"
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
		'en' => 'Energy Drain'
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
		'en' => 'Reload Cycle'
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
		'en' => 'Shield Strength'
	),
	'maxShieldStrength' => array(
		'de' => 'Max. Schildstärke',
		'en' => 'Max. Shield Strength'
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
		'en' => 'Max. Capacity'
	),

	/*****************************************************
	 * Battle
	 ****************************************************/

	'number' => array(
		'de' => 'Nummer',
		'en' => 'Number'
	),
	'fight' => array(
		'de' => 'Kämpfen',
		'en' => 'Fight'
	),
	'skirmish' => array(
		'de' => 'Kämpfen',
		'en' => 'Fight'
	),
	'pirateBay' => array(
		'de' => 'Piratenhort',
		'en' => 'Pirate Bay'
	),
	'showHim' => array(
		'de' => "Zeig's ihm!",
		'en' => 'In his face!'
	),
	'pirateBayDescription' => array(
		'de' => 'Lust auf ein Kämpfchen? Die Sonntagsflieger dort draussen haben gewiss noch ein paar Münzen zuviel.',
		'en' => 'You want a little quarrel? Those sunday pilots out there for sure have some spare coins.'
	),
	'badBoys' => array(
		'de' => 'Böse Buben',
		'en' => 'Bad Boys'
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
		'de' => 'Was für eine Enttäuschung, %s hat es Dir ganzschön gegeben!',
		'en' => 'What a swizz, %s really punished you!'
	),
	'skirmishCloseWon' => array(
		'de' => 'Das war aber recht knapp. Für %s lässt Du %s ziehen.',
		'en' => 'That was quite close. For %s you let %s go.'
	),
	'skirmishWellWon' => array(
		'de' => 'Du hast %s ziemlich zerlegt und %s erbeutet.',
		'en' => 'You really tore %s apart and took %s.'
	),
	'outOfFuel' => array(
		'de' => 'Schnell zurück, bevor der Treibstoff ausgeht!',
		'en' => 'Hurry back home before fuel runs out!'
	),
	'noWeaponsInfo' => array(
		'de' => 'Keine Waffe ausgerüstet!',
		'en' => 'No weapon equipped yet!'
	),


	// Old
	'insufficientEnergyWeapon' => array(
		'de' => "Energielevel zu niedrig, um %s abzufeuern.",
		'en' => "Energy level too low to fire %s."
	),
	'insufficientEnergyShield' => array(
		'de' => "Energielevel zu niedrig, um %s aufzubauen.",
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
	 * Tech data
	 ****************************************************/

	'starTripDuration' => array(
		'de' => 'Sternentour-Zeit',
		'en' => 'Star Trip-Time'
	),
	'seconds' => array(
		'de' => 'Sekunden',
		'en' => 'Seconds'
	),
	'shieldsHelp' => array(
		'de' => 'Schilde erfordern inital Energie um sich aufzubauen. Jeder Treffer zieht Energie vom Schild ab, bis die Schildstärke auf null gefallen ist und es kollabiert. Schilde können sich jederzeit neu aufbauen oder regenerieren, sofern genügend Energie verfügbar ist. Schilde können, zusätzlich zu ihrer Schutzwirkung, den Schaden durch Absorbtion reduzieren, sofern Absorbtionstyp und Schadenstyp übereinstimmen.',
		'en' => 'Shields require initial energy to build up. Every hits drains energy from the shield until its power drops to zero and it collapses. Shields can build up or regenerate any time, given there is enough energy available. In addition to the shields protective effect it can reduce damage when the absorb-type matches the damage-type.'
	),
	'reactorHelp' => array(
		'de' => 'Reaktoren versorgen Deine Waffensysteme und Schilde mit Energie. Je höher die Aufladung ist, desto schneller füllt sich die nutzbare Kapazität auf.',
		'en' => "Reactors provide power supply for your ship's weapon systems and shields. The higher the recharge rate, the fast the usable capacity recharges."
	),
	'driveHelp' => array(
		'de' => 'Antriebe mit mehr Schubkraft verbessern die Wendigkeit des Schiffes und damit Deine Ausweichchance. Je schwerer das Schiff, desto stärker sollte der Antrieb sein.',
		'en' => 'Drives with more thurst increase the agility of the ship and thus your evasion chance. The heavier the ship, the stronger the drive should be.'
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
	'engineer' => array(
		'de' => 'Ingenieur',
		'en' => 'Engineer'
	),
	'engineerDescription' => array(
		'de' => 'Du hast einen zufällig herumschlendernden Ingenieur mit Langeweile gefunden, er sagt...',
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
		'de' => 'Heute habe ich leider keinen neuen Tipp für Dich.',
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
	'noDriveNotice' => array(
		'de' => 'Du solltest zuerst einen Antrieb ausrüsten.',
		'en' => 'You should equip an engine first.'
	),

	'missionStrollAround' => array(
		'de' => 'Herumschlendern',
		'en' => 'Stroll Around'
	),
	'missionFoundMoney' => array(
		'de' => 'Glückstag! Du hast %s s£ gefunden!',
		'en' => 'Lucky day! You found %s s£!'
	),
	'missionTalkedWithPilots' => array(
		'de' => 'Du hast Dich mit einem anderen Piloten unterhalten. (%s Erfahrung)',
		'en' => 'You talked to another pilot. (%s Experience)'
	),
	'missionThoughtAboutLife' => array(
		'de' => 'Du hast über Dein Leben nachgedacht. (%s Erfahrung)',
		'en' => 'You thought about your life. (%s Experience)'
	),

	'missionCollectJunk' => array(
		'de' => 'Schrott sammeln',
		'en' => 'Collect Junk'
	),
	'missionMetWithJunkers' => array(
		'de' => 'Du hast Dich mit anderen Schrottsammlern unterhalten. (%s Erfahrung)',
		'en' => 'You talked to other junkers. (%s Experience)'
	),
	'missionBlindedByTheSun' => array(
		'de' => 'Du wurdest von der Sonne geblendet. (%s Erfahrung)',
		'en' => 'You have been blinded by the sun. (%s Experience)'
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
	'missionSawShootingStar' => array(
		'de' => 'Du hast eine Sternschnuppe gesehen. (%s Erfahrung)',
		'en' => 'You saw a shooting star. (%s Experience)'
	),
	'missionLookingForTheSun' => array(
		'de' => 'Du orientierst Dich nach der Sonne. (%s Erfahrung)',
		'en' => 'You orientate yourself by the sun. (%s Experience)'
	),
	'missionSawStardust' => array(
		'de' => 'Du hast Sternenstaub gesehen. (%s Erfahrung)',
		'en' => 'You saw stardust. (%s Experience)'
	),
	'missionFoundFloatingJunk' => array(
		'de' => 'Du hast zufällig herumfliegenden Weltraumschrott gefunden.',
		'en' => 'You found accidentially floating around space junk.'
	),
	'missionWatchingStarships' => array(
		'de' => 'Du hast andere Raumschiffe beobachtet. (%s Erfahrung)',
		'en' => 'You are watching other starships. (%s Experience)'
	),
	'missionEvadingAsteroid' => array(
		'de' => 'Du bist einem Asteroiden ausgewichen. (%s Erfahrung)',
		'en' => 'You evaded an asteroid. (%s Experience)'
	),

	'missionCarriage' => array(
		'de' => 'Transporter',
		'en' => 'Transporter'
	),
	'missionDeliverySuccess' => array(
		'de' => 'Du hast das Paket für %s s£ ungeöffnet und ohne Fragen zu stellen ausgeliefert.',
		'en' => 'You delivered the package unopened and without asking further questions for %s s£.'
	),
	'missionDeliveryFailure' => array(
		'de' => 'Bei der Lieferung gab es... gewisse "Komplikationen". (%s Erfahrung)',
		'en' => 'There have been some... intricacies during the delivery. (%s Experience)'
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
	'loginFailed' => array(
		'de' => 'Spieler nicht gefunden.',
		'en' => 'Player not found.'
	),
	'logoutHeadline' => array(
		'de' => 'Fehler: Seite nicht gefunden',
		'en' => 'Error: Page not found'
	),
	'logoutDescription' => array(
		'de' => 'Sie müssen sich einloggen, um diese Aktion ausführen zu können.',
		'en' => 'You must log in to perform this action.'
	),
	'logoutFootNote' => array(
		'de' => 'Nein Quatsch, wir machen nur Spaß. Bis zum nächsten mal! ;)',
		'en' => 'No, just kidding. See you next time! ;)'
	),
	'developmentMessage' => array(
		'de' => 'Wicked outer World wird gerade entwickelt und es kommen regelmäßig neue Features hinzu. Registriere Dir einen Account und gib uns Feedback!',
		'en' => 'Wicked outer World is currently being developed and new features arrive at a regular basis. Register yourself an account and give us feedback!'
	),

	/*****************************************************
	 * Register
	 ****************************************************/

	'register' => array(
		'de' => 'Registrieren',
		'en' => 'Register'
	),
	'registerIntro' => array(
		'de' => 'Du willst also ein tollkühner Weltraumcowboy werden? Dann hol` Dir Deine Pilotenlizenz und erhalte Deinen ersten Raumjäger!',
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
	'showIt' => array(
		'de' => 'Zeigs mir!',
		'en' => 'Show it!'
	),
	'accountData' => array(
		'de' => 'Dein %s Account',
		'en' => 'Your %s account'
	),
	'welcomeMail' => array(
		'de' => "Willkommen bei %s,

mit Deinen Account-Daten kannst Du Dich jederzeit auf http://www.wicked-outer-world.com einloggen.

----------------------------
Accountname: %s
Passwort: %s
----------------------------

Dies ist eine automatisch generierte Email. Bitte beantworte diese Email nicht, sondern wenden Dich bei Fragen oder Problemen an info@wicked-outer-world.com.

Wir wünschen Dir viel Spaß beim Spielen von %s!

Mit freundlichen Grüßen
Dein %s Team",
		'en' => "Welcome at %s,

with your account data you can log in at http://www.wicked-outer-world.com anytime.

----------------------------
Account name: %s
Password: %s
----------------------------

This is an automatically generated email. Please do not answer to this email. If you have got any questions or problems contact us at info@wicked-outer-world.com.

Good luck and enjoy playing %s!

Greetings
Your %s team"
	),

	/*****************************************************
	 * Account
	 ****************************************************/

	'account' => array(
		'de' => 'Account',
		'en' => 'Account'
	),
	'accountDataEmail' => array(
		'de' => 'Deine Account-Daten wurden an "%s" gesendet.',
		'en' => 'You account data has been sent to "%s".'
	),
	'confirm' => array(
		'de' => 'Bestätigen',
		'en' => 'Confirm'
	),
	'save' => array(
		'de' => 'Speichern',
		'en' => 'Save'
	),
	'passwordForgotten' => array(
		'de' => 'Hast Du vergessen ein Passwort einzugeben?',
		'en' => 'Did you forget to enter a password?'
	),
	'passwordSaved' => array(
		'de' => 'Password gespeichert.',
		'en' => 'Password saved.'
	),
	'changePassword' => array(
		'de' => 'Passwort ändern',
		'en' => 'Change password'
	),
	'abandonAccount' => array(
		'de' => 'Account aufgeben',
		'en' => 'Abandon account'
	),
	'abandonNotice' => array(
		'de' => 'Hier kannst Du Deinen Account unwiderruflich löschen.',
		'en' => 'Here you can delete your account beyond recall.'
	),

	/*****************************************************
	 * Pirate News
	 ****************************************************/

	'latestJoiner' => array(
		'de' => 'Neuester Weltraumpirat in den Gefilden: %s',
		'en' => 'Newest space pirate in this realms: %s'
	),

	/*****************************************************
	 * Imprint
	 ****************************************************/

	'address' => array(
		'de' => 'Anschrift',
		'en' => 'Address'
	),
	'country' => array(
		'de' => 'Deutschland',
		'en' => 'Germany'
	),
	'phone' => array(
		'de' => 'Telefon: 07031 2058958',
		'en' => 'Phone: +49 7031 2058958'
	),
	'contact' => array(
		'de' => 'Email schreiben',
		'en' => 'Write email'
	),

	/*****************************************************
	 * Custom
	 ****************************************************/

	'leaveFeedback' => array(
		'de' => 'Gib Feedback',
		'en' => 'Leave feedback'
	),
	'moreGames' => array(
		'de' => 'Mehr Spiele...',
		'en' => 'More Games...'
	),
	'browsergames' => array(
		'de' => 'Browsergames',
		'en' => 'Browsergames'
	),
	'battleForKyoto' => array(
		'de' => 'Schlacht um Kyoto',
		'en' => 'Battle for Kyoto'
	)
);
