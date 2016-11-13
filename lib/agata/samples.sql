--
-- PostgreSQL database dump
--
--

CREATE TABLE customer (
    code integer,
    name character varying(40),
    phone character varying(20),
    address character varying(40),
    age integer,
    photo character varying(40),
    ref_city integer
);



CREATE TABLE product (
    code integer,
    description character varying(40),
    unit character(2),
    amount numeric(14,2),
    cost numeric(14,2),
    sell_price numeric(14,2)
);

CREATE TABLE sales (
    ref_customer integer,
    ref_product integer,
    amount numeric(14,2),
    date date,
    price numeric(14,2)
);

CREATE TABLE state (
    code character(2),
    description character varying(40),
    etc integer
);


CREATE TABLE city (
    code integer,
    description character varying(40),
    ref_state character(2)
);

INSERT INTO customer VALUES (8, 'Tiago Giovanaz', '55 3443-3458', 'Av. dos Giovanaz', 23, 'images/photos/tiago.png', 5);
INSERT INTO customer VALUES (13, 'William Prigol Lopes', '55 3434-4545', 'Rua Gunsnroses', 19, 'images/photos/william.png', 5);
INSERT INTO customer VALUES (12, 'Henrique Gravina', '55 3434-1212', 'Rua Hidraulica', 17, 'images/photos/henrique.png', 1);
INSERT INTO customer VALUES (11, 'Jamiel Spezia', '55 3434-0404', 'Rua dos gringos', 17, 'images/photos/jamiel.png', 5);
INSERT INTO customer VALUES (10, 'Nasair da Silva', '55 3434-3454', 'Av. Frederico Hulck', 19, 'images/photos/nasair.png', 1);
INSERT INTO customer VALUES (9, 'Alexandre Schmidt', '55 3434-5656', 'Av. General Neto', 25, 'images/photos/xande.png', 4);
INSERT INTO customer VALUES (7, 'Vilson Cristiano Gärtner', '55 3434-5234', 'Rua Avelino Talini', 30, 'images/photos/vilson.png', 1);
INSERT INTO customer VALUES (5, 'Daniel Afonso Heisler', '55 3434-2342', 'Av. 28 de Maio', 23, 'images/photos/daniel.png', 2);
INSERT INTO customer VALUES (4, 'João Alex Fritsch', '55 3434-5445', 'Rua Benjamin Constant', 29, 'images/photos/joao.png', 1);
INSERT INTO customer VALUES (3, 'Pablo DallOglio', '55 3434-9595', 'Rua Conceicao', 23, 'images/photos/pablo.png', 3);
INSERT INTO customer VALUES (2, 'Cesar Brod', '55 3434-5535', 'Rua Julio de Castilhos', 38, 'images/photos/cesar.png', 1);
INSERT INTO customer VALUES (1, 'Maurício de Castro', '55 3434-9876', 'Rua Bento Goncalves', 26, 'images/photos/mauricio.png', 1);
INSERT INTO customer VALUES (15, 'Ana Paula Araujo', '55 3434-9393', 'Av. Sao Rafael', 23, 'images/photos/ana.png', 3);
INSERT INTO customer VALUES (16, 'Armando Taffarel', '55 3434-2424', 'Av. Internacional', 20, 'images/photos/armando.png', 1);
INSERT INTO customer VALUES (18, 'Diego Bienchetti', '55 3434-1814', 'Av. Bianchetti', 24, 'images/photos/diego.png', 1);
INSERT INTO customer VALUES (19, 'Douglas Scheibler', '55 3434-2822', 'Av. Teutonia', 24, 'images/photos/douglas.png', 1);
INSERT INTO customer VALUES (20, 'Ana Paula Fieguenbaum', '55 3434-3332', 'Av. Figui', 24, 'images/photos/figui.png', 1);
INSERT INTO customer VALUES (21, 'Janaina Bald', '55 3433-3332', 'Av. Figui', 24, 'images/photos/jana.png', 2);
INSERT INTO customer VALUES (22, 'Jessica Käfer', '55 3443-3332', 'Av. dos Kafer', 21, 'images/photos/jessica.png', 2);
INSERT INTO customer VALUES (23, 'Josi Petter', '55 3443-6632', 'Av. Estrelense', 24, 'images/photos/josi.png', 2);
INSERT INTO customer VALUES (24, 'Junior Mulinari', '55 3443-7738', 'Av. Vespasiano', 25, 'images/photos/junior.png', 1);
INSERT INTO customer VALUES (25, 'Marcone Theisen', '55 3443-1128', 'Av. Alemao', 25, 'images/photos/marcone.png', 1);
INSERT INTO customer VALUES (28, 'Paulo Köetz', '55 3443-2298', 'Av. dos Koetz', 23, 'images/photos/paulo.png', 1);
INSERT INTO customer VALUES (27, 'Rudi Uhrig Neto', '55 3443-9868', 'Av. dos Uhrig', 23, 'images/photos/rudi.png', 1);
INSERT INTO customer VALUES (26, 'Maico Schmitz', '55 3443-3318', 'Av. Meiense', 25, 'images/photos/maico.png', 1);
INSERT INTO customer VALUES (14, 'Joice Käfer', '55 3434-2344', 'Av. Gumercindo Saraiva', 21, 'images/photos/joice.png', 1);
INSERT INTO customer VALUES (17, 'Diego Bellin', '55 3434-1414', 'Av. Chevrolet', 24, 'images/photos/bellin.png', 1);


