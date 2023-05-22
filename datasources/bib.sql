-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 22 2023 г., 19:19
-- Версия сервера: 10.4.24-MariaDB
-- Версия PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `bib`
--

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `author` text DEFAULT NULL,
  `age` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `books`
--

INSERT INTO `books` (`id`, `name`, `author`, `age`) VALUES
(5, 'Гарри Поттер', 'Джоан Роулинг', '2019'),
(6, 'Шерлок Холмс', 'Артур Конан Дойл', '2020'),
(7, 'Буря мечей', 'Джордж Мартин', '2014'),
(8, 'Побег из шоушенка', 'Стивен Кинг', '2014');

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `from_user_id` bigint(20) NOT NULL,
  `to_user_id` bigint(20) NOT NULL,
  `message` text NOT NULL,
  `message_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `from_user_id`, `to_user_id`, `message`, `message_timestamp`) VALUES
(1, 2, 3, 'Привет!', '2023-05-07 19:06:37'),
(2, 3, 2, 'Здарова!', '2023-05-07 19:06:37'),
(3, 12, 2, 'Привет!', '2023-05-07 19:06:37'),
(4, 2, 12, 'Здарова!', '2023-05-07 19:06:37'),
(5, 12, 2, 'Как у тебя дела?', '0000-00-00 00:00:00'),
(6, 12, 2, 'Как у тебя дела?', '0000-00-00 00:00:00'),
(7, 12, 2, 'Как у тебя дела?', '0000-00-00 00:00:00'),
(8, 12, 2, 'У меня всё супер!', '0000-00-00 00:00:00'),
(9, 12, 1, 'Удалите меня из бана!', '0000-00-00 00:00:00'),
(10, 1, 12, 'Нет, ты плохо себя ведёшь!', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `username` varchar(30) NOT NULL,
  `passwd` varchar(100) NOT NULL,
  `role` varchar(60) NOT NULL DEFAULT 'user',
  `email` varchar(255) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `registration_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `passwd`, `role`, `email`, `first_name`, `last_name`, `registration_date`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin@admin.com', 'Админ', 'Админов', '2022-03-02 20:00:00'),
(2, 'zewius', 'zewius', 'user', 'zewius@user.com', 'Сергей', 'Красилов', '2022-03-02 20:00:00'),
(3, 'jenky', 'jenky', 'user', 'jenky@user.com', 'Евгений', 'Бовкун', '2022-03-02 20:00:00'),
(4, 'gtarp', 'gtarp', 'user', 'gtarp@user.com', 'Илья', 'Башкаев', '2022-03-02 20:00:00'),
(5, '111', '111', 'user', 'goga', 'QWERTY', 'ASDFGH', '2023-03-28 19:18:23'),
(6, 'usue_student', '1234', 'user', 'student@usue.ru', 'Студент', 'Усуев', '2023-03-28 19:20:35'),
(7, 'Zezeze', '4', 'user', '3', '1', '2', '2023-04-09 14:49:09'),
(8, '!!!!', '!!', 'user', '!!', '!!', '!!', '2023-04-09 14:49:55'),
(9, 'usere', '!!', 'user', '!!', '!!', '!!', '2023-04-09 14:51:19'),
(12, 'user', '202cb962ac59075b964b07152d234b70', 'user', 'serezha.krasilov.02@gmail.com', 'Сергей', 'Красилов', '2023-05-07 20:08:59');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_user_id` (`from_user_id`),
  ADD KEY `to_user_id` (`to_user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`to_user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
