-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 23 2024 г., 12:05
-- Версия сервера: 5.7.39
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `kinocinema`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comm`
--

CREATE TABLE `comm` (
  `id_comm` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_film_session` int(11) NOT NULL,
  `text` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `film_session`
--

CREATE TABLE `film_session` (
  `id_film_session` int(11) NOT NULL,
  `name_film` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` int(11) DEFAULT NULL,
  `genres` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `director` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cast` text COLLATE utf8mb4_unicode_ci,
  `trailer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poster` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `film_session`
--

INSERT INTO `film_session` (`id_film_session`, `name_film`, `duration`, `genres`, `director`, `cast`, `trailer`, `poster`, `fon`, `description`, `status`) VALUES
(8, 'Министерство неджентльменских дел', 119, 'боевик, драма, военный, история', 'Гай Ричи', 'Генри Кавилл\r\nАлан Ричсон\r\nРори Киннер', 'https://www.youtube.com/embed/1FrYaGDkoOs?si=gRYsnZ2Q2SzT8uj3', '1718799075_poster1.webp', '1718799075_fon1.webp', '1942 год, Великобритания. Они — лучшие из лучших. Отпетые авантюристы и первоклассные спецы, привыкшие действовать в одиночку. Но когда на кону стоит судьба всего мира, им приходится объединиться в сверхсекретное боевое подразделение и отправиться на выполнение дерзкой миссии против нацистов. Теперь их дело — война, и вести они её будут совершенно не по-джентльменски.', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `hall`
--

CREATE TABLE `hall` (
  `id_hall` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_of_rows` int(11) DEFAULT NULL,
  `number_of_seats` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `hall`
--

INSERT INTO `hall` (`id_hall`, `name`, `number_of_rows`, `number_of_seats`) VALUES
(1, 'Зал 1', 6, 16),
(2, 'Зал 2', 6, 16),
(3, 'Зал 3', 6, 16);

-- --------------------------------------------------------

--
-- Структура таблицы `session`
--

CREATE TABLE `session` (
  `id_session` int(11) NOT NULL,
  `id_film_session` int(11) DEFAULT NULL,
  `id_hall` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `price` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `session`
--

INSERT INTO `session` (`id_session`, `id_film_session`, `id_hall`, `date`, `time`, `price`) VALUES
(13, 8, 1, '2024-06-20', '15:30:00', '150.00'),
(14, 8, 3, '2024-06-21', '16:00:00', '300.00');

-- --------------------------------------------------------

--
-- Структура таблицы `ticket`
--

CREATE TABLE `ticket` (
  `id_ticket` int(11) NOT NULL,
  `id_session` int(11) NOT NULL,
  `row` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seats` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `ticket`
--

INSERT INTO `ticket` (`id_ticket`, `id_session`, `row`, `seats`, `id_user`) VALUES
(1, 13, '6', '13', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `email` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pass` varchar(225) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_user` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id_user`, `email`, `name`, `surname`, `pass`, `role_user`) VALUES
(1, 'man@gmail.com', 'qwerty', 'qwerty', '12345', 'admin'),
(2, '12345@12345', '123456789', '12345', '12345', 'user'),
(3, '', '', '', '', 'user');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comm`
--
ALTER TABLE `comm`
  ADD PRIMARY KEY (`id_comm`),
  ADD KEY `id_user` (`id_user`,`id_film_session`),
  ADD KEY `id_film_session` (`id_film_session`);

--
-- Индексы таблицы `film_session`
--
ALTER TABLE `film_session`
  ADD PRIMARY KEY (`id_film_session`);

--
-- Индексы таблицы `hall`
--
ALTER TABLE `hall`
  ADD PRIMARY KEY (`id_hall`);

--
-- Индексы таблицы `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id_session`),
  ADD KEY `id_film_session` (`id_film_session`),
  ADD KEY `id_hall` (`id_hall`);

--
-- Индексы таблицы `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id_ticket`),
  ADD KEY `id_session` (`id_session`,`id_user`),
  ADD KEY `id_user` (`id_user`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comm`
--
ALTER TABLE `comm`
  MODIFY `id_comm` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `film_session`
--
ALTER TABLE `film_session`
  MODIFY `id_film_session` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `hall`
--
ALTER TABLE `hall`
  MODIFY `id_hall` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `session`
--
ALTER TABLE `session`
  MODIFY `id_session` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id_ticket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comm`
--
ALTER TABLE `comm`
  ADD CONSTRAINT `comm_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `comm_ibfk_2` FOREIGN KEY (`id_film_session`) REFERENCES `film_session` (`id_film_session`);

--
-- Ограничения внешнего ключа таблицы `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `session_ibfk_1` FOREIGN KEY (`id_film_session`) REFERENCES `film_session` (`id_film_session`),
  ADD CONSTRAINT `session_ibfk_2` FOREIGN KEY (`id_hall`) REFERENCES `hall` (`id_hall`);

--
-- Ограничения внешнего ключа таблицы `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`id_session`) REFERENCES `session` (`id_session`),
  ADD CONSTRAINT `ticket_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