INSERT INTO product VALUES (1, 'chocolate', 'OZ', 100.00, 2.00, 2.50);
INSERT INTO product VALUES (3, 'notepad', 'PC', 1400.00, 9.00, 12.00);
INSERT INTO product VALUES (5, 'pencil', 'PC', 800.00, 1.80, 1.10);
INSERT INTO product VALUES (6, 'soap', 'OZ', 200.00, 0.10, 0.20);
INSERT INTO product VALUES (7, 'refrigerant', 'PC', 400.00, 1.20, 1.50);
INSERT INTO product VALUES (8, 'wine bottle', 'PC', 250.00, 4.60, 6.00);
INSERT INTO product VALUES (9, 'orange', 'OZ', 150.00, 1.70, 2.30);
INSERT INTO product VALUES (10, 'strawberry', 'OZ', 600.00, 0.90, 1.20);
INSERT INTO product VALUES (11, 'pineapple', 'OZ', 400.00, 1.80, 2.20);
INSERT INTO product VALUES (12, 'pants', 'PC', 300.00, 39.00, 52.00);
INSERT INTO product VALUES (13, 'tshirt', 'PC', 500.00, 19.00, 34.90);
INSERT INTO product VALUES (14, 'shoe', 'PC', 300.00, 29.00, 49.90);
INSERT INTO product VALUES (15, 'mouse', 'PC', 200.00, 9.00, 19.90);
INSERT INTO product VALUES (16, 'access point', 'PC', 100.00, 25.00, 39.90);


