-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2022 at 02:58 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `publisher_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` double NOT NULL,
  `img_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `category_id`, `publisher_id`, `title`, `author`, `cost`, `img_url`) VALUES
(1, 1, 1, 'The Loving and the Dead', 'Enid Blyton', 16, '849823b9b1a9f3ff08f48d4e89247f4b8ff3aeda.jpg'),
(2, 1, 1, 'No Longer Human', 'Gilbert Patten', 35, '2.jpg'),
(3, 1, 2, 'Love, Death + Robots', 'William Shakespeare', 14, '3.jpg'),
(4, 1, 2, 'The Knock-Knock Man', 'Agatha Christie', 14, '4.jpg'),
(5, 1, 1, 'The Writing in the Stone', 'Gilbert Patten', 28, '5.jpg'),
(6, 2, 3, 'Dune', 'Barbara Cartland', 14, '6.jpg'),
(7, 2, 4, 'Inmemorian', 'Danielle Steel', 13, '7.jpg'),
(8, 2, 3, 'Shards of Earth', 'Barbara Cartland', 14, '8.jpg'),
(9, 2, 4, 'Leviathan Wakes', 'Danielle Steel', 12, '9.jpg'),
(10, 2, 4, 'Three-Body Problem', 'Danielle Steel', 13, '10.jpg'),
(11, 3, 5, 'Baseless Hatred', 'Harold Robbins', 35, '11.jpg'),
(12, 3, 6, 'CEO School', 'Georges Simenon', 49, '12.jpg'),
(13, 3, 5, 'Strategic Learning', 'Harold Robbins', 35, '13.jpg'),
(14, 3, 7, 'A Course in Rasch Measurement Theory', 'Enid Blyton', 98, '14.jpg'),
(15, 3, 7, 'Mind Over Matter and Artificial Intelligence', 'Enid Blyton', 105, '15.jpg'),
(16, 4, 8, 'Hendrix', 'Sidney Sheldon', 32, '16.jpg'),
(17, 4, 8, 'Frankenstein', 'Sidney Sheldon', 19, '17.jpg'),
(18, 4, 8, 'It Won\'t Always Be Like This', 'Sidney Sheldon', 22, '18.jpg'),
(19, 4, 9, 'Vagina Love', 'Eiichiro Oda', 20, '19.jpg'),
(20, 4, 9, 'Lady Murasakis Tale Of Genji', 'Eiichiro Oda', 17, '20.jpg'),
(21, 5, 10, 'Nation, State and Empire', 'Jackie Collins', 28, '21.jpg'),
(22, 5, 10, 'Out of the Woods', 'Jackie Collins', 29, '22.jpg'),
(23, 5, 11, 'Zusammen', 'Horatio Alger', 61, '23.jpg'),
(24, 5, 11, 'Breaking Into Song', 'Horatio Alger', 18, '24.jpg'),
(25, 5, 2, 'Appalachian Reckoning', 'Nora Roberts', 42, '25.jpg'),
(26, 6, 12, 'Life\'s a Beach', 'Alexander Pushkin', 49, '26.jpg'),
(27, 6, 12, 'The California Style', 'Alexander Pushkin', 49, '27.jpg'),
(28, 6, 13, 'Country and Cozy', 'Paulo Coelho', 63, '28.jpg'),
(29, 6, 13, 'How To Get Away', 'Paulo Coelho', 63, '29.jpg'),
(30, 6, 13, 'Walls', 'Paulo Coelho', 70, '30.jpg'),
(31, 7, 14, 'Misadventures of a Little Soprano', 'Jeffrey Archer', 15, '31.jpg'),
(32, 7, 6, 'The Lies They Tell', 'René Goscinny', 27, '32.jpg'),
(34, 7, 14, 'Cats in Hats', 'Edgar Wallace', 12, '34.jpg'),
(35, 7, 5, 'No Drama Llama', 'Janet Dailey', 12, '35.jpg'),
(36, 7, 14, 'On Adventure With Dad', 'Edgar Wallace', 25, '36.jpg'),
(37, 8, 15, 'Let the Cash Flow', 'Jin Yong', 21, '37.jpg'),
(38, 8, 15, 'Build & Work', 'Jin Yong', 50, '38.jpg'),
(39, 8, 16, 'The Future of Real Estate', 'James Patterson', 20, '39.jpg'),
(40, 8, 1, 'Driving Digital Transformation', 'Roald Dahl', 28, '40.jpg'),
(41, 8, 17, 'Adman Vs. Chomsky', 'John Grisham', 21, '41.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`) VALUES
(1, 'Supernatural', 'Supernatural fiction or supernaturalist fiction is a genre of speculative fiction that exploits or is centered on supernatural themes, often contradicting naturalist assumptions of the real world.'),
(2, 'Science Fiction', 'Science fiction is a genre of speculative fiction which typically deals with imaginative and futuristic concepts such as advanced science and technology, space exploration, time travel, parallel universes, extraterrestrial life, sentient artificial intell'),
(3, 'Psychology', 'Books in the psychological fiction genre are made up of stories that place a large amount of emphasis on interior characterization, motives, circumstances, and action which come from external action. In the psychological genre the author doesn’t state wh'),
(4, 'Novel', 'The novel is a genre of Fiction, an invented prose narrative of considerable length and a certain complexity that deals imaginatively with human experience, usually through a connected sequence of events involving a group of persons in a specific setting.'),
(5, 'Literary Theory', 'A literary genre is a category of literature. Genres may be determined by literary technique, tone, content, or length. They generally move from more abstract, encompassing classes, which are then further sub-divided into more concrete distinctions. The d'),
(6, 'Interior', 'Interior book design is the art of creating visually appealing layouts of text and images for the inside of a book. Much of this design work falls under typesetting, the process of arranging and formatting text.'),
(7, 'Humor', 'Books in the humor nonfiction genre are about jokes, people, or events that are humorous. The books in this genre are designed to amuse the reader and make them laugh. They can be joke books or be about a comedian whose life is written in a humorous manne'),
(8, 'Economic and Business', 'Books in the economics nonfiction genre deal with the issues related to the production, consumption, and transfer of wealth in a country or the world. The books in this genre offer insight and opinion on the issues and struggles that plague and unbalance');

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20221024145751', '2022-10-24 16:58:01', 508),
('DoctrineMigrations\\Version20221024161556', '2022-10-24 18:16:06', 126),
('DoctrineMigrations\\Version20221024163224', '2022-10-24 18:32:37', 139),
('DoctrineMigrations\\Version20221024165457', '2022-10-24 18:55:02', 118),
('DoctrineMigrations\\Version20221025070702', '2022-10-25 09:07:10', 472),
('DoctrineMigrations\\Version20221030134434', '2022-10-30 14:44:44', 661);

