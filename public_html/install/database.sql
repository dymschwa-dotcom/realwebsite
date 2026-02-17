-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 09, 2024 at 07:12 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `collabstar`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `influencer_id` int UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `username`, `email_verified_at`, `image`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admins', 'admin@site.com', 'admin', NULL, '66fa27dcf01781727670236.png', '$2y$12$vc.c.pNxefhOjFzLFNMEW.16i/h1vQCigtZeTLDY12QlIlS0KTWbm', NULL, NULL, '2024-09-29 22:23:57');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `influencer_id` int NOT NULL DEFAULT '0',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `click_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE `campaigns` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `campaign_type` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_type` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `promoting_type` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `send_product` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_creator` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `campaign_step` tinyint(1) NOT NULL DEFAULT '0',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_requirements` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `monetary_value` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `review_process` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `approval_process` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `influencer_requirements` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `budget` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `hash_tags` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `campaign_categories`
--

CREATE TABLE `campaign_categories` (
  `id` bigint NOT NULL,
  `campaign_id` int UNSIGNED NOT NULL DEFAULT '0',
  `category_id` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `campaign_conversations`
--

CREATE TABLE `campaign_conversations` (
  `id` bigint UNSIGNED NOT NULL,
  `participant_id` int UNSIGNED NOT NULL DEFAULT '0',
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `influencer_id` int UNSIGNED NOT NULL DEFAULT '0',
  `admin_id` int UNSIGNED NOT NULL DEFAULT '0',
  `sender` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `attachments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `campaign_platforms`
--

CREATE TABLE `campaign_platforms` (
  `id` bigint UNSIGNED NOT NULL,
  `campaign_id` int UNSIGNED NOT NULL DEFAULT '0',
  `platform_id` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `campaign_tags`
--

CREATE TABLE `campaign_tags` (
  `id` bigint NOT NULL,
  `campaign_id` int UNSIGNED NOT NULL DEFAULT '0',
  `tag_id` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `method_code` int UNSIGNED NOT NULL DEFAULT '0',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `method_currency` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `rate` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `final_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `btc_amount` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btc_wallet` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_try` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=>success, 2=>pending, 3=>cancel',
  `from_api` tinyint(1) NOT NULL DEFAULT '0',
  `admin_feedback` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `success_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `failed_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_cron` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `device_tokens`
--

CREATE TABLE `device_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `influencer_id` int UNSIGNED NOT NULL DEFAULT '0',
  `is_app` tinyint(1) NOT NULL DEFAULT '0',
  `token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `extensions`
--

CREATE TABLE `extensions` (
  `id` bigint UNSIGNED NOT NULL,
  `act` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `script` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `shortcode` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'object',
  `support` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'help section',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>enable, 2=>disable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `extensions`
--

INSERT INTO `extensions` (`id`, `act`, `name`, `description`, `image`, `script`, `shortcode`, `support`, `status`, `created_at`, `updated_at`) VALUES
(1, 'tawk-chat', 'Tawk.to', 'Key location is shown bellow', 'tawky_big.png', '<script>\r\n                        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();\r\n                        (function(){\r\n                        var s1=document.createElement(\"script\"),s0=document.getElementsByTagName(\"script\")[0];\r\n                        s1.async=true;\r\n                        s1.src=\"https://embed.tawk.to/{{app_key}}\";\r\n                        s1.charset=\"UTF-8\";\r\n                        s1.setAttribute(\"crossorigin\",\"*\");\r\n                        s0.parentNode.insertBefore(s1,s0);\r\n                        })();\r\n                    </script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"------\"}}', 'twak.png', 0, '2019-10-18 11:16:05', '2024-05-16 06:23:02'),
(2, 'google-recaptcha2', 'Google Recaptcha 2', 'Key location is shown bellow', 'recaptcha3.png', '\n<script src=\"https://www.google.com/recaptcha/api.js\"></script>\n<div class=\"g-recaptcha\" data-sitekey=\"{{site_key}}\" data-callback=\"verifyCaptcha\"></div>\n<div id=\"g-recaptcha-error\"></div>', '{\"site_key\":{\"title\":\"Site Key\",\"value\":\"6LdPC88fAAAAADQlUf_DV6Hrvgm-pZuLJFSLDOWV\"},\"secret_key\":{\"title\":\"Secret Key\",\"value\":\"6LdPC88fAAAAAG5SVaRYDnV2NpCrptLg2XLYKRKB\"}}', 'recaptcha.png', 0, '2019-10-18 11:16:05', '2024-10-09 00:45:38'),
(3, 'custom-captcha', 'Custom Captcha', 'Just put any random string', 'customcaptcha.png', NULL, '{\"random_key\":{\"title\":\"Random String\",\"value\":\"SecureString\"}}', 'na', 0, '2019-10-18 11:16:05', '2024-10-01 07:15:51'),
(4, 'google-analytics', 'Google Analytics', 'Key location is shown bellow', 'google_analytics.png', '<script async src=\"https://www.googletagmanager.com/gtag/js?id={{measurement_id}}\"></script>\n                <script>\n                  window.dataLayer = window.dataLayer || [];\n                  function gtag(){dataLayer.push(arguments);}\n                  gtag(\"js\", new Date());\n                \n                  gtag(\"config\", \"{{measurement_id}}\");\n                </script>', '{\"measurement_id\":{\"title\":\"Measurement ID\",\"value\":\"------\"}}', 'ganalytics.png', 0, NULL, '2021-05-03 22:19:12'),
(5, 'fb-comment', 'Facebook Comment ', 'Key location is shown bellow', 'Facebook.png', '<div id=\"fb-root\"></div><script async defer crossorigin=\"anonymous\" src=\"https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v4.0&appId={{app_key}}&autoLogAppEvents=1\"></script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"----\"}}', 'fb_com.png', 0, NULL, '2022-03-21 17:18:36');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `influencer_id` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` bigint UNSIGNED NOT NULL,
  `act` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frontends`
--

CREATE TABLE `frontends` (
  `id` bigint UNSIGNED NOT NULL,
  `data_keys` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `seo_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tempname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frontends`
--

INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `seo_content`, `tempname`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'seo.data', '{\"seo_image\":\"1\",\"keywords\":[\"collab\",\"campaign\",\"influencer\",\"marketing\",\"brand\"],\"description\":\"Discover a powerful solution for brands and influencers with CollabStar, your go-to platform for managing influencer marketing campaigns effortlessly. Whether you\'re a brand looking to increase visibility or an influencer aiming to connect with top-tier campaigns, CollabStar offers the tools and features to streamline your process.\",\"social_title\":\"CollabStar - Influencer Marketing Platform\",\"social_description\":\"Discover a powerful solution for brands and influencers with CollabStar, your go-to platform for managing influencer marketing campaigns effortlessly. Whether you\'re a brand looking to increase visibility or an influencer aiming to connect with top-tier campaigns, CollabStar offers the tools and features to streamline your process.\",\"image\":\"66fbe0ed487741727783149.png\"}', NULL, NULL, '', '2020-07-04 23:42:52', '2024-10-01 05:48:40'),
(25, 'blog.content', '{\"heading\":\"Latest Blog Post\"}', NULL, 'basic', '', '2020-10-28 00:51:34', '2024-09-01 00:06:24'),
(27, 'contact_us.content', '{\"has_image\":\"1\",\"heading\":\"Get in Touch\",\"short_description\":\"Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde tempore quaerat saepe aliquam, totam vel reiciendis error quasi voluptates.\",\"email_address\":\"demo@example.com\",\"contact_details\":\"28 Royal Mesa, New York\",\"contact_number\":\"+99-0022-0033\",\"map_link\":\"https:\\/\\/www.google.com\\/maps\\/embed?pb=!1m18!1m12!1m3!1d2310.886823714306!2d-1.2899147229705012!3d54.60598637973359!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487e8d57705b779d%3A0x5b163d0825b7670a!2sCode%20Canyon!5e0!3m2!1sen!2sbd!4v1707634430732!5m2!1sen!2sbd\",\"image\":\"67051af6220c71728387830.png\"}', NULL, 'basic', '', '2020-10-28 00:59:19', '2024-10-08 23:37:38'),
(28, 'counter.content', '{\"heading\":\"Latest News\",\"subheading\":\"Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus necessitatibus repudiandae porro reprehenderit, beatae perferendis repellat quo ipsa omnis, vitae!\"}', NULL, 'basic', NULL, '2020-10-28 01:04:02', '2024-03-13 23:54:07'),
(31, 'social_icon.element', '{\"social_icon\":\"<i class=\\\"fab fa-facebook\\\"><\\/i>\",\"url\":\"https:\\/\\/www.facebook.com\\/\"}', NULL, 'basic', '', '2020-11-12 04:07:30', '2024-09-01 04:21:39'),
(33, 'feature.content', '{\"has_image\":\"1\",\"heading\":\"Leading Global Influencer Platform\",\"image\":\"66d31084dcf831725108356.png\"}', NULL, 'basic', '', '2021-01-03 23:40:54', '2024-08-31 06:45:56'),
(34, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Return Policy\",\"description\":\"Hassle-free return policy ensures your satisfaction.\",\"image\":\"66d3109d810cd1725108381.png\"}', NULL, 'basic', '', '2021-01-03 23:41:02', '2024-09-29 01:26:47'),
(41, 'cookie.data', '{\"short_desc\":\"We may use cookies or any other tracking technologies when you visit our website, including any other media form, mobile website, or mobile application related or connected to help customize the Site and improve your experience.\",\"description\":\"<div class=\\\"mb-5\\\">\\r\\n    <h4 class=\\\"mb-2\\\">Cookie Policy<\\/h4>\\r\\n\\r\\n<p>This Cookie Policy explains how to use cookies and similar technologies to recognize you when you visit our website. It explains what these technologies are and why we use them, as well as your rights to control our use of them.<\\/p>\\r\\n\\r\\n<\\/div>\\r\\n\\r\\n<div class=\\\"mb-5\\\">\\r\\n    <h4 class=\\\"mb-2\\\">What are cookies?<\\/h4>\\r\\n\\r\\n<p>Cookies are small pieces of data stored on your computer or mobile device when you visit a website. Cookies are widely used by website owners to make their websites work, or to work more efficiently, as well as to provide reporting information.<\\/p>\\r\\n\\r\\n<\\/div>\\r\\n\\r\\n<div class=\\\"mb-5\\\">\\r\\n    <h4 class=\\\"mb-2\\\">Why do we use cookies?<\\/h4>\\r\\n\\r\\n<p>We use cookies for several reasons. Some cookies are required for technical reasons for our Website to operate, and we refer to these as \\\"essential\\\" or \\\"strictly necessary\\\" cookies. Other cookies enable us to track and target the interests of our users to enhance the experience on our Website. Third parties serve cookies through our Website for advertising, analytics, and other purposes.<\\/p>\\r\\n\\r\\n<\\/div>\\r\\n\\r\\n<div class=\\\"mb-5\\\">\\r\\n    <h4 class=\\\"mb-2\\\">What types of cookies do we use?<\\/h4>\\r\\n\\r\\n<div>\\r\\n    <ul style=\\\"list-style: unset;\\\">\\r\\n        <li>\\r\\n            <strong>Essential Website Cookies:<\\/strong> \\r\\n            These cookies are strictly necessary to provide you with services available through our Website and to use some of its features.\\r\\n        <\\/li>\\r\\n        <li>\\r\\n            <strong>Analytics and Performance Cookies:<\\/strong> \\r\\n            These cookies allow us to count visits and traffic sources to measure and improve our Website\'s performance.\\r\\n        <\\/li>\\r\\n        <li>\\r\\n            <strong>Advertising Cookies:<\\/strong> \\r\\n            These cookies make advertising messages more relevant to you and your interests. They perform functions like preventing the same ad from continuously reappearing, ensuring that ads are properly displayed, and in some cases selecting advertisements that are based on your interests.\\r\\n        <\\/li>\\r\\n    <\\/ul>\\r\\n<\\/div>\\r\\n<\\/div>\\r\\n\\r\\n<div class=\\\"mb-5\\\">\\r\\n    <h4 class=\\\"mb-2\\\">Data Collected by Cookies<\\/h4>\\r\\n<p>Cookies may collect various types of data, including but not limited to:<\\/p>\\r\\n<ul style=\\\"list-style: unset;\\\">\\r\\n    <li>IP addresses<\\/li>\\r\\n    <li>Browser and device information<\\/li>\\r\\n    <li>Referring website addresses<\\/li>\\r\\n    <li>Pages visited on our website<\\/li>\\r\\n    <li>Interactions with our website, such as clicks and mouse movements<\\/li>\\r\\n    <li>Time spent on our website<\\/li>\\r\\n<\\/ul>\\r\\n\\r\\n<\\/div>\\r\\n\\r\\n<div class=\\\"mb-5\\\">\\r\\n    <h4 class=\\\"mb-2\\\">How We Use Collected Data<\\/h4>\\r\\n\\r\\n<p>We may use data collected by cookies for the following purposes:<\\/p>\\r\\n<ul style=\\\"list-style: unset;\\\">\\r\\n    <li>To personalize your experience on our website<\\/li>\\r\\n    <li>To improve our website\'s functionality and performance<\\/li>\\r\\n    <li>To analyze trends and gather demographic information about our user base<\\/li>\\r\\n    <li>To deliver targeted advertising based on your interests<\\/li>\\r\\n    <li>To prevent fraudulent activity and enhance website security<\\/li>\\r\\n<\\/ul>\\r\\n<\\/div>\\r\\n\\r\\n<div class=\\\"mb-5\\\">\\r\\n    <h4 class=\\\"mb-2\\\">Third-party cookies<\\/h4>\\r\\n\\r\\n<p>In addition to our cookies, we may also use various third-party cookies to report usage statistics of our Website, deliver advertisements on and through our Website, and so on.<\\/p>\\r\\n\\r\\n<\\/div>\\r\\n\\r\\n\\r\\n<div class=\\\"mb-5\\\">\\r\\n    <h4 class=\\\"mb-2\\\">How can we control cookies?<\\/h4>\\r\\n\\r\\n<p>You have the right to decide whether to accept or reject cookies. You can exercise your cookie preferences by clicking on the \\\"Cookie Settings\\\" link in the footer of our website. You can also set or amend your web browser controls to accept or refuse cookies. If you choose to reject cookies, you may still use our Website though your access to some functionality and areas of our Website may be restricted.<\\/p>\\r\\n\\r\\n<\\/div>\\r\\n\\r\\n<div>\\r\\n    <h4 class=\\\"mb-2\\\">Changes to our Cookie Policy<\\/h4>\\r\\n\\r\\n<p>We may update our Cookie Policy from time to time. We will notify you of any changes by posting the new Cookie Policy on this page.<\\/p>\\r\\n<\\/div>\",\"status\":1}', NULL, NULL, NULL, '2020-07-04 23:42:52', '2024-09-29 00:45:47'),
(42, 'policy_pages.element', '{\"title\":\"Privacy Policy\",\"details\":\"<div class=\\\"mb-5\\\">\\r\\n    <h4 class=\\\"mb-2\\\">Introduction<\\/h4>\\r\\n        <p>\\r\\n            This Privacy Policy describes how we collects, uses, and discloses information, including personal information, in connection with your use of our website.\\r\\n        <\\/p>\\r\\n<\\/div>\\r\\n     \\r\\n        \\r\\n        <div class=\\\"mb-5\\\">\\r\\n            <h4 class=\\\"mb-2\\\">Information We Collect<\\/h4>\\r\\n        <p>We collect two main types of information on the Website:<\\/p>\\r\\n        <ul>\\r\\n            <li><p><strong>Personal Information: <\\/strong>This includes data that can identify you as an individual, such as your name, email address, phone number, or mailing address. We only collect this information when you voluntarily provide it to us, like signing up for a newsletter, contacting us through a form, or making a purchase.<\\/p><\\/li>\\r\\n            <li><p><strong>Non-Personal Information: <\\/strong>This data cannot be used to identify you directly. It includes details like your browser type, device type, operating system, IP address, browsing activity, and usage statistics. We collect this information automatically through cookies and other tracking technologies.<\\/p><\\/li>\\r\\n        <\\/ul>\\r\\n        <\\/div>\\r\\n     \\r\\n        \\r\\n        <div class=\\\"mb-5\\\">\\r\\n            <h4 class=\\\"mb-2\\\">How We Use Information<\\/h4>\\r\\n        <p>The information we collect allows us to:<\\/p>\\r\\n        <ul>\\r\\n            <li>Operate and maintain the Website effectively.<\\/li>\\r\\n            <li>Send you newsletters or marketing communications, but only with your consent.<\\/li>\\r\\n            <li>Respond to your inquiries and fulfill your requests.<\\/li>\\r\\n            <li>Improve the Website and your user experience.<\\/li>\\r\\n            <li>Personalize your experience on the Website based on your browsing habits.<\\/li>\\r\\n            <li>Analyze how the Website is used to improve our services.<\\/li>\\r\\n            <li>Comply with legal and regulatory requirements.<\\/li>\\r\\n        <\\/ul>\\r\\n     \\r\\n        <\\/div>\\r\\n        \\r\\n       <div class=\\\"mb-5\\\">\\r\\n        <h4 class=\\\"mb-2\\\">Sharing of Information<\\/h4>\\r\\n        <p>We may share your information with trusted third-party service providers who assist us in operating the Website and delivering our services. These providers are obligated by contract to keep your information confidential and use it only for the specific purposes we disclose it for.<\\/p>\\r\\n        <p>We will never share your personal information with any third parties for marketing purposes without your explicit consent.<\\/p>\\r\\n     \\r\\n       <\\/div>\\r\\n        \\r\\n        <div class=\\\"mb-5\\\">\\r\\n            <h4 class=\\\"mb-2\\\">Data Retention<\\/h4>\\r\\n        <p>We retain your personal information only for as long as necessary to fulfill the purposes it was collected for. We may retain it for longer periods only if required or permitted by law.<\\/p>\\r\\n     \\r\\n        <\\/div>\\r\\n        \\r\\n        <div class=\\\"mb-5\\\">\\r\\n            <h4 class=\\\"mb-2\\\">Security Measures<\\/h4>\\r\\n        <p>We take reasonable precautions to protect your information from unauthorized access, disclosure, alteration, or destruction. However, complete security cannot be guaranteed for any website or internet transmission.<\\/p>\\r\\n     \\r\\n        <\\/div>\\r\\n        \\r\\n<div>\\r\\n    <h4 class=\\\"mb-2\\\">Changes to this Privacy Policy<\\/h4>\\r\\n    <p>We may update this Privacy Policy periodically. We will notify you of any changes by posting the revised policy on the Website. We recommend reviewing this policy regularly to stay informed of any updates.<\\/p>\\r\\n    <p><strong>Remember:<\\/strong>  This is a sample policy and may need adjustments to comply with specific laws and reflect your website\'s unique data practices. Consider consulting with a legal professional to ensure your policy is fully compliant.<\\/p>\\r\\n<\\/div>\"}', NULL, 'basic', 'privacy-policy', '2021-06-09 08:50:42', '2024-09-29 00:47:44'),
(43, 'policy_pages.element', '{\"title\":\"Terms of Service\",\"details\":\"<div class=\\\"mb-5\\\">\\r\\n    <h4 class=\\\"mb-2\\\">Introduction<\\/h4>\\r\\n        <p>\\r\\n            This Privacy Policy describes how we collects, uses, and discloses information, including personal information, in connection with your use of our website.\\r\\n        <\\/p>\\r\\n<\\/div>\\r\\n     \\r\\n        \\r\\n        <div class=\\\"mb-5\\\">\\r\\n            <h4 class=\\\"mb-2\\\">Information We Collect<\\/h4>\\r\\n        <p>We collect two main types of information on the Website:<\\/p>\\r\\n        <ul>\\r\\n            <li><p><strong>Personal Information: <\\/strong>This includes data that can identify you as an individual, such as your name, email address, phone number, or mailing address. We only collect this information when you voluntarily provide it to us, like signing up for a newsletter, contacting us through a form, or making a purchase.<\\/p><\\/li>\\r\\n            <li><p><strong>Non-Personal Information: <\\/strong>This data cannot be used to identify you directly. It includes details like your browser type, device type, operating system, IP address, browsing activity, and usage statistics. We collect this information automatically through cookies and other tracking technologies.<\\/p><\\/li>\\r\\n        <\\/ul>\\r\\n        <\\/div>\\r\\n     \\r\\n        \\r\\n        <div class=\\\"mb-5\\\">\\r\\n            <h4 class=\\\"mb-2\\\">How We Use Information<\\/h4>\\r\\n        <p>The information we collect allows us to:<\\/p>\\r\\n        <ul>\\r\\n            <li>Operate and maintain the Website effectively.<\\/li>\\r\\n            <li>Send you newsletters or marketing communications, but only with your consent.<\\/li>\\r\\n            <li>Respond to your inquiries and fulfill your requests.<\\/li>\\r\\n            <li>Improve the Website and your user experience.<\\/li>\\r\\n            <li>Personalize your experience on the Website based on your browsing habits.<\\/li>\\r\\n            <li>Analyze how the Website is used to improve our services.<\\/li>\\r\\n            <li>Comply with legal and regulatory requirements.<\\/li>\\r\\n        <\\/ul>\\r\\n     \\r\\n        <\\/div>\\r\\n        \\r\\n       <div class=\\\"mb-5\\\">\\r\\n        <h4 class=\\\"mb-2\\\">Sharing of Information<\\/h4>\\r\\n        <p>We may share your information with trusted third-party service providers who assist us in operating the Website and delivering our services. These providers are obligated by contract to keep your information confidential and use it only for the specific purposes we disclose it for.<\\/p>\\r\\n        <p>We will never share your personal information with any third parties for marketing purposes without your explicit consent.<\\/p>\\r\\n     \\r\\n       <\\/div>\\r\\n        \\r\\n        <div class=\\\"mb-5\\\">\\r\\n            <h4 class=\\\"mb-2\\\">Data Retention<\\/h4>\\r\\n        <p>We retain your personal information only for as long as necessary to fulfill the purposes it was collected for. We may retain it for longer periods only if required or permitted by law.<\\/p>\\r\\n     \\r\\n        <\\/div>\\r\\n        \\r\\n        <div class=\\\"mb-5\\\">\\r\\n            <h4 class=\\\"mb-2\\\">Security Measures<\\/h4>\\r\\n        <p>We take reasonable precautions to protect your information from unauthorized access, disclosure, alteration, or destruction. However, complete security cannot be guaranteed for any website or internet transmission.<\\/p>\\r\\n     \\r\\n        <\\/div>\\r\\n        \\r\\n<div>\\r\\n    <h4 class=\\\"mb-2\\\">Changes to this Privacy Policy<\\/h4>\\r\\n    <p>We may update this Privacy Policy periodically. We will notify you of any changes by posting the revised policy on the Website. We recommend reviewing this policy regularly to stay informed of any updates.<\\/p>\\r\\n    <p><strong>Remember:<\\/strong>  This is a sample policy and may need adjustments to comply with specific laws and reflect your website\'s unique data practices. Consider consulting with a legal professional to ensure your policy is fully compliant.<\\/p>\\r\\n<\\/div>\"}', NULL, 'basic', 'terms-of-service', '2021-06-09 08:51:18', '2024-09-29 00:47:53'),
(44, 'maintenance.data', '{\"description\":\"<div><h3 class=\\\"mb-3\\\" style=\\\"text-align: center; \\\">THE SITE IS UNDER MAINTENANCE<\\/h3><p style=\\\"text-align: center; \\\">We\'re just tuning up a few things.We apologize for the inconvenience but Front is currently undergoing planned maintenance. Thanks for your patience.<\\/p><\\/div>\",\"image\":\"6603c203472ad1711522307.png\"}', NULL, NULL, NULL, '2020-07-04 23:42:52', '2024-10-01 05:58:55'),
(52, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Morbi ac felis. In ut quam vitae odio lacinia tincidunt.\",\"description\":\"<h6 class=\\\"m-0\\\">The Reactive Model of Service Centers: Addressing Issues After They Arise<\\/h6>\\r\\n<div>The landscape of service center automation has undergone a remarkable transformation over the past few decades,\\r\\n    shifting from reactive to proactive approaches. Initially, service centers operated on a reactive model, primarily\\r\\n    addressing issues only after they arose. This method often involved responding to customer complaints and\\r\\n    troubleshooting problems as they emerged, leading to higher levels of downtime and customer dissatisfaction. The\\r\\n    focus was largely on fixing problems rather than preventing them, which created a cycle of continuous reaction to\\r\\n    service issues.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<blockquote style=\\\"font-style:italic;text-align:center;padding:20px;background:#ffeaef;font-weight:500;font-size:18px;border-left:4px solid #df3459;\\\">\\r\\n    Aenean metus lectus at id. Morbi aliquet commodo a sodales eget. Eu justo ante nibh et a turpis, aliquam phasellus\\r\\n    hymenaeos, imperdiet eget cras sociosqu, tincidunt a amet. Faucibus urna luctus, arcu ni<\\/blockquote>\\r\\n<h6 class=\\\"m-0\\\">Shifting Paradigms: The Move Toward Proactive Service Models<\\/h6>\\r\\n<div>As technology advanced, the paradigm began to shift towards a more proactive approach. The rise of advanced data\\r\\n    analytics and machine learning techniques enabled service centers to anticipate potential issues before they\\r\\n    occurred. By analyzing historical data and recognizing patterns, service centers could now predict when equipment\\r\\n    might fail or when a system could encounter problems. This shift not only reduced the frequency of unexpected\\r\\n    disruptions but also improved overall operational efficiency. Predictive maintenance became a key feature of\\r\\n    proactive service centers, allowing them to schedule maintenance activities during non-peak hours and address issues\\r\\n    before they impacted the customer experience.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Harnessing Data Analytics and Machine Learning for Predictive Maintenance<\\/h6>\\r\\n<div>This evolution was further accelerated by the integration of artificial intelligence (AI) and automation tools.\\r\\n    AI-driven systems can now monitor and analyze real-time data from various sources, providing insights into potential\\r\\n    issues and suggesting preventive measures. Automation tools facilitate swift responses to identified issues, often\\r\\n    without the need for human intervention. For instance, automated systems can initiate repairs or adjustments based\\r\\n    on predefined parameters, ensuring that minor issues are resolved before they escalate into significant problems.\\r\\n<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">The Role of AI and Automation in Revolutionizing Service Center Operations<\\/h6>\\r\\n<div>The proactive approach not only enhances operational efficiency but also fosters a more positive customer\\r\\n    experience. By addressing potential issues before they impact customers, service centers can ensure a higher level\\r\\n    of service continuity and reliability. Customers benefit from fewer disruptions and a more streamlined experience,\\r\\n    leading to increased satisfaction and loyalty.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Enhancing Customer Experience Through Proactive Service Strategies<\\/h6>\\r\\n<div>In essence, the evolution from a reactive to a proactive model in service center automation represents a\\r\\n    significant leap forward. It highlights the importance of leveraging advanced technologies to not only address\\r\\n    problems but to anticipate and prevent them, ultimately leading to a more efficient and customer-centric operation.\\r\\n    As technology continues to evolve, service centers will likely see even more sophisticated solutions that further\\r\\n    enhance their ability to provide seamless and proactive service.<\\/div>\",\"image\":\"66d4049155b171725170833.png\"}', NULL, 'basic', 'morbi-ac-felis-in-ut-quam-vitae-odio-lacinia-tincidunt', '2024-03-23 06:52:04', '2024-10-01 06:03:10'),
(55, 'counter.content', '{\"heading\":\"Latest Newsss\",\"subheading\":\"Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus necessitatibus repudiandae porro reprehenderit, beatae perferendis repellat quo ipsa omnis, vitae!\"}', NULL, 'basic', '', '2024-04-21 01:13:50', '2024-04-21 01:13:50'),
(56, 'counter.content', '{\"heading\":\"Latest News\",\"subheading\":\"Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloribus necessitatibus repudiandae porro reprehenderit, beatae perferendis repellat quo ipsa omnis, vitae!\"}', NULL, 'basic', '', '2024-04-21 01:13:52', '2024-04-21 01:13:52'),
(62, 'blog.content', '{\"heading\":\"Latest News\",\"subheading\":\"------\"}', NULL, 'basic', '', '2024-04-30 07:31:30', '2024-04-30 07:31:30'),
(64, 'banner.content', '{\"has_image\":\"1\",\"heading\":\"First Influencer Hiring Platform in The World\",\"subheading\":\"Join a thriving community, connect with top brands, and take your influence to new heights\",\"button_name\":\"Register as Influencer\",\"button_url\":\"influencer\\/register\",\"image\":\"66d303643904f1725104996.png\"}', NULL, 'basic', '', '2024-05-01 00:06:45', '2024-08-31 05:49:56'),
(65, 'faq.element', '{\"question\":\"What is an Influencer Marketing Platform?\",\"answer\":\"An Influencer Marketing Platform is a digital tool or service that connects brands with influencers, facilitating collaboration, content creation, and marketing campaigns.\"}', NULL, 'basic', '', '2024-05-04 00:21:20', '2024-09-01 03:06:10'),
(67, 'partner.element', '{\"has_image\":\"1\",\"image\":\"66f8fb21f38341727593249.png\"}', NULL, 'basic', '', '2024-08-31 04:58:36', '2024-09-29 01:00:50'),
(68, 'partner.element', '{\"has_image\":\"1\",\"image\":\"66f8fb1c032951727593244.png\"}', NULL, 'basic', '', '2024-08-31 04:59:24', '2024-09-29 01:00:44'),
(69, 'partner.element', '{\"has_image\":\"1\",\"image\":\"66f8fb16751881727593238.png\"}', NULL, 'basic', '', '2024-08-31 04:59:29', '2024-09-29 01:00:38'),
(70, 'partner.element', '{\"has_image\":\"1\",\"image\":\"66f8fb11816251727593233.png\"}', NULL, 'basic', '', '2024-08-31 04:59:35', '2024-09-29 01:00:33'),
(71, 'partner.element', '{\"has_image\":\"1\",\"image\":\"66f8fb0ccbe7f1727593228.png\"}', NULL, 'basic', '', '2024-08-31 04:59:41', '2024-09-29 01:00:28'),
(72, 'partner.element', '{\"has_image\":\"1\",\"image\":\"66f8fb0759e221727593223.png\"}', NULL, 'basic', '', '2024-08-31 04:59:47', '2024-09-29 01:00:23'),
(73, 'partner.element', '{\"has_image\":\"1\",\"image\":\"66f8fb02322f11727593218.png\"}', NULL, 'basic', '', '2024-08-31 04:59:52', '2024-09-29 01:00:18'),
(74, 'category.content', '{\"heading\":\"Get Influencer in Different Categories\"}', NULL, 'basic', '', '2024-08-31 05:56:48', '2024-08-31 05:56:48'),
(75, 'top_influencer.content', '{\"heading\":\"Our Top Influencers\"}', NULL, 'basic', '', '2024-08-31 06:15:37', '2024-08-31 06:15:37'),
(76, 'how_work.content', '{\"heading\":\"How does infulab work?\",\"button_name\":\"Register as Brand\",\"button_url\":\"\\/brand\\/register\"}', NULL, 'basic', '', '2024-08-31 06:21:58', '2024-09-29 01:17:09'),
(79, 'how_work.element', '{\"has_image\":\"1\",\"heading\":\"Influence Unleashed\",\"subheading\":\"Witness your brand flourish as passionate influencers bring it to life with creativity and purpose.\",\"image\":\"66d30b98267f81725107096.png\"}', NULL, 'basic', '', '2024-08-31 06:24:56', '2024-09-29 01:16:50'),
(80, 'how_work.element', '{\"has_image\":\"1\",\"heading\":\"Create Campaign\",\"subheading\":\"Empower your brand with an impactful campaign. Define objectives, set budgets, and engage with influencers.\",\"image\":\"66d30badb8d681725107117.png\"}', NULL, 'basic', '', '2024-08-31 06:25:17', '2024-08-31 06:25:17'),
(81, 'how_work.element', '{\"has_image\":\"1\",\"heading\":\"Complete Profile\",\"subheading\":\"Create a standout profile to connect with influencers and reach your target audience effectively.\",\"image\":\"66d30bc1df01e1725107137.png\"}', NULL, 'basic', '', '2024-08-31 06:25:37', '2024-08-31 06:25:37'),
(82, 'how_work.element', '{\"has_image\":\"1\",\"heading\":\"Create Account\",\"subheading\":\"Register your brand today to unlock a world of opportunities for collaboration and increased visibility.\",\"image\":\"66d30be313c431725107171.png\"}', NULL, 'basic', '', '2024-08-31 06:26:11', '2024-09-29 01:15:38'),
(83, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Creative Social\",\"description\":\"Unlock brand\'s creative potential with our social solutions.\",\"image\":\"66d310b2d4f781725108402.png\"}', NULL, 'basic', '', '2024-08-31 06:46:42', '2024-09-29 01:27:22'),
(84, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Top Rated Influencers\",\"description\":\"Partner with the industry\'s best influencers.\",\"image\":\"66d310c6569371725108422.png\"}', NULL, 'basic', '', '2024-08-31 06:47:02', '2024-08-31 06:47:02'),
(85, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Advanced Analysis\",\"description\":\"Harness the power of data for informed decisions and growth\",\"image\":\"66d310e0473791725108448.png\"}', NULL, 'basic', '', '2024-08-31 06:47:28', '2024-08-31 06:47:28'),
(86, 'feature.element', '{\"has_image\":\"1\",\"title\":\"Simplify Payments\",\"description\":\"Effortless payment solutions for your convenience.\",\"image\":\"66d310f69f9ec1725108470.png\"}', NULL, 'basic', '', '2024-08-31 06:47:50', '2024-08-31 06:47:50'),
(87, 'feature.element', '{\"has_image\":\"1\",\"title\":\"World Wide\",\"description\":\"Influencer opportunities for worldwide growth\",\"image\":\"66d311138b5aa1725108499.png\"}', NULL, 'basic', '', '2024-08-31 06:48:19', '2024-09-29 01:27:41'),
(88, 'counter.element', '{\"title\":\"Categories\",\"counter_digit\":\"15\",\"counter_symbol\":\"+\"}', NULL, 'basic', '', '2024-08-31 07:00:02', '2024-08-31 07:00:02'),
(89, 'counter.element', '{\"title\":\"Job Completed\",\"counter_digit\":\"3000\",\"counter_symbol\":\"+\"}', NULL, 'basic', '', '2024-08-31 07:00:23', '2024-08-31 07:00:23'),
(90, 'counter.element', '{\"title\":\"Total Client\",\"counter_digit\":\"100\",\"counter_symbol\":\"k\"}', NULL, 'basic', '', '2024-08-31 07:00:34', '2024-08-31 07:00:34'),
(91, 'counter.element', '{\"title\":\"Influencers\",\"counter_digit\":\"130\",\"counter_symbol\":\"k\"}', NULL, 'basic', '', '2024-08-31 07:00:49', '2024-08-31 07:00:49'),
(92, 'testimonial.content', '{\"heading\":\"Our Achievements From Clients\"}', NULL, 'basic', '', '2024-08-31 07:48:10', '2024-08-31 07:48:10'),
(93, 'testimonial.element', '{\"has_image\":[\"1\"],\"quote\":\"We relied on infulab for influencer partnerships, and it exceeded our expectations. The platform\'s user-friendly interface, insightful data, and efficient collaboration tools helped us achieve remarkable results. A must-have for any advertiser!\",\"name\":\"Quentin Edwards\",\"designation\":\"UI\\/UX Designer\",\"image\":\"66d31f32d7ec41725112114.png\"}', NULL, 'basic', '', '2024-08-31 07:48:34', '2024-08-31 07:48:34'),
(94, 'testimonial.element', '{\"has_image\":[\"1\"],\"quote\":\"Infulab revolutionized our approach to influencer marketing. With its comprehensive profiles and streamlined communication, we found influencers aligned with our brand seamlessly. It\'s a game-changer in the industry, highly recommended.\",\"name\":\"Maia Bridges\",\"designation\":\"System Engineer\",\"image\":\"66d31f4f00d521725112143.png\"}', NULL, 'basic', '', '2024-08-31 07:49:02', '2024-08-31 07:49:03'),
(95, 'testimonial.element', '{\"has_image\":[\"1\"],\"quote\":\"Thanks to infulab, influencer collaboration became effortless. The platform\'s intuitive interface, rich analytics, and seamless negotiation tools ensured we partnered with influencers who truly resonate with our audience. Exceptional service!\\\"\",\"name\":\"Manix Hanson\",\"designation\":\"Web Developer\",\"image\":\"66d31f627534a1725112162.png\"}', NULL, 'basic', '', '2024-08-31 07:49:22', '2024-08-31 07:49:22'),
(96, 'testimonial.element', '{\"has_image\":[\"1\"],\"quote\":\"Discovering infulab transformed our influencer marketing strategy. Easy search, detailed insights, and smooth communication empowered us to connect with influencers authentically. It\'s our go-to for impactful campaigns\",\"name\":\"Mark Thompson\",\"designation\":\"Marketing Manager\",\"image\":\"66d31f751c37c1725112181.png\"}', NULL, 'basic', '', '2024-08-31 07:49:41', '2024-08-31 07:49:41'),
(97, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Morbi mollis tellus ac sapien Phasellus volutpat, metus eget egestas\",\"description\":\"<h6 class=\\\"m-0\\\">The Reactive Model of Service Centers: Addressing Issues After They Arise<\\/h6>\\r\\n<div>The landscape of service center automation has undergone a remarkable transformation over the past few decades,\\r\\n    shifting from reactive to proactive approaches. Initially, service centers operated on a reactive model, primarily\\r\\n    addressing issues only after they arose. This method often involved responding to customer complaints and\\r\\n    troubleshooting problems as they emerged, leading to higher levels of downtime and customer dissatisfaction. The\\r\\n    focus was largely on fixing problems rather than preventing them, which created a cycle of continuous reaction to\\r\\n    service issues.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<blockquote style=\\\"font-style:italic;text-align:center;padding:20px;background:#ffeaef;font-weight:500;font-size:18px;border-left:4px solid #df3459;\\\">\\r\\n    Aenean metus lectus at id. Morbi aliquet commodo a sodales eget. Eu justo ante nibh et a turpis, aliquam phasellus\\r\\n    hymenaeos, imperdiet eget cras sociosqu, tincidunt a amet. Faucibus urna luctus, arcu ni<\\/blockquote>\\r\\n<h6 class=\\\"m-0\\\">Shifting Paradigms: The Move Toward Proactive Service Models<\\/h6>\\r\\n<div>As technology advanced, the paradigm began to shift towards a more proactive approach. The rise of advanced data\\r\\n    analytics and machine learning techniques enabled service centers to anticipate potential issues before they\\r\\n    occurred. By analyzing historical data and recognizing patterns, service centers could now predict when equipment\\r\\n    might fail or when a system could encounter problems. This shift not only reduced the frequency of unexpected\\r\\n    disruptions but also improved overall operational efficiency. Predictive maintenance became a key feature of\\r\\n    proactive service centers, allowing them to schedule maintenance activities during non-peak hours and address issues\\r\\n    before they impacted the customer experience.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Harnessing Data Analytics and Machine Learning for Predictive Maintenance<\\/h6>\\r\\n<div>This evolution was further accelerated by the integration of artificial intelligence (AI) and automation tools.\\r\\n    AI-driven systems can now monitor and analyze real-time data from various sources, providing insights into potential\\r\\n    issues and suggesting preventive measures. Automation tools facilitate swift responses to identified issues, often\\r\\n    without the need for human intervention. For instance, automated systems can initiate repairs or adjustments based\\r\\n    on predefined parameters, ensuring that minor issues are resolved before they escalate into significant problems.\\r\\n<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">The Role of AI and Automation in Revolutionizing Service Center Operations<\\/h6>\\r\\n<div>The proactive approach not only enhances operational efficiency but also fosters a more positive customer\\r\\n    experience. By addressing potential issues before they impact customers, service centers can ensure a higher level\\r\\n    of service continuity and reliability. Customers benefit from fewer disruptions and a more streamlined experience,\\r\\n    leading to increased satisfaction and loyalty.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Enhancing Customer Experience Through Proactive Service Strategies<\\/h6>\\r\\n<div>In essence, the evolution from a reactive to a proactive model in service center automation represents a\\r\\n    significant leap forward. It highlights the importance of leveraging advanced technologies to not only address\\r\\n    problems but to anticipate and prevent them, ultimately leading to a more efficient and customer-centric operation.\\r\\n    As technology continues to evolve, service centers will likely see even more sophisticated solutions that further\\r\\n    enhance their ability to provide seamless and proactive service.<\\/div>\",\"image\":\"66d404cdc1d581725170893.png\"}', NULL, 'basic', 'morbi-mollis-tellus-ac-sapien-phasellus-volutpat-metus-eget-egestas', '2024-09-24 00:08:13', '2024-10-01 06:02:50'),
(98, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Etiam sit amet orci eget eros faucibus tincidunt\",\"description\":\"<h6 class=\\\"m-0\\\">The Reactive Model of Service Centers: Addressing Issues After They Arise<\\/h6>\\r\\n<div>The landscape of service center automation has undergone a remarkable transformation over the past few decades,\\r\\n    shifting from reactive to proactive approaches. Initially, service centers operated on a reactive model, primarily\\r\\n    addressing issues only after they arose. This method often involved responding to customer complaints and\\r\\n    troubleshooting problems as they emerged, leading to higher levels of downtime and customer dissatisfaction. The\\r\\n    focus was largely on fixing problems rather than preventing them, which created a cycle of continuous reaction to\\r\\n    service issues.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<blockquote style=\\\"font-style:italic;text-align:center;padding:20px;background:#ffeaef;font-weight:500;font-size:18px;border-left:4px solid #df3459;\\\">\\r\\n    Aenean metus lectus at id. Morbi aliquet commodo a sodales eget. Eu justo ante nibh et a turpis, aliquam phasellus\\r\\n    hymenaeos, imperdiet eget cras sociosqu, tincidunt a amet. Faucibus urna luctus, arcu ni<\\/blockquote>\\r\\n<h6 class=\\\"m-0\\\">Shifting Paradigms: The Move Toward Proactive Service Models<\\/h6>\\r\\n<div>As technology advanced, the paradigm began to shift towards a more proactive approach. The rise of advanced data\\r\\n    analytics and machine learning techniques enabled service centers to anticipate potential issues before they\\r\\n    occurred. By analyzing historical data and recognizing patterns, service centers could now predict when equipment\\r\\n    might fail or when a system could encounter problems. This shift not only reduced the frequency of unexpected\\r\\n    disruptions but also improved overall operational efficiency. Predictive maintenance became a key feature of\\r\\n    proactive service centers, allowing them to schedule maintenance activities during non-peak hours and address issues\\r\\n    before they impacted the customer experience.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Harnessing Data Analytics and Machine Learning for Predictive Maintenance<\\/h6>\\r\\n<div>This evolution was further accelerated by the integration of artificial intelligence (AI) and automation tools.\\r\\n    AI-driven systems can now monitor and analyze real-time data from various sources, providing insights into potential\\r\\n    issues and suggesting preventive measures. Automation tools facilitate swift responses to identified issues, often\\r\\n    without the need for human intervention. For instance, automated systems can initiate repairs or adjustments based\\r\\n    on predefined parameters, ensuring that minor issues are resolved before they escalate into significant problems.\\r\\n<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">The Role of AI and Automation in Revolutionizing Service Center Operations<\\/h6>\\r\\n<div>The proactive approach not only enhances operational efficiency but also fosters a more positive customer\\r\\n    experience. By addressing potential issues before they impact customers, service centers can ensure a higher level\\r\\n    of service continuity and reliability. Customers benefit from fewer disruptions and a more streamlined experience,\\r\\n    leading to increased satisfaction and loyalty.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Enhancing Customer Experience Through Proactive Service Strategies<\\/h6>\\r\\n<div>In essence, the evolution from a reactive to a proactive model in service center automation represents a\\r\\n    significant leap forward. It highlights the importance of leveraging advanced technologies to not only address\\r\\n    problems but to anticipate and prevent them, ultimately leading to a more efficient and customer-centric operation.\\r\\n    As technology continues to evolve, service centers will likely see even more sophisticated solutions that further\\r\\n    enhance their ability to provide seamless and proactive service.<\\/div>\",\"image\":\"66d4050bdfe421725170955.png\"}', NULL, 'basic', 'etiam-sit-amet-orci-eget-eros-faucibus-tincidunt', '2024-09-25 00:09:15', '2024-10-01 06:02:18'),
(99, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Quisque rutrum. Pellentesque habitant morbi tristique senectus\",\"description\":\"<h6 class=\\\"m-0\\\">The Reactive Model of Service Centers: Addressing Issues After They Arise<\\/h6>\\r\\n<div>The landscape of service center automation has undergone a remarkable transformation over the past few decades,\\r\\n    shifting from reactive to proactive approaches. Initially, service centers operated on a reactive model, primarily\\r\\n    addressing issues only after they arose. This method often involved responding to customer complaints and\\r\\n    troubleshooting problems as they emerged, leading to higher levels of downtime and customer dissatisfaction. The\\r\\n    focus was largely on fixing problems rather than preventing them, which created a cycle of continuous reaction to\\r\\n    service issues.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<blockquote style=\\\"font-style:italic;text-align:center;padding:20px;background:#ffeaef;font-weight:500;font-size:18px;border-left:4px solid #df3459;\\\">\\r\\n    Aenean metus lectus at id. Morbi aliquet commodo a sodales eget. Eu justo ante nibh et a turpis, aliquam phasellus\\r\\n    hymenaeos, imperdiet eget cras sociosqu, tincidunt a amet. Faucibus urna luctus, arcu ni<\\/blockquote>\\r\\n<h6 class=\\\"m-0\\\">Shifting Paradigms: The Move Toward Proactive Service Models<\\/h6>\\r\\n<div>As technology advanced, the paradigm began to shift towards a more proactive approach. The rise of advanced data\\r\\n    analytics and machine learning techniques enabled service centers to anticipate potential issues before they\\r\\n    occurred. By analyzing historical data and recognizing patterns, service centers could now predict when equipment\\r\\n    might fail or when a system could encounter problems. This shift not only reduced the frequency of unexpected\\r\\n    disruptions but also improved overall operational efficiency. Predictive maintenance became a key feature of\\r\\n    proactive service centers, allowing them to schedule maintenance activities during non-peak hours and address issues\\r\\n    before they impacted the customer experience.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Harnessing Data Analytics and Machine Learning for Predictive Maintenance<\\/h6>\\r\\n<div>This evolution was further accelerated by the integration of artificial intelligence (AI) and automation tools.\\r\\n    AI-driven systems can now monitor and analyze real-time data from various sources, providing insights into potential\\r\\n    issues and suggesting preventive measures. Automation tools facilitate swift responses to identified issues, often\\r\\n    without the need for human intervention. For instance, automated systems can initiate repairs or adjustments based\\r\\n    on predefined parameters, ensuring that minor issues are resolved before they escalate into significant problems.\\r\\n<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">The Role of AI and Automation in Revolutionizing Service Center Operations<\\/h6>\\r\\n<div>The proactive approach not only enhances operational efficiency but also fosters a more positive customer\\r\\n    experience. By addressing potential issues before they impact customers, service centers can ensure a higher level\\r\\n    of service continuity and reliability. Customers benefit from fewer disruptions and a more streamlined experience,\\r\\n    leading to increased satisfaction and loyalty.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Enhancing Customer Experience Through Proactive Service Strategies<\\/h6>\\r\\n<div>In essence, the evolution from a reactive to a proactive model in service center automation represents a\\r\\n    significant leap forward. It highlights the importance of leveraging advanced technologies to not only address\\r\\n    problems but to anticipate and prevent them, ultimately leading to a more efficient and customer-centric operation.\\r\\n    As technology continues to evolve, service centers will likely see even more sophisticated solutions that further\\r\\n    enhance their ability to provide seamless and proactive service.<\\/div>\",\"image\":\"66d4054622eef1725171014.png\"}', NULL, 'basic', 'quisque-rutrum-pellentesque-habitant-morbi-tristique-senectus', '2024-09-26 00:10:14', '2024-10-01 06:02:03'),
(100, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Praesent ac sem eget est egestas volutpat Nullam dictur\",\"description\":\"<h6 class=\\\"m-0\\\">The Reactive Model of Service Centers: Addressing Issues After They Arise<\\/h6>\\r\\n<div>The landscape of service center automation has undergone a remarkable transformation over the past few decades,\\r\\n    shifting from reactive to proactive approaches. Initially, service centers operated on a reactive model, primarily\\r\\n    addressing issues only after they arose. This method often involved responding to customer complaints and\\r\\n    troubleshooting problems as they emerged, leading to higher levels of downtime and customer dissatisfaction. The\\r\\n    focus was largely on fixing problems rather than preventing them, which created a cycle of continuous reaction to\\r\\n    service issues.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<blockquote style=\\\"font-style:italic;text-align:center;padding:20px;background:#ffeaef;font-weight:500;font-size:18px;border-left:4px solid #df3459;\\\">\\r\\n    Aenean metus lectus at id. Morbi aliquet commodo a sodales eget. Eu justo ante nibh et a turpis, aliquam phasellus\\r\\n    hymenaeos, imperdiet eget cras sociosqu, tincidunt a amet. Faucibus urna luctus, arcu ni<\\/blockquote>\\r\\n<h6 class=\\\"m-0\\\">Shifting Paradigms: The Move Toward Proactive Service Models<\\/h6>\\r\\n<div>As technology advanced, the paradigm began to shift towards a more proactive approach. The rise of advanced data\\r\\n    analytics and machine learning techniques enabled service centers to anticipate potential issues before they\\r\\n    occurred. By analyzing historical data and recognizing patterns, service centers could now predict when equipment\\r\\n    might fail or when a system could encounter problems. This shift not only reduced the frequency of unexpected\\r\\n    disruptions but also improved overall operational efficiency. Predictive maintenance became a key feature of\\r\\n    proactive service centers, allowing them to schedule maintenance activities during non-peak hours and address issues\\r\\n    before they impacted the customer experience.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Harnessing Data Analytics and Machine Learning for Predictive Maintenance<\\/h6>\\r\\n<div>This evolution was further accelerated by the integration of artificial intelligence (AI) and automation tools.\\r\\n    AI-driven systems can now monitor and analyze real-time data from various sources, providing insights into potential\\r\\n    issues and suggesting preventive measures. Automation tools facilitate swift responses to identified issues, often\\r\\n    without the need for human intervention. For instance, automated systems can initiate repairs or adjustments based\\r\\n    on predefined parameters, ensuring that minor issues are resolved before they escalate into significant problems.\\r\\n<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">The Role of AI and Automation in Revolutionizing Service Center Operations<\\/h6>\\r\\n<div>The proactive approach not only enhances operational efficiency but also fosters a more positive customer\\r\\n    experience. By addressing potential issues before they impact customers, service centers can ensure a higher level\\r\\n    of service continuity and reliability. Customers benefit from fewer disruptions and a more streamlined experience,\\r\\n    leading to increased satisfaction and loyalty.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Enhancing Customer Experience Through Proactive Service Strategies<\\/h6>\\r\\n<div>In essence, the evolution from a reactive to a proactive model in service center automation represents a\\r\\n    significant leap forward. It highlights the importance of leveraging advanced technologies to not only address\\r\\n    problems but to anticipate and prevent them, ultimately leading to a more efficient and customer-centric operation.\\r\\n    As technology continues to evolve, service centers will likely see even more sophisticated solutions that further\\r\\n    enhance their ability to provide seamless and proactive service.<\\/div>\",\"image\":\"66d4056b13db41725171051.png\"}', NULL, 'basic', 'praesent-ac-sem-eget-est-egestas-volutpat-nullam-dictur', '2024-09-27 00:10:51', '2024-10-01 06:01:53');
INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `seo_content`, `tempname`, `slug`, `created_at`, `updated_at`) VALUES
(101, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Suspendisse pulvinar, augue ac venenatis condimentum.\",\"description\":\"<h6 class=\\\"m-0\\\">The Reactive Model of Service Centers: Addressing Issues After They Arise<\\/h6>\\r\\n<div>The landscape of service center automation has undergone a remarkable transformation over the past few decades,\\r\\n    shifting from reactive to proactive approaches. Initially, service centers operated on a reactive model, primarily\\r\\n    addressing issues only after they arose. This method often involved responding to customer complaints and\\r\\n    troubleshooting problems as they emerged, leading to higher levels of downtime and customer dissatisfaction. The\\r\\n    focus was largely on fixing problems rather than preventing them, which created a cycle of continuous reaction to\\r\\n    service issues.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<blockquote style=\\\"font-style:italic;text-align:center;padding:20px;background:#ffeaef;font-weight:500;font-size:18px;border-left:4px solid #df3459;\\\">\\r\\n    Aenean metus lectus at id. Morbi aliquet commodo a sodales eget. Eu justo ante nibh et a turpis, aliquam phasellus\\r\\n    hymenaeos, imperdiet eget cras sociosqu, tincidunt a amet. Faucibus urna luctus, arcu ni<\\/blockquote>\\r\\n<h6 class=\\\"m-0\\\">Shifting Paradigms: The Move Toward Proactive Service Models<\\/h6>\\r\\n<div>As technology advanced, the paradigm began to shift towards a more proactive approach. The rise of advanced data\\r\\n    analytics and machine learning techniques enabled service centers to anticipate potential issues before they\\r\\n    occurred. By analyzing historical data and recognizing patterns, service centers could now predict when equipment\\r\\n    might fail or when a system could encounter problems. This shift not only reduced the frequency of unexpected\\r\\n    disruptions but also improved overall operational efficiency. Predictive maintenance became a key feature of\\r\\n    proactive service centers, allowing them to schedule maintenance activities during non-peak hours and address issues\\r\\n    before they impacted the customer experience.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Harnessing Data Analytics and Machine Learning for Predictive Maintenance<\\/h6>\\r\\n<div>This evolution was further accelerated by the integration of artificial intelligence (AI) and automation tools.\\r\\n    AI-driven systems can now monitor and analyze real-time data from various sources, providing insights into potential\\r\\n    issues and suggesting preventive measures. Automation tools facilitate swift responses to identified issues, often\\r\\n    without the need for human intervention. For instance, automated systems can initiate repairs or adjustments based\\r\\n    on predefined parameters, ensuring that minor issues are resolved before they escalate into significant problems.\\r\\n<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">The Role of AI and Automation in Revolutionizing Service Center Operations<\\/h6>\\r\\n<div>The proactive approach not only enhances operational efficiency but also fosters a more positive customer\\r\\n    experience. By addressing potential issues before they impact customers, service centers can ensure a higher level\\r\\n    of service continuity and reliability. Customers benefit from fewer disruptions and a more streamlined experience,\\r\\n    leading to increased satisfaction and loyalty.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Enhancing Customer Experience Through Proactive Service Strategies<\\/h6>\\r\\n<div>In essence, the evolution from a reactive to a proactive model in service center automation represents a\\r\\n    significant leap forward. It highlights the importance of leveraging advanced technologies to not only address\\r\\n    problems but to anticipate and prevent them, ultimately leading to a more efficient and customer-centric operation.\\r\\n    As technology continues to evolve, service centers will likely see even more sophisticated solutions that further\\r\\n    enhance their ability to provide seamless and proactive service.<\\/div>\",\"image\":\"66d4058e9fe641725171086.png\"}', NULL, 'basic', 'suspendisse-pulvinar-augue-ac-venenatis-condimentum', '2024-09-28 00:11:26', '2024-10-01 06:01:44'),
(102, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Duis lobortis massa imperdiet quam. Nunc egestas, augue\",\"description\":\"<h6 class=\\\"m-0\\\">The Reactive Model of Service Centers: Addressing Issues After They Arise<\\/h6>\\r\\n<div>The landscape of service center automation has undergone a remarkable transformation over the past few decades,\\r\\n    shifting from reactive to proactive approaches. Initially, service centers operated on a reactive model, primarily\\r\\n    addressing issues only after they arose. This method often involved responding to customer complaints and\\r\\n    troubleshooting problems as they emerged, leading to higher levels of downtime and customer dissatisfaction. The\\r\\n    focus was largely on fixing problems rather than preventing them, which created a cycle of continuous reaction to\\r\\n    service issues.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<blockquote style=\\\"font-style:italic;text-align:center;padding:20px;background:#ffeaef;font-weight:500;font-size:18px;border-left:4px solid #df3459;\\\">\\r\\n    Aenean metus lectus at id. Morbi aliquet commodo a sodales eget. Eu justo ante nibh et a turpis, aliquam phasellus\\r\\n    hymenaeos, imperdiet eget cras sociosqu, tincidunt a amet. Faucibus urna luctus, arcu ni<\\/blockquote>\\r\\n<h6 class=\\\"m-0\\\">Shifting Paradigms: The Move Toward Proactive Service Models<\\/h6>\\r\\n<div>As technology advanced, the paradigm began to shift towards a more proactive approach. The rise of advanced data\\r\\n    analytics and machine learning techniques enabled service centers to anticipate potential issues before they\\r\\n    occurred. By analyzing historical data and recognizing patterns, service centers could now predict when equipment\\r\\n    might fail or when a system could encounter problems. This shift not only reduced the frequency of unexpected\\r\\n    disruptions but also improved overall operational efficiency. Predictive maintenance became a key feature of\\r\\n    proactive service centers, allowing them to schedule maintenance activities during non-peak hours and address issues\\r\\n    before they impacted the customer experience.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Harnessing Data Analytics and Machine Learning for Predictive Maintenance<\\/h6>\\r\\n<div>This evolution was further accelerated by the integration of artificial intelligence (AI) and automation tools.\\r\\n    AI-driven systems can now monitor and analyze real-time data from various sources, providing insights into potential\\r\\n    issues and suggesting preventive measures. Automation tools facilitate swift responses to identified issues, often\\r\\n    without the need for human intervention. For instance, automated systems can initiate repairs or adjustments based\\r\\n    on predefined parameters, ensuring that minor issues are resolved before they escalate into significant problems.\\r\\n<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">The Role of AI and Automation in Revolutionizing Service Center Operations<\\/h6>\\r\\n<div>The proactive approach not only enhances operational efficiency but also fosters a more positive customer\\r\\n    experience. By addressing potential issues before they impact customers, service centers can ensure a higher level\\r\\n    of service continuity and reliability. Customers benefit from fewer disruptions and a more streamlined experience,\\r\\n    leading to increased satisfaction and loyalty.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Enhancing Customer Experience Through Proactive Service Strategies<\\/h6>\\r\\n<div>In essence, the evolution from a reactive to a proactive model in service center automation represents a\\r\\n    significant leap forward. It highlights the importance of leveraging advanced technologies to not only address\\r\\n    problems but to anticipate and prevent them, ultimately leading to a more efficient and customer-centric operation.\\r\\n    As technology continues to evolve, service centers will likely see even more sophisticated solutions that further\\r\\n    enhance their ability to provide seamless and proactive service.<\\/div>\",\"image\":\"66d405c4b41841725171140.png\"}', NULL, 'basic', 'duis-lobortis-massa-imperdiet-quam-nunc-egestas-augue', '2024-09-29 00:12:20', '2024-10-01 06:01:35'),
(103, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Etiam feugiat lorem non metus. Sed libero\",\"description\":\"<h6 class=\\\"m-0\\\">The Reactive Model of Service Centers: Addressing Issues After They Arise<\\/h6>\\r\\n<div>The landscape of service center automation has undergone a remarkable transformation over the past few decades,\\r\\n    shifting from reactive to proactive approaches. Initially, service centers operated on a reactive model, primarily\\r\\n    addressing issues only after they arose. This method often involved responding to customer complaints and\\r\\n    troubleshooting problems as they emerged, leading to higher levels of downtime and customer dissatisfaction. The\\r\\n    focus was largely on fixing problems rather than preventing them, which created a cycle of continuous reaction to\\r\\n    service issues.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<blockquote style=\\\"font-style:italic;text-align:center;padding:20px;background:#ffeaef;font-weight:500;font-size:18px;border-left:4px solid #df3459;\\\">\\r\\n    Aenean metus lectus at id. Morbi aliquet commodo a sodales eget. Eu justo ante nibh et a turpis, aliquam phasellus\\r\\n    hymenaeos, imperdiet eget cras sociosqu, tincidunt a amet. Faucibus urna luctus, arcu ni<\\/blockquote>\\r\\n<h6 class=\\\"m-0\\\">Shifting Paradigms: The Move Toward Proactive Service Models<\\/h6>\\r\\n<div>As technology advanced, the paradigm began to shift towards a more proactive approach. The rise of advanced data\\r\\n    analytics and machine learning techniques enabled service centers to anticipate potential issues before they\\r\\n    occurred. By analyzing historical data and recognizing patterns, service centers could now predict when equipment\\r\\n    might fail or when a system could encounter problems. This shift not only reduced the frequency of unexpected\\r\\n    disruptions but also improved overall operational efficiency. Predictive maintenance became a key feature of\\r\\n    proactive service centers, allowing them to schedule maintenance activities during non-peak hours and address issues\\r\\n    before they impacted the customer experience.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Harnessing Data Analytics and Machine Learning for Predictive Maintenance<\\/h6>\\r\\n<div>This evolution was further accelerated by the integration of artificial intelligence (AI) and automation tools.\\r\\n    AI-driven systems can now monitor and analyze real-time data from various sources, providing insights into potential\\r\\n    issues and suggesting preventive measures. Automation tools facilitate swift responses to identified issues, often\\r\\n    without the need for human intervention. For instance, automated systems can initiate repairs or adjustments based\\r\\n    on predefined parameters, ensuring that minor issues are resolved before they escalate into significant problems.\\r\\n<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">The Role of AI and Automation in Revolutionizing Service Center Operations<\\/h6>\\r\\n<div>The proactive approach not only enhances operational efficiency but also fosters a more positive customer\\r\\n    experience. By addressing potential issues before they impact customers, service centers can ensure a higher level\\r\\n    of service continuity and reliability. Customers benefit from fewer disruptions and a more streamlined experience,\\r\\n    leading to increased satisfaction and loyalty.<\\/div>\\r\\n<div><br \\/><\\/div>\\r\\n<h6 class=\\\"m-0\\\">Enhancing Customer Experience Through Proactive Service Strategies<\\/h6>\\r\\n<div>In essence, the evolution from a reactive to a proactive model in service center automation represents a\\r\\n    significant leap forward. It highlights the importance of leveraging advanced technologies to not only address\\r\\n    problems but to anticipate and prevent them, ultimately leading to a more efficient and customer-centric operation.\\r\\n    As technology continues to evolve, service centers will likely see even more sophisticated solutions that further\\r\\n    enhance their ability to provide seamless and proactive service.<\\/div>\",\"image\":\"66d405e507a791725171173.png\"}', NULL, 'basic', 'etiam-feugiat-lorem-non-metus-sed-libero', '2024-09-30 00:12:53', '2024-10-01 06:01:26'),
(104, 'cta.content', '{\"heading\":\"Ready to Get Start today?\",\"subheading\":\"Join Our Network, Partner with Brands, and Elevate Your Online Influence \\u2013 Your Journey Starts Here\",\"button_name\":\"Get Started\",\"button_url\":\"influencer\\/register\"}', NULL, 'basic', '', '2024-09-01 02:57:19', '2024-09-01 02:57:19'),
(105, 'faq.content', '{\"heading\":\"Frequently Asked Questions\"}', NULL, 'basic', '', '2024-09-01 03:05:54', '2024-09-01 03:05:54'),
(106, 'faq.element', '{\"question\":\"How does your platform work?\",\"answer\":\"Our platform works by allowing brands to create campaigns and connect with influencers who fit their target audience and brand values. Influencers can browse through available campaigns, apply to participate, and collaborate with brands to create sponsored content.\"}', NULL, 'basic', '', '2024-09-01 03:07:11', '2024-09-01 03:07:11'),
(107, 'faq.element', '{\"question\":\"What benefits for brands?\",\"answer\":\"Our platform offers brands the ability to reach a highly targeted audience through trusted influencers. It provides access to detailed analytics, real-time campaign tracking, and the ability to manage multiple campaigns and influencers in one centralized location.\"}', NULL, 'basic', '', '2024-09-01 03:07:25', '2024-10-08 23:45:36'),
(108, 'faq.element', '{\"question\":\"What benefits for influencers?\",\"answer\":\"Influencers benefit from our platform by gaining access to a diverse range of brands and campaigns to collaborate with. They can monetize their influence, expand their reach, and gain valuable insights into their audience demographics and engagement metrics.\"}', NULL, 'basic', '', '2024-09-01 03:07:41', '2024-10-08 23:45:19'),
(109, 'faq.element', '{\"question\":\"How do you verify influencer authenticity?\",\"answer\":\"We carefully vet influencers before allowing them to join our platform. We verify their audience demographics, engagement rates, and content quality to ensure authenticity and relevance for our brand partners.\"}', NULL, 'basic', '', '2024-09-01 03:07:53', '2024-10-08 23:41:08'),
(110, 'faq.element', '{\"question\":\"What campaigns can brands run?\",\"answer\":\"Brands can run various types of campaigns, including sponsored content, product reviews, giveaways, events, and more. Our platform offers flexibility in campaign types to accommodate diverse marketing objectives and strategies.\"}', NULL, 'basic', '', '2024-09-01 03:08:06', '2024-10-08 23:44:15'),
(111, 'faq.element', '{\"question\":\"How do you measure campaign success?\",\"answer\":\"We provide comprehensive analytics and reporting tools to measure the success of influencer marketing campaigns. Metrics such as reach, engagement, click-through rates, conversions, and return on investment (ROI) are tracked and analyzed to evaluate campaign performance.\"}', NULL, 'basic', '', '2024-09-01 03:08:20', '2024-10-08 23:44:48'),
(112, 'faq.element', '{\"question\":\"Is there a fee for influencers to join your platform?\",\"answer\":\"No, there is no fee for influencers to join our platform. It is free for influencers to create profiles, browse available campaigns, and apply to participate in collaborations.\"}', NULL, 'basic', '', '2024-09-01 03:08:29', '2024-09-01 03:08:29'),
(113, 'social_icon.element', '{\"social_icon\":\"<i class=\\\"fab fa-instagram\\\"><\\/i>\",\"url\":\"https:\\/\\/www.instagram.com\\/\"}', NULL, 'basic', '', '2024-09-01 04:21:51', '2024-09-01 04:21:51'),
(114, 'social_icon.element', '{\"social_icon\":\"<i class=\\\"fab fa-youtube\\\"><\\/i>\",\"url\":\"https:\\/\\/www.youtube.com\"}', NULL, 'basic', '', '2024-09-01 04:22:01', '2024-09-01 04:22:01'),
(115, 'footer.content', '{\"description\":\"Join our influencer marketplace and unlock the potential of authentic collaborations. Connect with top brands and influencers to amplify your reach.\"}', NULL, 'basic', '', '2024-09-01 04:22:50', '2024-09-01 04:22:50'),
(116, 'brand_login.content', '{\"heading\":\"Login as Brand\",\"subheading\":\"Access Your Brand Power and Influence\",\"title\":\"Connect, Collaborate, and Elevate Your Brand with Influencers\",\"short_description\":\"Unlock the potential of authentic influencer collaborations to elevate your brands reach and impact\"}', NULL, 'basic', '', '2024-09-01 23:28:57', '2024-09-01 23:28:57'),
(117, 'brand_register.content', '{\"heading\":\"Register as Brand\",\"subheading\":\"Start Your Brand Journey Today\",\"title\":\"Register Your Brand and Connect with Top Influencers\",\"short_description\":\"Register and Amplify Your Reach with Our Influencer Marketplace. Your Success Story Begins Here\"}', NULL, 'basic', '', '2024-09-01 23:29:27', '2024-09-01 23:29:27'),
(118, 'influencer_login.content', '{\"heading\":\"Login as Influencer\",\"subheading\":\"Next Step in Your Influencer Journey\",\"title\":\"Your Path to Influence and Success\",\"short_description\":\"Empower Your Influence and Amplify Your Reach with Our Comprehensive Platform.\"}', NULL, 'basic', '', '2024-09-02 00:51:58', '2024-09-02 00:51:58'),
(119, 'influencer_register.content', '{\"heading\":\"Register as Influencer\",\"subheading\":\"Step into the World of Influence\",\"title\":\"Register as an Influencer to Connect with Brands\",\"short_description\":\"Unlock Your Influence Potential \\u2013 Join Our Platform to Connect with Top Brands and Amplify Your Reach\"}', NULL, 'basic', '', '2024-09-02 00:52:22', '2024-09-02 00:52:22'),
(120, 'ongoing_campaign.content', '{\"heading\":\"Ongoing Campaigns\"}', NULL, 'basic', '', '2024-09-11 06:53:55', '2024-09-29 01:29:19'),
(121, 'empty_data.content', '{\"has_image\":\"1\",\"image\":\"66e7d3375c8cb1726468919.png\"}', NULL, 'basic', '', '2024-09-16 00:41:59', '2024-09-16 00:42:00'),
(122, 'policy_pages.element', '{\"title\":\"Refund Policy\",\"details\":\"<div class=\\\"mb-5\\\">\\r\\n    <h4 class=\\\"mb-2\\\">Introduction<\\/h4>\\r\\n        <p>\\r\\n            This Privacy Policy describes how we collects, uses, and discloses information, including personal information, in connection with your use of our website.\\r\\n        <\\/p>\\r\\n<\\/div>\\r\\n     \\r\\n        \\r\\n        <div class=\\\"mb-5\\\">\\r\\n            <h4 class=\\\"mb-2\\\">Information We Collect<\\/h4>\\r\\n        <p>We collect two main types of information on the Website:<\\/p>\\r\\n        <ul>\\r\\n            <li><p><strong>Personal Information: <\\/strong>This includes data that can identify you as an individual, such as your name, email address, phone number, or mailing address. We only collect this information when you voluntarily provide it to us, like signing up for a newsletter, contacting us through a form, or making a purchase.<\\/p><\\/li>\\r\\n            <li><p><strong>Non-Personal Information: <\\/strong>This data cannot be used to identify you directly. It includes details like your browser type, device type, operating system, IP address, browsing activity, and usage statistics. We collect this information automatically through cookies and other tracking technologies.<\\/p><\\/li>\\r\\n        <\\/ul>\\r\\n        <\\/div>\\r\\n     \\r\\n        \\r\\n        <div class=\\\"mb-5\\\">\\r\\n            <h4 class=\\\"mb-2\\\">How We Use Information<\\/h4>\\r\\n        <p>The information we collect allows us to:<\\/p>\\r\\n        <ul>\\r\\n            <li>Operate and maintain the Website effectively.<\\/li>\\r\\n            <li>Send you newsletters or marketing communications, but only with your consent.<\\/li>\\r\\n            <li>Respond to your inquiries and fulfill your requests.<\\/li>\\r\\n            <li>Improve the Website and your user experience.<\\/li>\\r\\n            <li>Personalize your experience on the Website based on your browsing habits.<\\/li>\\r\\n            <li>Analyze how the Website is used to improve our services.<\\/li>\\r\\n            <li>Comply with legal and regulatory requirements.<\\/li>\\r\\n        <\\/ul>\\r\\n     \\r\\n        <\\/div>\\r\\n        \\r\\n       <div class=\\\"mb-5\\\">\\r\\n        <h4 class=\\\"mb-2\\\">Sharing of Information<\\/h4>\\r\\n        <p>We may share your information with trusted third-party service providers who assist us in operating the Website and delivering our services. These providers are obligated by contract to keep your information confidential and use it only for the specific purposes we disclose it for.<\\/p>\\r\\n        <p>We will never share your personal information with any third parties for marketing purposes without your explicit consent.<\\/p>\\r\\n     \\r\\n       <\\/div>\\r\\n        \\r\\n        <div class=\\\"mb-5\\\">\\r\\n            <h4 class=\\\"mb-2\\\">Data Retention<\\/h4>\\r\\n        <p>We retain your personal information only for as long as necessary to fulfill the purposes it was collected for. We may retain it for longer periods only if required or permitted by law.<\\/p>\\r\\n     \\r\\n        <\\/div>\\r\\n        \\r\\n        <div class=\\\"mb-5\\\">\\r\\n            <h4 class=\\\"mb-2\\\">Security Measures<\\/h4>\\r\\n        <p>We take reasonable precautions to protect your information from unauthorized access, disclosure, alteration, or destruction. However, complete security cannot be guaranteed for any website or internet transmission.<\\/p>\\r\\n     \\r\\n        <\\/div>\\r\\n        \\r\\n<div>\\r\\n    <h4 class=\\\"mb-2\\\">Changes to this Privacy Policy<\\/h4>\\r\\n    <p>We may update this Privacy Policy periodically. We will notify you of any changes by posting the revised policy on the Website. We recommend reviewing this policy regularly to stay informed of any updates.<\\/p>\\r\\n    <p><strong>Remember:<\\/strong>  This is a sample policy and may need adjustments to comply with specific laws and reflect your website\'s unique data practices. Consider consulting with a legal professional to ensure your policy is fully compliant.<\\/p>\\r\\n<\\/div>\"}', NULL, 'basic', 'refund-policy', '2024-09-24 05:31:42', '2024-09-29 00:48:01'),
(123, 'banned.content', '{\"has_image\":\"1\",\"image\":\"66f3d7772f3d91727256439.png\"}', NULL, 'basic', '', '2024-09-25 03:23:17', '2024-09-25 03:27:19'),
(124, 'brand_kyc.content', '{\"required\":\"Complete KYC to unlock the full potential of our platform! KYC helps us verify your identity and keep things secure. It is quick and easy just follow the on-screen instructions. Get started with KYC verification now!\",\"pending\":\"Your KYC verification is being reviewed. We might need some additional information. You will get an email update soon. In the meantime, explore our platform with limited features.\",\"reject\":\"We regret to inform you that the Know Your Customer (KYC) information provided has been reviewed and unfortunately, it has not met our verification standards.\"}', NULL, 'basic', '', '2024-09-25 05:23:38', '2024-09-25 05:23:38'),
(125, 'influencer_kyc.content', '{\"required\":\"Complete KYC to unlock the full potential of our platform! KYC helps us verify your identity and keep things secure. It is quick and easy just follow the on-screen instructions. Get started with KYC verification now!\",\"pending\":\"Your KYC verification is being reviewed. We might need some additional information. You will get an email update soon. In the meantime, explore our platform with limited features.\",\"reject\":\"We regret to inform you that the Know Your Customer (KYC) information provided has been reviewed and unfortunately, it has not met our verification standards.\"}', NULL, 'basic', '', '2024-09-25 05:24:18', '2024-09-25 05:25:25'),
(126, 'partner.element', '{\"has_image\":\"1\",\"image\":\"66f8fb270ae921727593255.png\"}', NULL, 'basic', '', '2024-09-29 01:00:55', '2024-09-29 01:00:55'),
(127, 'breadcrumb.content', '{\"has_image\":\"1\",\"image\":\"66fbcd6f171071727778159.png\"}', NULL, 'basic', '', '2024-10-01 02:29:54', '2024-10-01 04:22:39'),
(128, 'social_icon.element', '{\"social_icon\":\"<i class=\\\"fa-brands fa-x-twitter\\\"><\\/i>\",\"url\":\"https:\\/\\/www.twitter.com\\/\"}', NULL, 'basic', '', '2024-10-08 23:38:09', '2024-10-08 23:38:29');

-- --------------------------------------------------------

--
-- Table structure for table `gateways`
--

CREATE TABLE `gateways` (
  `id` bigint UNSIGNED NOT NULL,
  `form_id` int UNSIGNED NOT NULL DEFAULT '0',
  `code` int DEFAULT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NULL',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>enable, 2=>disable',
  `gateway_parameters` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `supported_currencies` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `crypto` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: fiat currency, 1: crypto currency',
  `extra` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gateways`
--

INSERT INTO `gateways` (`id`, `form_id`, `code`, `name`, `alias`, `image`, `status`, `gateway_parameters`, `supported_currencies`, `crypto`, `extra`, `description`, `created_at`, `updated_at`) VALUES
(1, 0, 101, 'Paypal', 'Paypal', '663a38d7b455d1715091671.png', 1, '{\"paypal_email\":{\"title\":\"PayPal Email\",\"global\":true,\"value\":\"sb-owud61543012@business.example.com\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:21:11'),
(2, 0, 102, 'Perfect Money', 'PerfectMoney', '663a3920e30a31715091744.png', 1, '{\"passphrase\":{\"title\":\"ALTERNATE PASSPHRASE\",\"global\":true,\"value\":\"hR26aw02Q1eEeUPSIfuwNypXX\"},\"wallet_id\":{\"title\":\"PM Wallet\",\"global\":false,\"value\":\"\"}}', '{\"USD\":\"$\",\"EUR\":\"\\u20ac\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:22:24'),
(3, 0, 103, 'Stripe Hosted', 'Stripe', '663a39861cb9d1715091846.png', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"[STRIPE_SECRET_SCRUBBED]\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51I6GGiCGv1sRiQlEOisPKrjBqQqqcFsw8mXNaZ2H2baN6R01NulFS7dKFji1NRRxuchoUTEDdB7ujKcyKYSVc0z500eth7otOM\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:24:06'),
(4, 0, 104, 'Skrill', 'Skrill', '663a39494c4a91715091785.png', 1, '{\"pay_to_email\":{\"title\":\"Skrill Email\",\"global\":true,\"value\":\"merchant@skrill.com\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"---\"}}', '{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JOD\":\"JOD\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"KWD\":\"KWD\",\"MAD\":\"MAD\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"OMR\":\"OMR\",\"PLN\":\"PLN\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"SAR\":\"SAR\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TND\":\"TND\",\"TRY\":\"TRY\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\",\"COP\":\"COP\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:23:05'),
(5, 0, 105, 'PayTM', 'Paytm', '663a390f601191715091727.png', 1, '{\"MID\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"DIY12386817555501617\"},\"merchant_key\":{\"title\":\"Merchant Key\",\"global\":true,\"value\":\"bKMfNxPPf_QdZppa\"},\"WEBSITE\":{\"title\":\"Paytm Website\",\"global\":true,\"value\":\"DIYtestingweb\"},\"INDUSTRY_TYPE_ID\":{\"title\":\"Industry Type\",\"global\":true,\"value\":\"Retail\"},\"CHANNEL_ID\":{\"title\":\"CHANNEL ID\",\"global\":true,\"value\":\"WEB\"},\"transaction_url\":{\"title\":\"Transaction URL\",\"global\":true,\"value\":\"https:\\/\\/pguat.paytm.com\\/oltp-web\\/processTransaction\"},\"transaction_status_url\":{\"title\":\"Transaction STATUS URL\",\"global\":true,\"value\":\"https:\\/\\/pguat.paytm.com\\/paytmchecksum\\/paytmCallback.jsp\"}}', '{\"AUD\":\"AUD\",\"ARS\":\"ARS\",\"BDT\":\"BDT\",\"BRL\":\"BRL\",\"BGN\":\"BGN\",\"CAD\":\"CAD\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"HRK\":\"HRK\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EGP\":\"EGP\",\"EUR\":\"EUR\",\"GEL\":\"GEL\",\"GHS\":\"GHS\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"KES\":\"KES\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"MAD\":\"MAD\",\"NPR\":\"NPR\",\"NZD\":\"NZD\",\"NGN\":\"NGN\",\"NOK\":\"NOK\",\"PKR\":\"PKR\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"ZAR\":\"ZAR\",\"KRW\":\"KRW\",\"LKR\":\"LKR\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"UGX\":\"UGX\",\"UAH\":\"UAH\",\"AED\":\"AED\",\"GBP\":\"GBP\",\"USD\":\"USD\",\"VND\":\"VND\",\"XOF\":\"XOF\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:22:07'),
(6, 0, 106, 'Payeer', 'Payeer', '663a38c9e2e931715091657.png', 1, '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"866989763\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"7575\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"RUB\":\"RUB\"}', 0, '{\"status\":{\"title\": \"Status URL\",\"value\":\"ipn.Payeer\"}}', NULL, '2019-09-14 13:14:22', '2024-05-07 08:20:57'),
(7, 0, 107, 'PayStack', 'Paystack', '663a38fc814e91715091708.png', 1, '{\"public_key\":{\"title\":\"Public key\",\"global\":true,\"value\":\"pk_test_cd330608eb47970889bca397ced55c1dd5ad3783\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"[STRIPE_SECRET_SCRUBBED]\"}}', '{\"USD\":\"USD\",\"NGN\":\"NGN\"}', 0, '{\"callback\":{\"title\": \"Callback URL\",\"value\":\"ipn.Paystack\"},\"webhook\":{\"title\": \"Webhook URL\",\"value\":\"ipn.Paystack\"}}\r\n', NULL, '2019-09-14 13:14:22', '2024-05-07 08:21:48'),
(9, 0, 109, 'Flutterwave', 'Flutterwave', '663a36c2c34d61715091138.png', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"----------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"-----------------------\"},\"encryption_key\":{\"title\":\"Encryption Key\",\"global\":true,\"value\":\"------------------\"}}', '{\"BIF\":\"BIF\",\"CAD\":\"CAD\",\"CDF\":\"CDF\",\"CVE\":\"CVE\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"GHS\":\"GHS\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"KES\":\"KES\",\"LRD\":\"LRD\",\"MWK\":\"MWK\",\"MZN\":\"MZN\",\"NGN\":\"NGN\",\"RWF\":\"RWF\",\"SLL\":\"SLL\",\"STD\":\"STD\",\"TZS\":\"TZS\",\"UGX\":\"UGX\",\"USD\":\"USD\",\"XAF\":\"XAF\",\"XOF\":\"XOF\",\"ZMK\":\"ZMK\",\"ZMW\":\"ZMW\",\"ZWD\":\"ZWD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:12:18'),
(10, 0, 110, 'RazorPay', 'Razorpay', '663a393a527831715091770.png', 1, '{\"key_id\":{\"title\":\"Key Id\",\"global\":true,\"value\":\"rzp_test_kiOtejPbRZU90E\"},\"key_secret\":{\"title\":\"Key Secret \",\"global\":true,\"value\":\"osRDebzEqbsE1kbyQJ4y0re7\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:22:50'),
(11, 0, 111, 'Stripe Storefront', 'StripeJs', '663a3995417171715091861.png', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"[STRIPE_SECRET_SCRUBBED]\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51I6GGiCGv1sRiQlEOisPKrjBqQqqcFsw8mXNaZ2H2baN6R01NulFS7dKFji1NRRxuchoUTEDdB7ujKcyKYSVc0z500eth7otOM\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:24:21'),
(12, 0, 112, 'Instamojo', 'Instamojo', '663a384d54a111715091533.png', 1, '{\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"test_2241633c3bc44a3de84a3b33969\"},\"auth_token\":{\"title\":\"Auth Token\",\"global\":true,\"value\":\"test_279f083f7bebefd35217feef22d\"},\"salt\":{\"title\":\"Salt\",\"global\":true,\"value\":\"19d38908eeff4f58b2ddda2c6d86ca25\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:18:53'),
(13, 0, 501, 'Blockchain', 'Blockchain', '663a35efd0c311715090927.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"55529946-05ca-48ff-8710-f279d86b1cc5\"},\"xpub_code\":{\"title\":\"XPUB CODE\",\"global\":true,\"value\":\"xpub6CKQ3xxWyBoFAF83izZCSFUorptEU9AF8TezhtWeMU5oefjX3sFSBw62Lr9iHXPkXmDQJJiHZeTRtD9Vzt8grAYRhvbz4nEvBu3QKELVzFK\"}}', '{\"BTC\":\"BTC\"}', 1, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:08:47'),
(15, 0, 503, 'CoinPayments', 'Coinpayments', '663a36a8d8e1d1715091112.png', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"---------------------\"},\"private_key\":{\"title\":\"Private Key\",\"global\":true,\"value\":\"---------------------\"},\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"---------------------\"}}', '{\"BTC\":\"Bitcoin\",\"BTC.LN\":\"Bitcoin (Lightning Network)\",\"LTC\":\"Litecoin\",\"CPS\":\"CPS Coin\",\"VLX\":\"Velas\",\"APL\":\"Apollo\",\"AYA\":\"Aryacoin\",\"BAD\":\"Badcoin\",\"BCD\":\"Bitcoin Diamond\",\"BCH\":\"Bitcoin Cash\",\"BCN\":\"Bytecoin\",\"BEAM\":\"BEAM\",\"BITB\":\"Bean Cash\",\"BLK\":\"BlackCoin\",\"BSV\":\"Bitcoin SV\",\"BTAD\":\"Bitcoin Adult\",\"BTG\":\"Bitcoin Gold\",\"BTT\":\"BitTorrent\",\"CLOAK\":\"CloakCoin\",\"CLUB\":\"ClubCoin\",\"CRW\":\"Crown\",\"CRYP\":\"CrypticCoin\",\"CRYT\":\"CryTrExCoin\",\"CURE\":\"CureCoin\",\"DASH\":\"DASH\",\"DCR\":\"Decred\",\"DEV\":\"DeviantCoin\",\"DGB\":\"DigiByte\",\"DOGE\":\"Dogecoin\",\"EBST\":\"eBoost\",\"EOS\":\"EOS\",\"ETC\":\"Ether Classic\",\"ETH\":\"Ethereum\",\"ETN\":\"Electroneum\",\"EUNO\":\"EUNO\",\"EXP\":\"EXP\",\"Expanse\":\"Expanse\",\"FLASH\":\"FLASH\",\"GAME\":\"GameCredits\",\"GLC\":\"Goldcoin\",\"GRS\":\"Groestlcoin\",\"KMD\":\"Komodo\",\"LOKI\":\"LOKI\",\"LSK\":\"LSK\",\"MAID\":\"MaidSafeCoin\",\"MUE\":\"MonetaryUnit\",\"NAV\":\"NAV Coin\",\"NEO\":\"NEO\",\"NMC\":\"Namecoin\",\"NVST\":\"NVO Token\",\"NXT\":\"NXT\",\"OMNI\":\"OMNI\",\"PINK\":\"PinkCoin\",\"PIVX\":\"PIVX\",\"POT\":\"PotCoin\",\"PPC\":\"Peercoin\",\"PROC\":\"ProCurrency\",\"PURA\":\"PURA\",\"QTUM\":\"QTUM\",\"RES\":\"Resistance\",\"RVN\":\"Ravencoin\",\"RVR\":\"RevolutionVR\",\"SBD\":\"Steem Dollars\",\"SMART\":\"SmartCash\",\"SOXAX\":\"SOXAX\",\"STEEM\":\"STEEM\",\"STRAT\":\"STRAT\",\"SYS\":\"Syscoin\",\"TPAY\":\"TokenPay\",\"TRIGGERS\":\"Triggers\",\"TRX\":\" TRON\",\"UBQ\":\"Ubiq\",\"UNIT\":\"UniversalCurrency\",\"USDT\":\"Tether USD (Omni Layer)\",\"USDT.BEP20\":\"Tether USD (BSC Chain)\",\"USDT.ERC20\":\"Tether USD (ERC20)\",\"USDT.TRC20\":\"Tether USD (Tron/TRC20)\",\"VTC\":\"Vertcoin\",\"WAVES\":\"Waves\",\"XCP\":\"Counterparty\",\"XEM\":\"NEM\",\"XMR\":\"Monero\",\"XSN\":\"Stakenet\",\"XSR\":\"SucreCoin\",\"XVG\":\"VERGE\",\"XZC\":\"ZCoin\",\"ZEC\":\"ZCash\",\"ZEN\":\"Horizen\"}', 1, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:11:52'),
(16, 0, 504, 'CoinPayments Fiat', 'CoinpaymentsFiat', '663a36b7b841a1715091127.png', 1, '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"6515561\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:12:07'),
(17, 0, 505, 'Coingate', 'Coingate', '663a368e753381715091086.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"6354mwVCEw5kHzRJ6thbGo-N\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:11:26'),
(18, 0, 506, 'Coinbase Commerce', 'CoinbaseCommerce', '663a367e46ae51715091070.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"c47cd7df-d8e8-424b-a20a\"},\"secret\":{\"title\":\"Webhook Shared Secret\",\"global\":true,\"value\":\"55871878-2c32-4f64-ab66\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"JPY\":\"JPY\",\"GBP\":\"GBP\",\"AUD\":\"AUD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CNY\":\"CNY\",\"SEK\":\"SEK\",\"NZD\":\"NZD\",\"MXN\":\"MXN\",\"SGD\":\"SGD\",\"HKD\":\"HKD\",\"NOK\":\"NOK\",\"KRW\":\"KRW\",\"TRY\":\"TRY\",\"RUB\":\"RUB\",\"INR\":\"INR\",\"BRL\":\"BRL\",\"ZAR\":\"ZAR\",\"AED\":\"AED\",\"AFN\":\"AFN\",\"ALL\":\"ALL\",\"AMD\":\"AMD\",\"ANG\":\"ANG\",\"AOA\":\"AOA\",\"ARS\":\"ARS\",\"AWG\":\"AWG\",\"AZN\":\"AZN\",\"BAM\":\"BAM\",\"BBD\":\"BBD\",\"BDT\":\"BDT\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"BIF\":\"BIF\",\"BMD\":\"BMD\",\"BND\":\"BND\",\"BOB\":\"BOB\",\"BSD\":\"BSD\",\"BTN\":\"BTN\",\"BWP\":\"BWP\",\"BYN\":\"BYN\",\"BZD\":\"BZD\",\"CDF\":\"CDF\",\"CLF\":\"CLF\",\"CLP\":\"CLP\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"CUC\":\"CUC\",\"CUP\":\"CUP\",\"CVE\":\"CVE\",\"CZK\":\"CZK\",\"DJF\":\"DJF\",\"DKK\":\"DKK\",\"DOP\":\"DOP\",\"DZD\":\"DZD\",\"EGP\":\"EGP\",\"ERN\":\"ERN\",\"ETB\":\"ETB\",\"FJD\":\"FJD\",\"FKP\":\"FKP\",\"GEL\":\"GEL\",\"GGP\":\"GGP\",\"GHS\":\"GHS\",\"GIP\":\"GIP\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"GTQ\":\"GTQ\",\"GYD\":\"GYD\",\"HNL\":\"HNL\",\"HRK\":\"HRK\",\"HTG\":\"HTG\",\"HUF\":\"HUF\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"IMP\":\"IMP\",\"IQD\":\"IQD\",\"IRR\":\"IRR\",\"ISK\":\"ISK\",\"JEP\":\"JEP\",\"JMD\":\"JMD\",\"JOD\":\"JOD\",\"KES\":\"KES\",\"KGS\":\"KGS\",\"KHR\":\"KHR\",\"KMF\":\"KMF\",\"KPW\":\"KPW\",\"KWD\":\"KWD\",\"KYD\":\"KYD\",\"KZT\":\"KZT\",\"LAK\":\"LAK\",\"LBP\":\"LBP\",\"LKR\":\"LKR\",\"LRD\":\"LRD\",\"LSL\":\"LSL\",\"LYD\":\"LYD\",\"MAD\":\"MAD\",\"MDL\":\"MDL\",\"MGA\":\"MGA\",\"MKD\":\"MKD\",\"MMK\":\"MMK\",\"MNT\":\"MNT\",\"MOP\":\"MOP\",\"MRO\":\"MRO\",\"MUR\":\"MUR\",\"MVR\":\"MVR\",\"MWK\":\"MWK\",\"MYR\":\"MYR\",\"MZN\":\"MZN\",\"NAD\":\"NAD\",\"NGN\":\"NGN\",\"NIO\":\"NIO\",\"NPR\":\"NPR\",\"OMR\":\"OMR\",\"PAB\":\"PAB\",\"PEN\":\"PEN\",\"PGK\":\"PGK\",\"PHP\":\"PHP\",\"PKR\":\"PKR\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"RWF\":\"RWF\",\"SAR\":\"SAR\",\"SBD\":\"SBD\",\"SCR\":\"SCR\",\"SDG\":\"SDG\",\"SHP\":\"SHP\",\"SLL\":\"SLL\",\"SOS\":\"SOS\",\"SRD\":\"SRD\",\"SSP\":\"SSP\",\"STD\":\"STD\",\"SVC\":\"SVC\",\"SYP\":\"SYP\",\"SZL\":\"SZL\",\"THB\":\"THB\",\"TJS\":\"TJS\",\"TMT\":\"TMT\",\"TND\":\"TND\",\"TOP\":\"TOP\",\"TTD\":\"TTD\",\"TWD\":\"TWD\",\"TZS\":\"TZS\",\"UAH\":\"UAH\",\"UGX\":\"UGX\",\"UYU\":\"UYU\",\"UZS\":\"UZS\",\"VEF\":\"VEF\",\"VND\":\"VND\",\"VUV\":\"VUV\",\"WST\":\"WST\",\"XAF\":\"XAF\",\"XAG\":\"XAG\",\"XAU\":\"XAU\",\"XCD\":\"XCD\",\"XDR\":\"XDR\",\"XOF\":\"XOF\",\"XPD\":\"XPD\",\"XPF\":\"XPF\",\"XPT\":\"XPT\",\"YER\":\"YER\",\"ZMW\":\"ZMW\",\"ZWL\":\"ZWL\"}\r\n\r\n', 0, '{\"endpoint\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.CoinbaseCommerce\"}}', NULL, '2019-09-14 13:14:22', '2024-05-07 08:11:10'),
(24, 0, 113, 'Paypal Express', 'PaypalSdk', '663a38ed101a61715091693.png', 1, '{\"clientId\":{\"title\":\"Paypal Client ID\",\"global\":true,\"value\":\"Ae0-tixtSV7DvLwIh3Bmu7JvHrjh5EfGdXr_cEklKAVjjezRZ747BxKILiBdzlKKyp-W8W_T7CKH1Ken\"},\"clientSecret\":{\"title\":\"Client Secret\",\"global\":true,\"value\":\"EOhbvHZgFNO21soQJT1L9Q00M3rK6PIEsdiTgXRBt2gtGtxwRer5JvKnVUGNU5oE63fFnjnYY7hq3HBA\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:21:33'),
(25, 0, 114, 'Stripe Checkout', 'StripeV3', '663a39afb519f1715091887.png', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"[STRIPE_SECRET_SCRUBBED]\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51I6GGiCGv1sRiQlEOisPKrjBqQqqcFsw8mXNaZ2H2baN6R01NulFS7dKFji1NRRxuchoUTEDdB7ujKcyKYSVc0z500eth7otOM\"},\"end_point\":{\"title\":\"End Point Secret\",\"global\":true,\"value\":\"whsec_lUmit1gtxwKTveLnSe88xCSDdnPOt8g5\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, '{\"webhook\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.StripeV3\"}}', NULL, '2019-09-14 13:14:22', '2024-05-07 08:24:47'),
(27, 0, 115, 'Mollie', 'Mollie', '663a387ec69371715091582.png', 1, '{\"mollie_email\":{\"title\":\"Mollie Email \",\"global\":true,\"value\":\"vi@gmail.com\"},\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"test_cucfwKTWfft9s337qsVfn5CC4vNkrn\"}}', '{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2024-05-07 08:19:42'),
(30, 0, 116, 'Cashmaal', 'Cashmaal', '663a361b16bd11715090971.png', 1, '{\"web_id\":{\"title\":\"Web Id\",\"global\":true,\"value\":\"3748\"},\"ipn_key\":{\"title\":\"IPN Key\",\"global\":true,\"value\":\"546254628759524554647987\"}}', '{\"PKR\":\"PKR\",\"USD\":\"USD\"}', 0, '{\"webhook\":{\"title\": \"IPN URL\",\"value\":\"ipn.Cashmaal\"}}', NULL, NULL, '2024-05-07 08:09:31'),
(36, 0, 119, 'Mercado Pago', 'MercadoPago', '663a386c714a91715091564.png', 1, '{\"access_token\":{\"title\":\"Access Token\",\"global\":true,\"value\":\"APP_USR-7924565816849832-082312-21941521997fab717db925cf1ea2c190-1071840315\"}}', '{\"USD\":\"USD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"AUD\":\"AUD\",\"NZD\":\"NZD\"}', 0, NULL, NULL, NULL, '2024-05-07 08:19:24'),
(37, 0, 120, 'Authorize.net', 'Authorize', '663a35b9ca5991715090873.png', 1, '{\"login_id\":{\"title\":\"Login ID\",\"global\":true,\"value\":\"59e4P9DBcZv\"},\"transaction_key\":{\"title\":\"Transaction Key\",\"global\":true,\"value\":\"47x47TJyLw2E7DbR\"}}', '{\"USD\":\"USD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"AUD\":\"AUD\",\"NZD\":\"NZD\"}', 0, NULL, NULL, NULL, '2024-05-07 08:07:53'),
(46, 0, 121, 'NMI', 'NMI', '663a3897754cf1715091607.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"2F822Rw39fx762MaV7Yy86jXGTC7sCDy\"}}', '{\"AED\":\"AED\",\"ARS\":\"ARS\",\"AUD\":\"AUD\",\"BOB\":\"BOB\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"RUB\":\"RUB\",\"SEC\":\"SEC\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, NULL, '2024-05-07 08:20:07'),
(50, 0, 507, 'BTCPay', 'BTCPay', '663a35cd25a8d1715090893.png', 1, '{\"store_id\":{\"title\":\"Store Id\",\"global\":true,\"value\":\"HsqFVTXSeUFJu7caoYZc3CTnP8g5LErVdHhEXPVTheHf\"},\"api_key\":{\"title\":\"Api Key\",\"global\":true,\"value\":\"4436bd706f99efae69305e7c4eff4780de1335ce\"},\"server_name\":{\"title\":\"Server Name\",\"global\":true,\"value\":\"https:\\/\\/testnet.demo.btcpayserver.org\"},\"secret_code\":{\"title\":\"Secret Code\",\"global\":true,\"value\":\"SUCdqPn9CDkY7RmJHfpQVHP2Lf2\"}}', '{\"BTC\":\"Bitcoin\",\"LTC\":\"Litecoin\"}', 1, '{\"webhook\":{\"title\": \"IPN URL\",\"value\":\"ipn.BTCPay\"}}', NULL, NULL, '2024-05-07 08:08:13'),
(51, 0, 508, 'Now payments hosted', 'NowPaymentsHosted', '663a38b8d57a81715091640.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"--------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"------------\"}}', '{\"BTG\":\"BTG\",\"ETH\":\"ETH\",\"XMR\":\"XMR\",\"ZEC\":\"ZEC\",\"XVG\":\"XVG\",\"ADA\":\"ADA\",\"LTC\":\"LTC\",\"BCH\":\"BCH\",\"QTUM\":\"QTUM\",\"DASH\":\"DASH\",\"XLM\":\"XLM\",\"XRP\":\"XRP\",\"XEM\":\"XEM\",\"DGB\":\"DGB\",\"LSK\":\"LSK\",\"DOGE\":\"DOGE\",\"TRX\":\"TRX\",\"KMD\":\"KMD\",\"REP\":\"REP\",\"BAT\":\"BAT\",\"ARK\":\"ARK\",\"WAVES\":\"WAVES\",\"BNB\":\"BNB\",\"XZC\":\"XZC\",\"NANO\":\"NANO\",\"TUSD\":\"TUSD\",\"VET\":\"VET\",\"ZEN\":\"ZEN\",\"GRS\":\"GRS\",\"FUN\":\"FUN\",\"NEO\":\"NEO\",\"GAS\":\"GAS\",\"PAX\":\"PAX\",\"USDC\":\"USDC\",\"ONT\":\"ONT\",\"XTZ\":\"XTZ\",\"LINK\":\"LINK\",\"RVN\":\"RVN\",\"BNBMAINNET\":\"BNBMAINNET\",\"ZIL\":\"ZIL\",\"BCD\":\"BCD\",\"USDT\":\"USDT\",\"USDTERC20\":\"USDTERC20\",\"CRO\":\"CRO\",\"DAI\":\"DAI\",\"HT\":\"HT\",\"WABI\":\"WABI\",\"BUSD\":\"BUSD\",\"ALGO\":\"ALGO\",\"USDTTRC20\":\"USDTTRC20\",\"GT\":\"GT\",\"STPT\":\"STPT\",\"AVA\":\"AVA\",\"SXP\":\"SXP\",\"UNI\":\"UNI\",\"OKB\":\"OKB\",\"BTC\":\"BTC\"}', 1, '', NULL, NULL, '2024-05-07 08:20:40'),
(52, 0, 509, 'Now payments checkout', 'NowPaymentsCheckout', '663a38a59d2541715091621.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"---------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"-----------\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\"}', 1, '', NULL, NULL, '2024-05-07 08:20:21'),
(53, 0, 122, '2Checkout', 'TwoCheckout', '663a39b8e64b91715091896.png', 1, '{\"merchant_code\":{\"title\":\"Merchant Code\",\"global\":true,\"value\":\"253248016872\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"eQM)ID@&vG84u!O*g[p+\"}}', '{\"AFN\": \"AFN\",\"ALL\": \"ALL\",\"DZD\": \"DZD\",\"ARS\": \"ARS\",\"AUD\": \"AUD\",\"AZN\": \"AZN\",\"BSD\": \"BSD\",\"BDT\": \"BDT\",\"BBD\": \"BBD\",\"BZD\": \"BZD\",\"BMD\": \"BMD\",\"BOB\": \"BOB\",\"BWP\": \"BWP\",\"BRL\": \"BRL\",\"GBP\": \"GBP\",\"BND\": \"BND\",\"BGN\": \"BGN\",\"CAD\": \"CAD\",\"CLP\": \"CLP\",\"CNY\": \"CNY\",\"COP\": \"COP\",\"CRC\": \"CRC\",\"HRK\": \"HRK\",\"CZK\": \"CZK\",\"DKK\": \"DKK\",\"DOP\": \"DOP\",\"XCD\": \"XCD\",\"EGP\": \"EGP\",\"EUR\": \"EUR\",\"FJD\": \"FJD\",\"GTQ\": \"GTQ\",\"HKD\": \"HKD\",\"HNL\": \"HNL\",\"HUF\": \"HUF\",\"INR\": \"INR\",\"IDR\": \"IDR\",\"ILS\": \"ILS\",\"JMD\": \"JMD\",\"JPY\": \"JPY\",\"KZT\": \"KZT\",\"KES\": \"KES\",\"LAK\": \"LAK\",\"MMK\": \"MMK\",\"LBP\": \"LBP\",\"LRD\": \"LRD\",\"MOP\": \"MOP\",\"MYR\": \"MYR\",\"MVR\": \"MVR\",\"MRO\": \"MRO\",\"MUR\": \"MUR\",\"MXN\": \"MXN\",\"MAD\": \"MAD\",\"NPR\": \"NPR\",\"TWD\": \"TWD\",\"NZD\": \"NZD\",\"NIO\": \"NIO\",\"NOK\": \"NOK\",\"PKR\": \"PKR\",\"PGK\": \"PGK\",\"PEN\": \"PEN\",\"PHP\": \"PHP\",\"PLN\": \"PLN\",\"QAR\": \"QAR\",\"RON\": \"RON\",\"RUB\": \"RUB\",\"WST\": \"WST\",\"SAR\": \"SAR\",\"SCR\": \"SCR\",\"SGD\": \"SGD\",\"SBD\": \"SBD\",\"ZAR\": \"ZAR\",\"KRW\": \"KRW\",\"LKR\": \"LKR\",\"SEK\": \"SEK\",\"CHF\": \"CHF\",\"SYP\": \"SYP\",\"THB\": \"THB\",\"TOP\": \"TOP\",\"TTD\": \"TTD\",\"TRY\": \"TRY\",\"UAH\": \"UAH\",\"AED\": \"AED\",\"USD\": \"USD\",\"VUV\": \"VUV\",\"VND\": \"VND\",\"XOF\": \"XOF\",\"YER\": \"YER\"}', 0, '{\"approved_url\":{\"title\": \"Approved URL\",\"value\":\"ipn.TwoCheckout\"}}', NULL, NULL, '2024-05-07 08:24:56'),
(54, 0, 123, 'Checkout', 'Checkout', '663a3628733351715090984.png', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"------\"},\"public_key\":{\"title\":\"PUBLIC KEY\",\"global\":true,\"value\":\"------\"},\"processing_channel_id\":{\"title\":\"PROCESSING CHANNEL\",\"global\":true,\"value\":\"------\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"AUD\":\"AUD\",\"CAN\":\"CAN\",\"CHF\":\"CHF\",\"SGD\":\"SGD\",\"JPY\":\"JPY\",\"NZD\":\"NZD\"}', 0, NULL, NULL, NULL, '2024-05-07 08:09:44'),
(56, 0, 510, 'Binance', 'Binance', '663a35db4fd621715090907.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"tsu3tjiq0oqfbtmlbevoeraxhfbp3brejnm9txhjxcp4to29ujvakvfl1ibsn3ja\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"jzngq4t04ltw8d4iqpi7admfl8tvnpehxnmi34id1zvfaenbwwvsvw7llw3zdko8\"},\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"231129033\"}}', '{\"BTC\":\"Bitcoin\",\"USD\":\"USD\",\"BNB\":\"BNB\"}', 1, '{\"cron\":{\"title\": \"Cron Job URL\",\"value\":\"ipn.Binance\"}}', NULL, NULL, '2024-05-07 08:08:27'),
(57, 0, 124, 'SslCommerz', 'SslCommerz', '663a397a70c571715091834.png', 1, '{\"store_id\":{\"title\":\"Store ID\",\"global\":true,\"value\":\"---------\"},\"store_password\":{\"title\":\"Store Password\",\"global\":true,\"value\":\"----------\"}}', '{\"BDT\":\"BDT\",\"USD\":\"USD\",\"EUR\":\"EUR\",\"SGD\":\"SGD\",\"INR\":\"INR\",\"MYR\":\"MYR\"}', 0, NULL, NULL, NULL, '2024-05-07 08:23:54'),
(58, 0, 125, 'Aamarpay', 'Aamarpay', '663a34d5d1dfc1715090645.png', 1, '{\"store_id\":{\"title\":\"Store ID\",\"global\":true,\"value\":\"---------\"},\"signature_key\":{\"title\":\"Signature Key\",\"global\":true,\"value\":\"----------\"}}', '{\"BDT\":\"BDT\"}', 0, NULL, NULL, NULL, '2024-05-07 08:04:05');

-- --------------------------------------------------------

--
-- Table structure for table `gateway_currencies`
--

CREATE TABLE `gateway_currencies` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `symbol` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method_code` int DEFAULT NULL,
  `gateway_alias` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `max_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `percent_charge` decimal(5,2) NOT NULL DEFAULT '0.00',
  `fixed_charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `rate` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `gateway_parameter` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `site_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cur_text` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency text',
  `cur_sym` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency symbol',
  `email_from` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_from_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_template` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sms_template` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_from` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_template` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_color` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_config` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'email configuration',
  `sms_config` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `firebase_config` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `global_shortcodes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kv` tinyint(1) NOT NULL DEFAULT '0',
  `influencer_kv` tinyint(1) NOT NULL DEFAULT '0',
  `ev` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'email verification, 0 - dont check, 1 - check',
  `en` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'email notification, 0 - dont send, 1 - send',
  `sv` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'mobile verication, 0 - dont check, 1 - check',
  `sn` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'sms notification, 0 - dont send, 1 - send',
  `pn` tinyint(1) NOT NULL DEFAULT '1',
  `force_ssl` tinyint(1) NOT NULL DEFAULT '0',
  `in_app_payment` tinyint(1) NOT NULL DEFAULT '1',
  `maintenance_mode` tinyint(1) NOT NULL DEFAULT '0',
  `secure_password` tinyint(1) NOT NULL DEFAULT '0',
  `agree` tinyint(1) NOT NULL DEFAULT '0',
  `multi_language` tinyint(1) NOT NULL DEFAULT '1',
  `registration` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: Off	, 1: On',
  `influencer_registration` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: Off , 1: On ',
  `active_template` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `socialite_credentials` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_cron` datetime DEFAULT NULL,
  `available_version` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_customized` tinyint(1) NOT NULL DEFAULT '0',
  `max_image_upload` int DEFAULT '0',
  `campaign_approval_charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `brand_register_bonus_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `influencer_register_bonus_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `campaign_approve` tinyint(1) NOT NULL DEFAULT '0',
  `branregister_commission` tinyint(1) NOT NULL DEFAULT '0',
  `influencer_register_commission` tinyint(1) NOT NULL DEFAULT '0',
  `brand_register_commission` tinyint(1) NOT NULL DEFAULT '0',
  `influencer_withdrawal_commission` tinyint(1) NOT NULL DEFAULT '0',
  `campaign_charge` tinyint(1) NOT NULL DEFAULT '0',
  `paginate_number` int NOT NULL DEFAULT '0',
  `currency_format` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=>Both\r\n2=>Text Only\r\n3=>Symbol Only',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `site_name`, `cur_text`, `cur_sym`, `email_from`, `email_from_name`, `email_template`, `sms_template`, `sms_from`, `push_title`, `push_template`, `base_color`, `mail_config`, `sms_config`, `firebase_config`, `global_shortcodes`, `kv`, `influencer_kv`, `ev`, `en`, `sv`, `sn`, `pn`, `force_ssl`, `in_app_payment`, `maintenance_mode`, `secure_password`, `agree`, `multi_language`, `registration`, `influencer_registration`, `active_template`, `socialite_credentials`, `last_cron`, `available_version`, `system_customized`, `max_image_upload`, `campaign_approval_charge`, `brand_register_bonus_amount`, `influencer_register_bonus_amount`, `campaign_approve`, `branregister_commission`, `influencer_register_commission`, `brand_register_commission`, `influencer_withdrawal_commission`, `campaign_charge`, `paginate_number`, `currency_format`, `created_at`, `updated_at`) VALUES
(1, 'CollabStar', 'USD', '$', 'info@viserlab.com', '{{site_name}}', '<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n  <!--[if !mso]><!-->\r\n  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\r\n  <!--<![endif]-->\r\n  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n  <title></title>\r\n  <style type=\"text/css\">\r\n.ReadMsgBody { width: 100%; background-color: #ffffff; }\r\n.ExternalClass { width: 100%; background-color: #ffffff; }\r\n.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }\r\nhtml { width: 100%; }\r\nbody { -webkit-text-size-adjust: none; -ms-text-size-adjust: none; margin: 0; padding: 0; }\r\ntable { border-spacing: 0; table-layout: fixed; margin: 0 auto;border-collapse: collapse; }\r\ntable table table { table-layout: auto; }\r\n.yshortcuts a { border-bottom: none !important; }\r\nimg:hover { opacity: 0.9 !important; }\r\na { color: #0087ff; text-decoration: none; }\r\n.textbutton a { font-family: \'open sans\', arial, sans-serif !important;}\r\n.btn-link a { color:#FFFFFF !important;}\r\n\r\n@media only screen and (max-width: 480px) {\r\nbody { width: auto !important; }\r\n*[class=\"table-inner\"] { width: 90% !important; text-align: center !important; }\r\n*[class=\"table-full\"] { width: 100% !important; text-align: center !important; }\r\n/* image */\r\nimg[class=\"img1\"] { width: 100% !important; height: auto !important; }\r\n}\r\n</style>\r\n\r\n\r\n\r\n  <table bgcolor=\"#414a51\" width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n    <tbody><tr>\r\n      <td height=\"50\"></td>\r\n    </tr>\r\n    <tr>\r\n      <td align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n        <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n          <tbody><tr>\r\n            <td align=\"center\" width=\"600\">\r\n              <!--header-->\r\n              <table class=\"table-inner\" width=\"95%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                <tbody><tr>\r\n                  <td bgcolor=\"#0087ff\" style=\"border-top-left-radius:6px; border-top-right-radius:6px;text-align:center;vertical-align:top;font-size:0;\" align=\"center\">\r\n                    <table width=\"90%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td align=\"center\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#FFFFFF; font-size:16px; font-weight: bold;\">This is a System Generated Email</td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n              </tbody></table>\r\n              <!--end header-->\r\n              <table class=\"table-inner\" width=\"95%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                <tbody><tr>\r\n                  <td bgcolor=\"#FFFFFF\" align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n                    <table align=\"center\" width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"35\"></td>\r\n                      </tr>\r\n                      <!--logo-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"vertical-align:top;font-size:0;\">\r\n                          <a href=\"#\">\r\n                            <img style=\"display:block; line-height:0px; font-size:0px; border:0px;\" src=\"https://i.ibb.co/rw2fTRM/logo-dark.png\" width=\"220\" alt=\"img\">\r\n                          </a>\r\n                        </td>\r\n                      </tr>\r\n                      <!--end logo-->\r\n                      <tr>\r\n                        <td height=\"40\"></td>\r\n                      </tr>\r\n                      <!--headline-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"font-family: \'Open Sans\', Arial, sans-serif; font-size: 22px;color:#414a51;font-weight: bold;\">Hello {{fullname}} ({{username}})</td>\r\n                      </tr>\r\n                      <!--end headline-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n                          <table width=\"40\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                            <tbody><tr>\r\n                              <td height=\"20\" style=\" border-bottom:3px solid #0087ff;\"></td>\r\n                            </tr>\r\n                          </tbody></table>\r\n                        </td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                      <!--content-->\r\n                      <tr>\r\n                        <td align=\"left\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#7f8c8d; font-size:16px; line-height: 28px;\">{{message}}</td>\r\n                      </tr>\r\n                      <!--end content-->\r\n                      <tr>\r\n                        <td height=\"40\"></td>\r\n                      </tr>\r\n              \r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n                <tr>\r\n                  <td height=\"45\" align=\"center\" bgcolor=\"#f4f4f4\" style=\"border-bottom-left-radius:6px;border-bottom-right-radius:6px;\">\r\n                    <table align=\"center\" width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"10\"></td>\r\n                      </tr>\r\n                      <!--preference-->\r\n                      <tr>\r\n                        <td class=\"preference-link\" align=\"center\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#95a5a6; font-size:14px;\">\r\n                          © 2024 <a href=\"#\">{{site_name}}</a>&nbsp;. All Rights Reserved. \r\n                        </td>\r\n                      </tr>\r\n                      <!--end preference-->\r\n                      <tr>\r\n                        <td height=\"10\"></td>\r\n                      </tr>\r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n              </tbody></table>\r\n            </td>\r\n          </tr>\r\n        </tbody></table>\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td height=\"60\"></td>\r\n    </tr>\r\n  </tbody></table>', 'hi {{fullname}} ({{username}}), {{message}}', '{{site_name}}', '{{site_name}}', 'hi {{fullname}} ({{username}}), {{message}}', 'df3459', '{\"name\":\"php\"}', '{\"name\":\"clickatell\",\"clickatell\":{\"api_key\":\"----------------\"},\"infobip\":{\"username\":\"------------8888888\",\"password\":\"-----------------\"},\"message_bird\":{\"api_key\":\"-------------------\"},\"nexmo\":{\"api_key\":\"----------------------\",\"api_secret\":\"----------------------\"},\"sms_broadcast\":{\"username\":\"----------------------\",\"password\":\"-----------------------------\"},\"twilio\":{\"account_sid\":\"-----------------------\",\"auth_token\":\"---------------------------\",\"from\":\"----------------------\"},\"text_magic\":{\"username\":\"-----------------------\",\"apiv2_key\":\"-------------------------------\"},\"custom\":{\"method\":\"get\",\"url\":\"https:\\/\\/hostname.com\\/demo-api-v1\",\"headers\":{\"name\":[\"api_key\"],\"value\":[\"test_api 555\"]},\"body\":{\"name\":[\"from_number\"],\"value\":[\"5657545757\"]}}}', '{\"apiKey\":\"------------------------\",\"authDomain\":\"---------------------\",\"projectId\":\"----------------------\",\"storageBucket\":\"--------------------------\",\"messagingSenderId\":\"----------------------\",\"appId\":\"--------------------\",\"measurementId\":\"------------------------\"}', '{\n    \"site_name\":\"Name of your site\",\n    \"site_currency\":\"Currency of your site\",\n    \"currency_symbol\":\"Symbol of currency\"\n}', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 'basic', '{\"facebook\":{\"client_id\":\"----------------------\",\"client_secret\":\"---------------------\"},\"instagram\":{\"client_id\":\"---------------------\",\"client_secret\":\"--------------------\"},\"youtube\":{\"client_id\":\"---------------------------\",\"client_secret\":\"---------------------------\",\"api_key\":\"--------------------------\"}}', '2024-06-27 10:36:16', '1.0', 0, 5, 15.00000000, 15.00000000, 10.00000000, 0, 0, 0, 0, 0, 0, 20, 1, NULL, '2024-10-09 01:10:05');

-- --------------------------------------------------------

--
-- Table structure for table `influencers`
--

CREATE TABLE `influencers` (
  `id` bigint UNSIGNED NOT NULL,
  `firstname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dial_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `ref_by` int UNSIGNED NOT NULL DEFAULT '0',
  `referral_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'contains full address',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: banned, 1: active',
  `kyc_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kyc_rejection_reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kv` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: KYC Unverified, 2: KYC pending, 1: KYC verified',
  `ev` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: email unverified, 1: email verified',
  `sv` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: mobile unverified, 1: mobile verified',
  `profile_complete` tinyint(1) NOT NULL DEFAULT '0',
  `ver_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'stores verification code',
  `ver_code_send_at` datetime DEFAULT NULL COMMENT 'verification send time',
  `ts` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: 2fa off, 1: 2fa on',
  `tv` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: 2fa unverified, 1: 2fa verified',
  `tsc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ban_reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_seen` timestamp NULL DEFAULT NULL,
  `order_completed` int NOT NULL DEFAULT '0',
  `rating` decimal(5,2) NOT NULL DEFAULT '0.00',
  `total_review` int NOT NULL DEFAULT '0',
  `skills` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `gender` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `languages` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `influencer_categories`
--

CREATE TABLE `influencer_categories` (
  `id` int UNSIGNED NOT NULL,
  `influencer_id` int UNSIGNED NOT NULL DEFAULT '0',
  `category_id` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `influencer_password_resets`
--

CREATE TABLE `influencer_password_resets` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invite_campaigns`
--

CREATE TABLE `invite_campaigns` (
  `id` bigint UNSIGNED NOT NULL,
  `campaign_id` int UNSIGNED NOT NULL DEFAULT '0',
  `influencer_id` int UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: not default language, 1: default language',
  `image` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `is_default`, `image`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', 1, '66fbe212d637b1727783442.png', '2020-07-06 03:47:55', '2024-10-01 05:50:42'),
(14, 'Hindi', 'hi', 0, '66fbe21c262581727783452.png', '2024-10-01 05:50:52', '2024-10-01 05:50:52'),
(15, 'Bangla', 'bn', 0, '66fbe227099d21727783463.png', '2024-10-01 05:51:03', '2024-10-01 05:51:03');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_logs`
--

CREATE TABLE `notification_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `influencer_id` int UNSIGNED NOT NULL DEFAULT '0',
  `sender` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_from` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_to` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `notification_type` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_read` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_templates`
--

CREATE TABLE `notification_templates` (
  `id` bigint UNSIGNED NOT NULL,
  `act` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sms_body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `push_body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `shortcodes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `email_status` tinyint(1) NOT NULL DEFAULT '1',
  `email_sent_from_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_sent_from_address` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_status` tinyint(1) NOT NULL DEFAULT '1',
  `sms_sent_from` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_templates`
--

INSERT INTO `notification_templates` (`id`, `act`, `name`, `subject`, `push_title`, `email_body`, `sms_body`, `push_body`, `shortcodes`, `email_status`, `email_sent_from_name`, `email_sent_from_address`, `sms_status`, `sms_sent_from`, `push_status`, `created_at`, `updated_at`) VALUES
(1, 'BAL_ADD', 'Balance - Added', 'Your Account has been Credited', '{{site_name}} - Balance Added', '<div>We\'re writing to inform you that an amount of {{amount}} {{site_currency}} has been successfully added to your account.</div><div><br></div><div>Here are the details of the transaction:</div><div><br></div><div><b>Transaction Number: </b>{{trx}}</div><div><b>Current Balance:</b> {{post_balance}} {{site_currency}}</div><div><b>Admin Note:</b> {{remark}}</div><div><br></div><div>If you have any questions or require further assistance, please don\'t hesitate to contact us. We\'re here to assist you.</div>', 'We\'re writing to inform you that an amount of {{amount}} {{site_currency}} has been successfully added to your account.', '{{amount}} {{site_currency}} has been successfully added to your account.', '{\"trx\":\"Transaction number for the action\",\"amount\":\"Amount inserted by the admin\",\"remark\":\"Remark inserted by the admin\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, '{{site_name}} Finance', NULL, 0, NULL, 1, '2021-11-03 12:00:00', '2024-05-25 00:49:44'),
(2, 'BAL_SUB', 'Balance - Subtracted', 'Your Account has been Debited', '{{site_name}} - Balance Subtracted', '<div>We wish to inform you that an amount of {{amount}} {{site_currency}} has been successfully deducted from your account.</div><div><br></div><div>Below are the details of the transaction:</div><div><br></div><div><b>Transaction Number:</b> {{trx}}</div><div><b>Current Balance: </b>{{post_balance}} {{site_currency}}</div><div><b>Admin Note:</b> {{remark}}</div><div><br></div><div>Should you require any further clarification or assistance, please do not hesitate to reach out to us. We are here to assist you in any way we can.</div><div><br></div><div>Thank you for your continued trust in {{site_name}}.</div>', 'We wish to inform you that an amount of {{amount}} {{site_currency}} has been successfully deducted from your account.', '{{amount}} {{site_currency}} debited from your account.', '{\"trx\":\"Transaction number for the action\",\"amount\":\"Amount inserted by the admin\",\"remark\":\"Remark inserted by the admin\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, '{{site_name}} Finance', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:17:48'),
(3, 'DEPOSIT_COMPLETE', 'Deposit - Automated - Successful', 'Deposit Completed Successfully', '{{site_name}} - Deposit successful', '<div>We\'re delighted to inform you that your deposit of {{amount}} {{site_currency}} via {{method_name}} has been completed.</div><div><br></div><div>Below, you\'ll find the details of your deposit:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge: </b>{{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Received:</b> {{method_amount}} {{method_currency}}</div><div><b>Paid via:</b> {{method_name}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><div>Your current balance stands at {{post_balance}} {{site_currency}}.</div><div><br></div><div>If you have any questions or need further assistance, feel free to reach out to our support team. We\'re here to assist you in any way we can.</div>', 'We\'re delighted to inform you that your deposit of {{amount}} {{site_currency}} via {{method_name}} has been completed.', 'Deposit Completed Successfully', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, '{{site_name}} Billing', NULL, 1, NULL, 1, '2021-11-03 12:00:00', '2024-05-08 07:20:34'),
(4, 'DEPOSIT_APPROVE', 'Deposit - Manual - Approved', 'Deposit Request Approved', '{{site_name}} - Deposit Request Approved', '<div>We are pleased to inform you that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been approved.</div><div><br></div><div>Here are the details of your deposit:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge: </b>{{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Received: </b>{{method_amount}} {{method_currency}}</div><div><b>Paid via: </b>{{method_name}}</div><div><b>Transaction Number: </b>{{trx}}</div><div><br></div><div>Your current balance now stands at {{post_balance}} {{site_currency}}.</div><div><br></div><div>Should you have any questions or require further assistance, please feel free to contact our support team. We\'re here to help.</div>', 'We are pleased to inform you that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been approved.', 'Deposit of {{amount}} {{site_currency}} via {{method_name}} has been approved.', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, '{{site_name}} Billing', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:19:49'),
(5, 'DEPOSIT_REJECT', 'Deposit - Manual - Rejected', 'Deposit Request Rejected', '{{site_name}} - Deposit Request Rejected', '<div>We regret to inform you that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been rejected.</div><div><br></div><div>Here are the details of the rejected deposit:</div><div><br></div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Received:</b> {{method_amount}} {{method_currency}}</div><div><b>Paid via:</b> {{method_name}}</div><div><b>Charge:</b> {{charge}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><div>If you have any questions or need further clarification, please don\'t hesitate to contact us. We\'re here to assist you.</div><div><br></div><div>Rejection Reason:</div><div>{{rejection_message}}</div><div><br></div><div>Thank you for your understanding.</div>', 'We regret to inform you that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been rejected.', 'Your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been rejected.', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"rejection_message\":\"Rejection message by the admin\"}', 1, '{{site_name}} Billing', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:20:13'),
(6, 'DEPOSIT_REQUEST', 'Deposit - Manual - Requested', 'Deposit Request Submitted Successfully', NULL, '<div>We are pleased to confirm that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been submitted successfully.</div><div><br></div><div>Below are the details of your deposit:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge:</b> {{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Payable:</b> {{method_amount}} {{method_currency}}</div><div><b>Pay via: </b>{{method_name}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><div>Should you have any questions or require further assistance, please feel free to reach out to our support team. We\'re here to assist you.</div>', 'We are pleased to confirm that your deposit request of {{amount}} {{site_currency}} via {{method_name}} has been submitted successfully.', 'Your deposit request of {{amount}} {{site_currency}} via {{method_name}} submitted successfully.', '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\"}', 1, '{{site_name}} Billing', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-04-25 03:27:42'),
(7, 'PASS_RESET_CODE', 'Password - Reset - Code', 'Password Reset', '{{site_name}} Password Reset Code', '<div>We\'ve received a request to reset the password for your account on <b>{{time}}</b>. The request originated from\r\n            the following IP address: <b>{{ip}}</b>, using <b>{{browser}}</b> on <b>{{operating_system}}</b>.\r\n    </div><br>\r\n    <div><span>To proceed with the password reset, please use the following account recovery code</span>: <span><b><font size=\"6\">{{code}}</font></b></span></div><br>\r\n    <div><span>If you did not initiate this password reset request, please disregard this message. Your account security\r\n            remains our top priority, and we advise you to take appropriate action if you suspect any unauthorized\r\n            access to your account.</span></div>', 'To proceed with the password reset, please use the following account recovery code: {{code}}', 'To proceed with the password reset, please use the following account recovery code: {{code}}', '{\"code\":\"Verification code for password reset\",\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}', 1, '{{site_name}} Authentication Center', NULL, 0, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:24:57'),
(8, 'PASS_RESET_DONE', 'Password - Reset - Confirmation', 'Password Reset Successful', NULL, '<div><div><span>We are writing to inform you that the password reset for your account was successful. This action was completed at {{time}} from the following browser</span>: <span>{{browser}}</span><span>on {{operating_system}}, with the IP address</span>: <span>{{ip}}</span>.</div><br><div><span>Your account security is our utmost priority, and we are committed to ensuring the safety of your information. If you did not initiate this password reset or notice any suspicious activity on your account, please contact our support team immediately for further assistance.</span></div></div>', 'We are writing to inform you that the password reset for your account was successful.', 'We are writing to inform you that the password reset for your account was successful.', '{\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}', 1, '{{site_name}} Authentication Center', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-04-25 03:27:24'),
(9, 'ADMIN_SUPPORT_REPLY', 'Support - Reply', 'Re: {{ticket_subject}} - Ticket #{{ticket_id}}', '{{site_name}} - Support Ticket Replied', '<div>\r\n    <div><span>Thank you for reaching out to us regarding your support ticket with the subject</span>:\r\n        <span>\"{{ticket_subject}}\"&nbsp;</span><span>and ticket ID</span>: {{ticket_id}}.</div><br>\r\n    <div><span>We have carefully reviewed your inquiry, and we are pleased to provide you with the following\r\n            response</span><span>:</span></div><br>\r\n    <div>{{reply}}</div><br>\r\n    <div><span>If you have any further questions or need additional assistance, please feel free to reply by clicking on\r\n            the following link</span>: <a href=\"{{link}}\" title=\"\" target=\"_blank\">{{link}}</a><span>. This link will take you to\r\n            the ticket thread where you can provide further information or ask for clarification.</span></div><br>\r\n    <div><span>Thank you for your patience and cooperation as we worked to address your concerns.</span></div>\r\n</div>', 'Thank you for reaching out to us regarding your support ticket with the subject: \"{{ticket_subject}}\" and ticket ID: {{ticket_id}}. We have carefully reviewed your inquiry. To check the response, please go to the following link: {{link}}', 'Re: {{ticket_subject}} - Ticket #{{ticket_id}}', '{\"ticket_id\":\"ID of the support ticket\",\"ticket_subject\":\"Subject  of the support ticket\",\"reply\":\"Reply made by the admin\",\"link\":\"URL to view the support ticket\"}', 1, '{{site_name}} Support Team', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:26:06'),
(10, 'EVER_CODE', 'Verification - Email', 'Email Verification Code', NULL, '<div>\r\n    <div><span>Thank you for taking the time to verify your email address with us. Your email verification code\r\n            is</span>: <b><font size=\"6\">{{code}}</font></b></div><br>\r\n    <div><span>Please enter this code in the designated field on our platform to complete the verification\r\n            process.</span></div><br>\r\n    <div><span>If you did not request this verification code, please disregard this email. Your account security is our\r\n            top priority, and we advise you to take appropriate measures if you suspect any unauthorized access.</span>\r\n    </div><br>\r\n    <div><span>If you have any questions or encounter any issues during the verification process, please don\'t hesitate\r\n            to contact our support team for assistance.</span></div><br>\r\n    <div><span>Thank you for choosing us.</span></div>\r\n</div>', '---', '---', '{\"code\":\"Email verification code\"}', 1, '{{site_name}} Verification Center', NULL, 0, NULL, 0, '2021-11-03 12:00:00', '2024-04-25 03:27:12'),
(11, 'SVER_CODE', 'Verification - SMS', 'Verify Your Mobile Number', NULL, '---', 'Your mobile verification code is {{code}}. Please enter this code in the appropriate field to verify your mobile number. If you did not request this code, please ignore this message.', '---', '{\"code\":\"SMS Verification Code\"}', 0, '{{site_name}} Verification Center', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-04-25 03:27:03'),
(12, 'WITHDRAW_APPROVE', 'Withdraw - Approved', 'Withdrawal Confirmation: Your Request Processed Successfully', '{{site_name}} - Withdrawal Request Approved', '<div>We are writing to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been processed successfully.</div><div><br></div><div>Below are the details of your withdrawal:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge:</b> {{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>You will receive:</b> {{method_amount}} {{method_currency}}</div><div><b>Via:</b> {{method_name}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><hr><div><br></div><div><b>Details of Processed Payment:</b></div><div>{{admin_details}}</div><div><br></div><div>Should you have any questions or require further assistance, feel free to reach out to our support team. We\'re here to help.</div>', 'We are writing to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been processed successfully.', 'Withdrawal Confirmation: Your Request Processed Successfully', '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"admin_details\":\"Details provided by the admin\"}', 1, '{{site_name}} Finance', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:26:37'),
(13, 'WITHDRAW_REJECT', 'Withdraw - Rejected', 'Withdrawal Request Rejected', '{{site_name}} - Withdrawal Request Rejected', '<div>We regret to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been rejected.</div><div><br></div><div>Here are the details of your withdrawal:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge:</b> {{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Expected Amount:</b> {{method_amount}} {{method_currency}}</div><div><b>Via:</b> {{method_name}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><hr><div><br></div><div><b>Refund Details:</b></div><div>{{amount}} {{site_currency}} has been refunded to your account, and your current balance is {{post_balance}} {{site_currency}}.</div><div><br></div><hr><div><br></div><div><b>Reason for Rejection:</b></div><div>{{admin_details}}</div><div><br></div><div>If you have any questions or concerns regarding this rejection or need further assistance, please do not hesitate to contact our support team. We apologize for any inconvenience this may have caused.</div>', 'We regret to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been rejected.', 'Withdrawal Request Rejected', '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after fter this action\",\"admin_details\":\"Rejection message by the admin\"}', 1, '{{site_name}} Finance', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:26:55'),
(14, 'WITHDRAW_REQUEST', 'Withdraw - Requested', 'Withdrawal Request Confirmation', '{{site_name}} - Requested for withdrawal', '<div>We are pleased to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been submitted successfully.</div><div><br></div><div>Here are the details of your withdrawal:</div><div><br></div><div><b>Amount:</b> {{amount}} {{site_currency}}</div><div><b>Charge:</b> {{charge}} {{site_currency}}</div><div><b>Conversion Rate:</b> 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div><b>Expected Amount:</b> {{method_amount}} {{method_currency}}</div><div><b>Via:</b> {{method_name}}</div><div><b>Transaction Number:</b> {{trx}}</div><div><br></div><div>Your current balance is {{post_balance}} {{site_currency}}.</div><div><br></div><div>Should you have any questions or require further assistance, feel free to reach out to our support team. We\'re here to help.</div>', 'We are pleased to inform you that your withdrawal request of {{amount}} {{site_currency}} via {{method_name}} has been submitted successfully.', 'Withdrawal request submitted successfully', '{\"trx\":\"Transaction number for the withdraw\",\"amount\":\"Amount requested by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the withdraw method\",\"method_currency\":\"Currency of the withdraw method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after fter this transaction\"}', 1, '{{site_name}} Finance', NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2024-05-08 07:27:20'),
(15, 'DEFAULT', 'Default Template', '{{subject}}', '{{subject}}', '{{message}}', '{{message}}', '{{message}}', '{\"subject\":\"Subject\",\"message\":\"Message\"}', 1, NULL, NULL, 1, NULL, 1, '2019-09-14 13:14:22', '2024-05-16 01:32:53'),
(16, 'KYC_APPROVE', 'KYC Approved', 'KYC Details has been approved', '{{site_name}} - KYC Approved', '<div><div><span>We are pleased to inform you that your Know Your Customer (KYC) information has been successfully reviewed and approved. This means that you are now eligible to conduct any payout operations within our system.</span></div><br><div><span>Your commitment to completing the KYC process promptly is greatly appreciated, as it helps us ensure the security and integrity of our platform for all users.</span></div><br><div><span>With your KYC verification now complete, you can proceed with confidence to carry out any payout transactions you require. Should you encounter any issues or have any questions along the way, please don\'t hesitate to reach out to our support team. We\'re here to assist you every step of the way.</span></div><br><div><span>Thank you once again for choosing {{site_name}} and for your cooperation in this matter.</span></div></div>', 'We are pleased to inform you that your Know Your Customer (KYC) information has been successfully reviewed and approved. This means that you are now eligible to conduct any payout operations within our system.', 'Your  Know Your Customer (KYC) information has been approved successfully', '[]', 1, '{{site_name}} Verification Center', NULL, 1, NULL, 0, NULL, '2024-05-08 07:23:57'),
(17, 'KYC_REJECT', 'KYC Rejected', 'KYC has been rejected', '{{site_name}} - KYC Rejected', '<div><div><span>We regret to inform you that the Know Your Customer (KYC) information provided has been reviewed and unfortunately, it has not met our verification standards. As a result, we are unable to approve your KYC submission at this time.</span></div><br><div><span>We understand that this news may be disappointing, and we want to assure you that we take these matters seriously to maintain the security and integrity of our platform.</span></div><br><div><span>Reasons for rejection may include discrepancies or incomplete information in the documentation provided. If you believe there has been a misunderstanding or if you would like further clarification on why your KYC was rejected, please don\'t hesitate to contact our support team.</span></div><br><div><span>We encourage you to review your submitted information and ensure that all details are accurate and up-to-date. Once any necessary adjustments have been made, you are welcome to resubmit your KYC information for review.</span></div><br><div><span>We apologize for any inconvenience this may cause and appreciate your understanding and cooperation in this matter.</span></div><br><div>Rejection Reason:</div><div>{{reason}}</div><div><br></div><div><span>Thank you for your continued support and patience.</span></div></div>', 'We regret to inform you that the Know Your Customer (KYC) information provided has been reviewed and unfortunately, it has not met our verification standards. As a result, we are unable to approve your KYC submission at this time. We encourage you to review your submitted information and ensure that all details are accurate and up-to-date. Once any necessary adjustments have been made, you are welcome to resubmit your KYC information for review.', 'Your  Know Your Customer (KYC) information has been rejected', '{\"reason\":\"Rejection Reason\"}', 1, '{{site_name}} Verification Center', NULL, 1, NULL, 0, NULL, '2024-05-08 07:24:13'),
(18, 'CAMPAIGN_REQUEST_PENDING', 'Campaign Request Pending', 'Campaign Request Pending', 'Campaign Request Pending', 'Hi {{username}},<div><br></div><div>This is a friendly reminder that your campaign request is still pending.<br><br>Here is a summary of your request:</div><div><br></div><div>Campaign Title : {{title}}</div><div>Start Date : {{start_date}}</div><div>End Date : {{end_date}}<br><div>Budget : {{budget}} {{site_currency}}<br><br>Thanks<br></div></div>', 'Hi {{username}},\r\n\r\nThis is a friendly reminder that your campaign request is still pending.', 'Hi {{username}},\r\n\r\nThis is a friendly reminder that your campaign request is still pending.', '{\"username\":\"Brand Username\",\"title\":\"Campaign Title\",\"budget\":\"Campaign Budget\",\"start_date\":\"The campaign will be start\",\"end_date\":\"The campaign will be end\"}', 1, NULL, NULL, 1, NULL, 0, NULL, NULL),
(19, 'CAMPAIGN_REQUEST_APPROVED', 'Campaign Request Approved', 'Campaign Request Approved', 'Campaign Request Approved', '<div><span style=\"color: rgb(33, 37, 41);\">Hi {{username}},</span><div><br></div><div>We are excited to let you know that your campaign request for <b>{{title}} </b>has been approved.</div><div><br></div><div>Your campaign will launch on {{start_date}} and run till {{end_date}}.&nbsp;&nbsp;</div><div>Your budget is {{budget}} {{site_currency}}</div><div><br></div><div><div>Thanks</div></div></div>', 'We are excited to let you know that your campaign request for {{title}} has been approved.', 'We are excited to let you know that your campaign request for {{title}} has been approved.', '{\"username\":\"Brand Username\",\"title\":\"Campaign Title\",\"budget\":\"Campaign Budget\",\"start_date\":\"The campaign will be start\",\"end_date\":\"The campaign will be end\"}', 1, NULL, NULL, 1, NULL, 0, NULL, NULL),
(20, 'BRAND_ACCEPT_REQUEST', 'Brand Accept Participation Request', 'Brand has accepted campaign participation request', 'Brand has accepted campaign participation request', '<span style=\"color: rgb(33, 37, 41);\">Hi {{brand}},</span><div><br></div><div>You have accepted {{influencer}} in your campaign.</div><div>Your campaign {{title}}</div><div>Participant Number : {{participant_number}}</div><div>Campaign Budget : {{budget}} {{site_currency}}</div><div>{{budget}} {{site_currency}} has been subtacted in your account .</div><div>Your Post balance : {{post_balance}}</div><div>Transaction Number : {{trx}}</div><div><div>Thanks</div></div>', 'You have accepted {{influncer}} in your campaign.', 'You have accepted {{influncer}} in your campaign.', '{\r\n\"influencer\":\"Participate Influencer Username\", \"brand\":\"Campaign Creator\",\"participant_number\":\"Participant Number\",\"title\":\"Campaign Title\",\"budget\":\"Campaign Budget\",\"post_balance\":\"Advertiser Post Balance\",\"trx\":\"Transaction Number\"\r\n}', 1, NULL, NULL, 1, NULL, 0, NULL, NULL),
(21, 'PARTICIPATE_REQUEST_ACCEPTED', 'Campaign Participation Request Accepted', 'Campaign Participation Request Accepted', 'Campaign Participation Request Accepted', '<span style=\"color: rgb(33, 37, 41);\">Hi {{influencer}},</span><div><br></div><div>My Name is {{brand}}. I am letting you know that we have accepted your campaign participation request for our campaign.</div><div><br></div><div>Participant Number : {{participant_number}}</div><div><br></div><div><div>Thanks</div></div>', 'Hi {{influencer}},\r\nI am letting you know that we have accepted your campaign participation request for our campaign.', 'Hi {{influencer}},\r\nI am letting you know that we have accepted your campaign participation request for our campaign.', '{\r\n            \"influencer\":\"Participate Influencer Username\", \"brand\":\"Campaign Creator\",\"participant_number\":\"Participant Number\",\"title\":\"Campaign Title\"\r\n        }', 1, NULL, NULL, 1, NULL, 0, NULL, NULL),
(22, 'PARTICIPATE_REQUEST_REJECTED', 'Campaign Participation Request Rejected', 'Campaign Participation Request Rejected', 'Campaign Participation Request Rejected', '<span style=\"color: rgb(33, 37, 41);\">Hi {{influencer}},</span><div><br></div><div>My Name is {{brand}}. I am writing to inform you that we have declined your campaign participation request for our campaign.</div><div>Campaign Title : {{title}}</div><div>Participant Number : {{participant_number}}</div><div><br></div><div><div>Thanks</div></div>', 'I am writing to inform you that we have declined your campaign participation request for our campaign.\r\nParticipant Number : {{participant_number}}', 'I am writing to inform you that we have declined your campaign participation request for our campaign.\r\nParticipant Number : {{participant_number}}', '{\r\n            \"influencer\":\"Participate Influencer Username\", \"brand\":\"Campaign Creator\",\"participant_number\":\"Participant Number\",\"title\":\"Campaign Title\"\r\n        }', 1, NULL, NULL, 1, NULL, 0, NULL, NULL),
(23, 'CAMPAIGN_JOB_COMPLETED', 'Campaign Job Completed', 'Campaign Job Completed Successfully', 'Campaign Job Completed Successfully', '<span style=\"color: rgb(33, 37, 41);\">Dear {{influencer}},</span><div><br></div><div>My name is {{brand}} and I am writing to inform you that your job successfully completed.<br></div><div>The campaign title : {{title}}<br></div><div>Participant Number : {{participant_number}}</div><div>{{budget}} {{site_currency}} added in you account<br></div><div><div>Thanks</div></div>', 'My name is {{brand}} and I am writing to inform you that your job successfully', 'My name is {{brand}} and I am writing to inform you that your job successfully', '{\r\n            \"title\":\"Campaign Title\",\r\n            \"brand\":\"Campaign Creator\",\r\n            \"influencer\":\"Particated influencer in Campaign\",\r\n            \"participant_number\":\"Participant Number\",\"budget\":\"Campaign Budget\",\"trx\":\"Transaction Number\"        }', 1, NULL, NULL, 1, NULL, 0, NULL, NULL),
(24, 'CAMPAIGN_JOB_REPORTED', 'Campaign Job Reported', 'Brand Reported the Campaign Job', 'Brand Reported the Campaign Job', '<span style=\"color: rgb(33, 37, 41);\">Dear {{influencer}},</span><div><br></div><div>My name is {{brand}} and I am writing to inform you that I have reported on your job.</div><div>The campaign title : {{title}}<br></div><div>The reason is {{reason}}.</div><div>Participant Number : {{participant_number}}</div><div><div>Thanks</div></div>', 'My name is {{brand}} and I am writing to inform you that I have reported on your job.', 'My name is {{brand}} and I am writing to inform you that I have reported on your job.', '{\r\n            \"title\":\"Campaign Title\",\r\n            \"brand\":\"Campaign Creator\",\r\n            \"influencer\":\"Particated influencer in Campaign\",\r\n            \"participant_number\":\"Participant Number\",\"reason\":\"Reported Reason\"\r\n        }', 1, NULL, NULL, 1, NULL, 0, NULL, NULL),
(25, 'CAMPAIGN_PARTICIPANT_REQUEST', 'Campaign Participate Request', 'Campaign Participate Request', 'Campaign Participate Request', '<div><span style=\"color: rgb(33, 37, 41);\">Hi {{brand}},</span></div><div><br></div><div>{{influencer}} is request on your campaign.</div><div>Campaign Title : {{title}}</div><div>Participant Number : {{participant_number}}</div><div><br><div><div>Thanks</div></div></div>', 'Hi {{brand}},\r\n\r\n{{influencer}} is request on your campaign.', 'Hi {{brand}},\r\n\r\n{{influencer}} is request on your campaign.', '{\r\n            \"brand\":\"Campaign Creator Username\",\r\n            \"influencer\":\"Participant Influencer Username\",\r\n            \"participant_number\":\"Participant Number\",\"title\":\"Campaign Title\"\r\n        }', 1, NULL, NULL, 1, NULL, 0, NULL, NULL),
(26, 'PARTICIPATE_REQUEST_PENDING', 'Campaign Participation Request Pending', 'Campaign Participation Request Pending', 'Campaign Participation Request Pending', '<span style=\"color: rgb(33, 37, 41);\">Hi {{influencer}},</span><div><br></div><div>I am the at {{brand}}. I am writing to let you know that we have received your campaign participation request for our campaign.</div><div>We are currenlty reviewing all request, and we will be in touch with you as soon as we have a decision.</div><div>Campaign Title : {{title}}</div><div>Participant Number : {{participant_number}}</div><div><br></div><div>Thanks</div>', 'I am writing to let you know that we have received your campaign participation request for our campaign.\r\nParticipant Number : {{participant_number}}', 'I am writing to let you know that we have received your campaign participation request for our campaign.\r\nParticipant Number : {{participant_number}}', '{\r\n            \"influencer\":\"Participate Influencer Username\", \"brand\":\"Brand Name\",\"participant_number\":\"Participant Number\",\"title\":\"Campaign Title\"\r\n        }', 1, NULL, NULL, 1, NULL, 0, NULL, NULL),
(27, 'IN_FAVOUR_OF_BRAND', 'Admin In Favour of Advertiser', 'Admin In Favour of Brand', 'Admin In Favour of Brand', '<div><span style=\"color: rgb(33, 37, 41);\">Dear {{brand}},</span></div><div><span style=\"color: rgb(33, 37, 41);\"><br></span></div>The administrator has decided in favour to you<div><br></div><div>The Campaign Title : {{title}}<br></div><div>Participant Number : {{participant_number}}</div><div><br></div><div>{{budget}}&nbsp;{{site_currency}} {{site_currency}} added in your account</div><div>Transaction Number : {{trx}}<br></div><div><div>Thanks</div></div>', 'The administrator has decided in favour to you', 'The administrator has decided in favour to you', '{\r\n            \"title\":\"Campaign Title\",\r\n            \"brand\":\"Campaign Creator\",\r\n        \"participant_number\":\"Participant Number\",\"budget\":\"Campaign Budget\",\"trx\":\"Transaction Number\"        }', 1, NULL, NULL, 1, NULL, 0, NULL, '2024-09-25 06:58:57'),
(28, 'CAMPAIGN_JOB_REJECTED', 'Campaign Job Rejected', 'Campaign Job Rejected Successfully', 'Campaign Job Rejected Successfully', '<span style=\"color: rgb(33, 37, 41);\">Dear {{influencer}},</span><div><br></div><div>I am an administrator. I am writing to inform you that your campaign job has been rejected.</div><div>Administrator in favor of {{brand}}</div><div>The campaign title : {{title}}<br></div><div>Participant Number : {{participant_number}}</div><div><div><br></div><div>Thanks</div></div>', 'Dear {{influencer}},\r\nI am writing to inform you that your campaign job has been rejected', 'Dear {{influencer}},\r\nI am writing to inform you that your campaign job has been rejected', '{\r\n            \"title\":\"Campaign Title\",\r\n            \"brand\":\"Campaign Creator\",\r\n            \"influencer\":\"Particated influencer in Campaign\",\r\n            \"participant_number\":\"Participant Number\"       }', 1, NULL, NULL, 1, NULL, 0, NULL, NULL),
(29, 'IN_FAVOUR_OF_INFLUENCER', 'Admin In Favour of Influencer', 'Admin in favour of Influencer', 'Admin in favour of Influencer', '<span style=\"color: rgb(33, 37, 41);\">Dear {{brand}},</span><div><br></div><div>Administrator has decided in favour of {{influencer}}<br></div><div>The campaign title : {{title}}<br></div><div>Participant Number : {{participant_number}}</div><div><div>Thanks</div></div>', 'Administrator has decided in favour of {{influencer}}', 'Administrator has decided in favour of {{influencer}}', '{\r\n            \"title\":\"Campaign Title\",\r\n            \"brand\":\"Campaign Creator\",\r\n            \"influencer\":\"Particated influencer in Campaign\",\r\n            \"participant_number\":\"Participant Number\"       }', 1, NULL, NULL, 1, NULL, 0, NULL, NULL),
(30, 'SEND_INVITE_REQUEST', 'Send Invite Request For Campaign', 'Send Invite Request For Campaign', 'Send Invite Request For Campaign', '<div>Hi {{username}},</div><div><br></div><div>You are invited to this campaign.</div><div>Campaign Title : {{title}}</div><div>Campaign will be end&nbsp; : {{end_date}}<br></div><br><div>Thanks<br></div><div><br></div>', 'Hi {{username}},\r\n\r\nYou are invited to this campaign.', 'Hi {{username}},\r\n\r\nYou are invited to this campaign.', '{\r\n                \"username\" :\"Influencer Username\",\r\n                \"title\" : \"Campaign Title\",\r\n                \"end_date\": \"Campaign Ending Date\"\r\n            }', 1, NULL, NULL, 1, NULL, 0, NULL, NULL),
(31, 'CAMPAIGN_APPROVAL_CHARGE', 'Campaign Approval Charge', 'Campaign Approval Charge', 'Campaign Approval Charge', '<span style=\"color: rgb(33, 37, 41);\">Hi {{brand}},</span><div><br></div><div>We are excited to let you know that your campaign request for <b>{{title}} </b>has been approved.</div><div><span style=\"color: var(--bs-body-color); font-size: 1rem; text-align: var(--bs-body-text-align);\">we deducted {{charge}} {{site_currency}} from your account for campaign approval.</span><br></div><div>TRX : {{trx}}</div><div><br></div><div><div>Thanks<br></div></div>', 'We are excited to let you know that your campaign request for {{title}} has been approved.\r\nwe deducted {{charge}} {{site_currency}} from your account for campaign approval.', 'We are excited to let you know that your campaign request for {{title}} has been approved.\r\nwe deducted {{charge}} {{site_currency}} from your account for campaign approval.', '{\r\n                \"brand\":\"Brand Username\",\r\n                \"charge\":\"Campaign Approval Charge\",\r\n                \"trx\":\"Transaction Number\",\r\n                \"title\":\"Campaign Title\"\r\n            }', 1, NULL, NULL, 1, NULL, 0, NULL, NULL),
(32, 'REFERRAL_COMMISSION', 'Referral Commission', 'Referral Commission', 'Referral Commission', '<div>Hi,</div><div>You have got {{amount}} {{site_currency}} for {{type}} referral commission.</div><div>Commission level is {{level}}</div><div>Transaction Number : {{trx}}</div><div>Post Balance : {{post_balance}}<br></div>', 'You have got {{amount}} {{site_currency}} for {{type}} referral commission.', 'You have got {{amount}} {{site_currency}} for {{type}} referral commission.', '{\"amount\":\"Referral Commission Amount\",\"amount\":\"Post Balance\",\"trx\":\"Transaction Number\",\"level\":\"Commission of level\",\"type\":\"Commission Type\"}', 1, NULL, NULL, 1, NULL, 0, NULL, NULL),
(33, 'CAMPAIGN_JOB_DELIVERED', 'Campaign Job Delivered', 'Influencer Delivered the Campaign Job', 'Influencer Delivered the Campaign Job', '<span style=\"color: rgb(33, 37, 41);\">Dear {{brand}},</span><div><br></div><div>My name is {{influencer}}, and I am writing to inform you that I have delivered all of the campaign materials for the {{title}} campaign<br></div><div>I have attached all of the deliverables to this email.<br></div><div>Participant Number : {{participant_number}}</div><div><div>Thanks</div></div>', 'My name is {{influencer}}, and I am writing to inform you that I have delivered all of the campaign materials for the {{title}} campaign', 'My name is {{influencer}}, and I am writing to inform you that I have delivered all of the campaign materials for the {{title}} campaign', '{\r\n            \"title\":\"Campaign Title\",\r\n            \"brand\":\"Campaign Creator\",\r\n            \"influencer\":\"Particated influencer in Campaign\",\r\n            \"participant_number\":\"Participant Number\"\r\n        }', 1, NULL, NULL, 1, NULL, 0, NULL, NULL),
(34, 'CAMPAIGN_JOB_CANCELED', 'Campaign Job Canceled', 'Influencer Canceled the Campaign Job', 'Influencer Canceled the Campaign Job', '<span style=\"color: rgb(33, 37, 41);\">Dear {{brand}},</span><div><br></div><div>My name is {{influencer}}, and I am wrtting to inform you that i will be unable to participate in the campaign.</div><div><br></div><div>I wish you all the best with the campaign, and i hope that we can collaborate in the future.</div><div>Campaign : {{title}},</div><div>Participant Number : {{participant_number}}</div><div><br></div><div>{{budget}} {{site_currency}} added in your account.</div><div>Transaction Number : {{trx}}</div><div><br></div><div><div>Thanks</div></div>', 'My name is {{influencer}}, and I am wrtting to inform you that i will be unable to participate in the campaign.', 'My name is {{influencer}}, and I am wrtting to inform you that i will be unable to participate in the campaign.', '{\r\n            \"title\":\"Campaign Title\",\r\n            \"brand\":\"Campaign Creator\",\r\n            \"influencer\":\"Particated influencer in Campaign\",\r\n            \"participant_number\":\"Participant Number\",\r\n            \"budget\" : \"Campaign Budget\",\r\n            \"trx\":\"Transaction Number\"\r\n        }', 1, NULL, NULL, 1, NULL, 0, NULL, NULL),
(35, 'CAMPAIGN_REQUEST_REJECTED', 'Campaign Request Rejected', 'Campaign Request Rejected', 'Campaign Request Rejected', '<div><span style=\"color: rgb(33, 37, 41);\">Hi {{username}},</span><div><br></div><div>We are writing to inform you that your campaign request for <b>{{title}} </b>has been rejected.</div><div>The reason for the rejection is {{reason}}</div><div>Your campaign will launch on {{start_date}} and run till {{end_date}}.&nbsp;&nbsp;</div><div>Your budget is {{budget}} {{site_currency}}</div><div><br></div><div><div>Thanks</div></div></div>', 'We are writing to inform you that your campaign request for {{title}} has been rejected.', 'We are writing to inform you that your campaign request for {{title}} has been rejected.', '{\"username\":\"Brand Username\",\"title\":\"Campaign Title\",\"budget\":\"Campaign Budget\",\"start_date\":\"The campaign will be start\",\"end_date\":\"The campaign will be end\",\"reason\":\"Campaign Rejected Reason\"}', 1, NULL, NULL, 1, NULL, 0, NULL, NULL),
(36, 'INFLUENCER_REGISTER_COMMISSION', 'Influencer Register Commission', 'Influencer Register Commission', 'Influencer Register Commission', 'Hello {{fullname}},<div>You have got a register bonus.</div><div>{{amount}} {{site_currency}} add on your wallet.</div><div><br></div>', 'Hello {{fullname}},\r\nYou have got a register bonus.\r\n{{amount}} {{site_currency}} add on your wallet.', 'Hello {{fullname}},\r\nYou have got a register bonus.\r\n{{amount}} {{site_currency}} add on your wallet.', '{\"username\":\"New Registered Influencer Fullname\",\"amount\":\"Influencer Register Bonus\"}', 1, NULL, NULL, 1, NULL, 0, NULL, NULL),
(37, 'BRAND_REGISTER_COMMISSION', 'Brand Register Commission', 'Brand Register Commission', 'Brand Register Commission', 'Hello {{fullname}},<div>You have got a register bonus.</div><div>{{amount}} {{site_currency}} add on your wallet.</div><div><br></div>', 'Hello {{fullname}},\r\nYou have got a register bonus.\r\n{{amount}} {{site_currency}} add on your wallet.', 'Hello {{fullname}},\r\nYou have got a register bonus.\r\n{{amount}} {{site_currency}} add on your wallet.', '{\"username\":\"New Registered Brand Fullname\",\"amount\":\"Brand Register Bonus\"}', 1, NULL, NULL, 1, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'template name',
  `secs` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `seo_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `slug`, `tempname`, `secs`, `seo_content`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'HOME', '/', 'templates.basic.', '[\"partner\",\"top_influencer\",\"category\",\"how_work\",\"feature\",\"counter\",\"ongoing_campaign\",\"testimonial\",\"blog\",\"cta\"]', NULL, 1, '2020-07-11 06:23:58', '2024-09-11 06:54:28'),
(4, 'Blog', 'blog', 'templates.basic.', NULL, NULL, 1, '2020-10-22 01:14:43', '2020-10-22 01:14:43'),
(5, 'Contact', 'contact', 'templates.basic.', '[\"faq\"]', NULL, 1, '2020-10-22 01:14:53', '2024-10-08 05:38:45'),
(28, 'Campaigns', 'campaigns', 'templates.basic.', NULL, NULL, 1, '2024-09-18 05:26:29', '2024-09-18 05:26:29'),
(29, 'Influencers', 'influencers', 'templates.basic.', NULL, NULL, 1, '2024-09-18 05:34:44', '2024-09-18 05:34:44'),
(30, 'Categories', 'categories', 'templates.basic.', NULL, NULL, 1, '2024-09-27 23:51:56', '2024-09-27 23:55:52'),
(33, 'FAQ', 'faq', 'templates.basic.', '[\"faq\",\"cta\",\"blog\"]', NULL, 0, '2024-10-01 05:39:15', '2024-10-08 23:58:33'),
(34, 'About', 'about', 'templates.basic.', '[\"category\",\"how_work\",\"feature\",\"counter\",\"blog\"]', NULL, 0, '2024-10-01 05:39:23', '2024-10-09 00:16:18');

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `id` bigint NOT NULL,
  `influencer_id` int UNSIGNED NOT NULL DEFAULT '0',
  `campaign_id` int UNSIGNED NOT NULL DEFAULT '0',
  `participant_number` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `budget` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `invitation_letter` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `report_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `platforms`
--

CREATE TABLE `platforms` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `platforms`
--

INSERT INTO `platforms` (`id`, `name`, `icon`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Facebook', '<i class=\"fab fa-facebook\"></i>', 1, '2023-09-12 06:05:03', '2024-09-11 01:10:55'),
(2, 'Instagram', '<i class=\"fab fa-instagram\"></i>', 1, '2023-09-12 06:06:05', '2024-10-01 04:27:33'),
(3, 'Youtube', '<i class=\"fab fa-youtube\"></i>', 1, '2023-09-12 06:06:37', '2023-09-12 06:06:37');

-- --------------------------------------------------------

--
-- Table structure for table `profile_galleries`
--

CREATE TABLE `profile_galleries` (
  `id` bigint UNSIGNED NOT NULL,
  `influencer_id` int UNSIGNED NOT NULL DEFAULT '0',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
  `id` bigint UNSIGNED NOT NULL,
  `commission_type` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` int NOT NULL DEFAULT '0',
  `percent` decimal(5,2) NOT NULL DEFAULT '0.00',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `participant_id` int UNSIGNED NOT NULL DEFAULT '0',
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `influencer_id` int UNSIGNED NOT NULL DEFAULT '0',
  `star` tinyint(1) NOT NULL DEFAULT '0',
  `review` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `social_links`
--

CREATE TABLE `social_links` (
  `id` bigint UNSIGNED NOT NULL,
  `influencer_id` int UNSIGNED NOT NULL DEFAULT '0',
  `platform_id` int UNSIGNED NOT NULL DEFAULT '0',
  `followers` bigint NOT NULL DEFAULT '0',
  `social_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `channel_connect` tinyint(1) NOT NULL DEFAULT '0',
  `social_user_id` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_attachments`
--

CREATE TABLE `support_attachments` (
  `id` bigint UNSIGNED NOT NULL,
  `support_message_id` int UNSIGNED NOT NULL DEFAULT '0',
  `attachment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_messages`
--

CREATE TABLE `support_messages` (
  `id` bigint UNSIGNED NOT NULL,
  `support_ticket_id` int UNSIGNED NOT NULL DEFAULT '0',
  `admin_id` int UNSIGNED NOT NULL DEFAULT '0',
  `message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int DEFAULT '0',
  `influencer_id` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: Open, 1: Answered, 2: Replied, 3: Closed',
  `priority` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = Low, 2 = medium, 3 = heigh',
  `last_reply` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `influencer_id` int NOT NULL DEFAULT '0',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `post_balance` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `trx_type` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `update_logs`
--

CREATE TABLE `update_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `update_log` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `firstname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `dial_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'contains full address',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: banned, 1: active',
  `kyc_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kyc_rejection_reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kv` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: KYC Unverified, 2: KYC pending, 1: KYC verified',
  `ev` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: email unverified, 1: email verified',
  `sv` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: mobile unverified, 1: mobile verified',
  `profile_complete` tinyint(1) NOT NULL DEFAULT '0',
  `ver_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'stores verification code',
  `ver_code_send_at` datetime DEFAULT NULL COMMENT 'verification send time',
  `ban_reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_last_seen` timestamp NULL DEFAULT NULL,
  `brand_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_logins`
--

CREATE TABLE `user_logins` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `influencer_id` int UNSIGNED NOT NULL DEFAULT '0',
  `user_ip` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` bigint UNSIGNED NOT NULL,
  `method_id` int UNSIGNED NOT NULL DEFAULT '0',
  `influencer_id` int UNSIGNED NOT NULL DEFAULT '0',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `currency` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `trx` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `final_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `after_charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `withdraw_information` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=>success, 2=>pending, 3=>cancel,  ',
  `admin_feedback` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_methods`
--

CREATE TABLE `withdraw_methods` (
  `id` bigint UNSIGNED NOT NULL,
  `form_id` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_limit` decimal(28,8) DEFAULT '0.00000000',
  `max_limit` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `fixed_charge` decimal(28,8) DEFAULT '0.00000000',
  `rate` decimal(28,8) DEFAULT '0.00000000',
  `percent_charge` decimal(5,2) DEFAULT NULL,
  `currency` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`username`);

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campaign_categories`
--
ALTER TABLE `campaign_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campaign_conversations`
--
ALTER TABLE `campaign_conversations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `campaign_platforms`
--
ALTER TABLE `campaign_platforms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `campaign_platforms_campaign_id_foreign` (`campaign_id`),
  ADD KEY `campaign_platforms_platform_id_foreign` (`platform_id`);

--
-- Indexes for table `campaign_tags`
--
ALTER TABLE `campaign_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device_tokens`
--
ALTER TABLE `device_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extensions`
--
ALTER TABLE `extensions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontends`
--
ALTER TABLE `frontends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateways`
--
ALTER TABLE `gateways`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `influencers`
--
ALTER TABLE `influencers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `influencer_categories`
--
ALTER TABLE `influencer_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `influencer_id` (`influencer_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `influencer_password_resets`
--
ALTER TABLE `influencer_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invite_campaigns`
--
ALTER TABLE `invite_campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_logs`
--
ALTER TABLE `notification_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_templates`
--
ALTER TABLE `notification_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `platforms`
--
ALTER TABLE `platforms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile_galleries`
--
ALTER TABLE `profile_galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_links`
--
ALTER TABLE `social_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_attachments`
--
ALTER TABLE `support_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `update_logs`
--
ALTER TABLE `update_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`,`email`);

--
-- Indexes for table `user_logins`
--
ALTER TABLE `user_logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw_methods`
--
ALTER TABLE `withdraw_methods`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `campaign_categories`
--
ALTER TABLE `campaign_categories`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `campaign_conversations`
--
ALTER TABLE `campaign_conversations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `campaign_platforms`
--
ALTER TABLE `campaign_platforms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `campaign_tags`
--
ALTER TABLE `campaign_tags`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `device_tokens`
--
ALTER TABLE `device_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `extensions`
--
ALTER TABLE `extensions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frontends`
--
ALTER TABLE `frontends`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `gateways`
--
ALTER TABLE `gateways`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `influencers`
--
ALTER TABLE `influencers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `influencer_categories`
--
ALTER TABLE `influencer_categories`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `influencer_password_resets`
--
ALTER TABLE `influencer_password_resets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invite_campaigns`
--
ALTER TABLE `invite_campaigns`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_logs`
--
ALTER TABLE `notification_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_templates`
--
ALTER TABLE `notification_templates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `platforms`
--
ALTER TABLE `platforms`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `profile_galleries`
--
ALTER TABLE `profile_galleries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `social_links`
--
ALTER TABLE `social_links`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_attachments`
--
ALTER TABLE `support_attachments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `update_logs`
--
ALTER TABLE `update_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_logins`
--
ALTER TABLE `user_logins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdraw_methods`
--
ALTER TABLE `withdraw_methods`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