INSERT INTO sales VALUES (7, 1, 7.00, '2003-10-31', 23.00);
INSERT INTO sales VALUES (9, 1, 3.00, '2003-10-31', 23.00);
INSERT INTO sales VALUES (1, 2, 2.00, '2003-10-31', 13.99);
INSERT INTO sales VALUES (2, 2, 2.00, '2003-10-31', 13.99);
INSERT INTO sales VALUES (4, 2, 5.00, '2003-10-31', 13.99);
INSERT INTO sales VALUES (6, 2, 4.00, '2003-10-31', 13.99);
INSERT INTO sales VALUES (8, 2, 2.00, '2003-10-31', 13.99);
INSERT INTO sales VALUES (1, 3, 9.00, '2003-10-31', 11.99);
INSERT INTO sales VALUES (3, 3, 4.00, '2003-10-31', 11.99);
INSERT INTO sales VALUES (5, 3, 7.00, '2003-10-31', 13.00);
INSERT INTO sales VALUES (7, 3, 4.00, '2003-10-31', 13.00);
INSERT INTO sales VALUES (9, 3, 6.00, '2003-10-31', 11.99);
INSERT INTO sales VALUES (2, 4, 2.00, '2003-10-31', 0.50);
INSERT INTO sales VALUES (4, 4, 7.00, '2003-10-31', 0.50);
INSERT INTO sales VALUES (6, 4, 7.00, '2003-10-31', 0.59);
INSERT INTO sales VALUES (8, 4, 7.00, '2003-10-31', 0.59);
INSERT INTO sales VALUES (10, 4, 4.00, '2003-10-31', 0.59);
INSERT INTO sales VALUES (1, 5, 4.00, '2003-10-31', 10.00);
INSERT INTO sales VALUES (3, 5, 4.00, '2003-10-31', 10.00);
INSERT INTO sales VALUES (5, 5, 3.00, '2003-10-31', 10.00);
INSERT INTO sales VALUES (7, 5, 7.00, '2003-10-31', 10.00);
INSERT INTO sales VALUES (9, 5, 9.00, '2003-10-31', 10.00);
INSERT INTO sales VALUES (2, 6, 9.00, '2003-10-31', 0.20);
INSERT INTO sales VALUES (4, 6, 2.00, '2003-10-31', 0.20);
INSERT INTO sales VALUES (6, 6, 9.00, '2003-10-31', 0.20);
INSERT INTO sales VALUES (10, 6, 9.00, '2003-10-31', 0.29);
INSERT INTO sales VALUES (2, 8, 3.00, '2003-10-31', 20.00);
INSERT INTO sales VALUES (2, 8, 7.00, '2003-10-31', 21.00);
INSERT INTO sales VALUES (4, 8, 3.00, '2003-10-31', 21.00);
INSERT INTO sales VALUES (6, 8, 2.00, '2003-10-31', 21.00);
INSERT INTO sales VALUES (8, 8, 2.00, '2003-10-31', 21.00);
INSERT INTO sales VALUES (10, 8, 8.00, '2003-10-31', 21.00);
INSERT INTO sales VALUES (1, 12, 4.00, '2003-10-31', 21.00);
INSERT INTO sales VALUES (1, 13, 4.00, '2003-10-31', 13.99);
INSERT INTO sales VALUES (2, 14, 2.00, '2003-10-31', 11.99);
INSERT INTO sales VALUES (4, 16, 3.00, '2003-10-31', 16.00);
INSERT INTO sales VALUES (3, 15, 6.00, '2003-10-31', 5.00);
INSERT INTO sales VALUES (1, 1, 2.00, '2003-10-31', 23.99);
INSERT INTO sales VALUES (3, 1, 42.00, '2003-10-31', 23.99);
INSERT INTO sales VALUES (5, 1, 7.00, '2003-10-31', 23.99);
INSERT INTO sales VALUES (10, 2, 9.00, '2003-10-31', 15.00);
INSERT INTO sales VALUES (1, 7, 3.00, '2003-10-31', 15.00);
INSERT INTO sales VALUES (3, 7, 7.00, '2003-10-31', 15.00);
INSERT INTO sales VALUES (5, 7, 7.00, '2003-10-31', 15.00);
INSERT INTO sales VALUES (7, 7, 4.00, '2003-10-31', 15.00);
INSERT INTO sales VALUES (9, 7, 4.00, '2003-10-31', 15.00);

INSERT INTO state VALUES ('NY', 'New York', NULL);
INSERT INTO state VALUES ('CA', 'California', NULL);
INSERT INTO state VALUES ('CO', 'Colorado', NULL);
INSERT INTO state VALUES ('a ', 'a', 1);
INSERT INTO state VALUES ('a ', 'a', 1);
INSERT INTO state VALUES ('MA', 'Massachusetts', NULL);
INSERT INTO state VALUES ('b ', 'b', NULL);

INSERT INTO city VALUES (2, 'Cambridge', 'MA');
INSERT INTO city VALUES (3, 'Lawrence', 'MA');
INSERT INTO city VALUES (4, 'Somerville', 'MA');
INSERT INTO city VALUES (5, 'Albany', 'NY');
INSERT INTO city VALUES (6, 'Cortland', 'NY');
INSERT INTO city VALUES (7, 'Hamilton', 'NY');
INSERT INTO city VALUES (8, 'Waterville', 'NY');
INSERT INTO city VALUES (9, 'Del Rey', 'CA');
INSERT INTO city VALUES (10, 'Kingsburg', 'CA');
INSERT INTO city VALUES (11, 'Lakeport', 'CA');
INSERT INTO city VALUES (12, 'Palo Alto', 'CA');
INSERT INTO city VALUES (13, 'Colorado Springs', 'CO');
INSERT INTO city VALUES (14, 'New Castle', 'CO');
INSERT INTO city VALUES (15, 'Springfield', 'CO');
INSERT INTO city VALUES (16, 'Westminster', 'CO');
INSERT INTO city VALUES (1, 'Arlington', 'MA');
