INSERT INTO user_group (name)
VALUES
("admin"),
("default");

INSERT INTO user (u_id, display_name, ug_id, mail, password)
VALUES
(1, "Admin", 1, "admin@platypurse.com", "$2y$10$LwVfecVMxhs91PiCTgq0reP0ZgiOIGUAmsot2.RnLZgAQ10Zg25Bu"),
(2, "SchnabelFan1337", 2, "schnabelfan@ymail.com", "$2y$10$LwVfecVMxhs91PiCTgq0reP0ZgiOIGUAmsot2.RnLZgAQ10Zg25Bu"),
(3, "ShadowStabber69_HD", 2, "yrtwk@gmail.com", "$2y$10$LwVfecVMxhs91PiCTgq0reP0ZgiOIGUAmsot2.RnLZgAQ10Zg25Bu"),
(4, "Harald", 2, "harald.haraldsen@outlook.com", "$2y$10$LwVfecVMxhs91PiCTgq0reP0ZgiOIGUAmsot2.RnLZgAQ10Zg25Bu");
/*
$2y$10$LwVfecVMxhs91PiCTgq0reP0ZgiOIGUAmsot2.RnLZgAQ10Zg25Bu == 123
*/

INSERT INTO user_rating (from_u_id, for_u_id, rating)
VALUES
(2, 3, 3),
(2, 4, 5),
(3, 2, 2),
(3, 4, 4),
(4, 2, 5),
(4, 3, 1);

INSERT INTO platypus (p_id, name, age_years, sex, size, weight)
VALUES
(1, "Perry", 7, "männlich", 47, 1350),
(2, "Schnabella", 5, "weiblich", 35, 999),
(3, "Schnabello", 9, "männlich", 11, 1111),
(4, "Daisy", 4, "weiblich", 39, 1292),
(5, "Flap", 17, "männlich", 46, 1437),
(6, "Anatina", 3, "weiblich", 40, 1000),
(7, "Rufus", 4, "männlich", 44, 1200),
(8, "Goal", 2, "weiblich", 36, 800),
(9, "Bozo", 6, "männlich", 57, 3000);

INSERT INTO offer (o_id, u_id, p_id, price, negotiable, description)
VALUES
(1, 2, 1, 12999, 0, "Er ist ein Schnabeltier, die machen nicht viel. Ist aber tagsüber immer verschwunden..."),
(2, 4, 2, 9900, 0, "Wärst du so freundlich und kaufst dieses Schnabeltier?"),
(3, 4, 3, 9900, 1, "Rietlebanchs sesied fauk!"),
(4, 4, 4, 13300, 1, ""),
(5, 3, 5, 7950, 0, "Ist ein älteres Tier und hat Erinnerungen hinterlassen."),
(6, 2, 6, 150000, 1, "Selbsterklärend."),
(7, 3, 7, 550, 0, "Bisschen vertrottelt, besitzt aber Erfindergeist!"),
(8, 2, 8, 11879, 0, "Gutmütiges Vieh. Hat aber gespaltene Persönlichkeiten"),
(9, 2, 9, 10000, 1, "In Ehrfurcht vor der Größe dieses Jungens. Absolute Einheit.");

INSERT INTO saved_offers (u_id, o_id)
VALUES
(2, 1),
(3, 2),
(4, 3),
(2, 4),
(3, 5),
(4, 6),
(2, 7),
(3, 8),
(4, 9),
(2, 8),
(3, 7),
(4, 7),
(2, 5),
(3, 4),
(4, 1),
(2, 2);


INSERT INTO message (sender_id, receiver_id, message) VALUES
(1, 2, 'Das ist ein Test'),
(1, 1, 'Das ist ein Test'),
(1, 1, 'Das ist ein Test'),
(1, 1, 'Das ist ein Test');

/*Tables to fill:
  - message
  - msg_thread
  - report_reason
  - thread_user
  - user_reports
  - offer_reports
  - log
  - offer_images*/