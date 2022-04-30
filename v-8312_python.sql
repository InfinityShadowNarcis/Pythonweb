-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Апр 30 2022 г., 20:46
-- Версия сервера: 10.4.24-MariaDB-cll-lve
-- Версия PHP: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `v-8312_python`
--

-- --------------------------------------------------------

--
-- Структура таблицы `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `host_id` int(11) NOT NULL,
  `skill_lvl` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `courses`
--

INSERT INTO `courses` (`id`, `name`, `host_id`, `skill_lvl`) VALUES
(1, 'Начальный питон', 1, 1),
(2, 'Средний питон', 1, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `information`
--

CREATE TABLE `information` (
  `id` int(11) NOT NULL,
  `id_lecture` int(11) NOT NULL,
  `information` text DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `setting` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `information`
--

INSERT INTO `information` (`id`, `id_lecture`, `information`, `type`, `setting`) VALUES
(1, 1, 'Роль лекции в учебном процессе', 'text', 'header'),
(2, 1, 'Лекция – традиционно ведущая форма обучения в вузе. Ее основная дидактическая цель – формирование ориентировочной основы для последующего усвоения студентами учебными материала. Будучи главным звеном дидактического цикла обучения, она выполняет научные, воспитательные и мировоззренческие функции, вводит студента в творческую лабораторию лектора.\n        Лекция – методологическая и организационная основа для всех форм учебных занятий, в том числе самостоятельных. Методологическая основа – так как вводит студента в науку вообще, придает учебному курсу концептуальность, а организационная - так как все другие формы учебных занятий так или иначе «завязаны» на лекцию, чаще всего логически следуют за ней, опираются на нее содержательно и тематически.\n        В ряде случаев лекция выполняет функцию основного источника информации: при отсутствии учебников и учебных пособий, чаще по новым курсам, в случае, когда новые научные данные по той или иной теме не нашлись отражения в учебниках, отдельные разделы и темы курсов очень сложны для самостоятельного изучения. В таких случаях только лектор может методически помочь студентам в освоении сложного материала.\n        По силе личного эмоционального воздействия лектора, его контакта с аудиторией, производимого впечатления, общего влияния на студентов лекционный способ передачи учебного материала наиболее удачен. Лекция раскрывает понятийный аппарат конкретной области знания, проблемы, логику, дает цельное представление о предмете, показывая его место в системе науки, связь с родственными дисциплинами, возбуждает интерес к предмету, развивает профессиональные интересы, в значительной мере определяет содержание других видов занятий.\n        Хотя основа материала лекций и учебника одинакова, лекция, безусловно, имеет неоспоримое преимущество перед учебником: в ней дается новейшее освещение научных вопросов, приводятся самые современные данные о достижениях науки, техники и производства, которых в учебнике может и не быть. Помимо этого, лекция и учебник различаются объемом материала: если учебник приводит подробности, детали, то в лекции их, как правило, нет. В отдельных случаях, например при создании совершенно новых курсов, лекция может оказаться единственной формой передачи студентам знаний, поскольку она опережает процесс создания учебника, который обычно длиться несколько лет.\n        Содержание лекции устанавливается на основе учебной программы данной дисциплины. Это заставляет перейти на жесткую систему отбора материала, умело использовать наглядные пособия, технические средства и вычислительную технику.\nКонкретное содержание лекций может быть разнообразным. Оно включает: изложение той или иной области науки в ее основном содержании: освещение задач, методов и успехов науки и научной практики; рассмотрение различных общих и конкретных проблем науки, техники и культуры; освещение путей научных изысканий; анализ исторических явлений; критика и научная оценка состояния теории и практики.\n        Существенно важным для лекции является изложение материалов личного творчества лектора. Это повышает у студентов интерес к предмету, активизирует их мысленную работу.\n        Лекция в высшей школе – это не простой пересказ учебника или других литературных источников, это личное научно-педагогическое творчество преподавателя в определенной области знания. Настоящий преподаватель, педагог по призванию, готовиться к лекциям не накануне или за час-два до их проведения, а всегда, в течение всей своей деятельности, всю жизнь.\n        В лекциях преподаватель, наряду с систематическим изложением фундаментальных основ науки, высказывает свои научные идеи, свое отношение к предмету изучения, свое творческое понимание его сущности и перспектив развития. Каждая лекция требует его личного анализа развития научных положений, исторического подхода к ним и в то же время непременного освещения их современного состояния, с критическим подходом и раскрытием противоречий в развитии науки и практике ее приложений. Подготовка к лекции требует самого тщательного отбора материала – главного, основного и существенного, привлечения ярких и выразительных примеров, иллюстрирующих положения науки. От лекции требуется также, чтобы она будила и направляла самостоятельную мыслительную деятельность студентов, формировала из мировоззрение. А это значит, что преподаватель должен не только всесторонне знать предмет обучения, но и глубоко понимать соответствующие педагогические и психологические проблемы. Быть философски вооруженным.', 'text', 'ordinary'),
(3, 1, 'https://python.petropavlovsk.kz/images/lectures/lecture_3_image.png', 'image', 'Схема взаимодействия');

-- --------------------------------------------------------

--
-- Структура таблицы `lectures`
--

CREATE TABLE `lectures` (
  `id` int(11) NOT NULL,
  `id_course` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `lectures`
--

INSERT INTO `lectures` (`id`, `id_course`, `name`) VALUES
(1, 1, 'Введение в курс'),
(8, 1, 'Переменные'),
(9, 1, 'Функции'),
(10, 1, 'Классы');

-- --------------------------------------------------------

--
-- Структура таблицы `skill_levels`
--

CREATE TABLE `skill_levels` (
  `id` int(2) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `skill_levels`
--

INSERT INTO `skill_levels` (`id`, `name`) VALUES
(1, 'Начальный'),
(2, 'Средний'),
(3, 'Высокий');

-- --------------------------------------------------------

--
-- Структура таблицы `statuses`
--

CREATE TABLE `statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `statuses`
--

