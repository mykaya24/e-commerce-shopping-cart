USE ecommerce;

-- =========================
-- CATEGORIES
-- =========================
INSERT INTO categories (name, slug) VALUES
('Beyaz Eşya', 'beyaz-esya'),
('Küçük Elektrikli', 'kucuk-elektrikli'),
('Ankastre', 'ankastre');

-- =========================
-- PRODUCTS
-- =========================
INSERT INTO products (name, description, price, stock, category_id, image_url) VALUES
('Siemens VSX7XTRM 850 W Toz Torbasız Süpürge','Siemens VSX7XTRM 850 W Toz Torbasız Süpürge',15000.00, 30, 2, 'https://media3.bsh-group.com/Product_Shots/23677442_SMS26DW00T_STP_def.webp' ),
('Bosch DWK065G60T Siyah Duvar Tipi Davlumbaz (Yatık Cam)','Bosch DWK065G60T Siyah Duvar Tipi Davlumbaz (Yatık Cam)',5610.88, 30, 3, 'https://media3.bsh-group.com/Product_Shots/23677442_SMS26DW00T_STP_def.webp' ),
('Arçelik AFC 230 S Siyah Ankastre Fırın - Zaman Ayarlı','Arçelik AFC 230 S Siyah Ankastre Fırın - Zaman Ayarlı',4800.00, 30, 3, 'https://media3.bsh-group.com/Product_Shots/23677442_SMS26DW00T_STP_def.webp'),
('Arçelik AFM 130 B Beyaz Ankastre Fırın','Arçelik AFM 130 B Beyaz Ankastre Fırın',10500.00, 30, 3, 'https://media3.bsh-group.com/Product_Shots/23677442_SMS26DW00T_STP_def.webp'),
('Bosch POP7C2O12O Beyaz Cam Ankastre Ocak - 67 cm','Bosch POP7C2O12O Beyaz Cam Ankastre Ocak - 67 cm',9025.00, 30, 3, 'https://media3.bsh-group.com/Product_Shots/23677442_SMS26DW00T_STP_def.webp'),
('Bosch GSV24VWF0N A+ 192 LT 6 Çekmeceli Dikey Derin Dondurucu','Bosch GSV24VWF0N A+ 192 LT 6 Çekmeceli Dikey Derin Dondurucu',11142.38, 30, 1, 'https://media3.bsh-group.com/Product_Shots/23677442_SMS26DW00T_STP_def.webp'),
('Bosch KDN55NWF1N Çift Kapılı No-Frost Buzdolabı','Bosch KDN55NWF1N Çift Kapılı No-Frost Buzdolabı',16278.00, 30, 1, 'https://media3.bsh-group.com/Product_Shots/23677442_SMS26DW00T_STP_def.webp'),
('Bosch WGA141X1TR 1000 Devir 9 kg Çamaşır Makinesi','Bosch WGA141X1TR 1000 Devir 9 kg Çamaşır Makinesi',16260.20, 30, 1, 'https://media3.bsh-group.com/Product_Shots/23677442_SMS26DW00T_STP_def.webp'),
('Beko BM 6047 BC Beyaz Bulaşık Makinesi','Beko BM 6047 BC Beyaz Bulaşık Makinesi',18000.00, 30, 1, 'https://media3.bsh-group.com/Product_Shots/23677442_SMS26DW00T_STP_def.webp'),
('Bosch BGC41Q69 650 W Toz Torbasız Süpürge','Bosch BGC41Q69 650 W Toz Torbasız Süpürge',10679.39, 30, 2, 'https://media3.bsh-group.com/Product_Shots/23677442_SMS26DW00T_STP_def.webp'),
('Siemens SN23HY62MT Gri 6 Programlı Bulaşık Makinesi','Siemens SN23HY62MT Gri 6 Programlı Bulaşık Makinesi',36500.00, 30, 1, 'https://media3.bsh-group.com/Product_Shots/23677442_SMS26DW00T_STP_def.webp'),
('Siemens TP713R19 Siyah Tam Otomatik Kahve Makinesi','Siemens TP713R19 Siyah Tam Otomatik Kahve Makinesi',36000.00, 30, 2, 'https://media3.bsh-group.com/Product_Shots/23677442_SMS26DW00T_STP_def.webp'),
('Beko CMX 11140 Çamaşır Makinesi 11 kg','Beko CMX 11140 Çamaşır Makinesi 11 kg',24000.00, 30, 1, 'https://media3.bsh-group.com/Product_Shots/23677442_SMS26DW00T_STP_def.webp'),
('Beko 970475 EI No Frost Buzdolabı 477 Lt','Beko 970475 EI No Frost Buzdolabı 477 Lt',34000.00, 30, 1, 'https://media3.bsh-group.com/Product_Shots/23677442_SMS26DW00T_STP_def.webp'),
('Bosch SMS4EKW63T Beyaz Bulaşık Makinesi','Bosch SMS4EKW63T Beyaz Bulaşık Makinesi',19581.73, 30, 1, 'https://media3.bsh-group.com/Product_Shots/23677442_SMS26DW00T_STP_def.webp'),
('Bosch KDN76XIE1N inox Buzdolabı No Frost ','Bosch KDN76XIE1N inox Buzdolabı No Frost ',43928.55, 30, 1, 'https://media3.bsh-group.com/Product_Shots/23677442_SMS26DW00T_STP_def.webp');


-- =========================
-- COUPONS
-- =========================
INSERT INTO coupons (code, type, value, min_cart_total, expires_at, is_active) VALUES
(
  'INDIRIM10',
  'percentage',
  10,
  500,
  DATE_ADD(NOW(), INTERVAL 30 DAY),
  1
),
(
  'SABIT200',
  'fixed',
  200,
  1000,
  DATE_ADD(NOW(), INTERVAL 15 DAY),
  1
),
(
  'PASIF50',
  'fixed',
  50,
  300,
  DATE_ADD(NOW(), INTERVAL 7 DAY),
  0
);
