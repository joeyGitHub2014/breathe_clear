-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jun 21, 2017 at 01:54 PM
-- Server version: 5.6.35-cll-lve
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `breathclear`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin1`
--

CREATE TABLE IF NOT EXISTS `admin1` (
  `id0` mediumint(8) NOT NULL AUTO_INCREMENT,
  `u1` varchar(100) NOT NULL,
  `p2` varchar(100) NOT NULL,
  PRIMARY KEY (`id0`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `admin1`
--

INSERT INTO `admin1` (`id0`, `u1`, `p2`) VALUES
(1, '4a18f73e3e39553699f08b17ba545e20', 'fb089644dbfcd6bb6ef333fdcbaf8b17'),
(2, '0c821f675f132d790b3f25e79da739a7', '0c821f675f132d790b3f25e79da739a7'),
(6, '263594292fdc0ce9460e10e5eedcc518', '0c821f675f132d790b3f25e79da739a7'),
(7, '8ff32489f92f33416694be8fdc2d4c22', '8ff32489f92f33416694be8fdc2d4c22'),
(8, '1fd406685cbdee605d0a7bebed56fdb0', '1fd406685cbdee605d0a7bebed56fdb0'),
(9, 'd41d8cd98f00b204e9800998ecf8427e', 'd41d8cd98f00b204e9800998ecf8427e'),
(10, '8ff32489f92f33416694be8fdc2d4c22', '8ff32489f92f33416694be8fdc2d4c22'),
(12, 'bf403351dfb2ae819874163aff25a49c', 'fef7185dd6e69d561bc286f3fe6e391f'),
(13, '89c246298be2b6113fb10ba80f3c6956', '89c246298be2b6113fb10ba80f3c6956');

-- --------------------------------------------------------

--
-- Table structure for table `allergens1`
--

CREATE TABLE IF NOT EXISTS `allergens1` (
  `allergenID` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `batteryName` varchar(50) DEFAULT '0',
  `antigenName` varchar(255) DEFAULT '0',
  `groupID` mediumint(8) unsigned NOT NULL,
  `site` smallint(3) unsigned DEFAULT '0',
  `lotNumber` varchar(10) DEFAULT NULL,
  `expDate` varchar(10) DEFAULT NULL,
  `fileName` varchar(200) DEFAULT NULL,
  `caption` text,
  `disabled` int(11) NOT NULL DEFAULT '0',
  `customID` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`allergenID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

--
-- Dumping data for table `allergens1`
--

