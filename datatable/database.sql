CREATE DATABASE IF NOT EXIST demo;
USE demo;
CREATE TABLE IF NOT EXIST barang(barang_id int(4) auto_increment primary key, tipe VARCHAR(30), stok int(3), harga int(7));
INSERT INTO barang(tipe,stok,harga) VALUES('Kaos Band',15,500000),('Kaos Indie',15,250000),('Kaos Formal',15,250000),('Kaos Casual',15,150000),('Kemeja Funnel',20,500000),('Kemeja Katun',30,250000),('Kemeja Casual',10,300000),('Jaket Band',10,750000),('Jaket Hoodie',19,500000),('Jaket Runner',11,650000),('Formal Dress Laki',11,1250000),('Gown',11,1500000),('Sling Bag',11,500000),('Casual Bag',10,650000),('Formal Bag',9,900000);
