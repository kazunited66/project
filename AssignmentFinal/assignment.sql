-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2023 at 01:11 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assignment`
--

-- --------------------------------------------------------

--
-- Table structure for table `actors`
--

CREATE TABLE `actors` (
  `actor_id` int(11) NOT NULL,
  `actor_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `actors`
--

INSERT INTO `actors` (`actor_id`, `actor_name`) VALUES
(1, 'Tom Hanks'),
(2, 'Leonardo DiCaprio'),
(3, 'Meryl Streep'),
(4, 'Brad Pitt'),
(5, 'Scarlett Johansson'),
(6, 'Johnny Depp'),
(7, 'Tom Cruise'),
(8, 'Natalie Portman'),
(9, 'Morgan Freeman'),
(10, 'Cate Blanchett'),
(11, 'Jim Carrey'),
(12, 'Johnny Cash'),
(13, 'Clint Eastwood'),
(14, 'Eli Wallach'),
(15, 'Lee Van Cleef'),
(16, 'Samuel L. Jackson'),
(17, 'Bruce Willis'),
(18, 'Elijah Wood');

-- --------------------------------------------------------

--
-- Table structure for table `directors`
--

CREATE TABLE `directors` (
  `director_id` int(11) NOT NULL,
  `director_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `directors`
--

INSERT INTO `directors` (`director_id`, `director_name`) VALUES
(1, 'Christopher Nolan'),
(2, 'Quentin Tarantino'),
(3, 'Steven Spielberg'),
(4, 'Martin Scorsese'),
(5, 'James Cameron'),
(6, 'Hayao Miyazaki'),
(7, 'David Fincher'),
(8, 'Alfred Hitchcock'),
(9, 'Stanley Kubrick'),
(10, 'Francis Ford Coppola'),
(11, 'Quentin Tarantino'),
(12, 'Christopher Nolan'),
(13, 'Tim Burton'),
(14, 'Akira Kurosawa'),
(15, 'Billy Wilder');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `genre_id` int(11) NOT NULL,
  `genre_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`genre_id`, `genre_name`) VALUES
(1, 'Action'),
(2, 'Drama'),
(3, 'Comedy'),
(4, 'Science Fiction'),
(5, 'Thriller'),
(6, 'Adventure'),
(7, 'Animation'),
(8, 'Fantasy'),
(9, 'Romance'),
(10, 'Mystery'),
(11, 'Horror'),
(12, 'Musical'),
(13, 'Documentary'),
(14, 'Western'),
(15, 'War');

-- --------------------------------------------------------

--
-- Table structure for table `movieactors`
--

CREATE TABLE `movieactors` (
  `movie_id` int(11) NOT NULL,
  `actor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movieactors`
--

INSERT INTO `movieactors` (`movie_id`, `actor_id`) VALUES
(13, 11),
(14, 6),
(15, 8),
(16, 17),
(17, 9),
(18, 11),
(19, 12),
(20, 17),
(21, 6),
(22, 10),
(23, 16),
(24, 6),
(25, 16),
(26, 2),
(27, 17),
(28, 6),
(29, 18),
(30, 4),
(31, 14),
(32, 9);

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `movie_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `release_year` int(11) DEFAULT NULL,
  `genre_id` int(11) DEFAULT NULL,
  `director_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `ImageURL` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`movie_id`, `title`, `release_year`, `genre_id`, `director_id`, `description`, `language`, `ImageURL`, `created_at`, `updated_at`) VALUES
