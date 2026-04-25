-- Load script assuming MySQL. 
-- Adjust "INFILE 'path/to/file.csv'" to your actual file path if needed during execution.
-- Make sure to run this script from the directory containing the CSV files, or provide full paths.

LOAD DATA INFILE 'students.csv'
INTO TABLE Student
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'clubs.csv'
INTO TABLE Club
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'events.csv'
INTO TABLE Event
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;

LOAD DATA INFILE 'registrations.csv'
INTO TABLE Registration
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS;
