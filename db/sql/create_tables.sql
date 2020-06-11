CREATE TABLE user_group (
  ug_id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT NOT NULL
);

CREATE TABLE user (
  u_id INTEGER PRIMARY KEY AUTOINCREMENT,
  display_name TEXT UNIQUE NOT NULL,
  mail TEXT UNIQUE NOT NULL,
  password TEXT NOT NULL,
  ug_id INTEGER NOT NULL,
  rating REAL DEFAULT 0,
  created_at TEXT DEFAULT (datetime('now','localtime')),
  disabled INTEGER DEFAULT 0,
  CONSTRAINT fk_user_group
    FOREIGN KEY (ug_id)
    REFERENCES user_group(ug_id)
);

CREATE TABLE user_rating (
  from_u_id INTEGER NOT NULL,
  for_u_id INTEGER NOT NULL,
  rating INTEGER NOT NULL,
  PRIMARY KEY(from_u_id, for_u_id),
  CONSTRAINT fk_from_user
    FOREIGN KEY (from_u_id)
    REFERENCES user(u_id),
  CONSTRAINT fk_for_user
    FOREIGN KEY (for_u_id)
    REFERENCES user(u_id)
);

CREATE TABLE platypus (
  p_id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT NOT NULL,
  age_years INTEGER NOT NULL,
  sex TEXT NOT NULL,
  size INTEGER NOT NULL,
  weight INTEGER NOT NULL,
  active INTEGER DEFAULT 1
);

CREATE TABLE offer (
  o_id INTEGER PRIMARY KEY AUTOINCREMENT,
  u_id INTEGER NOT NULL,
  p_id INTEGER NOT NULL,
  price INTEGER NOT NULL,
  negotiable INTEGER DEFAULT 0,
  description TEXT DEFAULT "",
  clicks INTEGER DEFAULT 0,
  create_date TEXT DEFAULT (datetime('now','localtime')),
  edit_date text,
  active INTEGER DEFAULT 1,
  CONSTRAINT fk_platypus
    FOREIGN KEY (p_id)
    REFERENCES platypus(p_id),
  CONSTRAINT fk_user
    FOREIGN KEY (u_id)
    REFERENCES user(u_id)
);

CREATE TABLE offer_images (
  oi_id INTEGER NOT NULL,
  o_id INTEGER NOT NULL,
  picture_position INTEGER NOT NULL,
  image BLOB NOT NULL,
  CONSTRAINT fk_offer
    FOREIGN KEY (o_id)
    REFERENCES offer(o_id)
);

CREATE TABLE saved_offers (
  u_id INTEGER NOT NULL,
  o_id INTEGER NOT NULL,
  active INTEGER DEFAULT 1,
  PRIMARY KEY (u_id, o_id),
  CONSTRAINT fk_user
    FOREIGN KEY (u_id)
    REFERENCES user(u_id),
  CONSTRAINT fk_offer
    FOREIGN KEY (o_id)
    REFERENCES offer(o_id)
);

CREATE TABLE message (
  msg_id INTEGER PRIMARY KEY AUTOINCREMENT,
  sender_id INTEGER NOT NULL,
  receiver_id INTEGER NOT NULL,
  message TEXT NOT NULL,
  send_date DEFAULT (datetime('now','localtime')),
  CONSTRAINT fk_sender_user
    FOREIGN KEY (sender_id)
    REFERENCES user(u_id),
  CONSTRAINT fk_receiver_user
    FOREIGN KEY (receiver_id)
    REFERENCES user(u_id)
);

CREATE TABLE report_reason (
  rr_id INTEGER PRIMARY KEY AUTOINCREMENT,
  reason TEXT NOT NULL
);

CREATE TABLE user_reports (
  ur_id INTEGER PRIMARY KEY AUTOINCREMENT,
  reported_u_id INTEGER NOT NULL,
  reporter_u_id INTEGER NOT NULL,
  rr_id INTEGER NOT NULL,
  message text,
  CONSTRAINT fk_user_reported
    FOREIGN KEY (reported_u_id)
    REFERENCES user(u_id),
  CONSTRAINT fk_user_reporter
    FOREIGN KEY (reporter_u_id)
    REFERENCES user(u_id),
  CONSTRAINT fk_report_reason
    FOREIGN KEY (rr_id)
    REFERENCES report_reason(rr_id)
);

CREATE TABLE offer_reports (
  or_id INTEGER PRIMARY KEY AUTOINCREMENT,
  reported_o_id INTEGER NOT NULL,
  reporter_u_id INTEGER NOT NULL,
  rr_id INTEGER NOT NULL,
  message text,
  CONSTRAINT fk_offer_reported
    FOREIGN KEY (reported_o_id)
    REFERENCES offer(o_id),
  CONSTRAINT fk_user_reporter
    FOREIGN KEY (reporter_u_id)
    REFERENCES user(u_id),
  CONSTRAINT fk_report_reason
    FOREIGN KEY (rr_id)
    REFERENCES report_reason(rr_id)
);

CREATE TABLE log (
  l_id INTEGER PRIMARY KEY AUTOINCREMENT,
  message text
);
