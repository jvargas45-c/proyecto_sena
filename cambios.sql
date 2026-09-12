-- First (1)

INSERT INTO categorias(id_categoria, nombre_categoria)
VALUES ('5', 'Panadería');

-- Second (2)

INSERT INTO productos(id_producto, nombre_producto, descripcion, tipo_ponque, stock, imagen, id_categoria, id_tamano)
VALUES
('7', 'Pan Campesino', 'Pan campesino de panadería', 'Pan', '15', 'https://st2.depositphotos.com/1765488/6303/i/450/depositphotos_63035425-stock-photo-freshly-baked-traditional-bread.jpg', '5', '1'),
('8', 'Croissant Clásico', 'Croissant Clásico de panadería', 'Pan', '15', 'https://imagenes.20minutos.es/files/image_1920_1080/uploads/imagenes/2022/07/17/fotografia-de-cruasanes.jpeg', '5', '1'),
('9', 'Café Latte', 'Café Latte de cafetería', 'Café', '12', 'https://pixelz.cc/wp-content/uploads/2018/07/latte-art-wood-table-uhd-4k-wallpaper.jpg', '5', '1'),
('10', 'Pan de Chocolate', 'Pan de Chocolate', 'Pan', '8', 'https://t4.ftcdn.net/jpg/21/48/95/03/360_F_2148950334_lP9HjRmGvZ4HE4eSHbMBMrvFXrOwfUOe.jpg', '5', '1'),
('11', 'Galletas Decorativas', 'Galletas Decorativas para eventos', 'Galleta', '30', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS82hjPe355lvF44HkwuWxJOMMs4q3jBgBRfnednzYYMgDHJ5jnHuYnBZ9M&s=10', '5', '1');

-- Third (3)

INSERT INTO precios(id_precio ,id_producto, precio)
VALUES
(7, 7, 5000),
(8, 8, 5000),
(9, 9, 6000),
(10, 10, 4000),
(11, 11, 9000);

-- Finish