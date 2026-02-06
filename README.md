# legacy-php-essentials (2026)
Utilerias comprobadas de php 5.3 a php 8.x para manejo de utf8 / unicode legacy

Este repositorio es un concentrado de funciones pensadas para entornos Legacy php

A veces no puedes dominar tu entorno ni poner extensiones en el server. Puedes adaptarlo pero probablente usas 8.x o similares. A veces no está en tu control. 

## ⚖️ Sobre la Licencia
He elegido la **Licencia MIT** por su simplicidad. Es lo más cercano a una "Creative Commons" para código: haz lo que quieras con él, solo mantén el crédito del autor. 

* **¿Por qué no LGPL 2.1?** Aunque es una gran licencia para proteger mejoras (obligando a compartir los cambios del archivo), para este experimento buscaba la mínima fricción posible. La MIT es "Plug & Play", igual que la filosofía del proyecto.

## ✍️ Acerca del Autor
Este proyecto forma parte de una serie de artículos Mi enfoque no es la programación de laboratorio, sino la **Programación Real**: aquella que sobrevive a servidores compartidos, bloqueos de oficina y conexiones de una sola rayita de señal.

Mi nombre es Alfonso Orozco Aguilar, soy mexicano, programo desde 1991 para comer, y no tengo cuenta de Linkedin para disminuir superficie de ataque. Llevo trabajando desde que tengo memoria como devops / programador senior, y en 2026 estoy por terminar la licenciatura de contaduria. En el sitio esta mi perfil de facebook.

[Perfil de Facebook de Alfonso Orozco Aguilar](https://www.facebook.com/alfonso.orozcoaguilar)

## 🛠️ ¿Por qué cPanel y PHP?
* **Versión de PHP:** Asumimos un entorno moderno de **PHP 8.4**, pero por su naturaleza procedural, el código es confiable en cualquier hospedaje compartido con **PHP 5.** o superior. Tu respaldo es como un "Tupperware" que puedes cambiar de refrigerador sin problemas.

* Claro que debes migrarlo aa algo moderno , si puedes. Doy mantenimiento a algunos sistemas de 5.3 (air gapped) y 5.6 en cpanel especial. No muchas personas pueden levantar un 5.6 en cpanel. De entrada necesitas  root.

---

## 📂 Guía de Archivos (Los Especímenes)

* **`common.php`**: Funciones que suelo usar en proyectos hechos a mano. 2010 probablemente

## 🚀 Requisitos Mínimos
1. Un dominio y hospedaje php 7.x Hospedaje compartido con PHP 7.x o superior y se sugiere a MySQL/MariaDB.