INSERT INTO `allergens1` (`allergenID`, `batteryName`, `antigenName`, `groupID`, `site`, `lotNumber`, `expDate`, `fileName`, `caption`, `disabled`, `customID`) VALUES
(12, 'A', 'California Black Walnut', 2, 5, 'W07022608', '2-16', 'feather.jpg', 'A member of the Walnut family, this tree is endemic to California.  Pecans are also a member of the Walnut family but Pecans are not generally found in California.  Walnut trees bloom in April and May.  They produce large pollen so the particles do not travel far, but California Black Walnut can still cause a lot of allergies especially if cultivated commercially. Photo: Michael Charters.      ', 1, 0),
(11, 'A', 'Rough Pigweed', 4, 4, 'P43022509', '2-14', 'Rough_Pigweed.jpg', 'Also known as Redroot Pigweed, it is found nationwide and in many parts of the world.  Despite its unappetizing name, Rough Pigweed is actually edible!  When young, the small leaves can be used as salad greens, but don''t try this at home - they''re also high in nitrates! Photo: Richard Old, www.xidservices.com.\r\n', 1, 0),
(10, 'A', 'Atriplex mixtures', 4, 3, 'A41020811', '2-15', 'red mullberry tree1.bmp', 'A mixture of shrubs, specifically wingscale, lenscale, allscale and annual saltbush.  Each of these four species is a member of the Atriplex genus. These shrubs live well in salty, barren environments including deserts like those in Southern California.  They are common in the western U.S. and can be heavy pollinators in late summer.  There are up to two hundred species of these kinds of shrubs.	\r\nPhoto: Richard Old, www.xidservices.com', 1, 0),
(8, 'A', 'European Dust Mite', 5, 1, 'D28083011', '8-14', 'European_dust_mite.jpg', 'They are called European but are found in bedrooms throughout the United States as well! These microscopic arthropods eat animal and human dander, fungi and other small proteins.  Dust mites live mainly where their food is:  pillows, blankets, mattresses, rugs and upholstery.  It is the feces that can be inhaled and trigger allergies.  To make matters worse, vacuuming sends dust mite particles airborne! Dust mites do not like cool, dry environments.  They thrive in temperatures 25-30 degrees centigrade and are rare in dry climates and high altitudes. Photo: Copyright Dennis Kunkel   Microscopy, Inc. \r\n', 1, 0),
(13, 'A', 'Western Ragweed', 4, 6, 'R18011811', '10-14', 'western_ragweed.jpg', 'The most important weed in North America, it is common in orchards and vineyards.  Western Ragweed is often seen on California roadsides and in dry fields.  It flowers from July to November.  Some ragweeds can cross react with watermelon and cantaloupe so if you are allergic to one, you can be allergic to all!	\r\n', 1, 0),
(14, 'A', 'Alternaria', 1, 7, 'A01012612', '4-15', 'Alternaria_alternata.jpg', 'An extremely allergenic mold that is most active in dry, hot weather.  It is particularly troublesome outdoors in the afternoon and when there are warm Santa Ana winds. Alternaria is also commonly found in plants. It is common across the globe and is abundant in the United States. Alternaria may be highly associated with asthma. It is a member of the Dematiaceae group of molds, the most highly allergenic group in the Deuteromycete class. Photo: Copyright Dennis Kunkel Microscopy, Inc.', 1, 0),
(41, 'A', 'Positive Skin Test', 1, 2, 'IJ00172', '9-201', 'nopicture2.jpg', 'nothing ', 1, 0),
(16, 'B', 'California Sycamore', 2, 1, 'S32020811', '10-14', 'ca_sycamore.jpg', '	This tree requires only a moderate amount of water so it thrives in sunny California.   The California Sycamore has a short blooming season in April and can grow up to 75 feet tall.  It is a member of the Platanaceae or ', 1, 0),
(17, 'A', 'Russian Thistle', 4, 2, 'R02031511 ', '7-15', 'russian_thistle.jpg', 'Commonly known as Tumbleweed.  Under the right conditions this plant can grow to more than six feet!  Needs very little water so it thrives in the desert.  It was originally brought unintentionally by Russian  immigrants to the U.S. in 1873 as a flax-seed contaminant.  Tumbleweed made its debut in California in 1895 via contaminated rail cars.  Even a small scratch from this pesty plant can cause a sizable reaction in the allergic patient.  Pollen is produced in summer but it is in early winter and late fall when the plant breaks free from the soil and blows across the landscape.  Each plant can produce up to 20,000 seeds!  Russian Thistle is considered a pest because it can displace cash crops.  It also can help spread prarie wildfires if it ignites and is blown from place to place.  Russian thistle also goes by the name of Salsola tragus, Salsola iberica  and Salsola australis	 \r\n', 1, 0),
(18, 'B', 'Eucalyptus', 2, 3, 'E09030508', '3-14', 'Eucalyptus_globulus.jpg', '	Native to Australia, this fast growing tree can grow to over 100 feet tall!  The pollen is allergenic but does not tend to infest the air the way some other pollens can; nevertheless, it can cause hay fever, conjunctivitis and asthma.  A particularly common species of Eucalyptus in California is the Tasmanian bluegum.  The Eucalyptus genus is part of the Myrtle family of trees.	Photo: Jackie Allison. \r\n', 1, 0),
(19, 'B', 'Coastal Sage', 4, 4, 'S34040208', ' 4-14', 'costal_sage_artemisia.jpg', '	Despite its name, Coastal Sage not a true sage.  It is a native California shrub that can grow to several feet high and is an important component of chaparral.  Coastal sage is a fast-growing and drought-tolerant plant that has been used as a medicine by some native american tribes.   Also known as coastal sagebrush, it is useful for erosion control.  Fire actually helps Coastal Sage germinate.   It''s pollen can be a troublesome allergen.	\r\n', 1, 0),
(20, 'B', 'Feather Mixture', 4, 5, 'F11041211 ', '7-14', 'feather.jpg', 'It is often the dust mites in the feathers that provoke allergies but the feathers themselves are allergenic as well.  We test for chicken, duck and goose feathers.	\r\n', 1, 0),
(21, 'B', 'Standard Bermuda Grass', 3, 6, 'G35110310', '11-13', 'sky.png', 'One of the most allergenic grasses, it probably originated in India but is now found throughout much of the world.  Bermuda grass is a perennial (year-round) grass that is found on lawns, golf courses and playing fields of all types.   It also can behave as a weed in gardens.  It has small flowers and can grow quickly.  Bermuda grass can be an important contributor to pediatric asthma in semi-arid environments but also grows well in areas that are warm and moist.   It also is known as Dog''s Tooth Grass,  Bahama Grass and Devil grass.   Photo: Richard Old, www.xidservices.com	\r\n', 1, 0),
(22, 'B', 'Seven Standard Grasses', 3, 7, 'G35110310', '11-13', 'Seven_Standard_Grasses.jpg', 'This is a mixture of Kentucky bluegrass, meadow fescue grass, orchard grass, perennial rye grass, redtop grass, sweet vernal grass and timothy grass.  Interestingly, Timothy grass can cross react with apples and carrots so if you are  allergic to one, you can be allergic to all!  Timothy grass is a perennial grass found in every state in the U.S.  It can be weedy and invasive. Photo: Richard Old, www.xidservices.com.  	\r\n', 0, 0),
(23, 'B', 'Cockroach', 5, 8, 'C69022112', '4-15', 'Cockroach.jpg', 'These handsome creatures can cause asthma.   Not surprisingly, cockroaches are common in urban areas and in older living spaces.  The most common antigens are called  Blag I and Blag II and are found in cockroach feces and in its exoskeleton. Photo: Copyright Dennis Kunkel Microscopy, Inc.	\r\n', 0, 0),
(24, 'C', 'Hormodendrum', 1, 1, 'H02082411', '10-14', 'Hormodendrum.jpg', 'A mold commonly found in leather, rubber, cloth, foods and wood products.   While molds are often thought of as indoor allergens, they can be denser in outdoor air than pollens!  Hormodendrum spore concentration increases during dry, windy weather and is particularly troublesome in the afternoon and when there are warm\r\n', 0, 0),
(25, 'C', 'Aspergillus Fumigatus', 1, 2, 'A35030811 ', '9-14', 'Aspergillus_fumigatus.jpg', 'An "indoor" mold commonly found in grain, damp cloth, leather goods, spoiled foods, damp paper, and decaying plants.  It is present in the air year-round but increases during the summer.  Aspergillus has a worldwide distribution. Photo: Copyright Dennis Kunkel Microscopy, Inc.\r\n', 0, 0),
(26, 'C', 'Red Maple (Acer Rubrum) ', 2, 3, 'A35030811', '10-14', 'acer.jpg', 'It''s no surprise that this member of the Maple family has the biggest leaves of all 125 maple species!  It is a moderately allergenic tree found throughout the pacific coast of the United States and Canada.  The tree normally grows to 75 feet but can reach 100 feet!  Its flowers bloom in April and May.  Only 13 maple species are native to the United States.  There is a variety of allergenicity within the maple family. 	Photo: JE (Jed) and Bonnie McClellan, California Academy of Sciences.\r\n', 0, 0),
(27, 'C', 'Dog', 1, 4, 'D05121411 ', '4-15', 'dog.jpg', 'The allergen is found mainly on the dog''s skin but can also be found in the saliva.  Some breeds make more of the main allergen, called Can f 1, than others.  The allergen can trigger asthma because the protein is small. Photo: Danielle Frank\r\n', 0, 0),
(28, 'C', 'Cat', 5, 5, 'C39011712', '1-15', 'cat.jpg', 'The main allergen is found primarily in the cat''s saliva but also can be found in the brain and sebaceous glands in the skin.  Male cats make more allergen and some cat species make more allergen than others.  Unfortunately, cat allergen (a protein called Fel d I) can stay stuck to some surfaces for a long time â€“ up to 6 months!  Also unfortunate for those allergic to cats is that 70% of house dust contains cat allergen!  Since cat allergen can stay suspended in the air for a long time, it is often found in areas where the cat is long gone.  It can even be transported by cat owners from place to place.	\r\n', 0, 0),
(29, 'C', 'White Oak', 2, 6, '020031312', '4-15', 'nopicture.jpg', 'This tree sheds lots of pollen!  It is closely related to the similarly named California Live Oak and is found throughout Southern California.    There are more than 60 native species of oak in the United States.  It is important to be tested for the oak species in your area because there is relatively little cross-reactivity among different oak species.	\r\n', 0, 0),
(30, 'C', 'Olive', 2, 7, 'O0910910  ', '4-15', 'olive_tree.jpg', 'Olive trees are strongly allergenic, particularly in the Southwestern United States.  They are native to Asia, parts of Africa and the Mediterranean.  	\r\n', 0, 0),
(31, 'C', 'Acacia Pollen', 2, 8, 'A15033010', '1-15', 'acacia.jpg', 'We test for a species of Acacia called Acacia baileyana.  It is part of the Fabaceae family.  Acacia is not native to California but is now common here.  It is also known as the Cootamundra Wattle!	Photo: Dr. Dean Wm. Taylor, Jepson Herbarium.\r\n', 0, 0),
(32, 'D', 'Pullularia', 1, 1, 'P05051711 ', '10-14', 'Pullularia.jpg', 'A mold found in the air year-round but spore concentration tends to increase during the summer.  Pullularia is found worldwide and is widespread in the United States.  It is commonly found in plastics and paints.  It is a member of the Dematiaceae group of molds, the most highly allergenic group in the Deuteromycete class. Photo: Copyright Dennis Kunkel Microscopy, Inc.\r\n', 0, 0),
(33, 'D', 'Mucor Racemosus', 1, 2, 'M34100311 ', '5-15', 'nopicture1.jpg', 'Some outdoor molds tend to be found on grass and are released when the grass is cut.  If you reacted to Grass Smut Mix, you are allergic to one or both of two molds that cause disease in two common grasses: Bermuda Grass and Timothy Grass. 	', 0, 0),
(34, 'D', 'American Dust Mite', 5, 3, 'D36061511 ', '6-14', 'dust_mite.jpg', 'These microscopic arthropods eat animal and human dander, fungi and other small proteins.  Dust mites live mainly where their food is: pillows, blankets, mattresses, rugs and upholstery.  It is the feces that can be inhaled and trigger allergies.  To make matters worse, vacuuming sends dust mite particles airborne.  Dust mites do not like cool, dry environments.  They thrive in temperatures 25-30 degrees centigrade and are rare in dry climates and high altitudes.\r\n', 0, 0),
(35, 'D', 'Kochia', 5, 4, 'K01112111 ', '1-15', 'kochia.jpg', 'Kochia is a drought-resistant plant originally brought to the United States from Eurasia in 1900.  It is common in California''s Central Valley, southern desert and in some coastal regions.  The plant grows to 2-5 feet.  Like Russian Thistle, it can break off at its base and be blown from place to place.  Kochia has been called ', 0, 0),
(36, 'D', 'Johnson Grass', 3, 5, 'J04092308', '1-12', 'Johnson_sorghum_halepense.jpg', '	Like Bermuda grass, it is perennial (year-round).  Johnson grass is common in all areas of North America.  It is an official "noxious weed" in many states including California because it can harm cash crops.  Livestock can become ill if they eat too much Johnson grass! Photo: Richard Old, www.xidservices.com.	 \r\n', 0, 0),
(37, 'D', 'Arizona Cypress', 2, 6, 'C51092308 ', '4-14', 'arizona_cypress.jpg', 'Commonly used as a Christmas Tree, the Arizona Cypress tolerates drought well, grows quickly and lives only 30-50 yearsâ€¦ not very long in the world of trees. It blooms in April and May.  Unlike many gymnosperms, Cypress family members generate very potent pollens.  Interestingly, Cedars and Junipers are part of the cypress family and they all cross-react so you can have an allergy to an East Coast cedar in New York and react to an Arizona Cypress in Los Angeles! Photo: Sally and Andy Wasowski.	\r\n', 0, 0),
(38, 'D', 'West Cottonwood', 2, 7, 'C50092711 ', '4-15', 'nopicture3.jpg', 'This tree is part of the Willow (Salicaceae) family and blooms in April and May.  The Aspen is also a member of this family. 	 \r\n', 0, 0),
(39, 'D', 'Chinese Elm', 2, 8, 'E08122011 ', '4-15', 'chinese_elm.jpg', 'Also known as the Siberian Elm, this allergenic tree was introduced to the U.S. from the Far East.  It grows up to 65 feet high!  The Chinese Elm flowers in the early spring and is drought resistant so it does very well in Southern California. 	Photo: Ben Legler. \r\n', 0, 0),
(42, 'A', 'Coco Glycerine ', 4, 8, 'EXF061708', '4-15', 'nopicture4.jpg', 'No text.  ', 0, 0),
(54, 'a', 'food test', 0, 0, '111', '04/15', 'TitleImage.png', ' test', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `analysis`
--

CREATE TABLE IF NOT EXISTS `analysis` (
  `analysisID` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `analysisCount` mediumint(8) unsigned NOT NULL,
  `patientID` mediumint(8) unsigned DEFAULT '0',
  `allergenID` mediumint(8) unsigned DEFAULT '0',
  `MSPScore` varchar(5) DEFAULT '0',
  `ITScore` varchar(5) DEFAULT '0',
  `validated` tinyint(1) unsigned DEFAULT '0',
  `dateAdded` datetime NOT NULL,
  `treatment` int(1) DEFAULT '0',
  `dilutionLevel` int(11) DEFAULT '0',
  `twoWhl` int(11) DEFAULT '0',
  `refill` int(11) DEFAULT '0',
  PRIMARY KEY (`analysisID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33470 ;

--
-- Dumping data for table `analysis`
--

INSERT INTO `analysis` (`analysisID`, `analysisCount`, `patientID`, `allergenID`, `MSPScore`, `ITScore`, `validated`, `dateAdded`, `treatment`, `dilutionLevel`, `twoWhl`, `refill`) VALUES
(33239, 1, 1020, 12, '7', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33240, 1, 1020, 11, '13', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33241, 1, 1020, 10, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33242, 1, 1020, 8, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33243, 1, 1020, 13, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33244, 1, 1020, 14, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33245, 1, 1020, 41, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33246, 1, 1020, 16, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33247, 1, 1020, 17, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33248, 1, 1020, 18, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33249, 1, 1020, 19, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33250, 1, 1020, 20, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33251, 1, 1020, 21, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33252, 1, 1020, 22, '19', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33253, 1, 1020, 23, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33254, 1, 1020, 24, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33255, 1, 1020, 25, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33256, 1, 1020, 26, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33257, 1, 1020, 27, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33258, 1, 1020, 28, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33259, 1, 1020, 29, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33260, 1, 1020, 30, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33261, 1, 1020, 31, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33262, 1, 1020, 32, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33263, 1, 1020, 33, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33264, 1, 1020, 34, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33265, 1, 1020, 35, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33266, 1, 1020, 36, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33267, 1, 1020, 37, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33268, 1, 1020, 38, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33269, 1, 1020, 39, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33270, 1, 1020, 42, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33271, 1, 1020, 54, '5', '5', 0, '2016-12-20 16:10:08', 1, 0, 0, 1),
(33272, 2, 1020, 12, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33273, 2, 1020, 11, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33274, 2, 1020, 10, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33275, 2, 1020, 8, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33276, 2, 1020, 13, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33277, 2, 1020, 14, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33278, 2, 1020, 41, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33279, 2, 1020, 16, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33280, 2, 1020, 17, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33281, 2, 1020, 18, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33282, 2, 1020, 19, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33283, 2, 1020, 20, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33284, 2, 1020, 21, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33285, 2, 1020, 22, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33286, 2, 1020, 23, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33287, 2, 1020, 24, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33288, 2, 1020, 25, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33289, 2, 1020, 26, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33290, 2, 1020, 27, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33291, 2, 1020, 28, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33292, 2, 1020, 29, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33293, 2, 1020, 30, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33294, 2, 1020, 31, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33295, 2, 1020, 32, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33296, 2, 1020, 33, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33297, 2, 1020, 34, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33298, 2, 1020, 35, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33299, 2, 1020, 36, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33300, 2, 1020, 37, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33301, 2, 1020, 38, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33302, 2, 1020, 39, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33303, 2, 1020, 42, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33304, 2, 1020, 54, '5', '5', 0, '2016-12-20 16:11:04', 0, 0, 0, 0),
(33305, 1, 1018, 12, '22', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33306, 1, 1018, 11, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33307, 1, 1018, 10, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33308, 1, 1018, 8, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33309, 1, 1018, 13, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33310, 1, 1018, 14, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33311, 1, 1018, 41, '5', '19', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33312, 1, 1018, 16, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33313, 1, 1018, 17, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33314, 1, 1018, 18, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33315, 1, 1018, 19, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33316, 1, 1018, 20, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33317, 1, 1018, 21, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33318, 1, 1018, 22, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33319, 1, 1018, 23, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33320, 1, 1018, 24, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33321, 1, 1018, 25, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33322, 1, 1018, 26, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33323, 1, 1018, 27, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33324, 1, 1018, 28, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33325, 1, 1018, 29, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33326, 1, 1018, 30, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33327, 1, 1018, 31, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33328, 1, 1018, 32, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33329, 1, 1018, 33, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33330, 1, 1018, 34, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33331, 1, 1018, 35, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33332, 1, 1018, 36, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33333, 1, 1018, 37, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33334, 1, 1018, 38, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33335, 1, 1018, 39, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33336, 1, 1018, 42, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33337, 1, 1018, 54, '5', '5', 0, '2016-12-20 16:13:34', 2, 0, 0, 0),
(33338, 3, 1020, 12, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33339, 3, 1020, 11, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33340, 3, 1020, 10, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33341, 3, 1020, 8, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33342, 3, 1020, 13, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33343, 3, 1020, 14, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33344, 3, 1020, 41, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33345, 3, 1020, 16, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33346, 3, 1020, 17, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33347, 3, 1020, 18, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33348, 3, 1020, 19, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33349, 3, 1020, 20, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33350, 3, 1020, 21, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33351, 3, 1020, 22, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33352, 3, 1020, 23, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33353, 3, 1020, 24, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33354, 3, 1020, 25, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33355, 3, 1020, 26, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33356, 3, 1020, 27, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33357, 3, 1020, 28, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33358, 3, 1020, 29, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33359, 3, 1020, 30, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33360, 3, 1020, 31, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33361, 3, 1020, 32, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33362, 3, 1020, 33, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33363, 3, 1020, 34, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33364, 3, 1020, 35, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33365, 3, 1020, 36, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33366, 3, 1020, 37, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33367, 3, 1020, 38, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33368, 3, 1020, 39, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33369, 3, 1020, 42, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33370, 3, 1020, 54, '5', '5', 0, '2016-12-20 16:16:20', 0, 0, 0, 0),
(33371, 1, 1022, 12, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33372, 1, 1022, 11, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33373, 1, 1022, 10, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33374, 1, 1022, 8, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33375, 1, 1022, 13, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33376, 1, 1022, 14, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33377, 1, 1022, 41, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33378, 1, 1022, 16, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33379, 1, 1022, 17, '13', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33380, 1, 1022, 18, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33381, 1, 1022, 19, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33382, 1, 1022, 20, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33383, 1, 1022, 21, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33384, 1, 1022, 22, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33385, 1, 1022, 23, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33386, 1, 1022, 24, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33387, 1, 1022, 25, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33388, 1, 1022, 26, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33389, 1, 1022, 27, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33390, 1, 1022, 28, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33391, 1, 1022, 29, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33392, 1, 1022, 30, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33393, 1, 1022, 31, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33394, 1, 1022, 32, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33395, 1, 1022, 33, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33396, 1, 1022, 34, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33397, 1, 1022, 35, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33398, 1, 1022, 36, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33399, 1, 1022, 37, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33400, 1, 1022, 38, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33401, 1, 1022, 39, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33402, 1, 1022, 42, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33403, 1, 1022, 54, '5', '5', 0, '2016-12-21 09:19:26', 2, 3, 0, 0),
(33404, 1, 1023, 12, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33405, 1, 1023, 11, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33406, 1, 1023, 10, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33407, 1, 1023, 8, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33408, 1, 1023, 13, '5', '18', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33409, 1, 1023, 14, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33410, 1, 1023, 41, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33411, 1, 1023, 16, '19', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33412, 1, 1023, 17, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33413, 1, 1023, 18, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33414, 1, 1023, 19, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33415, 1, 1023, 20, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33416, 1, 1023, 21, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33417, 1, 1023, 22, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33418, 1, 1023, 23, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33419, 1, 1023, 24, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33420, 1, 1023, 25, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33421, 1, 1023, 26, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33422, 1, 1023, 27, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33423, 1, 1023, 28, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33424, 1, 1023, 29, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33425, 1, 1023, 30, '19', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33426, 1, 1023, 31, '5', '27', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33427, 1, 1023, 32, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33428, 1, 1023, 33, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33429, 1, 1023, 34, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33430, 1, 1023, 35, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33431, 1, 1023, 36, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33432, 1, 1023, 37, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33433, 1, 1023, 38, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33434, 1, 1023, 39, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33435, 1, 1023, 42, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33436, 1, 1023, 54, '5', '5', 0, '2016-12-22 09:30:39', 1, 0, 0, 0),
(33447, 1, 1025, 16, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33446, 1, 1025, 42, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33445, 1, 1025, 14, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33444, 1, 1025, 13, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33443, 1, 1025, 12, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33442, 1, 1025, 11, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33441, 1, 1025, 10, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33440, 1, 1025, 41, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33439, 1, 1025, 17, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33438, 1, 1025, 8, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33437, 1, 1025, 54, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33448, 1, 1025, 18, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33449, 1, 1025, 19, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33450, 1, 1025, 20, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33451, 1, 1025, 21, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33452, 1, 1025, 22, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33453, 1, 1025, 23, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33454, 1, 1025, 24, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33455, 1, 1025, 25, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33456, 1, 1025, 26, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33457, 1, 1025, 27, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33458, 1, 1025, 28, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33459, 1, 1025, 29, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33460, 1, 1025, 30, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33461, 1, 1025, 31, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33462, 1, 1025, 32, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33463, 1, 1025, 33, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33464, 1, 1025, 34, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33465, 1, 1025, 35, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33466, 1, 1025, 36, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33467, 1, 1025, 37, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33468, 1, 1025, 38, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0),
(33469, 1, 1025, 39, '5', '5', 0, '2017-05-25 10:55:18', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `custom_allergens`
--

CREATE TABLE IF NOT EXISTS `custom_allergens` (
  `patientID` int(11) NOT NULL,
  `analysisCount` mediumint(9) NOT NULL,
  `allergenID` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `batteryName` varchar(50) DEFAULT '0',
  `antigenName` varchar(255) DEFAULT '0',
  `groupID` mediumint(8) unsigned NOT NULL,
  `site` smallint(3) unsigned DEFAULT '0',
  `lotNumber` varchar(10) DEFAULT NULL,
  `expDate` varchar(10) DEFAULT NULL,
  `fileName` varchar(200) DEFAULT 'nopicture.jpg',
  `caption` text,
  `disabled` int(11) NOT NULL DEFAULT '0',
  `MSPScore` int(5) NOT NULL DEFAULT '5',
  `ISPScore` int(5) NOT NULL DEFAULT '5',
  `twoWhl` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`allergenID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `custom_allergens`
--

INSERT INTO `custom_allergens` (`patientID`, `analysisCount`, `allergenID`, `batteryName`, `antigenName`, `groupID`, `site`, `lotNumber`, `expDate`, `fileName`, `caption`, `disabled`, `MSPScore`, `ISPScore`, `twoWhl`) VALUES
(1, 1, 1, 'A', '0', 1, 1, 'jao', '11-14', 'nopicture.jpg', NULL, 0, 5, 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `groupID` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `groupName` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `sortOrder` tinyint(4) unsigned NOT NULL,
  PRIMARY KEY (`groupID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`groupID`, `groupName`, `sortOrder`) VALUES
(1, 'Mold', 1),
(2, 'Trees', 2),
(3, 'Grass', 3),
(4, 'Weeds', 4),
(5, 'Animals, etc.', 5);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE IF NOT EXISTS `patient` (
  `patientID` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `patientFirst` varchar(100) NOT NULL DEFAULT '0',
  `patientLast` varchar(100) NOT NULL DEFAULT '0',
  `chartNum` varchar(25) DEFAULT '0',
  `dateOfBirth` varchar(10) DEFAULT '0',
  `sex` char(1) DEFAULT '0',
  `zipCodeHome` varchar(12) DEFAULT '0',
  `zipCodeWork` varchar(12) DEFAULT '0',
  `dateAdded` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  `tester` varchar(50) NOT NULL,
  PRIMARY KEY (`patientID`),
  UNIQUE KEY `patientID` (`patientID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1026 ;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`patientID`, `patientFirst`, `patientLast`, `chartNum`, `dateOfBirth`, `sex`, `zipCodeHome`, `zipCodeWork`, `dateAdded`, `email`, `tester`) VALUES
(1025, 'joseph', 'orlando', '111111111', '2017-05-18', 'M', '90036', '90036', '2017-05-25 10:55:18', 'jorlando2012@gmail.com', ''),
(1023, 'joe', 'orlandp', '1111111', '1995-12-31', 'M', '', '', '2016-12-22 09:30:20', '', ''),
(1024, 'joseph', 'orlando', '11111111', '2017-04-20', 'M', '90036', '90036', '2017-04-06 12:01:38', 'jorlando2012@gmail.com', '');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE IF NOT EXISTS `report` (
  `reportID` int(10) NOT NULL AUTO_INCREMENT,
  `patientID` int(10) NOT NULL,
  `analysisCount` int(10) NOT NULL,
  `treatment` int(1) NOT NULL,
  `allergenID` int(5) NOT NULL,
  `allergenName` varchar(50) NOT NULL,
  `dilutionLevel` smallint(1) NOT NULL,
  `dilution` int(1) NOT NULL,
  `quantity` float NOT NULL,
  `lotNumber` int(10) NOT NULL,
  `expDate` varchar(5) NOT NULL,
  PRIMARY KEY (`reportID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `treatment`
--

CREATE TABLE IF NOT EXISTS `treatment` (
  `analysisCount` int(10) NOT NULL,
  `patientID` int(11) NOT NULL,
  `treatment` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
