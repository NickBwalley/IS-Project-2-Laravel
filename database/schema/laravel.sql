
--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `name`, `email`, `description`, `date_time`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', 'Has log out', 'Thu, Nov 2, 2023 9:11 AM', NULL, NULL),
(2, 'Admin', 'admin@gmail.com', 'Has logged in', 'Thu, Nov 2, 2023 9:24 AM', NULL, NULL),
(3, 'Admin', 'admin@gmail.com', 'Has logged in', 'Fri, Nov 3, 2023 8:46 AM', NULL, NULL);

-- --------------------------------------------------------


--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `answer`, `created_at`, `updated_at`) VALUES
(1, 'A', NULL, NULL),
(2, 'B', NULL, NULL),
(3, 'C', NULL, NULL),
(4, 'D', NULL, NULL),
(5, 'E', NULL, NULL);

-- --------------------------------------------------------


INSERT INTO `departments` (`id`, `department`, `created_at`, `updated_at`) VALUES
(1, 'Section A', '2023-11-02 02:51:47', '2023-11-02 02:51:47'),
(2, 'Section B', '2023-11-02 02:51:55', '2023-11-02 02:51:55'),
(3, 'Section C', '2023-11-02 02:52:05', '2023-11-02 02:52:05');

-- --------------------------------------------------------


--
-- Dumping data for table `departments_assigned`
--

INSERT INTO `departments_assigned` (`id`, `department`, `employee_name`, `employee_id_auto`, `created_at`, `updated_at`) VALUES
(1, 'Section B', 'David Kibiro', 'KNF00002', '2023-11-02 02:52:21', '2023-11-02 02:52:21'),
(2, 'Section A', 'Samson Chacha', 'KNF00003', '2023-11-02 02:52:46', '2023-11-02 02:52:46'),
(3, 'Section A', 'David Kibiro', 'KNF00002', '2023-11-02 06:30:04', '2023-11-02 06:30:04');

-- --------------------------------------------------------


--
-- Dumping data for table `leaves_employees`
--

INSERT INTO `leaves_employees` (`id`, `user_id`, `leave_type`, `from_date`, `to_date`, `day`, `leave_reason`, `status`, `created_at`, `updated_at`) VALUES
(1, 'KNF00001', 'Medical Leave', '02-11-2023', '10-11-2023', '8', 'See a doctor', 'pending', '2023-11-02 02:49:46', '2023-11-02 02:49:46');

-- --------------------------------------------------------


--
-- Dumping data for table `performance_indicator_lists`
--

INSERT INTO `performance_indicator_lists` (`id`, `per_name_list`, `created_at`, `updated_at`) VALUES
(1, 'None', NULL, NULL),
(2, 'Beginner', NULL, NULL),
(3, 'Intermediate', NULL, NULL),
(4, 'Advanced', NULL, NULL),
(5, 'Expert / Leader', NULL, NULL);

-- --------------------------------------------------------


--
-- Dumping data for table `permission_lists`
--

INSERT INTO `permission_lists` (`id`, `permission_name`, `read`, `write`, `create`, `delete`, `import`, `export`) VALUES
(1, 'Holidays', 'Y', 'Y', 'Y', 'Y', 'Y', 'N'),
(2, 'Leaves', 'Y', 'Y', 'Y', 'N', 'N', 'N'),
(3, 'Clients', 'Y', 'Y', 'Y', 'N', 'N', 'N'),
(4, 'Projects', 'Y', 'N', 'Y', 'N', 'N', 'N'),
(5, 'Tasks', 'Y', 'Y', 'Y', 'Y', 'N', 'N'),
(6, 'Chats', 'Y', 'Y', 'Y', 'Y', 'N', 'N'),
(7, 'Assets', 'Y', 'Y', 'Y', 'Y', 'N', 'N'),
(8, 'Timing Sheets', 'Y', 'Y', 'Y', 'Y', 'N', 'N');



--
-- Dumping data for table `position_types`
--

INSERT INTO `position_types` (`id`, `position`, `created_at`, `updated_at`) VALUES
(1, 'CEO', NULL, NULL),
(2, 'Manager', NULL, NULL),
(3, 'Team Leader', NULL, NULL);

-- --------------------------------------------------------


--
-- Dumping data for table `roles_permissions`
--

INSERT INTO `roles_permissions` (`id`, `permissions_name`, `created_at`, `updated_at`) VALUES
(1, 'CEO', NULL, NULL),
(2, 'Manager', NULL, NULL),
(3, 'Team Leader', NULL, NULL);

-- --------------------------------------------------------

--
-- Dumping data for table `role_type_users`
--

