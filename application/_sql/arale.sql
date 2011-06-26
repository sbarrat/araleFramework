--
-- Base de datos: `arale`
--
use `arale`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--


CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `nombre` varchar(255) NOT NULL DEFAULT '',
  `apellidos` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;    

---
--- Insertamos el usuario por defecto en `users`
---

INSERT INTO `users` (
`username`,`password`,`nombre`,`apellidos`,`email`
) 
VALUES (
'admin',sha1('password'),'admin','araleFramework','admin@araleFramework.com' 
);