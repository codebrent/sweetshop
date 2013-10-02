SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `sweetshop` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `sweetshop`;

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `categoryId` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`categoryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `firstName` text NOT NULL,
  `lastName` text NOT NULL,
  `phone` text,
  `email` text NOT NULL,
  `address1` text NOT NULL,
  `address2` text,
  `suburb` text,
  `city` text NOT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `productId` int(11) NOT NULL AUTO_INCREMENT,
  `categoryId` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` longtext NOT NULL,
  `weight` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`productId`),
  FOREIGN KEY (`categoryId`) REFERENCES categories(`categoryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `orderId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `deliveryDate` date DEFAULT NULL,
  `status` enum('Pending','Ordered','Delivered','') NOT NULL,
  PRIMARY KEY (`orderId`),
  FOREIGN KEY (`userId`) REFERENCES users(`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `orderitems`;
CREATE TABLE IF NOT EXISTS `orderitems` (
  `orderId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`orderId`,`productId`),
  FOREIGN KEY (`orderId`) REFERENCES orders(`orderId`),
  FOREIGN KEY (`productId`) REFERENCES products(`productId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `categories` (`categoryId`, `name`) VALUES
(1, 'Lollies'),
(2, 'Cakes'),
(3, 'Muffins'),
(4, 'Biscuits');

INSERT INTO `users` (`userId`, `username`, `password`, `firstName`, `lastName`, `phone`, `email`, `address1`, `address2`, `suburb`, `city`) VALUES
(1, 'Andrew', 'd914e3ecf6cc481114a3f534a5faf90b', 'Andrew', 'Gilman', NULL, 'a.gilman@massey.ac.nz', 'Massey University', NULL, 'Albany', 'AUCKLAND');

INSERT INTO `products` (`productId`, `categoryId`, `name`, `description`, `weight`, `stock`, `price`) VALUES
(1, 1, 'Gumballs', 'A ball made of gum often dispensed from a gumball machine', 50, 100, '0.10'),
(2, 2, 'Sponge Cake', 'Sponge cake is a cake based on flour (usually wheat flour), sugar, and eggs, sometimes leavened with baking powder which has a firm, yet well aerated structure, similar to a sea sponge. A sponge cake may be produced by either the batter method, or the foam method.\r\nTypically the batter method in the U.S. is known as a butter or pound cake while in the U.K. it is known as Madeira cake or Victoria sponge cake. Using the foam method a cake may simply be known as a sponge cake or in the U.K. occasionally whisked sponge, these forms of cake are common in Europe especially in French patisserie.', 1000, 50, '15.20'),
(3, 1, 'M&amp;M''s', 'M&amp;M''s are "colorful button-shaped candies"[1] produced by Mars, Incorporated. The candy shells, each of which has the letter "m" printed in lower case on one side, surround a variety of fillings, including milk chocolate, dark chocolate, crisped rice, mint chocolate, peanuts, almonds, orange chocolate, coconut, pretzel, wild cherry, cinnamon, raspberry, and peanut butter. M&amp;M''s originated in the United States in 1941, and are now sold in as many as 100 countries.[1] They are produced in different colors, some of which have changed over the years', 50, 10, '2.00'),
(4, 1, 'Sugar Reds', 'Some kind of red lolly covered in sugar. Sweet and Red.', 2, 1000, '0.10'),
(5, 1, 'Nice Chocolates', 'Chocolate is a processed, typically sweetened food produced from the seed of the tropical Theobroma cacao tree. Cacao has been cultivated for at least three millennia in Mexico, Central America and Northern South America. Its earliest documented use is around 1100 BC. The majority of the Mesoamerican people made chocolate beverages, including the Aztecs. The seeds of the cacao tree have an intense bitter taste, and must be fermented to develop the flavor.', 250, 10, '8.75'),
(6, 1, 'Red n Yellows', 'Some red candy with yellow on the bottom', 10, 5000, '0.15'),
(7, 1, 'Lollies with wrappers', 'Avoid sticky hands and disappointed children. These lollies have wrappers.', 10, 600, '0.15'),
(8, 1, 'Liquorice allsorts', 'Liquorice allsorts (also spelled licorice allsorts) consist of a variety of liquorice sold as a mixture. These confections are made of liquorice, sugar, coconut, aniseed jelly, fruit flavourings, and gelatine. They were first produced in Sheffield, England, by Geo. Bassett &amp; Co Ltd who had taken over Wilkinsons (Pontefract cakes/mushrooms), Barratts (sherbet fountains/sweet cigarettes) and Trebor (mints) before being taken over themselves by the Cadbury''s consortium.', 100, 100, '2.50'),
(9, 1, 'Easter Eggs', 'Easter eggs are special eggs that are often given to celebrate Easter or springtime. As such, Easter eggs are common during the season of Eastertide. The oldest tradition is to use dyed and painted chicken eggs, but a modern custom is to substitute chocolate eggs, or plastic eggs filled with confectionery such as jelly beans.\r\nEggs, in general, were a traditional symbol of fertility, and rebirth.[1] In Christianity, they symbolize the empty tomb of Jesus:[2][3][4] though an egg appears to be like the stone of a tomb, a bird hatches from it with life; similarly, the Easter egg, for Christians, is a reminder that Jesus rose from the grave, and that those who believe will also experience eternal life.[2][3]', 50, 5, '6.00'),
(10, 4, 'Sprinkles Biscuits', 'Sprinkles are very small pieces of confectionery used as a decoration or to add texture to desserts�typically cupcakes, cookies, doughnuts, ice cream, frozen yogurt, and some puddings. The candies, which are produced in a variety of colors, are usually too small to be eaten individually.', 100, 10, '1.00'),
(11, 1, 'Pacman Candy Set', 'Play your favourite game with candy. hours of fun.', 100, 10, '5.20'),
(12, 1, 'Lifesavers', 'Life Savers is an American brand of ring-shaped mints and artificially fruit-flavored hard candy. The candy is known for its distinctive packaging, coming in aluminum foil rolls.\r\nIn 1912, candy manufacturer Clarence Crane of Garrettsville, Ohio,[1] invented Life Savers as a "summer candy" that could withstand heat better than chocolate. The candy''s name is derived from its similarity to the shape of lifebuoys used for saving people who have fallen from boats. The name has also inspired an urban legend that Crane invented the candy to prevent children from choking, due to his own child having choked on a hard candy.', 50, 12, '5.20'),
(13, 2, 'Hamburger Surprise Cake', 'It looks like a hamburger but it is a cake. Surprise!!', 50, 5, '105.00'),
(14, 2, 'Diet Cake', 'You can not put on weight if the cake is smaller than a five cent piece.', 5, 2, '100.00'),
(15, 2, 'Art Cake', 'A work of art.', 1000, 2, '150.00'),
(16, 2, 'Spiderman Cake', 'It has Spiderman on the cake.', 1500, 2, '150.00'),
(17, 2, 'Piggy Cake', 'Warning: Contain bacon', 60, 50, '4.25'),
(18, 2, 'Mushroom Cakes', 'These do not taste like mushroom. They taste like cake.', 654, 41, '17.45'),
(20, 3, 'Nice Cupcakes', 'These look nice but they taste terrible.', 600, 40, '1.25'),
(21, 4, 'Fancy Biscuits', 'I can''t remember what these are called. Just buy them.', 100, 80, '2.30'),
(22, 2, 'Birthday Cake', 'only suitable for an 80 year old called Olive. please don''t use for other birthdays.', 79, 5, '4.20'),
(23, 3, 'Bran Muffins', 'A muffin (American-style muffin in the UK) is a type of semi-sweet cake or quick bread that is baked in portions appropriate for one person. They are similar to cupcakes, although they are usually less sweet and lack icing. Savory varieties, such as cornbread muffins or cheese muffins also exist.', 100, 10, '0.50'),
(24, 3, 'Coffee Muffin', 'Contains more caffeine than 3 cups of coffee', 100, 6, '9.50'),
(25, 3, 'One and a half muffins', 'A little extra when one muffin isn''t enough', 70, 5, '6.30'),
(26, 3, 'Raspberry and Chocolate Muffins', 'Taste how they look', 100, 10, '2.50'),
(27, 4, 'Happy Gingerbread Men', 'Why are they all so happy?', 150, 50, '1.00'),
(28, 4, 'Anzac Biscuits', 'An old classic', 100, 45, '1.20'),
(29, 4, 'Star Biscuits', 'They have a star in the middle', 150, 10, '1.20'),
(30, 4, 'Crazy Bunnies', 'Maybe something to do with Easter?', 50, 50, '0.95');

INSERT INTO `orders` (`orderId`, `userId`, `deliveryDate`, `status`) VALUES
(1, 1, NULL, 'Pending'),
(2, 1, '2013-09-01', 'Delivered'),
(3, 1, '2013-09-04', 'Delivered'),
(4, 1, '2013-09-10', 'Delivered'),
(5, 1, '0000-00-00', 'Ordered'),
(6, 1, '0000-00-00', 'Ordered');

INSERT INTO `orderitems` (`orderId`, `productId`, `quantity`, `price`) VALUES
(2, 22, 3, '1.00'),
(2, 27, 5, '1.00'),
(3, 7, 1, '0.15'),
(3, 11, 1, '5.20'),
(3, 24, 1, '9.50'),
(4, 1, 1, '0.10'),
(4, 5, 1, '8.75'),
(4, 7, 2, '0.15'),
(4, 11, 5, '5.20'),
(4, 20, 10, '1.25'),
(5, 20, 10, '1.25'),
(5, 10, 1, '1.00'),
(5, 15, 2, '150.00'),
(6, 21, 5, '2.30'),
(6, 13, 5, '105.00');