INSERT INTO `role_type_users` (`id`, `role_type`, `created_at`, `updated_at`) VALUES
(1, 'Admin', NULL, NULL),
(2, 'Manager', NULL, NULL),
(3, 'Employee', NULL, NULL);

-- --------------------------------------------------------


INSERT INTO `sequence_tbls` (`id`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13),
(14);

-- --------------------------------------------------------


INSERT INTO `staff_salaries_paid` (`id`, `name`, `employee_id_auto`, `invoice_number`, `receipt_number`, `employee_mpesa_number`, `senders_mpesa_number`, `number_of_kgs_harvested`, `shillings_per_kg`, `amount_paid`, `status`, `created_at`, `updated_at`) VALUES
(1, 'David Kibiro', 'KNF00002', 'INV00001', 'RCDKNJ0001', '0714394333', '0722000000', '100', 8.00, 800.00, 'success', '2023-11-02 03:25:25', '2023-11-02 03:25:25'),
(2, 'David Kibiro', 'KNF00002', 'INV00001', 'RCDKNJ0002', '0714394333', '0722000000', '95', 8.00, 760.00, 'success', '2023-11-02 06:00:03', '2023-11-02 06:00:03');


--
-- Dumping data for table `type_jobs`
--

INSERT INTO `type_jobs` (`id`, `name_type_job`, `created_at`, `updated_at`) VALUES
(1, 'Full Time', NULL, NULL),
(2, 'Part Time', NULL, NULL),
(3, 'Internship', NULL, NULL),
(4, 'Temporary', NULL, NULL),
(5, 'Remote', NULL, NULL),
(6, 'Others', NULL, NULL);