INSERT INTO `statuses` (`id`, `name`) VALUES
(1, 'Не доступна'),
(2, 'Выполняется'),
(3, 'Завершена');

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `id_lecture` int(11) NOT NULL,
  `task` text NOT NULL,
  `input` varchar(255) NOT NULL,
  `output` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `id_lecture`, `task`, `input`, `output`) VALUES
(1, 1, 'Факториалом числа натурального числа n называется произведение чисел от 1 до n включительно. Факториалом нуля называют единицу. Написать программу нахождения факториала данного числа. Реализовать через рекурсию и без рекурсии. Вывести на экран факториалы от десяти первых чисел.', '1 2 3 4 5 6 7 8 9 10', '1 2 6 24 120 720 5040 40320 362880 3628800');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `login`, `pass`, `role`) VALUES
(1, ' Александр Васильевич', 'teacher', '123', '2'),
(2, 'Кальяскаров Арман', 'student', '123', '1'),
(3, 'Алексей Воронцов', 'lexa11', '123', '1'),
(4, 'Иванов Иван', 'startapych', '123', '1'),
(5, 'Одарич Константин', 'odak', 'odak', '1'),
(6, 'Тарасюк Андрей', 'andrey', '123', '1'),
(7, 'Александр Иванович', 'acd', '123', '1'),
(8, 'login', 'pass', '12345', '1'),
(9, 'Истомин Никита', 'nikita', '123456', '1'),
(10, 'KOT', 'KOT', 'KOT', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `user_courses`
--

CREATE TABLE `user_courses` (
  `id` int(11) NOT NULL,
  `id_course` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `rating` int(3) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_courses`
--

INSERT INTO `user_courses` (`id`, `id_course`, `id_user`, `rating`, `status`) VALUES
(1, 1, 2, NULL, 2),
(9, 1, 5, NULL, 2),
(10, 2, 2, NULL, 2),
(11, 1, 9, NULL, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `user_lectures`
--

CREATE TABLE `user_lectures` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_lecture` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_lectures`
--

INSERT INTO `user_lectures` (`id`, `id_user`, `id_lecture`, `status`, `rating`) VALUES
(1, 2, 1, 3, 89),
(2, 2, 8, 2, NULL),
(3, 5, 1, 3, 96),
(4, 9, 1, 3, 99),
(5, 9, 8, 2, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `skill_lvl` (`skill_lvl`),
  ADD KEY `host_id` (`host_id`);

--
-- Индексы таблицы `information`
--
ALTER TABLE `information`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_lecture` (`id_lecture`);

--
-- Индексы таблицы `lectures`
--
ALTER TABLE `lectures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_course` (`id_course`);

--
-- Индексы таблицы `skill_levels`
--
ALTER TABLE `skill_levels`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_lecture` (`id_lecture`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user_courses`
--
ALTER TABLE `user_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `status` (`status`),
  ADD KEY `id_course` (`id_course`);

--
-- Индексы таблицы `user_lectures`
--
ALTER TABLE `user_lectures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_lecture` (`id_lecture`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `status` (`status`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `information`
--
ALTER TABLE `information`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `lectures`
--
ALTER TABLE `lectures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `skill_levels`
--
ALTER TABLE `skill_levels`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `user_courses`
--
ALTER TABLE `user_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `user_lectures`
--
ALTER TABLE `user_lectures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`host_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`skill_lvl`) REFERENCES `skill_levels` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `information`
--
ALTER TABLE `information`
  ADD CONSTRAINT `information_ibfk_1` FOREIGN KEY (`id_lecture`) REFERENCES `lectures` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `lectures`
--
ALTER TABLE `lectures`
  ADD CONSTRAINT `lectures_ibfk_1` FOREIGN KEY (`id_course`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`id_lecture`) REFERENCES `lectures` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `user_courses`
--
ALTER TABLE `user_courses`
  ADD CONSTRAINT `user_courses_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_courses_ibfk_2` FOREIGN KEY (`id_course`) REFERENCES `courses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_courses_ibfk_3` FOREIGN KEY (`status`) REFERENCES `statuses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `user_lectures`
--
ALTER TABLE `user_lectures`
  ADD CONSTRAINT `user_lectures_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_lectures_ibfk_2` FOREIGN KEY (`id_lecture`) REFERENCES `lectures` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_lectures_ibfk_3` FOREIGN KEY (`status`) REFERENCES `statuses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