(1, 'Inception', 2010, 4, 1, 'A mind-bending heist movie', 'English', 'Inception.avif', '2023-11-10 22:49:25', '2023-11-13 05:06:52'),
(2, 'Pulp Fiction', 1994, 3, 2, 'A nonlinear crime film', 'English', 'pulpFiction.jpg', '2023-11-10 22:49:25', '2023-11-13 05:07:47'),
(3, 'The Shawshank Redemption', 1994, 2, 3, 'A tale of hope and perseverance', 'English', 'theShawshankRedemption.jpg', '2023-11-10 22:49:25', '2023-11-13 05:09:22'),
(4, 'The Godfather', 1972, 2, 4, 'A classic Mafia drama', 'English', 'thegodfather.avif', '2023-11-10 22:49:25', '2023-11-13 05:09:05'),
(5, 'The Dark Knight', 2008, 1, 1, 'Gotham needs a hero', 'English', 'thedarkknight.jpg', '2023-11-10 22:49:25', '2023-11-13 05:08:19'),
(6, 'Schindler\'s List', 1993, 2, 3, 'A powerful story of humanity', 'English', 'schindler\'sList.jpg', '2023-11-10 22:49:25', '2023-11-13 05:07:51'),
(7, 'Forrest Gump', 1994, 3, 1, 'Life is like a box of chocolates', 'English', 'ForestGump.jpg', '2023-11-10 22:49:25', '2023-11-13 10:44:45'),
(8, 'Titanic', 1997, 2, 5, 'A tragic love story at sea', 'English', 'Titanic.jpg', '2023-11-10 22:49:25', '2023-11-13 10:44:53'),
(9, 'Fight Club', 1999, 1, 2, 'Rules are meant to be broken', 'English', 'fightClub.jpg', '2023-11-10 22:49:25', '2023-11-13 10:45:04'),
(10, 'The Matrix', 1999, 4, 5, 'Welcome to the real world', 'English', 'theMatrix.jpg', '2023-11-10 22:49:25', '2023-11-13 10:56:38'),
(11, 'The Departed', 2006, 1, 4, 'Undercover in the Boston Mafia', 'English', 'theDeparted.jpg', '2023-11-10 22:56:00', '2023-11-13 10:56:50'),
(12, 'The Social Network', 2010, 3, 3, 'The Story of Facebook', 'English', 'theSocialNetwork', '2023-11-10 22:57:11', '2023-11-13 10:57:01'),
(13, 'Spirited Away', 2001, 7, 6, 'A journey in a magical world', 'Japanese', 'spiritedAway.jpg', '2023-11-10 23:39:10', '2023-11-13 10:57:24'),
(14, 'Fight Club', 1999, 1, 7, 'Rules are meant to be broken', 'English', 'fightClub.jpg', '2023-11-10 23:39:10', '2023-11-13 10:50:09'),
(15, 'Vertigo', 1958, 5, 8, 'A tale of obsession and deception', 'English', 'vertigo.jpg', '2023-11-10 23:39:10', '2023-11-13 10:57:34'),
(16, '2001: A Space Odyssey', 1968, 8, 9, 'The evolution of mankind', 'English', 'spaceOdyssey.jpg', '2023-11-10 23:39:10', '2023-11-13 10:58:18'),
(17, 'Apocalypse Now', 1979, 1, 10, 'Journey into the heart of darkness', 'English', 'apocalypseNow.jpg', '2023-11-10 23:39:10', '2023-11-13 10:49:21'),
(18, 'My Neighbor Totoro', 1988, 7, 6, 'Adventures with magical creatures', 'Japanese', 'MyNeighborTotoro.jpg', '2023-11-10 23:39:10', '2023-11-13 11:00:39'),
(19, 'The Princess Bride', 1987, 6, 7, 'A fairy tale adventure', 'English', 'ThePrincessBride.jpg', '2023-11-10 23:39:10', '2023-11-13 11:01:31'),
(20, 'The Shining', 1980, 5, 9, 'Here\'s Johnny!', 'English', 'TheShining.jpg', '2023-11-10 23:39:10', '2023-11-13 11:02:05'),
(21, 'The Godfather: Part III', 1990, 2, 10, 'The final chapter of the Corleone saga', 'English', 'TheGodfatherPart3.jpg', '2023-11-10 23:39:10', '2023-11-13 11:03:14'),
(22, 'Gone with the Wind', 1939, 9, 8, 'Epic love story during the Civil War', 'English', 'GonewiththeWind.jpg', '2023-11-10 23:39:10', '2023-11-13 11:04:12'),
(23, 'The Exorcist', 1973, 11, 11, 'A chilling tale of demonic possession', 'English', 'TheExorcist.jpg', '2023-11-10 23:41:23', '2023-11-13 11:05:09'),
(24, 'Moulin Rouge!', 2001, 12, 12, 'A musical journey through Paris', 'English', 'MoulinRouge.jpg', '2023-11-10 23:41:23', '2023-11-13 11:05:48'),
(25, 'An Inconvenient Truth', 2006, 13, 13, 'Al Gore\'s documentary on climate change', 'English', 'AnInconvenientTruth.jpg', '2023-11-10 23:41:23', '2023-11-13 11:06:44'),
(26, 'Django Unchained', 2012, 1, 11, 'A bounty hunter\'s revenge in the pre-Civil War South', 'English', 'DjangoUnchained.jpg', '2023-11-10 23:41:23', '2023-11-13 11:07:13'),
(27, 'Seven Samurai', 1954, 15, 14, 'Legendary samurai defend a village', 'Japanese', 'SevenSamurai.jpg', '2023-11-10 23:41:23', '2023-11-13 11:08:02'),
(28, 'Edward Scissorhands', 1990, 8, 13, 'A story of an artificial man with scissor hands', 'English', 'EdwardScissorhands.jpg', '2023-11-10 23:41:23', '2023-11-13 11:08:49'),
(29, 'Sunset Boulevard', 1950, 5, 15, 'The dark side of Hollywood', 'English', 'SunsetBoulevard.jpg', '2023-11-10 23:41:23', '2023-11-13 11:09:36'),
(30, 'A Clockwork Orange', 1971, 14, 9, 'A dystopian crime film', 'English', 'AClockworkOrange.jpg', '2023-11-10 23:41:23', '2023-11-13 11:10:14'),
(31, 'The Good, the Bad and the Ugly', 1966, 14, 14, 'A classic Spaghetti Western', 'Italian', 'TheGood.jpg', '2023-11-10 23:41:23', '2023-11-13 11:11:12'),
(32, 'Saving Private Ryan', 1998, 15, 3, 'A powerful depiction of WWII', 'English', 'SavingPrivateRyan.jpg', '2023-11-10 23:41:23', '2023-11-13 11:12:38');

