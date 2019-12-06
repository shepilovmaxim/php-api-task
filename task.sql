CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `key` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `users` (`id`, `name`, `email`, `photo`, `key`, `password`) VALUES
(1, 'John', 'johndoe@gmail.com', 'johndoe.jpg', '04d10d6be7ed3320a6df155bba695499', '$2y$12$9wbLUyD37nO9VIaEH1avKu1oUfXH3AYJjZuQ2RTAkf0caoB64zRhG'),
(11, 'Jane', 'janedoe@gmail.com', 'janedoe.jpg', '43a14efcabdd9788580e54e423604d8f', '$2y$12$/.Nn3jW5qh7tGd19WOl1.uzILVZ1nOcGoUFJ1ekoE6WVlHGFMJ/y2');