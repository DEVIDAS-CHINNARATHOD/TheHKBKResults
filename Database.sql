-- Create database if not exists
CREATE DATABASE IF NOT EXISTS `Studentresults`;
USE `Studentresults`;

-- Faculty table
CREATE TABLE `faculty` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Marks table
CREATE TABLE `marks` (
  `id` int(11) NOT NULL,
  `usn` varchar(20) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `marks` int(11) NOT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `ia_type` varchar(20) NOT NULL,
  `semester` int(11) NOT NULL,
  `faculty_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Students table
CREATE TABLE `students` (
  `usn` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `branch` varchar(50) NOT NULL,
  `semester` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Keys & Indexes
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `marks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usn` (`usn`),
  ADD KEY `FK_faculty_id` (`faculty_id`);

ALTER TABLE `students`
  ADD PRIMARY KEY (`usn`);

-- Auto-increment setup
ALTER TABLE `faculty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `marks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
