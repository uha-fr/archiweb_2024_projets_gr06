-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le : sam. 27 jan. 2024 à 15:17
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bd_nitru`
--

-- --------------------------------------------------------

--
-- Structure de la table `ingredients`
--

CREATE TABLE `ingredients` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `calorie_per_serving` float DEFAULT NULL,
  `serving_size` float DEFAULT NULL,
  `unity_of_measure` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `nutritionist_client`
--

CREATE TABLE `nutritionist_client` (
  `client_id` int(11) NOT NULL,
  `nutritionist_id` int(11) NOT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `plans`
--

CREATE TABLE `plans` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `period` int(11) DEFAULT NULL,
  `total_length` int(11) DEFAULT NULL,
  `median_caloric_value` float DEFAULT NULL,
  `creator` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `plan_recipes`
--

CREATE TABLE `plan_recipes` (
  `id` int(11) NOT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `recipe_id` int(11) DEFAULT NULL,
  `date` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `pwdreset`
--

CREATE TABLE `pwdreset` (
  `pwdResetId` int(11) NOT NULL,
  `pwdResetEmail` text NOT NULL,
  `pwdResetSelector` text NOT NULL,
  `pwdResetToken` longtext NOT NULL,
  `pwdResetExpires` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `pwdreset`
--

INSERT INTO `pwdreset` (`pwdResetId`, `pwdResetEmail`, `pwdResetSelector`, `pwdResetToken`, `pwdResetExpires`) VALUES
(5, 'ahfqfqfg@gmail.com', 'd32637585e2a89fb', '$2y$10$ancCpDAVRIHXZTBUGr87.eRVl7fwyEkdiQwHkmZoxz7I1rdIMTJQu', '1705419153');

-- --------------------------------------------------------

--
-- Structure de la table `recipes`
--

CREATE TABLE `recipes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `calories` float DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `visibility` tinyint(1) DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `creator` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)  -- Define `id` as the primary key
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `recipes`
--

