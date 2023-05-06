SET GLOBAL event_scheduler="ON";
CREATE EVENT status_akun ON SCHEDULE EVERY 1 day STARTS current_date + INTERVAL 1 day + INTERVAL 1 minute DO UPDATE account SET status = "Offline";

set foreign_key_checks=0;

ALTER TABLE accounts AUTO_INCREMENT = 1;
ALTER TABLE type AUTO_INCREMENT = 1;
ALTER TABLE harga AUTO_INCREMENT = 1;
ALTER TABLE transaksi AUTO_INCREMENT = 1;
ALTER TABLE list_kendaraan AUTO_INCREMENT = 1;