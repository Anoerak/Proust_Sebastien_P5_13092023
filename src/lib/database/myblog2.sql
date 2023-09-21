-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Sep 21, 2023 at 02:39 PM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myblog`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text CHARACTER SET utf8mb4 NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `validation_status` varchar(12) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `post_id`, `user_id`, `content`, `created_at`, `updated_at`, `validation_status`) VALUES
(29, 25, 20, 'A first comment by myself!!', '2023-09-18 16:26:34', '2023-09-21 11:32:33', 'published'),
(30, 25, 20, 'And a second comment to test it out..', '2023-09-21 11:33:20', NULL, 'pending'),
(38, 25, 20, 'Because never twice without a third time.', '2023-09-21 11:47:51', '2023-09-21 11:50:41', 'unpublished');

-- --------------------------------------------------------

--
-- Table structure for table `credentials`
--

CREATE TABLE `credentials` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `credentials`
--

INSERT INTO `credentials` (`id`, `user_id`, `username`, `password`) VALUES
(1, 1, 'admin', 'admin'),
(9, 15, 'barney', '$2y$10$sibFPqEgsY2iQiz0J8kDd.ci/5E.2THYUbS5z5BX5c8qDvmUb1tCy'),
(14, 20, 'Sébastien', '$2y$10$L2EN5KLvQMcmJZ4PpE/7E.MsmScX58m4Fzk0Used9PwF3qepJVLBO');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `newsletter`
--

INSERT INTO `newsletter` (`id`, `email`, `status`) VALUES
(1, 'test@test.com', 'active'),
(2, 'barney@stinson.com', 'inactive'),
(6, 'seb@iamseb.dev', 'inactive'),
(12, 'test@test.fr', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL DEFAULT 'https://picsum.photos/530/200?random=',
  `content` text NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `site_link` varchar(255) NOT NULL,
  `github_link` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `author_id`, `category`, `title`, `description`, `picture`, `content`, `keywords`, `site_link`, `github_link`, `created_at`, `updated_at`) VALUES
(13, 20, 'Fullstack', 'Portoflio PHP Vanilla', 'A vanilla php porfolio with a nice frontend.', './public/img/post_picture/65084df6c8c280.10464035.webp', 'Here is a portfolio/blog in vanilla PHP.\r\n\r\nThis goal was to provide a nice and user friendly experience inspired by Apple.\r\n\r\nSome nice API to provide the local forecast based on your IP, an interactive map loaded with a trip which has meaning to me and a direct lve visual of the analytics of this website.\r\n\r\nThis portfolio is also interactive since user can create an account and add comments on the different projects.', 'PHP, API, Plausible, Apple, MapBox, WeatherAPI, IPGeolocation', 'https://iamseb.dev/alternate', 'https://github.com/Anoerak/Proust_Sebastien_P5_13092023', '2023-01-26 18:22:47', '2023-09-18 15:17:42'),
(14, 20, 'Others', 'Plausible Analytics Container', 'I wrote  this guide assists you in deploying your own containerized Plausible Analytics system on a NAS.', './public/img/post_picture/65084b5b66b331.08074243.webp', 'Plausible Analytics is a simple, lightweight (< 1 KB), open-source, and privacy-friendly alternative to Google Analytics1. It’s designed to provide website owners with valuable insights about their traffic, bounce rate, and visit duration without collecting any personal or identifiable data from visitors1.\r\n\r\nOne of the key aspects that sets Plausible Analytics apart from many other web analytics providers is its commitment to privacy. It’s built as a privacy-first web analytics tool1. By using Plausible, you don’t need to compromise the user experience of your website. You don’t need to have any prompts to obtain consent for GDPR, CCPA or PECR. You don’t need to show any cookie banners either1.\r\n\r\nNow, why would you want to self-host Plausible Analytics? Here are some reasons:\r\n\r\nFull Control: Self-hosting Plausible gives you full control over your data. You can host your instance on any server in any country that you wish2.\r\nAccess to Raw Data: If you want access to the raw data, self-hosting gives you that option. You can take the data directly from the ClickHouse database2.\r\nCost-Effective: Self-hosting Plausible is free as in beer. You only need to pay for your server and whatever cost there is associated with running a server3.\r\nLightweight and Dockerized: Plausible Analytics is designed to be self-hosted through Docker4. It’s lightweight and easy to install while remaining flexible enough to adjust to your existing infrastructure5.\r\nIn conclusion, if you’re looking for a privacy-friendly, open-source alternative to Google Analytics that gives you full control over your data and is cost-effective, then self-hosting Plausible Analytics could be an excellent choice for you.', 'Plausible, Docker, Synology, NAS, Analytics, RGPD, Europe, Privacy', 'https://iamseb.dev/fdsqfhqsl', 'https://github.com/Anoerak/Tutorials/tree/main/Docker/Plausible', '2023-01-26 20:13:28', '2023-09-18 15:06:35'),
(15, 20, 'Backend', 'BileMo API', 'An API for mobile phone company to offer access to their catalogue.', './public/img/post_picture/65082b7de1a983.65009414.webp', 'As a developer at BileMo, a company specializing in high-end mobile phones, I was responsible for developing an API to provide access to our product catalog to other platforms in a B2B model. This was not for direct sales, but to allow our business partners to access our catalog and manage their users.\r\n\r\nI implemented several features in the API:\r\n\r\nProduct Consultation: I enabled clients to view the list of BileMo products and consult the details of each product.\r\nUser Management: I developed features that allowed clients to view the list of their registered users, consult the details of each user, add a new user, and delete a user.\r\nFor security, I ensured that only referenced clients could access the APIs. I implemented authentication via OAuth or JWT.\r\n\r\nTo meet the high standards of our first partner, I made sure to follow the rules of levels 1, 2 and 3 of the Richardson model when exposing data. All data was served in JSON format. To optimize performance, I implemented caching for responses.\r\n\r\nThis project allowed me to showcase my problem-solving skills and proficiency in developing professional-grade APIs. It was a challenging task that involved designing robust APIs, handling authentication, managing data effectively, and optimizing performance.', 'PHP, Symfony, Composer, Doctrine, Nelmio, Hateoas', 'https://iamseb.dev/bilemo', 'https://github.com/Anoerak/BileMo', '2023-01-26 20:27:12', '2023-09-18 14:47:49'),
(16, 20, 'Fullstack', 'Chalets & Caviar', 'A WordPress website for high end cabins in the French Alps. ', './public/img/post_picture/650830723fcfa4.06641184.webp', 'Objective: The main purpose of the “Chalets & Caviar” project is to promote a real estate agency that provides high-end chalets in the French Alps. The project is targeted towards individuals with high revenues who are interested in luxury real estate.\r\n\r\nKey Features & Technologies Used: The project was built using WordPress and a variety of extensions, add-ons, and page builders such as ASkimet, Broken Link Checker, Central Color Palette, CookieYes GDPR Cookie Consent, Duplicate Page, Elementor, Hustle, Ocean, Redirection, SEOPress, UpdraftPlus, Weglot, WP Mail SMTP, and WPForms.\r\n\r\nDesign: The design of the project is modern, intuitive, nature-oriented and fluid. It’s detailed, fully functional and well-designed. The intuitive and modern design gives it a luxurious feel.\r\n\r\nChallenges & Learning Experience: One of the main challenges faced during the development of this project was learning how to use WordPress from scratch. Despite this challenge, the project was successfully completed and the end result is a slick-looking site.\r\n\r\nFeedback & Achievements: The project has received positive feedback from both a mentor and an evaluator who were amazed by its quality, design and functionalities. This positive feedback is a testament to the hard work and dedication that went into this project.\r\n\r\nFuture Plans: The “Chalets & Caviar” project will be used in the portfolio to showcase skills and experience in WordPress development.\r\n\r\nOverall, the “Chalets & Caviar” project is a testament to the power of learning new technologies and applying them effectively to create a high-quality product.', 'WordPress, Elementor, SEOPress, WP Mail SMTP, WPForms, CookieYes GDPR', 'https://sebdevcloud.synology.me/wordpress/', 'https://github.com/Anoerak/Proust_Sebastien_P2_02082023', '2023-01-26 20:29:51', '2023-09-18 14:43:48'),
(25, 20, 'Fullstack', 'IamSeb Portfolio', 'My other portfolio website, available with React, Vue or Symfony.', './public/img/post_picture/650830434aafb8.54828052.webp', 'Welcome to the professional portfolio of Sebastien, a dedicated and innovative web developer. This portfolio showcases Sebastien’s expertise in various aspects of web development, including front-end and back-end technologies.\r\n\r\nSebastian’s portfolio is a testament to his ability to create dynamic, user-friendly, and aesthetically pleasing websites. It highlights his proficiency in HTML, CSS, JavaScript, and other modern web technologies such as React, Vue or Symfony.\r\n\r\nThe portfolio also demonstrates Sebastien’s ability to work on diverse projects, reflecting his adaptability and commitment to meeting client needs. Each project in the portfolio is a clear indicator of his ability to combine creativity with technical skills to produce outstanding results.\r\n\r\nIn addition to showcasing his technical skills, Sebastien’s portfolio also highlights his understanding of UI/UX design principles. This ensures that the websites he develops are not only functional but also intuitive and engaging for users.\r\n\r\nOverall, Sebastian’s portfolio serves as a comprehensive display of his capabilities as a web developer and his commitment to delivering high-quality work.', 'HTML, JS, PHP, React, Vue, Symfony', 'https://iamseb.dev', 'https://github.com/Anoerak/IAmSeb_Portfolio', '2023-01-26 21:46:43', '2023-09-21 11:19:53'),
(27, 20, 'Frontend', 'title', 'description', './public/img/post_picture/650c0bdcd2ae23.85189778.webp', 'description', 'keyword', 'link', 'github', '2023-09-21 09:24:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `privilege`
--

CREATE TABLE `privilege` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `privilege` varchar(5) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `privilege`
--

INSERT INTO `privilege` (`id`, `user_id`, `privilege`) VALUES
(1, 1, 'admin'),
(7, 15, 'admin'),
(12, 20, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `birthday` date DEFAULT NULL,
  `profile_picture` varchar(255) NOT NULL DEFAULT 'https://www.freeiconspng.com/uploads/no-image-icon-33.png',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `firstname`, `lastname`, `email`, `birthday`, `profile_picture`, `created_at`, `updated_at`) VALUES
(1, 'Boss', 'admin', 'admin', 'admin@admin.fr', '2023-01-17', 'https://www.freeiconspng.com/uploads/no-image-icon-33.png', '2023-01-17 15:44:45', ''),
(15, 'barney', 'David', 'Stinson', 'barney@stinson.com', '1977-07-04', './public/img/profile_picture/63d2c5efa223d2.68564200.jpg', '2023-01-23 19:14:23', NULL),
(20, 'Sébastien', 'Sébastien', 'P.', 'seb@iamseb.dev', '1985-01-28', './public/img/profile_picture/65086b51a26d95.86355937.webp', '2023-09-18 17:21:40', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `credentials`
--
ALTER TABLE `credentials`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auhtor_id` (`author_id`);

--
-- Indexes for table `privilege`
--
ALTER TABLE `privilege`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id_2` (`user_id`),
  ADD UNIQUE KEY `user_id` (`user_id`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `credentials`
--
ALTER TABLE `credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `privilege`
--
ALTER TABLE `privilege`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `credentials`
--
ALTER TABLE `credentials`
  ADD CONSTRAINT `credentials_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `privilege`
--
ALTER TABLE `privilege`
  ADD CONSTRAINT `privilege_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
