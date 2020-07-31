INSERT INTO platypus (name, age_years, sex, size, weight)
VALUES
("Perry", ABS(RANDOM()) % 21, "männlich", ABS(RANDOM()) % 76, ABS(RANDOM()) % 3001),
("Schnabella", ABS(RANDOM()) % 21, "weiblich", ABS(RANDOM()) % 76, ABS(RANDOM()) % 3001),
("Schnabello", ABS(RANDOM()) % 21, "männlich", ABS(RANDOM()) % 76, ABS(RANDOM()) % 3001),
("Daisy", ABS(RANDOM()) % 21, "weiblich", ABS(RANDOM()) % 76, ABS(RANDOM()) % 3001),
("Flap", ABS(RANDOM()) % 21, "männlich", ABS(RANDOM()) % 76, ABS(RANDOM()) % 3001),
("Anatina", ABS(RANDOM()) % 21, "weiblich", ABS(RANDOM()) % 76, ABS(RANDOM()) % 3001),
("Rufus", ABS(RANDOM()) % 21, "männlich", ABS(RANDOM()) % 76, ABS(RANDOM()) % 3001),
("Goal", ABS(RANDOM()) % 21, "weiblich", ABS(RANDOM()) % 76, ABS(RANDOM()) % 3001),
("Bozo", ABS(RANDOM()) % 21, "männlich", ABS(RANDOM()) % 76, ABS(RANDOM()) % 3001);

INSERT INTO offer (u_id, p_id, price, negotiable, description, zipcode)
VALUES
(3, 1, ABS(RANDOM()) % 100001, ABS(RANDOM()) % 2, "Er ist ein Schnabeltier, die machen nicht viel. Ist aber tagsüber immer verschwunden...", "26129"),
(3, 2, ABS(RANDOM()) % 100001, ABS(RANDOM()) % 2, "Wärst du so freundlich und kaufst dieses Schnabeltier?", "26180"),
(3, 3, ABS(RANDOM()) % 100001, ABS(RANDOM()) % 2, "Rietlebanchs sesied fauk!", "01108"),
(3, 4, ABS(RANDOM()) % 100001, ABS(RANDOM()) % 2, "", "20457"),
(3, 5, ABS(RANDOM()) % 100001, ABS(RANDOM()) % 2, "Ist ein älteres Tier und hat Erinnerungen hinterlassen.", null),
(3, 6, ABS(RANDOM()) % 100001, ABS(RANDOM()) % 2, "Selbsterklärend.", "26121"),
(3, 7, ABS(RANDOM()) % 100001, ABS(RANDOM()) % 2, "Bisschen vertrottelt, besitzt aber Erfindergeist!", "26169"),
(3, 8, ABS(RANDOM()) % 100001, ABS(RANDOM()) % 2, "Gutmütiges Vieh. Hat aber gespaltene Persönlichkeiten", "26655"),
(3, 9, ABS(RANDOM()) % 100001, ABS(RANDOM()) % 2, "In Ehrfurcht vor der Größe dieses Jungens. Absolute Einheit.", "49661");