-- --------------------------------------------------------

--
-- Stand-in structure for view `movies detailed view`
-- (See below for the actual view)
--
CREATE TABLE `movies detailed view` (
`movie_id` int(11)
,`title` varchar(255)
,`release_year` int(11)
,`genre_name` varchar(50)
,`director_name` varchar(100)
,`actor_name` varchar(100)
,`description` text
,`language` varchar(50)
,`ImageURL` varchar(255)
);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `review_date` date DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `user_id`, `movie_id`, `rating`, `comment`, `review_date`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 4, 'Very GOod Movie', NULL, '2023-11-14 03:19:57', '2023-11-14 03:19:57'),
(2, 4, 9, 5, 'asdasdsadsadsadsadsad', '2023-11-14', '2023-11-14 03:27:35', '2023-11-14 03:27:35'),
(3, 4, 28, 4, 'Goofd Moviewssasd', '2023-11-14', '2023-11-14 03:28:22', '2023-11-14 03:28:22'),
(4, 4, 30, 4, 'Very GOod movie and sophisticated', '2023-11-14', '2023-11-14 03:29:11', '2023-11-14 03:29:11'),
(5, 4, 14, 4, 'good moviewasda', '2023-11-14', '2023-11-14 04:22:25', '2023-11-14 04:36:34'),
(6, 5, 14, 5, 'asdasdsadsadsa', '2023-11-14', '2023-11-14 04:43:58', '2023-11-14 04:43:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `registered_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstName`, `lastName`, `address`, `email`, `password_hash`, `registered_at`) VALUES
(4, 'Utsav', 'Neupane', 'Lidcombe', 'utsavneupane7@gmail.com', '$2y$10$7Xqp.yhXPz2Grdix/emE/uENCZs8QGBjbTqpjwJ3.IE7rF1lgjIEO', '2023-11-13 03:47:57'),
(5, 'asdasdasd', 'asdasd', 'asdasdsa', 'asdsaasd', 'asdsadas', '2023-11-14 04:43:20');

-- --------------------------------------------------------

--
-- Structure for view `movies detailed view`
--
DROP TABLE IF EXISTS `movies detailed view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `movies detailed view`  AS SELECT `movies`.`movie_id` AS `movie_id`, `movies`.`title` AS `title`, `movies`.`release_year` AS `release_year`, `genres`.`genre_name` AS `genre_name`, `directors`.`director_name` AS `director_name`, `actors`.`actor_name` AS `actor_name`, `movies`.`description` AS `description`, `movies`.`language` AS `language`, `movies`.`ImageURL` AS `ImageURL` FROM (((`movies` join `genres` on(`movies`.`genre_id` = `genres`.`genre_id`)) join `directors` on(`movies`.`director_id` = `directors`.`director_id`)) join `actors` on(`movies`.`movie_id` = `actors`.`actor_id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actors`
--
ALTER TABLE `actors`
  ADD PRIMARY KEY (`actor_id`);

--
-- Indexes for table `directors`
--
ALTER TABLE `directors`
  ADD PRIMARY KEY (`director_id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`genre_id`);

--
-- Indexes for table `movieactors`
--
ALTER TABLE `movieactors`
  ADD PRIMARY KEY (`movie_id`,`actor_id`),
  ADD KEY `actor_id` (`actor_id`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movie_id`),
  ADD KEY `genre_id` (`genre_id`),
  ADD KEY `director_id` (`director_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actors`
--
ALTER TABLE `actors`
  MODIFY `actor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `directors`
--
ALTER TABLE `directors`
  MODIFY `director_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `genre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `movieactors`
--
ALTER TABLE `movieactors`
  ADD CONSTRAINT `movieactors_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`),
  ADD CONSTRAINT `movieactors_ibfk_2` FOREIGN KEY (`actor_id`) REFERENCES `actors` (`actor_id`);

--
-- Constraints for table `movies`
--
ALTER TABLE `movies`
  ADD CONSTRAINT `movies_ibfk_1` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`genre_id`),
  ADD CONSTRAINT `movies_ibfk_2` FOREIGN KEY (`director_id`) REFERENCES `directors` (`director_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
