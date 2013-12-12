
INSERT INTO `jsrab`.`users` (`username`, `password`) VALUES ('sam', 'samsam123');
INSERT INTO `jsrab`.`tireSize` (`tireSize`) VALUES ('B104');
INSERT INTO `jsrab`.`tiretreads` (`tireThread`) VALUES ('295/80-22.5');
INSERT INTO `jsrab`.`customers` (`name`,`phonenumber`) VALUES ('Companyname', 'phonenumber');
INSERT INTO `jsrab`.`orders` (`customerID`, `tiretreadID`, `tiresizeID`, `total`, `comments`, `deliverydate`, `userID`,`lastChange`) VALUES ('c_id', 'tt_id', 'ts_id', 'total', 'ordernumber, follownumber mm', '2014-12-04', 'u_id', '2008-07-04');

SELECT orders.id, orders.date, orders.customerID, orders.tiretreadID, orders.tiresizeID, orders.total, orders.comments, orders.deliverydate, orders.userID,orders.lastChange, customers.id AS customer_id, customers.name AS customer_name, customers.phonenumber AS customer_phonenumber, tiretreads.id AS tiretread_id, tiretreads.name AS tiretread_name, tiresizes.id AS tiresize_id, tiresizes.name AS tiresize_name FROM orders LEFT JOIN customers ON customers.id = orders.id LEFT JOIN tiretreads ON tiretreads.id = orders.tiretreadID LEFT JOIN tiresizes ON tiresizes.id = orders.tiresizeID;

desc customers;
RENAME TABLE customer TO customers;
ALTER TABLE orders MODIFY COLUMN `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE orders CHANGE kundID customerID int(11);

select * from users;
select * from tiretreads;
select * from tireSize;

mysql> desc customers;
+-------------+-------------+------+-----+---------+----------------+
| Field       | Type        | Null | Key | Default | Extra          |
+-------------+-------------+------+-----+---------+----------------+
| id	      | int(11)     | NO   | PRI | NULL    | auto_increment |
| name        | varchar(45) | YES  |     | NULL    |                |
| phonenumber | varchar(45) | YES  |     | NULL    |                |
+-------------+-------------+------+-----+---------+----------------+selec

mysql> desc orders
+--------------+-------------+------+-----+-------------------+----------------+
| Field        | Type        | Null | Key | Default           | Extra          |
+--------------+-------------+------+-----+-------------------+----------------+
| id           | int(11)     | NO   | PRI | NULL              | auto_increment |
| date         | timestamp   | NO   |     | CURRENT_TIMESTAMP |                |
| customerID   | int(11)     | YES  |     | NULL              |                |
| tiretreadID  | int(11)     | YES  |     | NULL              |                |
| tiresizeID   | int(11)     | YES  |     | NULL              |                |
| total        | int(11)     | YES  |     | NULL              |                |
| comments     | varchar(45) | YES  |     | NULL              |                |
| deliverydate | varchar(45) | YES  |     | NULL              |                |
| userID       | varchar(45) | YES  |     | NULL              |                |
| lastChange   | date        | YES  |     | NULL              |                |
+--------------+-------------+------+-----+-------------------+----------------+

mysql> desc users
    -> ;
+----------+-------------+------+-----+---------+----------------+
| Field    | Type        | Null | Key | Default | Extra          |
+----------+-------------+------+-----+---------+----------------+
| id       | int(11)     | NO   | PRI | NULL    | auto_increment |
| username | varchar(45) | YES  |     | NULL    |                |
| password | varchar(45) | YES  |     | NULL    |                |
+----------+-------------+------+-----+---------+----------------+
3 rows in set (0.00 sec)

mysql> desc tiretreads;
+--------+-------------+------+-----+---------+----------------+
| Field  | Type        | Null | Key | Default | Extra          |
+--------+-------------+------+-----+---------+----------------+
| id     | int(11)     | NO   | PRI | NULL    | auto_increment |
| name   | varchar(45) | YES  |     | NULL    |                |
+--------+-------------+------+-----+---------+----------------+
+----+-------------+
| id | thread      |
+----+-------------+
|  1 | 315/80-22,5 |
|  2 | 315/70-22,5 |
|  3 | 10.00-20    |
|  4 | 265/70-19.5 |
|  5 | 295/80-22.5 |
+----+-------------+


mysql> desc tiresizes;
+-------+-------------+------+-----+---------+----------------+
| Field | Type        | Null | Key | Default | Extra          |
+-------+-------------+------+-----+---------+----------------+
| id    | int(11)     | NO   | PRI | NULL    | auto_increment |
| name  | varchar(45) | YES  |     | NULL    |                |
+-------+-------------+------+-----+---------+----------------+
+----+--------+
| id | size   |
+----+--------+
|  1 | BDR-W+ |
|  3 | BDR-HG |
|  5 | BDY    |
|  7 | B104   |
+----+--------+







