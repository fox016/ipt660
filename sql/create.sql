DROP TABLE IF EXISTS cars; /* This will delete the table if it already exists */

CREATE TABLE IF NOT EXISTS cars /* This will create the table if it doesn't already exist */
(
  car_id INTEGER(10) NOT NULL AUTO_INCREMENT, /* Every car created will be given an ID incrementally */
  make VARCHAR(100) NOT NULL, /* NOT NULL means that this has to be defined */
  model VARCHAR(100) NOT NULL,
  year VARCHAR(4) NOT NULL,
  trim VARCHAR (100) DEFAULT NULL, /* DEFAULT NULL means that this will be NULL by default */
  color VARCHAR(50) DEFAULT NULL,
  vin VARCHAR(17) DEFAULT NULL,
  PRIMARY KEY(car_id) /* The PRIMARY KEY is a list of values where the set of values must be unique (in this case, no two cars should ever the same car_id) */
);
