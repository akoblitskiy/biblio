-- MySQL dump 10.13  Distrib 5.7.28, for Linux (x86_64)
--
-- Host: localhost    Database: biblio
-- ------------------------------------------------------
-- Server version	5.7.28-0ubuntu0.18.04.4

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `author`
--

DROP TABLE IF EXISTS `author`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(127) NOT NULL,
  `bio` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `author`
--

LOCK TABLES `author` WRITE;
/*!40000 ALTER TABLE `author` DISABLE KEYS */;
INSERT INTO `author` VALUES (1,'Tolkien, J.R.R.','J.R.R. TOLKIEN (1892–1973) is the creator of Middle-earth and author of such classic and extraordinary works of fiction as The Hobbit, The Lord of the Rings, and The Silmarillion. His books have been translated into more than fifty languages and have sold many millions of copies worldwide.'),(2,'Gladwell, Malcolm','Malcolm Timothy Gladwell CM (born September 3, 1963) is a Canadian journalist, author, and public speaker. He has been a staff writer for The New Yorker since 1996. He has published six books: The Tipping Point: How Little Things Can Make a Big Difference (2000); Blink: The Power of Thinking Without Thinking (2005); Outliers: The Story of Success (2008); What the Dog Saw: And Other Adventures (2009), a collection of his journalism; and David and Goliath: Underdogs, Misfits, and the Art of Battling Giants (2013). His first five books were on The New York Times Best Seller list. His sixth book, Talking to Strangers: What We Should Know about the People We Don\'t Know, was released in September 2019. He is also the host of the podcast Revisionist History and co-founder of the podcast company Pushkin Industries.'),(3,'Mandela, Nelson','Nelson Rolihlahla Mandela was a South African anti-apartheid revolutionary, political leader, and philanthropist who served as President of South Africa from 1994 to 1999. He was the country\'s first black head of state and the first elected in a fully representative democratic election. His government focused on dismantling the legacy of apartheid by tackling institutionalised racism and fostering racial reconciliation. Ideologically an African nationalist and socialist, he served as President of the African National Congress (ANC) party from 1991 to 1997.'),(4,'Mark Twain','Samuel Langhorne Clemens known by his pen name Mark Twain, was an American writer, humorist, entrepreneur, publisher, and lecturer. He was lauded as the \"greatest humorist this country has produced\", and William Faulkner called him \"the father of American literature\". His novels include The Adventures of Tom Sawyer (1876) and its sequel, the Adventures of Huckleberry Finn (1884), the latter often called \"The Great American Novel\".');
/*!40000 ALTER TABLE `author` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(127) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `year` varchar(6) DEFAULT NULL,
  `pages_count` int(11) DEFAULT NULL,
  `publisher_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `publisher_id` (`publisher_id`),
  CONSTRAINT `book_ibfk_1` FOREIGN KEY (`publisher_id`) REFERENCES `publisher` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book`
--

LOCK TABLES `book` WRITE;
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` VALUES (1,'The Hobbit: or There and Back Again','J.R.R. Tolkien\'s classic prelude to his Lord of the Rings trilogy. Bilbo Baggins is a hobbit who enjoys a comfortable, unambitious life, rarely traveling any farther than his pantry or cellar. But his contentment is disturbed when the wizard Gandalf and a company of dwarves arrive on his doorstep one day to whisk him away on an adventure. They have launched a plot to raid the treasure hoard guarded by Smaug the Magnificent, a large and very dangerous dragon. Bilbo reluctantly joins their quest, unaware that on his journey to the Lonely Mountain he will encounter both a magic ring and a frightening creature known as Gollum.','1980',486,1),(2,'Talking to Strangers: What We Should Know about the People We Don\'t Know','How did Fidel Castro fool the CIA for a generation? Why did Neville Chamberlain think he could trust Adolf Hitler? Why are campus sexual assaults on the rise? Do television sitcoms teach us something about the way we relate to each other that isn\'t true?\nWhile tackling these questions, Malcolm Gladwell was not solely writing a book for the page. He was also producing for the ear. In the audiobook version of Talking to Strangers, you\'ll hear the voices of people he interviewed--scientists, criminologists, military psychologists. Court transcripts are brought to life with re-enactments. You actually hear the contentious arrest of Sandra Bland by the side of the road in Texas. As Gladwell revisits the deceptions of Bernie Madoff, the trial of Amanda Knox, and the suicide of Sylvia Plath, you hear directly from many of the players in these real-life tragedies. There\'s even a theme song - Janelle Monae\'s \"Hell You Talmbout.\"','2010',348,2),(3,'Unfinished Tales of Númenor and Middle-earth','Unfinished Tales of Númenor and Middle-earth concentrates on the lands of Middle-earth and comprises Gandalf\'s lively account of how he came to send the Dwarves to the celebrated party at Bag-End, the story of the emergence of the sea god Ulmo before the eyes of Tuor on the coast of Beleriand, and an exact description of the military organization of the Riders of Rohan and the journey of the Black Riders during the hunt for the Ring. It also contains the only surviving story about the long ages of Númenor before its downfall, and all that is known about the Five Wizards sent to Middle-earth as emissaries of the Valar, about the Seeing Stones known as palantíri, and about the legend of Amroth.','2005',362,1),(4,'The Illustrated Long Walk To Freedom: The Autobiography of Nelson Mandela','First American edition of the illustrated autobiography of one of the greatest moral leaders of the twentieth century. Quarto, original boards. Signed and dated by Nelson Mandela on the title page. Fine in a near fine dust jacket. \"The Nelson Mandela who emerges from his memoir is considerably more human than the icon of legend Mandela is, on the evidence of his amazing life, neither a messiah nor a moralist nor really a revolutionary but a pragmatist to the core, a shrewd balancer of honor and interests. He is, to use a word unhappily fallen into disrepute, a politician, though one distinguished from lesser practitioners of his calling mainly by his unwavering faith in his ultimate objective, ending white minority rule\" (New York Times). ','1995',174,3),(5,'Dog\'s Tale','Short story first published in Harper\'s Magazine, then as a pamphlet for the National Anti-Vivisection Society. Months later it was expanded into this book. Red cloth-covered boards with black and white dogs illustration and white title. Four tinted engravings by W.T. Smedley. States Published September, 1904. 1st edition thus. VG/No Jacket. Unmarked, sharp corners. Slight loss of lettering on cover. Handsome copy. ','1904',66,4),(6,'The Hobbit: or There and Back Again','J.R.R. Tolkien\'s classic prelude to his Lord of the Rings trilogy. Bilbo Baggins is a hobbit who enjoys a comfortable, unambitious life, rarely traveling any farther than his pantry or cellar. But his contentment is disturbed when the wizard Gandalf and a company of dwarves arrive on his doorstep one day to whisk him away on an adventure. They have launched a plot to raid the treasure hoard guarded by Smaug the Magnificent, a large and very dangerous dragon. Bilbo reluctantly joins their quest, unaware that on his journey to the Lonely Mountain he will encounter both a magic ring and a frightening creature known as Gollum.','1980',486,1),(7,'Talking to Strangers: What We Should Know about the People We Don\'t Know','How did Fidel Castro fool the CIA for a generation? Why did Neville Chamberlain think he could trust Adolf Hitler? Why are campus sexual assaults on the rise? Do television sitcoms teach us something about the way we relate to each other that isn\'t true?\nWhile tackling these questions, Malcolm Gladwell was not solely writing a book for the page. He was also producing for the ear. In the audiobook version of Talking to Strangers, you\'ll hear the voices of people he interviewed--scientists, criminologists, military psychologists. Court transcripts are brought to life with re-enactments. You actually hear the contentious arrest of Sandra Bland by the side of the road in Texas. As Gladwell revisits the deceptions of Bernie Madoff, the trial of Amanda Knox, and the suicide of Sylvia Plath, you hear directly from many of the players in these real-life tragedies. There\'s even a theme song - Janelle Monae\'s \"Hell You Talmbout.\"','2010',348,2),(8,'Unfinished Tales of Númenor and Middle-earth','Unfinished Tales of Númenor and Middle-earth concentrates on the lands of Middle-earth and comprises Gandalf\'s lively account of how he came to send the Dwarves to the celebrated party at Bag-End, the story of the emergence of the sea god Ulmo before the eyes of Tuor on the coast of Beleriand, and an exact description of the military organization of the Riders of Rohan and the journey of the Black Riders during the hunt for the Ring. It also contains the only surviving story about the long ages of Númenor before its downfall, and all that is known about the Five Wizards sent to Middle-earth as emissaries of the Valar, about the Seeing Stones known as palantíri, and about the legend of Amroth.','2005',362,1),(9,'The Illustrated Long Walk To Freedom: The Autobiography of Nelson Mandela','First American edition of the illustrated autobiography of one of the greatest moral leaders of the twentieth century. Quarto, original boards. Signed and dated by Nelson Mandela on the title page. Fine in a near fine dust jacket. \"The Nelson Mandela who emerges from his memoir is considerably more human than the icon of legend Mandela is, on the evidence of his amazing life, neither a messiah nor a moralist nor really a revolutionary but a pragmatist to the core, a shrewd balancer of honor and interests. He is, to use a word unhappily fallen into disrepute, a politician, though one distinguished from lesser practitioners of his calling mainly by his unwavering faith in his ultimate objective, ending white minority rule\" (New York Times). ','1995',174,3);
/*!40000 ALTER TABLE `book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book_to_author`
--

DROP TABLE IF EXISTS `book_to_author`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book_to_author` (
  `book_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  PRIMARY KEY (`book_id`,`author_id`),
  KEY `author_id` (`author_id`),
  CONSTRAINT `book_to_author_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`),
  CONSTRAINT `book_to_author_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book_to_author`
--

LOCK TABLES `book_to_author` WRITE;
/*!40000 ALTER TABLE `book_to_author` DISABLE KEYS */;
INSERT INTO `book_to_author` VALUES (1,1),(3,1),(2,2),(4,3),(5,4);
/*!40000 ALTER TABLE `book_to_author` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `publisher`
--

DROP TABLE IF EXISTS `publisher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `publisher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(127) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `publisher`
--

LOCK TABLES `publisher` WRITE;
/*!40000 ALTER TABLE `publisher` DISABLE KEYS */;
INSERT INTO `publisher` VALUES (1,'Mariner Books'),(2,'Little, Brown and Company'),(3,'Little Brown'),(4,'Harper & Brothers');
/*!40000 ALTER TABLE `publisher` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-12-17 23:22:57
