-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2024 at 03:24 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medosmuseum`
--

-- --------------------------------------------------------

--
-- Table structure for table `artifact`
--

CREATE TABLE `artifact` (
  `artifact_ID` int(5) NOT NULL,
  `artifact_Name` varchar(50) NOT NULL,
  `Excerpt` varchar(100) NOT NULL,
  `Creator` varchar(40) NOT NULL,
  `Condition` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artifact`
--

INSERT INTO `artifact` (`artifact_ID`, `artifact_Name`, `Excerpt`, `Creator`, `Condition`) VALUES
(12, 'Medo\'s Pose', 'Picture of a cat, Medo, on the kitchen floor. SPRAWLED.', 'Bektic', 'Good'),
(32132, 'Raining Cats and Dogs', 'Painting of precipitating cats and dogs', 'Da Vinci', 'Fair'),
(34521, 'Cozy Kittens', 'Kittens wrapped in blankets', 'Picasso', 'Fair'),
(2312, 'Calico', 'Splatter of cat coat colors', 'Pollock', 'Good'),
(58888, 'Saint Jerome Extracting a Thorn from a Lion’s Paw', '15th Century', 'Master of the Murano', 'Good'),
(59997, 'Two Lions', 'Tempera colors, gold leaf, and ink on parchment', 'Franco-Flemish', 'Fair'),
(67354, 'Le Chat', 'about 1857–1858, Conté crayon and pastel with stumping and blending, fixed on wove paper', 'Jean-François Millet', 'Fair'),
(69697, 'Magdaleine Pinceloup de la Grange, née de Parseval', '1747, Oil on canvas', 'Jean-Baptiste Perronneau', 'Good'),
(12345, 'Kitty Series', '1871, Hand-colored albumen silver print.', 'John P. Soule', 'Good'),
(28765, 'Egyptian Statue, title unknown', 'Bronze figure of the cat-headed goddess Bastet, Late Period or Ptolemaic Period, c. 664-30 BC.', 'Unknown', 'Poor'),
(34987, 'White Angora Cat', 'Painted in 1761', 'Jean-Jacques Bachelier', 'Good'),
(98765, 'Two Children Teasing a Cat', 'Painted in 1588', 'Annibale Carracci', 'Fair'),
(1, 'The Original', 'First picture of the day, Medo', 'Bektic', 'Good');

-- --------------------------------------------------------

--
-- Table structure for table `attends`
--

CREATE TABLE `attends` (
  `visitor_ID` int(5) NOT NULL,
  `event_ID` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attends`
--

INSERT INTO `attends` (`visitor_ID`, `event_ID`) VALUES
(212, 1),
(6543, 1),
(1245, 1),
(915, 1),
(122, 1);

-- --------------------------------------------------------

--
-- Table structure for table `displays`
--

CREATE TABLE `displays` (
  `artifact_ID` int(5) NOT NULL,
  `exhibit_ID` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `displays`
--

INSERT INTO `displays` (`artifact_ID`, `exhibit_ID`) VALUES
(28765, 'EX2'),
(98765, 'EX2'),
(69697, 'EX2'),
(12345, 'EX2'),
(1, 'EX2'),
(2312, 'EX405'),
(32132, 'EX405'),
(58888, 'EX405'),
(59997, 'EX405');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `event_ID` int(5) NOT NULL,
  `event_Title` varchar(40) NOT NULL,
  `Date` datetime(6) NOT NULL,
  `staff_ID` int(5) NOT NULL,
  `room_num` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`event_ID`, `event_Title`, `Date`, `staff_ID`, `room_num`) VALUES
(1, 'Opening Night - Cats', '2024-12-05 18:00:00.000000', 11111, '300A'),
(2, 'Medieval Cats and Seminar', '2024-12-06 15:00:00.000000', 42036, '210B'),
(3, 'Big Cats of the Wild', '2024-12-09 10:00:00.000000', 42034, '150C');

-- --------------------------------------------------------

--
-- Table structure for table `exhibit`
--

CREATE TABLE `exhibit` (
  `exhibit_ID` varchar(5) NOT NULL,
  `exhibit_Name` varchar(50) NOT NULL,
  `start_Of_Term` date NOT NULL,
  `end_Of_Term` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exhibit`
--

INSERT INTO `exhibit` (`exhibit_ID`, `exhibit_Name`, `start_Of_Term`, `end_Of_Term`) VALUES
('EX2', 'Cats Throughout History', '2024-11-04', '2025-04-25'),
('EX405', 'The Wild', '2024-12-03', '2024-12-20');

-- --------------------------------------------------------

--
-- Table structure for table `hosts`
--

CREATE TABLE `hosts` (
  `staff_ID` int(5) NOT NULL,
  `event_ID` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hosts`
--

INSERT INTO `hosts` (`staff_ID`, `event_ID`) VALUES
(11111, 1);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_num` varchar(10) NOT NULL,
  `capacity` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_num`, `capacity`) VALUES
('110A', 30),
('210B', 45),
('300A', 100),
('150C', 25);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_ID` int(5) NOT NULL,
  `staff_Name` varchar(20) NOT NULL,
  `Position` varchar(20) NOT NULL,
  `contact_Info` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_ID`, `staff_Name`, `Position`, `contact_Info`) VALUES
(42035, 'Jacob Hartmann', 'Manager', '412-420-2002'),
(42034, 'Chrus', 'Art Maintainance', '412-012-2599'),
(11111, 'Meldin Bektic', 'Owner', '111-111-1111'),
(12121, 'John Smith', 'Manager', '212-123-1213'),
(42036, 'Caitlyn Hartmann', 'Curator', '412-266-1999'),
(33333, 'Nick Cage', 'Event Coordinator', '234-456-6789');

-- --------------------------------------------------------

--
-- Table structure for table `visitor`
--

CREATE TABLE `visitor` (
  `visitor_ID` int(5) NOT NULL,
  `visitor_Name` varchar(20) NOT NULL,
  `v_Contact_Info` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitor`
--

INSERT INTO `visitor` (`visitor_ID`, `visitor_Name`, `v_Contact_Info`) VALUES
(212, 'Vicki Wilson', '123-213-4235'),
(6543, 'Sharon Love', '923-134-5342'),
(1245, 'Sierra Nicole', '346-271-3745'),
(915, 'Jason Lee', '242-326-6423'),
(122, 'Catherine Louise', '423-124-7662');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
