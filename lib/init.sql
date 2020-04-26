/* groups */
CREATE TABLE groups (
  group_id INTEGER PRIMARY KEY,
  password TEXT,
  title TEXT,
  ctime INTEGER,
  mtime INTEGER
);

/* members */
CREATE TABLE members (
  member_id INTEGER PRIMARY KEY,
  group_id INTEGER,
  name TEXT,
  score INTEGER DEFAULT 0,
  high_score INTEGER DEFAULT 0,
  ctime INTEGER,
  mtime INTEGER
);

