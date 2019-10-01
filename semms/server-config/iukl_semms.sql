-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2019 at 01:44 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iukl_semms`
--

-- --------------------------------------------------------

--
-- Table structure for table `appeal`
--

CREATE TABLE `appeal` (
  `id` int(11) UNSIGNED NOT NULL,
  `case_id` int(11) UNSIGNED DEFAULT NULL,
  `result` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `student_appeal_request_details` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `request_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes_remarks` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `appeal_submitted_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attachment`
--

CREATE TABLE `attachment` (
  `attachment_id` int(11) NOT NULL,
  `path` text NOT NULL,
  `report_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE `cases` (
  `id` int(11) NOT NULL,
  `report_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Ongoing',
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `finesettlement`
--

CREATE TABLE `finesettlement` (
  `id` int(11) UNSIGNED NOT NULL,
  `case_id` int(11) UNSIGNED DEFAULT NULL,
  `result` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fine_amount` double DEFAULT NULL,
  `notes_remarks` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hearing`
--

CREATE TABLE `hearing` (
  `id` int(11) UNSIGNED NOT NULL,
  `case_id` int(11) UNSIGNED DEFAULT NULL,
  `result` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes_remarks` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hearing_session_date` date DEFAULT NULL,
  `hearing_session_start` time DEFAULT NULL,
  `hearing_session_end` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `misconduct`
--

CREATE TABLE `misconduct` (
  `misconduct_id` int(11) NOT NULL,
  `type` text NOT NULL,
  `report_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `subject` text NOT NULL,
  `description` text NOT NULL,
  `related_id` int(11) NOT NULL,
  `tag` varchar(10) NOT NULL,
  `date_triggered` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` varchar(5) NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) UNSIGNED NOT NULL,
  `case_id` int(11) UNSIGNED DEFAULT NULL,
  `outstanding` double DEFAULT NULL,
  `payment_status` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_paid` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `primaryinvestigation`
--

CREATE TABLE `primaryinvestigation` (
  `id` int(11) UNSIGNED NOT NULL,
  `case_id` int(11) UNSIGNED DEFAULT NULL,
  `notes_remarks` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `result` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `report_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_code` varchar(10) NOT NULL,
  `course_name` varchar(25) NOT NULL,
  `exam_venue` text NOT NULL,
  `exam_date` varchar(15) NOT NULL,
  `exam_time` varchar(15) NOT NULL,
  `misconduct_time` varchar(15) NOT NULL,
  `misconduct_description` text NOT NULL,
  `action_taken` text NOT NULL,
  `reporter_id` int(11) NOT NULL,
  `superior_id` int(11) NOT NULL,
  `witness1_name` varchar(30) NOT NULL,
  `witness1_contact_no` text NOT NULL,
  `witness1_email` varchar(30) NOT NULL,
  `witness2_name` varchar(30) NOT NULL,
  `witness2_contact_no` text NOT NULL,
  `witness2_email` varchar(30) NOT NULL,
  `report_status` varchar(10) NOT NULL DEFAULT 'Pending',
  `case_status` varchar(10) NOT NULL,
  `uploaded_by` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_approval_date` timestamp NULL DEFAULT NULL,
  `is_valid` varchar(7) NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stagehistory`
--

CREATE TABLE `stagehistory` (
  `id` int(11) UNSIGNED NOT NULL,
  `case_id` int(11) UNSIGNED DEFAULT NULL,
  `stage_id` int(11) UNSIGNED DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_updated` datetime DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `matric_id` varchar(15) NOT NULL,
  `ic_or_passport` varchar(25) NOT NULL,
  `name` varchar(30) NOT NULL,
  `programme` varchar(10) NOT NULL,
  `contact_no` text NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `matric_id`, `ic_or_passport`, `name`, `programme`, `contact_no`, `email`) VALUES
(1, '172018845', '970906145941', 'Ahmad Firdaus', 'CIT 301', '0149608981', 'ahmad0609firdaus@gmail.com'),
(2, '172018846', '970906145942', 'Mohd Haziq', 'CIT 302', '0149608982', 'haziq@gmail.com'),
(3, '172018847', '970906155941', 'Mohd Akmal', 'CIT 301', '0123456789', 'akmal@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `staff_id` varchar(15) NOT NULL,
  `password` text NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `contact_no` text NOT NULL,
  `user_type` varchar(15) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_date` timestamp NULL DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `granted_access` varchar(3) NOT NULL DEFAULT 'Yes'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `staff_id`, `password`, `name`, `email`, `contact_no`, `user_type`, `created_date`, `modified_date`, `last_login`, `granted_access`) VALUES
(1, 'ADMIN01', '$2y$10$Gwu.PGQcoWaPWXobf.pbJO48MXR9LZG6a93.Q0GeZ1IsqwcTCA0Zq', 'Mohammad Ezad', 'ezad@iukl.edu.my', '0123456789', 'Admin', '2019-07-01 01:37:30', '2019-10-01 01:16:01', '2019-10-01 01:16:01', 'Yes'),
(2, 'COUNSELOR01', '$2y$10$xwpiNeKORQjepSr7Q06Bmu9AGrolrNOZvaAf8iK5yPz2vwAPlsfvO', 'Mohamad Amin', 'saiful@iukl.edu.my', '0133456789', 'Counselor', '2019-07-11 22:10:06', '2019-10-01 01:32:05', '2019-10-01 01:32:05', 'Yes'),
(3, 'BURSARY01', '$2y$10$Bty0E/ku9al9GKcyF9bpweDKEIx728VvYYyGXQo8hOK/W1SZ0DZW.', 'Nurul Adira', 'adira@iukl.edu.my', '0123456788', 'Bursary Admin', '2019-07-11 22:10:06', '2019-10-01 01:30:26', '2019-10-01 01:30:26', 'Yes'),
(7, 'IEN00025', '$2y$10$SLtC3p4e3BvxvZcOHINxsOWIaMg/F0JmNKrhO6u.4WYE6ICxRh//G', 'Mohd Safwan', 'safwan@iukl.edu.my', '0143043738', 'Invigilator', '2019-07-22 19:31:26', '2019-10-01 01:09:10', '2019-10-01 01:09:10', 'Yes'),
(8, 'IEN00026', '$2y$10$L7bK9ig9esEx0Xb9pckgluA0hH4RGMC4miD9RwIBBhRCOm9dQ9QEe', 'Mohd Syarif', 'syarif@iukl.edu.my', '0149608982', 'Invigilator', '2019-08-14 11:01:12', '2019-09-09 05:06:00', '2019-09-09 05:06:00', 'Yes'),
(9, 'IEN00027', '$2y$10$0NGO8OjEuuIi0aFboZj1zOqgG5z1xGRITjJtPThvwZPYX09UC2PBe', 'Mohd Saiful', 'saiful@iukl.edu.my', '0149608983', 'Invigilator', '2019-09-13 02:27:00', '2019-10-01 00:26:02', '2019-10-01 00:26:02', 'Yes'),
(12, 'ADMIN02', '$2y$10$fWw/YvcyaPL2SxSAXtwmnet60dUTy3A3UnfqhpzzUWf14RsY88ES6', 'Mohd Akram', 'akram@iukl.edu.my', '0123456678', 'Admin', '2019-09-30 22:43:51', '2019-09-30 22:44:21', NULL, 'Yes');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appeal`
--
ALTER TABLE `appeal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_appeal_case` (`case_id`);

--
-- Indexes for table `attachment`
--
ALTER TABLE `attachment`
  ADD PRIMARY KEY (`attachment_id`),
  ADD KEY `report_id` (`report_id`);

--
-- Indexes for table `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `report_id` (`report_id`);

--
-- Indexes for table `finesettlement`
--
ALTER TABLE `finesettlement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_finesettlement_case` (`case_id`);

--
-- Indexes for table `hearing`
--
ALTER TABLE `hearing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_hearing_case` (`case_id`);

--
-- Indexes for table `misconduct`
--
ALTER TABLE `misconduct`
  ADD PRIMARY KEY (`misconduct_id`),
  ADD KEY `report_id` (`report_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_payment_case` (`case_id`);

--
-- Indexes for table `primaryinvestigation`
--
ALTER TABLE `primaryinvestigation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_primaryinvestigation_case` (`case_id`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `reporter_id` (`reporter_id`),
  ADD KEY `superior_id` (`superior_id`);

--
-- Indexes for table `stagehistory`
--
ALTER TABLE `stagehistory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_stagehistory_case` (`case_id`),
  ADD KEY `index_foreignkey_stagehistory_stage` (`stage_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appeal`
--
ALTER TABLE `appeal`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attachment`
--
ALTER TABLE `attachment`
  MODIFY `attachment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cases`
--
ALTER TABLE `cases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `finesettlement`
--
ALTER TABLE `finesettlement`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hearing`
--
ALTER TABLE `hearing`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `misconduct`
--
ALTER TABLE `misconduct`
  MODIFY `misconduct_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `primaryinvestigation`
--
ALTER TABLE `primaryinvestigation`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stagehistory`
--
ALTER TABLE `stagehistory`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attachment`
--
ALTER TABLE `attachment`
  ADD CONSTRAINT `attachment_ibfk_1` FOREIGN KEY (`report_id`) REFERENCES `report` (`report_id`);

--
-- Constraints for table `cases`
--
ALTER TABLE `cases`
  ADD CONSTRAINT `cases_ibfk_1` FOREIGN KEY (`report_id`) REFERENCES `report` (`report_id`);

--
-- Constraints for table `misconduct`
--
ALTER TABLE `misconduct`
  ADD CONSTRAINT `misconduct_ibfk_1` FOREIGN KEY (`report_id`) REFERENCES `report` (`report_id`);

--
-- Constraints for table `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `report_ibfk_2` FOREIGN KEY (`reporter_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `report_ibfk_3` FOREIGN KEY (`superior_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
