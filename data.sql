INSERT INTO aliment (nom, qtt, prix) VALUES
('Carrot', 1, 13083),
('Yam', 1, 4261),
('Chia seeds', 1, 47987),
('Avocado', 1, 21341);

INSERT INTO nutriment (nom) VALUES 
('Proteins'),
('Carbohydrates'),
('Lipids'),
('Water'),
('Vitamins'),
('Minerals');

INSERT INTO contenir (aliment_id, nutriment_id, qtt) VALUES
-- Carotte
(1, 1, 8),
(1, 2, 90),    
(1, 3, 1),   
(1, 4, 880),   
(1, 5, 0.2),
(1, 6, 1),

-- Patate douce
(2, 1, 16),
(2, 2, 201),    
(2, 3, 1),   
(2, 4, 700),   
(2, 5, 0.2),
(2, 6, 2),

-- Graines de chia
(3, 1, 170),
(3, 2, 420),    
(3, 3, 310),   
(3, 4, 60),   
(3, 5, 0.05),
(3, 6, 2),

-- Avocat
(4, 1, 20),
(4, 2, 85),    
(4, 3, 150),   
(4, 4, 700),   
(4, 5, 0.1),
(4, 6, 1);