INSERT INTO `recipes` (`id`, `name`, `calories`, `type`, `image_url`, `visibility`, `creation_date`, `creator`) VALUES
(1, 'Green Smoothie Bowl', 350, 'breakfast', 'https://hungryhealthyhappy.com/wp-content/uploads/2014/08/Smoothie-Bowl-1.jpg', 1, '2024-01-27 00:00:00', 41),
(2, 'Quinoa Salad', 450, 'lunch', 'https://cdn.loveandlemons.com/wp-content/uploads/2020/08/quinoa-salad-recipes-580x763.jpg', 1, '2024-01-27 00:00:00', 41),
(3, 'Grilled Salmon with Asparagus', 500, 'dinner', 'https://www.eatwell101.com/wp-content/uploads/2019/03/baked-salmon-in-foil-recipe.jpg', 1, '2024-01-27 00:00:00', 41),
(4, 'Avocado Toast', 250, 'breakfast', 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.eatingwell.com%2Frecipe%2F8029771%2Favocado-toast-recipe%2F&psig=AOvVaw0QeKNNnShWZCMOkr1p3k7g&ust=1710691468004000&source=images&cd=vfe&opi=89978449&ved=0CBMQjRxqFwoTCODK-buU-YQDFQAAAAAdAAAAABAE', 1, '2024-01-27 00:00:00', 41),
(5, 'Tomato Basil Soup', 175, 'lunch', 'https://cdn.apartmenttherapy.info/image/upload/f_jpg,q_auto:eco,c_fill,g_auto,w_1500,ar_1:1/k%2FPhoto%2FRecipes%2F2019-08-Recipe-Best-Tomato-Basil-Soup%2FTomato_Basil_Soup_067', 1, '2024-01-27 00:00:00', 41),
(6, 'Chicken Caesar Salad', 400, 'lunch', 'https://s23209.pcdn.co/wp-content/uploads/2023/01/220905_DD_Chx-Caesar-Salad_051.jpg', 1, '2024-01-27 00:00:00', 41),
(7, 'Beef Stir Fry', 550, 'dinner', 'https://khinskitchen.com/wp-content/uploads/2023/03/beef-stir-fry-01.jpg', 1, '2024-01-27 00:00:00', 41),
(8, 'Vegetable Curry', 300, 'dinner', 'https://images.immediate.co.uk/production/volatile/sites/30/2022/06/Courgette-curry-c295fa0.jpg?resize=768,574', 1, '2024-01-27 00:00:00', 41),
(9, 'Berry Yogurt Parfait', 220, 'snack', 'https://foolproofliving.com/wp-content/uploads/2017/12/Greek-Yogurt-Parfait-Recipe.jpg', 1, '2024-01-27 00:00:00', 41),
(10, 'Peanut Butter Banana Smoothie', 350, 'snack', 'https://www.delscookingtwist.com/wp-content/uploads/2023/09/Peanut-Butter-Banana-Smoothie_1-730x1095.jpg', 1, '2024-01-27 00:00:00', 41);
-- --------------------------------------------------------

--
-- Structure de la table `recipe_ingredient`
--

CREATE TABLE `recipe_ingredient` (
  `id` int(11) NOT NULL,
  `recipe_id` int(11) DEFAULT NULL,
  `ingredient_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `active` int(11) NOT NULL,
  `creation_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `age` int(11) DEFAULT NULL,
  `role` varchar(250) NOT NULL DEFAULT 'Regular',
  `height` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `daily_caloriegoal` int(11) DEFAULT NULL,
  `gender` varchar(250) DEFAULT NULL,
  `goal` varchar(250) DEFAULT NULL,
  `img` varchar(250) DEFAULT '/public/images/default-user.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);
--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `fullname`, `password`, `email`, `active`, `creation_date`, `age`, `role`, `height`, `weight`, `daily_caloriegoal`, `gender`, `goal`, `img`) VALUES
(41, 'Ahmed Boulaabi', '$2y$10$7jAEIB7zXKP5M0uhP4ntuuVth5kOHFkjredT.Kfaq67a7AY6HvosO', 'ahmed@gmail.com', 1, '2024-01-27 00:00:00', 23, 'Regular', 178, 73, 227449, 'male', 'lose-weight-normal', '/public/images/default-user.png'),
(42, 'Admin', '$2y$10$Q5cdRJXVEp05oKUfefW6ZOh.meRN.UYM6/QR62NUw0Q0VoZRmQ1wa', 'admin@gmail.com', 1, '2024-01-27 00:00:00', 25, 'Admin', 185, 85, 355815, 'male', 'gain-weight-normal', '/public/images/default-user.png'),
(43, 'l', '$2y$10$EzcOr/J1puxzNQMwnNxbGe0Lhvz9NiGBbvnzZfEhGCFK0IrZOMqK.', 'l@gmail.com', 1, '2024-03-07 10:52:18', 45, 'Regular', 123, 34, 86194, 'male', 'lose-weight-normal', '/public/images/default-user.png'),
(44, 'nutri', '$2y$10$a8BLHeRtDwQuy48A.05dEe5iQPe/QpNxPrtxV3gDFBc16y3gmUp1W', 'nutri@gmail.com', 1, '2024-03-07 10:53:07', 34, 'Nutritionist', 34, 34, 29671, 'male', 'lose-weight-normal', '/public/images/default-user.png'),
(45, 'm', '$2y$10$JHFyqb7kyXUXL.Cwc4Lp8ODzyNrH9IdEHmrnj6VcQE1TxKiFdiZ9K', 'm@gmail.com', 1, '2024-03-15 20:36:21', 1, 'Regular', 0, 0, -31146, 'female', 'lose-weight-fast', '/public/images/default-user.png'),
(46, 'changed', '$2y$10$N6L9VyRICso.k4aKm6Eyt..6f7mA/NflUPwRf0AqKuaMQxdaq4VLC', 'v@gmail.com', 1, '2024-03-16 13:15:27', 33, 'Regular', 33, 33, 195873, 'male', 'gain-weight-normal', '');
-- --------------------------------------------------------

--
-- Structure de la table `user_plan`
--

CREATE TABLE `user_plan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `managed_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `notifications` (
    `notif_id` int(11),
    `sender_id` int(11),
    `receiver_id` int(11),
    `type` int(11),
    `creation_date` DATETIME
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Index pour les tables déchargées
--

ALTER TABLE `notifications` 
  ADD PRIMARY KEY (`notif_id`);

--
-- Index pour la table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `nutritionist_client`
--
ALTER TABLE `nutritionist_client`
  ADD PRIMARY KEY (`client_id`,`nutritionist_id`);

--
-- Index pour la table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creator` (`creator`);

--
-- Index pour la table `plan_recipes`
--
ALTER TABLE `plan_recipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plan_id` (`plan_id`),
  ADD KEY `recipe_id` (`recipe_id`),
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


--
-- Index pour la table `pwdreset`
--
ALTER TABLE `pwdreset`
  ADD PRIMARY KEY (`pwdResetId`);

--
-- Index pour la table `recipes`
--
ALTER TABLE `recipes`
  ADD KEY `creator` (`creator`);

--
-- Index pour la table `recipe_ingredient`
--
ALTER TABLE `recipe_ingredient`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipe_id` (`recipe_id`),
  ADD KEY `ingredient_id` (`ingredient_id`);



--
-- Index pour la table `user_plan`
--
ALTER TABLE `user_plan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `plan_id` (`plan_id`),
  ADD KEY `managed_by` (`managed_by`),
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


--
-- AUTO_INCREMENT pour les tables déchargées
--
ALTER TABLE `notifications`
  MODIFY `notif_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `pwdreset`
--
ALTER TABLE `pwdreset`
  MODIFY `pwdResetId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table notifications
--

ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `notifications_ibfk2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `nutritionist_client`
--
ALTER TABLE `nutritionist_client`
  ADD CONSTRAINT `nutritionist_client_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `plans`
--
ALTER TABLE `plans`
  ADD CONSTRAINT `plans_ibfk_1` FOREIGN KEY (`creator`) REFERENCES `users` (`id`),
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour la table `plan_recipes`
--
ALTER TABLE `plan_recipes`
  ADD CONSTRAINT `plan_recipes_ibfk_1` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`),
  ADD CONSTRAINT `plan_recipes_ibfk_2` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`);

--
-- Contraintes pour la table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_ibfk_1` FOREIGN KEY (`creator`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `recipe_ingredient`
--
ALTER TABLE `recipe_ingredient`
  ADD CONSTRAINT `recipe_ingredient_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`),
  ADD CONSTRAINT `recipe_ingredient_ibfk_2` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`);

--
-- Contraintes pour la table `user_plan`
--
ALTER TABLE `user_plan`
  ADD CONSTRAINT `user_plan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_plan_ibfk_2` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`),
  ADD CONSTRAINT `user_plan_ibfk_3` FOREIGN KEY (`managed_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;