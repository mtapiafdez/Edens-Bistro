CREATE TABLE rooms(
	room_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    room_name VARCHAR(100) NOT NULL,
    room_desc VARCHAR(255) NOT NULL,
    room_capacity TINYINT NOT NULL

);

ALTER TABLE reservations
	ADD FOREIGN KEY (room) REFERENCES rooms(room_id)

SELECT * FROM `reservations` INNER JOIN rooms ON reservations.room = rooms.room_id;