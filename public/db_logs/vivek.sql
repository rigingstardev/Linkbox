ALTER TABLE `questions` ADD `bg_image` VARCHAR(255) NULL AFTER `active`;

--
-- Table structure for table `allergy_patients`
--

CREATE TABLE `allergy_patients` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allergy_patients`
--
ALTER TABLE `allergy_patients`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allergy_patients`
--
ALTER TABLE `allergy_patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
  
  

--
-- Table structure for table `past_medical_history`
--

CREATE TABLE `past_medical_history` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `past_medical_history`
--
ALTER TABLE `past_medical_history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `past_medical_history`
--
ALTER TABLE `past_medical_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
  
  
--
-- Table structure for table `social_history`
--

CREATE TABLE `social_history` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `smoke` enum('1','0') NOT NULL COMMENT '1 - Yes, 0 - No',
  `drink` enum('1','0') NOT NULL COMMENT '1 - Yes, 0 - No',
  `drug` enum('1','0') NOT NULL COMMENT '1 - Yes, 0 - No',
  `comments` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `social_history`
--
ALTER TABLE `social_history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `social_history`
--
ALTER TABLE `social_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
  
-- ALTER TABLE `social_history` ADD `comments` TEXT NULL AFTER `value`;



--
-- Table structure for table `family_history`
--

CREATE TABLE `family_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `patient_id` int(10) UNSIGNED NOT NULL,
  `illness` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `relation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `illness_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `family_history`
--
ALTER TABLE `family_history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `family_history`
--
ALTER TABLE `family_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
  
  
--
-- Table structure for table `surgical_history`
--

CREATE TABLE `surgical_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `patient_id` int(10) UNSIGNED NOT NULL,
  `surgery` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `surgery_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `surgical_history`
--
ALTER TABLE `surgical_history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `surgical_history`
--
ALTER TABLE `surgical_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
  
  
ALTER TABLE `patients` CHANGE `name` `first_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `patients` ADD `last_name` VARCHAR(255) NULL AFTER `first_name`;


CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_reserved_at_index` (`queue`,`reserved_at`);