-- --------------------------------------------------------

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `user_id`, `email`, `join_date`, `phone_number`, `status`, `role_name`, `avatar`, `position`, `department`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'KNF00001', 'admin@gmail.com', 'Thu, Nov 2, 2023 5:40 AM', '0722000000', 'Active', 'Admin', 'photo_defaults.jpg', NULL, 'cleaning', NULL, '$2y$10$m05N/IAZoFg86lmTSZrc2OHPzEWoqBmXlFm9dYDAjOrlD8osKs4Hm', NULL, '2023-11-02 02:40:32', '2023-11-02 02:40:32'),
(2, 'David Kibiro', 'KNF00002', 'davidkibiro@gmail.com', 'Thu, Nov 2, 2023 5:43 AM', '0714394333', 'Active', 'Employee', 'photo_defaults.jpg', NULL, 'management', NULL, '$2y$10$A8w3NXrdmThw4OkSZJeBJOmex/SrNh36NqLsv5vxVc4zwJgnU979i', NULL, '2023-11-02 02:43:11', '2023-11-02 02:43:11'),
(3, 'Samson Chacha', 'KNF00003', 'samsonchacha@gmail.com', 'Thu, Nov 2, 2023 5:46 AM', '0719947280', 'Active', 'Employee', 'photo_defaults.jpg', NULL, 'picking', NULL, '$2y$10$4VU/Lyp8sFosp8zRy48/SePql0q5.DabCOq29blaOnsrqnSeuGpNi', NULL, '2023-11-02 02:46:33', '2023-11-02 02:46:33'),
(4, 'kerefa', 'KNF00004', 'kerefa@gmail.com', 'Thu, Nov 2, 2023 5:47 AM', '0721980461', 'Active', 'Manager', 'photo_defaults.jpg', NULL, 'management', NULL, '$2y$10$iDwAVuu9ucKpgNZA9hyxkeA0.Uqyiyh7B8FrhNur.McnbomNxjlhO', NULL, '2023-11-02 02:47:08', '2023-11-02 02:48:50'),
(5, 'Consolata Gichuru', 'KNF00005', 'consolatagich@gmail.com', 'Thu, Nov 2, 2023 5:47 AM', '0721490768', 'Active', 'Manager', 'photo_defaults.jpg', NULL, 'management', NULL, '$2y$10$sp4o5NGrM.5b5/WNtXFekuwpotanYkKe0PPSzoCXdfWJwdECJf/vm', NULL, '2023-11-02 02:47:57', '2023-11-02 02:47:57'),
(6, 'Thomas Omayo', 'KNF00006', 'thomasomayo@gmail.com', 'Thu, Nov 2, 2023 8:48 AM', '0719389889', 'Active', 'Employee', 'photo_defaults.jpg', NULL, 'picking', NULL, '$2y$10$7G9FOTogUw5aBUV6pJe4oOjH3eXp8XzPs90EnXKua6O0T6mbbEqee', NULL, '2023-11-02 05:48:43', '2023-11-02 05:48:43'),
(7, 'John Njenga', 'KNF00007', 'jngenga23@gmail.com', 'Thu, Nov 2, 2023 8:49 AM', '0710380339', 'Active', 'Employee', 'photo_defaults.jpg', NULL, 'picking', NULL, '$2y$10$kIi5poKwjnKbfdOrARUbbOzC4KNH9WAjr.DtLhzOE3LYZM7UBMYdi', NULL, '2023-11-02 05:49:22', '2023-11-02 05:49:22'),
(8, 'Simon Wanderi', 'KNF00008', 'simonwanderi1989@gmail.com', 'Thu, Nov 2, 2023 8:49 AM', '0758994898', 'Active', 'Employee', 'photo_defaults.jpg', NULL, 'picking', NULL, '$2y$10$APyB18u7d5geRsvnlnylVe67KXJaNznISwEDQXTDLH/CLxD2odOVW', NULL, '2023-11-02 05:49:53', '2023-11-02 05:49:53'),
(9, 'Francis Gichohi', 'KNF00009', 'francisgichohi@gmail.com', 'Thu, Nov 2, 2023 8:50 AM', '0715998308', 'Active', 'Employee', 'photo_defaults.jpg', NULL, 'picking', NULL, '$2y$10$xKhwq0jfbq2O1bWXpK8PuuEAUpmARwjJETH6zybwyRblu0or.nz16', NULL, '2023-11-02 05:50:20', '2023-11-02 05:50:20'),
(10, 'Nancy Kimunto', 'KNF00010', 'nancykimunto@gmail.com', 'Thu, Nov 2, 2023 8:50 AM', '0749808008', 'Active', 'Employee', 'photo_defaults.jpg', NULL, 'picking', NULL, '$2y$10$VZb35mOCyb/kqPqp/j20UuA2NbCDilxTtElVcfvfAT82HKIm7csMa', NULL, '2023-11-02 05:50:47', '2023-11-02 05:50:47'),
(11, 'Robine Kerubo', 'KNF00011', 'robinekerubo49@gmail.com', 'Thu, Nov 2, 2023 8:51 AM', '0712980349', 'Active', 'Employee', 'photo_defaults.jpg', NULL, 'picking', NULL, '$2y$10$yh6HlZt1ycAZNoMDERH3yulKtC1O/UUt8ZcnZxOYT9e4hT7jaJNNW', NULL, '2023-11-02 05:51:19', '2023-11-02 05:51:19'),
(12, 'Mary Mbithe', 'KNF00012', 'marymbithe94@gmail.com', 'Thu, Nov 2, 2023 8:52 AM', '0794598008', 'Active', 'Employee', 'photo_defaults.jpg', NULL, 'picking', NULL, '$2y$10$PRVwgUAJCCG.CLbTzBkDTO2rWw8.zStPt74SLHP8b19jzuRULaAiW', NULL, '2023-11-02 05:52:28', '2023-11-02 05:52:28'),
(13, 'Mary Moraa', 'KNF00013', 'marymoraa58@gmail.com', 'Thu, Nov 2, 2023 8:52 AM', '0758080330', 'Active', 'Employee', 'photo_defaults.jpg', NULL, 'picking', NULL, '$2y$10$KqlB.YvuOHToyi74r9zr6epwbgHoc0cHoJ2xdhzN.K8mWLrF.6/4K', NULL, '2023-11-02 05:52:58', '2023-11-02 05:52:58'),
(14, 'Thomas Aunga', 'KNF00014', 'thomasaunga91@gmail.com', 'Thu, Nov 2, 2023 8:54 AM', '0791889298', 'Active', 'Employee', 'photo_defaults.jpg', NULL, 'picking', NULL, '$2y$10$r2pRDnovwRjCQoLSsrSau.T1nVki77ymKhqwR1zqakT7SLX5IIaZy', NULL, '2023-11-02 05:54:29', '2023-11-02 05:54:29');

-
--
-- Dumping data for table `user_activity_logs`
--

INSERT INTO `user_activity_logs` (`id`, `user_name`, `email`, `phone_number`, `status`, `role_name`, `modify_user`, `date_time`, `created_at`, `updated_at`) VALUES
(1, 'kerefa', 'kerefa@gmail.com', '0721980461', 'Active', 'Manager', 'Update', 'Thu, Nov 2, 2023 5:48 AM', NULL, NULL);

-- --------------------------------------------------------

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`id`, `type_name`, `created_at`, `updated_at`) VALUES
(1, 'Active', NULL, NULL),
(2, 'Inactive', NULL, NULL),
(3, 'Disable', NULL, NULL);
