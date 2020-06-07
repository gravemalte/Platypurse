INSERT INTO user_group (name)
VALUES
("admin"),
("default");

INSERT INTO user (display_name, ug_id, mail, password)
VALUES
("Admin", 1, "admin@platypurse.com", ""),
("SchnabelFan1337", 2, "schnabelfan@ymail.com", ""),
("ShadowStabber69_HD", 2, "yrtwk@gmail.com", ""),
("Harald", 2, "harald.haraldsen@outlook.com", "");

INSERT INTO user_rating (from_u_id, for_u_id, rating)
VALUES
(2, 3, 3),
(2, 4, 5),
(3, 2, 2),
(3, 4, 4),
(4, 2, 5),
(4, 3, 1);

INSERT INTO platypus (p_id, name, age_years, age_months sex, size)
VALUES
(7, "männlich", 47),
(4, "weiblich", 35),
(11, "männlich", 11),
(8, "weiblich", 39),
(15, "männlich", 46),
(3, "weiblich", 40),
(5, "männlich", 44),
(3, "weiblich", 36),
(5, "männlich", 57),
(6, "weiblich", 38);

INSERT INTO offer (title, u_id, p_id, price, negotiable, description)
VALUES
("Perry", 2, 1, 12999, 0, "Er ist ein Schnabeltier, die machen nicht viel. Ist aber tagsüber immer verschwunden..."),
("Schnabella", 4, 2, 9900, 0, "Wärst du so freundlich und kaufst dieses Schnabeltier?"),
("Schnabello", 4, 3, 9900, 1, "Rietlebanchs sesied fauk!"),
("Daisy", 4, 4, 13300, 1, ""),
("Flap", 3, 5, 7950, 0, "Ist ein älteres Tier und hat Erinnerungen hinterlassen."),
("Anatina", 2, 6, 150000, 1, "Selsbterklärend."),
("Rufus", 3, 7, 550, 0, "Bisschen vertrottelt, besitzt aber Erfindergeist!"),
("Goal", 2, 8, 11879, 0, "Gutmütiges Vieh. Hat aber gespaltene Persönlichkeiten"),
("Bozo", 2, 9, 10000, 1, "In Ehrfurcht vor der Größe dieses Jungens. Absolute Einheit."),
("Deleta", 2, 10, 9999, 0, "Kann gelöscht werden");

INSERT INTO saved_offers (u_id, o_id)
VALUES
(2, )