-- --------------------------------------------------------

--
-- Table structure for table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `payment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `order_id_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `publisher`
--

CREATE TABLE `publisher` (
  `id` int(11) NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `publisher`
--

INSERT INTO `publisher` (`id`, `address`, `phone`, `name`) VALUES
(1, '193 Nguyen Luong Bang', '129472845', 'Harper Collins Publishers LLC'),
(2, '174 Le Duan', '192374908', 'The MIT Press Publishers LLC'),
(3, '184 Nguyen Thien Thuat', '132457192', 'Holtzbrinck Publishers LLC'),
(4, '02 Le Duan', '190227455', 'Cengage Learning Publishers LLC'),
(5, '35 Dong Da', '183925728', 'Bertelsmann Publishers LLC'),
(6, '43 Hai Phong', '172842136', 'Thomson Reuters Publishers LLC'),
(7, '22 My Khe', '108325768', 'Oxford University Press LLC'),
(8, '69 Truong Chinh', '169832566', 'Houghton Mifflin Harcourt Publishers LLC'),
(9, '72 Le Dinh Ly', '164823954', 'Informa Publishers LLC'),
(10, '17 Ong Ich Khiem', '129426485', 'Random House Publishers LLC'),
(11, '123 Pham Van Dong', '192038574', 'UC Press Publishers LLC'),
(12, '07 Nguyen Tri Phuong', '157392788', 'Wolters Kluwer Publishers LLC'),
(13, '72 Tran Phu', '163982341', 'Hachette Livre Publishers LLC'),
(14, '38 Ly Thuong Kiet', '172941286', 'Reed Elsevier Publishers LLC'),
(15, '18 Le Trong Tan', '148923412', 'Springer Nature Publishers LLC'),
(16, '29 Ton Dan', '156999843', 'Wiley Publishers LLC'),
(17, '92 Vo Van Kiet', '154698226', 'Phoenix Publishing House LLC');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `fullname`, `phone`) VALUES
(1, 'nguyentuankiet@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$nmkBC5mHOjBok/nrs2mUKuW.Rs3lYSpdcd0J/KX2FEj5lAuE03FJK', 'Nguyen Tuan Kiet', '113'),
(3, 'tester@gmail.com', '[\"ROLE_USER\"]', '$2y$13$l/jCSielP/crRd6jBGE74.h1kx.ezBPnF9K.FLqO7uyZ4nyK35LKS', 'Tester-User', '114'),
(5, '12a@gmail.com', '[\"ROLE_USER\"]', '$2y$13$/Gm46FQhxXuSYont97ucY.jmTDs2J.ryHHVBXAmYJOIt2b7GQlGtS', 'Mình tên Nguyễn Tuấn Kiệt', '+84914852966');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_CBE5A33112469DE2` (`category_id`),
  ADD KEY `IDX_CBE5A33140C86FCE` (`publisher_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F5299398A76ED395` (`user_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_ED896F46FCDAEAAA` (`order_id_id`),
  ADD KEY `IDX_ED896F4616A2B381` (`book_id`);

--
-- Indexes for table `publisher`
--
ALTER TABLE `publisher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `publisher`
--
ALTER TABLE `publisher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `FK_CBE5A33112469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_CBE5A33140C86FCE` FOREIGN KEY (`publisher_id`) REFERENCES `publisher` (`id`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_F5299398A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `FK_ED896F4616A2B381` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`),
  ADD CONSTRAINT `FK_ED896F46FCDAEAAA` FOREIGN KEY (`order_id_id`) REFERENCES `order` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
