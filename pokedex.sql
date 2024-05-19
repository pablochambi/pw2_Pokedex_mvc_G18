create database if not exists pokedex;

use pokedex;

create table usuario(
    id int primary key auto_increment,
    name varchar(50) not null unique,
    password varchar(50) not null,
    rol varchar(50) not null
);

CREATE TABLE pokemon (
     id INT AUTO_INCREMENT PRIMARY KEY,
     numero_id INT UNIQUE,
     imagen VARCHAR(100),
     nombre VARCHAR(50),
     tipo1 VARCHAR(50),
     tipo2 VARCHAR(50),
     descripcion VARCHAR(1000)
);

INSERT INTO pokemon (numero_id, imagen, nombre, tipo1, tipo2, descripcion) VALUES
(1, 'public/imagenes/bulbasaur.png', 'Bulbasaur', 'public/imagenes/tipo/planta.png', 'public/imagenes/tipo/veneno.png', 'Tipo: Planta/Veneno
Descripción: Bulbasaur es un Pokémon de tipo Planta/Veneno. Es el Pokémon inicial de tipo Planta en la región de Kanto. Aparece como un pequeño Pokémon reptiliano de color verde con una semilla en su espalda que eventualmente se desarrolla en un bulbo floral. Bulbasaur es conocido por su capacidad para absorber la energía solar a través de la planta en su lomo, lo que le permite realizar ataques poderosos como Rayo Solar.
Altura: 0.7 m
Peso: 6.9 kg
Habilidades especiales: Espesura, Clorofila (Habilidad oculta)
Número en la Pokédex Nacional: #001'),
(2, 'public/imagenes/ivysaur.png', 'Ivysaur', 'public/imagenes/tipo/planta.png', 'public/imagenes/tipo/veneno.png', 'Tipo: Planta/Veneno
Descripción: Ivysaur es la segunda etapa de evolución de Bulbasaur. A medida que Bulbasaur madura, su bulbo floral se desarrolla aún más, convirtiéndose en un brote con flores en forma de capullo. Ivysaur es más grande y más poderoso que Bulbasaur, y puede utilizar una variedad de ataques de tipo Planta y Veneno para defenderse de los enemigos.
Altura: 1.0 m
Peso: 13.0 kg
Habilidades especiales: Espesura, Clorofila (Habilidad oculta)
Número en la Pokédex Nacional: #002'),
(3, 'public/imagenes/venusaur.png', 'Venusaur', 'public/imagenes/tipo/planta.png', 'public/imagenes/tipo/veneno.png', 'Tipo: Planta/Veneno
Descripción: Venusaur es la forma final de la línea evolutiva de Bulbasaur. Cuando Ivysaur alcanza su plena madurez, el bulbo en su espalda florece completamente, revelando una hermosa y poderosa flor. Venusaur es un Pokémon majestuoso y poderoso, capaz de lanzar ataques devastadores de tipo Planta y Veneno. Es un defensor valiente y leal para su entrenador.
Altura: 2.0 m
Peso: 100.0 kg
Habilidades especiales: Espesura, Clorofila (Habilidad oculta)
Número en la Pokédex Nacional: #003'),
(4, 'public/imagenes/charmander.png', 'Charmander', 'public/imagenes/tipo/fuego.png', NULL, 'Tipo: Fuego
Descripción: Charmander es un Pokémon de tipo Fuego y es uno de los tres Pokémon iniciales disponibles en la región de Kanto. Es un pequeño lagarto con una llama ardiente en la punta de su cola. Charmander es conocido por su naturaleza enérgica y su deseo de convertirse en un poderoso Dragón de Fuego algún día. A medida que crece, la llama en su cola se hace más fuerte y su poder aumenta.
Altura: 0.6 m
Peso: 8.5 kg
Habilidades especiales: Mar Llamas, Poder Solar (Habilidad oculta)
Número en la Pokédex Nacional: #004'),
(5, 'public/imagenes/charmeleon.png', 'Charmeleon', 'public/imagenes/tipo/fuego.png', NULL, 'Tipo: Fuego
Descripción: Charmeleon es la segunda etapa de evolución de Charmander. A medida que Charmander crece y se fortalece, evoluciona en Charmeleon. Este Pokémon es más grande y más agresivo que Charmander, y tiene una llama ardiente más grande y brillante en la punta de su cola. Charmeleon es conocido por su temperamento feroz y su determinación de convertirse en un poderoso Charizard algún día.
Altura: 1.1 m
Peso: 19.0 kg
Habilidades especiales: Mar Llamas, Poder Solar (Habilidad oculta)
Número en la Pokédex Nacional: #005'),
(6, 'public/imagenes/charizard.png', 'Charizard', 'public/imagenes/tipo/fuego.png', 'public/imagenes/tipo/volador.png', 'Tipo: Fuego/Volador
Descripción: Charizard es la forma final de la línea evolutiva de Charmander. Cuando Charmeleon alcanza su plena madurez, evoluciona en Charizard, un majestuoso Dragón de Fuego/Volador. Charizard es uno de los Pokémon más poderosos y respetados en la región de Kanto. Tiene la capacidad de volar por los cielos con sus grandes alas y lanzar llamas ardientes desde su boca.
Altura: 1.7 m
Peso: 90.5 kg
Habilidades especiales: Mar Llamas, Poder Solar (Habilidad oculta)
Número en la Pokédex Nacional: #006');

insert into usuario(name, password, rol) values('admin', 'admin', 'admin');

