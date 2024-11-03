
--
-- Database: `chef_jose_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `profile` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) DEFAULT NULL,
  `last_modified` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



--
-- Table structure for table `combo`
--

CREATE TABLE `combo` (
  `comboID` int(11) NOT NULL,
  `displayPic` longblob NOT NULL,
  `comboName` varchar(250) DEFAULT NULL,
  `comboCode` varchar(250) DEFAULT NULL,
  `comboPrice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `combo`
--

 
--
-- Table structure for table `comboitems`
--

CREATE TABLE `comboitems` (
  `comboItemID` int(11) NOT NULL,
  `comboID` int(11) DEFAULT NULL,
  `productID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employeeID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `profilePic` mediumblob DEFAULT NULL,
  `fName` varchar(100) DEFAULT NULL,
  `mName` varchar(100) DEFAULT NULL,
  `lName` varchar(100) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contactno` int(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Table structure for table `orderitems`
--

CREATE TABLE `orderitems` (
  `orderItemId` int(11) NOT NULL,
  `ref_no` int(25) NOT NULL,
  `itemType` varchar(20) DEFAULT 'product',
  `productID` int(11) DEFAULT NULL,
  `comboID` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unitPrice` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderID` int(11) NOT NULL,
  `ref_no` int(25) NOT NULL,
  `orderDate` date DEFAULT current_timestamp(),
  `orderTime` time NOT NULL DEFAULT current_timestamp(),
  `employeeID` int(11) DEFAULT NULL,
  `totalAmount` double DEFAULT NULL,
  `paymentMethod` varchar(100) DEFAULT '-----',
  `gcashAccountName` varchar(50) DEFAULT '-----',
  `gcashAccountNo` varchar(50) DEFAULT '-----',
  `discountType` varchar(250) DEFAULT '-----',
  `discount` varchar(10) DEFAULT '-----'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productID` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `displayPic` longblob DEFAULT NULL,
  `quantityInStock` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `userRole` varchar(50) DEFAULT NULL,
  `userName` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

