-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour geststagiaires
CREATE DATABASE IF NOT EXISTS `geststagiaires` /*!40100 DEFAULT CHARACTER SET armscii8 COLLATE armscii8_bin */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `geststagiaires`;

-- Listage de la structure de table geststagiaires. applications
CREATE TABLE IF NOT EXISTS `applications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table geststagiaires.applications : ~0 rows (environ)

-- Listage de la structure de table geststagiaires. attestations
CREATE TABLE IF NOT EXISTS `attestations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `superviseur_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `activities` json NOT NULL,
  `signature_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut` enum('en cours','complété','signé','envoyé') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en cours',
  `date_generation` datetime NOT NULL,
  `date_signature` datetime DEFAULT NULL,
  `date_envoi` datetime DEFAULT NULL,
  `rapport_id` bigint unsigned NOT NULL,
  `superviseur_id` bigint unsigned NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `attestations_rapport_id_foreign` (`rapport_id`),
  KEY `attestations_superviseur_id_foreign` (`superviseur_id`),
  CONSTRAINT `attestations_rapport_id_foreign` FOREIGN KEY (`rapport_id`) REFERENCES `rapports` (`id`) ON DELETE CASCADE,
  CONSTRAINT `attestations_superviseur_id_foreign` FOREIGN KEY (`superviseur_id`) REFERENCES `superviseurs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table geststagiaires.attestations : ~13 rows (environ)
INSERT INTO `attestations` (`id`, `superviseur_name`, `company_name`, `company_address`, `activities`, `signature_path`, `statut`, `date_generation`, `date_signature`, `date_envoi`, `rapport_id`, `superviseur_id`, `file_path`, `created_at`, `updated_at`) VALUES
	(1, 'carlos De Bordeaux', '', '', '"[]"', NULL, 'en cours', '2025-05-09 08:25:02', NULL, NULL, 2, 1, NULL, '2025-05-09 07:25:02', '2025-05-09 07:25:02'),
	(2, 'carlos De Bordeaux', '', '', '"[]"', NULL, 'en cours', '2025-05-09 08:46:07', NULL, NULL, 3, 1, NULL, '2025-05-09 07:46:07', '2025-05-09 07:46:07'),
	(3, 'carlos De Bordeaux', '', '', '"[]"', NULL, 'en cours', '2025-05-09 09:10:08', NULL, NULL, 4, 1, NULL, '2025-05-09 08:10:08', '2025-05-09 08:10:08'),
	(4, 'carlos De Bordeaux', '', '', '"[]"', NULL, 'en cours', '2025-05-09 10:26:06', NULL, NULL, 6, 1, NULL, '2025-05-09 09:26:06', '2025-05-09 09:26:06'),
	(5, 'carlos De Bordeaux', '', '', '"[]"', NULL, 'en cours', '2025-05-09 11:25:43', NULL, NULL, 7, 1, NULL, '2025-05-09 10:25:43', '2025-05-09 10:25:43'),
	(6, 'carlos De Bordeaux', '', '', '"[]"', NULL, 'en cours', '2025-05-09 21:25:54', NULL, NULL, 8, 1, NULL, '2025-05-09 20:25:54', '2025-05-09 20:25:54'),
	(7, 'carlos De Bordeaux', '', '', '"[]"', NULL, 'en cours', '2025-05-09 22:30:16', NULL, NULL, 10, 1, NULL, '2025-05-09 21:30:16', '2025-05-09 21:30:16'),
	(8, 'carlos De Bordeaux', '', '', '"[]"', NULL, 'en cours', '2025-05-09 22:30:36', NULL, NULL, 9, 1, NULL, '2025-05-09 21:30:36', '2025-05-09 21:30:36'),
	(9, 'carlos De Bordeaux', '', '', '"[]"', NULL, 'en cours', '2025-05-09 22:58:51', NULL, NULL, 11, 1, NULL, '2025-05-09 21:58:51', '2025-05-09 21:58:51'),
	(11, 'carlos De Bordeaux', 'Nom de l\'entreprise', 'Adresse de l\'entreprise', '"[\\"Activit\\\\u00e9 1\\",\\"Activit\\\\u00e9 2\\"]"', NULL, 'en cours', '2025-05-10 02:46:01', NULL, NULL, 13, 1, NULL, '2025-05-10 01:46:01', '2025-05-10 01:46:01'),
	(12, 'carlos De Bordeaux', 'Nom de l\'entreprise', 'Adresse de l\'entreprise', '"[\\"Activit\\\\u00e9 1\\",\\"Activit\\\\u00e9 2\\"]"', NULL, 'en cours', '2025-05-10 02:56:16', NULL, NULL, 14, 1, NULL, '2025-05-10 01:56:16', '2025-05-10 01:56:16'),
	(14, 'carlos De Bordeaux', 'Nom de l\'entreprise', 'Adresse de l\'entreprise', '"[\\"Activit\\\\u00e9 1\\",\\"Activit\\\\u00e9 2\\"]"', 'signatures/681f23d9d07a2.png', 'envoyé', '2025-05-10 07:56:36', '2025-05-10 10:00:57', '2025-05-10 10:01:12', 16, 1, 'public/attestations/attestation-14.pdf', '2025-05-10 06:56:36', '2025-05-10 09:01:12'),
	(15, 'carlos De Bordeaux', 'OTAK-MING', 'Haie-Vive; Rue 1030 avenue St Hermès', '"[\\"intervention sur la gestion des appareils\\",\\"Assistance lors des \\\\u00e9v\\\\u00e8nements majeures\\",\\"Contribution a l\'ouverture d\'un site partenariat\\"]"', 'signatures/681fb7fe93028.png', 'envoyé', '2025-05-10 20:31:15', '2025-05-10 20:33:02', '2025-05-10 20:35:09', 17, 1, 'public/attestations/attestation-15.pdf', '2025-05-10 19:31:15', '2025-05-10 19:35:09');

-- Listage de la structure de table geststagiaires. demandes_stage
CREATE TABLE IF NOT EXISTS `demandes_stage` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `stagiaire_id` bigint unsigned DEFAULT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `formation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `specialisation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lettre_motivation_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en_attente_sg',
  `authorization` tinyint(1) NOT NULL DEFAULT '0',
  `assigned_department` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `authorized_by` bigint unsigned DEFAULT NULL,
  `authorized_at` timestamp NULL DEFAULT NULL COMMENT 'Date et heure de l''autorisation',
  `rejected_by` bigint unsigned DEFAULT NULL,
  `rejected_at` timestamp NULL DEFAULT NULL COMMENT 'Date et heure du rejet',
  `signature_path` text COLLATE utf8mb4_unicode_ci COMMENT 'Signature électronique en format base64',
  `department_id` bigint unsigned DEFAULT NULL,
  `intern_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_created` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `demandes_stage_stagiaire_id_foreign` (`stagiaire_id`),
  KEY `demandes_stage_authorized_by_foreign` (`authorized_by`),
  KEY `demandes_stage_rejected_by_foreign` (`rejected_by`),
  KEY `demandes_stage_department_id_foreign` (`department_id`),
  CONSTRAINT `demandes_stage_authorized_by_foreign` FOREIGN KEY (`authorized_by`) REFERENCES `stagiaires` (`id`) ON DELETE SET NULL,
  CONSTRAINT `demandes_stage_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `demandes_stage_rejected_by_foreign` FOREIGN KEY (`rejected_by`) REFERENCES `stagiaires` (`id`) ON DELETE SET NULL,
  CONSTRAINT `demandes_stage_stagiaire_id_foreign` FOREIGN KEY (`stagiaire_id`) REFERENCES `stagiaires` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table geststagiaires.demandes_stage : ~7 rows (environ)
INSERT INTO `demandes_stage` (`id`, `stagiaire_id`, `prenom`, `nom`, `email`, `telephone`, `formation`, `specialisation`, `lettre_motivation_path`, `date_debut`, `date_fin`, `created_at`, `updated_at`, `status`, `authorization`, `assigned_department`, `authorized_by`, `authorized_at`, `rejected_by`, `rejected_at`, `signature_path`, `department_id`, `intern_code`, `account_created`) VALUES
	(1, 1, 'robin', 'BATMAN', 'chrisdaiki7@gmail.com', '58187101', 'Licence', 'Informatique', 'lettres_motivation/d1lCcTBhpF4vMgRromBzRb9U7kOIWXwFCupDnVvt.pdf', '2025-04-28', '2025-05-15', '2025-05-08 17:14:54', '2025-05-08 18:09:21', 'approved', 0, NULL, NULL, '2025-05-08 17:28:38', NULL, NULL, 'signatures/sign_1_1746728918.png', 1, 'STG-SMGUOB', 1),
	(2, 2, 'Trisha', 'vonyle', 'trishavonyle@gmail.com', '0140526589', 'Master', 'juristes', 'lettres_motivation/b0mgxxiMQKY3NaYwdcK5dt6RA3OyLVtdCm84A4ok.pdf', '2025-04-29', '2025-05-07', '2025-05-08 17:16:18', '2025-05-08 18:16:07', 'approved', 0, NULL, NULL, '2025-05-08 17:28:09', NULL, NULL, 'signatures/sign_2_1746728889.png', 3, 'STG-ECPVHS', 1),
	(3, 3, 'benoit', 'Helsing', 'benoithelsing01@gmail.com', '0158254499', 'Licence', 'logistiques', 'lettres_motivation/lrLGu4aa8isI7SdP6L65coMHg8kQX2otb3sPWgGE.pdf', '2025-04-03', '2025-05-08', '2025-05-08 17:17:30', '2025-05-10 23:00:40', 'approved', 0, NULL, NULL, '2025-05-08 17:27:46', NULL, NULL, 'signatures/sign_3_1746728866.png', 2, 'STG-QKMJNW', 1),
	(4, 4, 'zer', 'rtyui', 'zer@gmail.com', '0140253699', 'Licence', 'Cuisine', 'lettres_motivation/zG8POazsUMhL7nwYmpDH4ShUtQkZtjnBemYJsGEW.pdf', '2025-04-14', '2025-06-08', '2025-05-10 01:49:11', '2025-05-10 01:58:00', 'approved', 0, NULL, NULL, '2025-05-10 01:52:33', NULL, NULL, 'signatures/sign_4_1746845553.png', 2, 'STG-6DQUW4', 1),
	(5, NULL, 'boio', 'kko', 'lil@gmail.com', '0196366399', 'Master', 'juristes', 'lettres_motivation/Stw3mcPVCu6WaJnmy9uF6JNPtpVgrI5wwwdyVkqp.pdf', '2025-05-06', '2025-05-31', '2025-05-11 00:10:26', '2025-05-12 08:34:25', 'transferee_dpaf', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
	(6, NULL, 'David', 'SESSOU', 'davidsessou007@gmail.com', '0160124090', 'Licence', 'Informatiques', 'lettres_motivation/MfZIBbVEz83cnTckp9zNEnlRhCbdl33Ee1MjXrN8.pdf', '2025-03-03', '2025-06-03', '2025-05-13 13:34:11', '2025-05-13 13:37:43', 'approved', 0, NULL, NULL, '2025-05-13 13:37:43', NULL, NULL, 'signatures/sign_6_1747147063.png', 1, 'STG-EW85E4', 0),
	(7, NULL, 'aristide', 'SESSOU', 'aristidesessou324@gmail.com', '0160405490', 'Licence', 'Informatique', 'lettres_motivation/DyJ7cOQLghuh7fFuqOYiSt4Dwn7kIbW6DXknwv32.pdf', '2025-03-03', '2025-06-03', '2025-05-13 13:45:34', '2025-05-13 13:48:09', 'approved', 0, NULL, NULL, '2025-05-13 13:48:09', NULL, NULL, 'signatures/sign_7_1747147689.png', 1, 'STG-YEABU1', 0);

-- Listage de la structure de table geststagiaires. departments
CREATE TABLE IF NOT EXISTS `departments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `departments_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table geststagiaires.departments : ~5 rows (environ)
INSERT INTO `departments` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'Direction de Système D\'information', '2025-05-08 18:23:47', '2025-05-08 18:23:49'),
	(2, 'Direction Ressources Humaines', '2025-05-08 18:23:50', '2025-05-08 18:23:52'),
	(3, 'Direction Juridiques', '2025-05-08 18:24:43', '2025-05-08 18:24:44'),
	(4, 'Direction Commerciale', '2025-05-08 18:25:20', '2025-05-08 18:25:21'),
	(5, 'Direction Techniques', '2025-05-08 18:25:42', '2025-05-08 18:25:44');

-- Listage de la structure de table geststagiaires. dpafs
CREATE TABLE IF NOT EXISTS `dpafs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dpafs_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table geststagiaires.dpafs : ~1 rows (environ)
INSERT INTO `dpafs` (`id`, `nom`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Karl', 'dpaf@gmail.com', '$2y$12$lqKfAYgtIpcJWcV3kEZn9utigGuOefzlMRN2nCNyfrIcvhCEFJ/T.', NULL, '2025-05-08 17:19:38', '2025-05-08 17:19:38');

-- Listage de la structure de table geststagiaires. evenements
CREATE TABLE IF NOT EXISTS `evenements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `stagiaire_id` bigint unsigned NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `couleur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#3b82f6',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `evenements_stagiaire_id_foreign` (`stagiaire_id`),
  CONSTRAINT `evenements_stagiaire_id_foreign` FOREIGN KEY (`stagiaire_id`) REFERENCES `stagiaires` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table geststagiaires.evenements : ~0 rows (environ)

-- Listage de la structure de table geststagiaires. failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table geststagiaires.failed_jobs : ~0 rows (environ)

-- Listage de la structure de table geststagiaires. memoires
CREATE TABLE IF NOT EXISTS `memoires` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stagiaire_id` bigint unsigned NOT NULL,
  `submit_date` date NOT NULL,
  `status` enum('pending','approved','rejected','revision') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `summary` text COLLATE utf8mb4_unicode_ci,
  `field` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `feedback` text COLLATE utf8mb4_unicode_ci,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `review_requested_at` timestamp NULL DEFAULT NULL,
  `resubmitted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `memoires_stagiaire_id_foreign` (`stagiaire_id`),
  CONSTRAINT `memoires_stagiaire_id_foreign` FOREIGN KEY (`stagiaire_id`) REFERENCES `stagiaires` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table geststagiaires.memoires : ~3 rows (environ)
INSERT INTO `memoires` (`id`, `title`, `stagiaire_id`, `submit_date`, `status`, `summary`, `field`, `feedback`, `file_path`, `created_at`, `updated_at`, `review_requested_at`, `resubmitted_at`) VALUES
	(1, 'plateforme digitale de gestion et de suivi de stagiaire', 3, '2025-05-09', 'approved', 'Aucun résumé fourni', 'Non spécifié', NULL, 'memoires/7HZmEugZ2YNqXM7VTxc6eayxyuVuafhrwjtZwOor.pdf', '2025-05-09 15:02:20', '2025-05-09 16:45:19', NULL, NULL),
	(2, 'plateforme digitale de gestion et de suivi de stagiaire', 3, '2025-05-09', 'revision', 'Aucun résumé fourni', 'Non spécifié', 'revoire quelques données', 'memoires/xpXycwUrjtKLzxwD1yrOrqFbjKDFxKgNkW6UmOuP.pdf', '2025-05-09 15:03:51', '2025-05-09 15:58:48', NULL, NULL),
	(3, 'plateforme digitale de gestion et de suivi de stagiaire', 3, '2025-05-09', 'rejected', 'Aucun résumé fourni', 'Non spécifié', 'pas cohérent.HS', 'memoires/8hjgHiphTlaNtwn3Dr5PXrKswvE83F9jY1z1l4ar.docx', '2025-05-09 16:42:07', '2025-05-09 16:46:16', NULL, '2025-05-09 16:42:07');

-- Listage de la structure de table geststagiaires. migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table geststagiaires.migrations : ~55 rows (environ)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
	(4, '2019_08_19_000000_create_failed_jobs_table', 1),
	(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(6, '2025_03_25_205204_create_demande_stages_table', 1),
	(7, '2025_04_16_210028_create_roles_table', 2),
	(8, '2025_03_25_205551_create_stagiaires_table', 3),
	(9, '2025_03_25_205707_create_rapports_table', 3),
	(10, '2025_03_25_205743_create_memoires_table', 3),
	(11, '2025_03_25_205815_create_attestations_table', 3),
	(12, '2025_03_25_205848_create_notifications_table', 3),
	(13, '2025_03_25_221000_create_sessions_table', 3),
	(14, '2025_03_26_101037_create_applications_table', 3),
	(15, '2025_05_05_234316_create_superviseurs_table', 4),
	(16, '2025_04_18_163304_create_taches_table', 5),
	(17, '2025_04_22_152253_create_evenements_table', 5),
	(18, '2025_04_24_193949_create_profiles_table', 5),
	(19, '2025_04_24_201321_add_stagiaire_id_to_demandes_stage_table', 5),
	(20, '2025_04_24_213627_add_columns_to_rapports_table', 5),
	(21, '2025_04_25_092511_create_parametres_table', 5),
	(22, '2025_04_28_143344_update_lettre_motivation_column', 5),
	(23, '2025_04_29_152443_create_sgs_table', 5),
	(24, '2025_04_29_213332_create_dpafs_table', 5),
	(25, '2025_04_30_081042_create_srhds_table', 5),
	(26, '2025_04_30_142645_add_status_to_demandes_stage_table', 5),
	(27, '2025_05_02_094502_verify_and_add_authorization_fields_to_demandes_stage_table', 5),
	(28, '2025_05_02_155346_add_assigned_department_to_demandes_stage_table', 5),
	(29, '2025_05_02_161958_add_department_to_demandes_stage_table', 5),
	(30, '2025_05_02_171806_add_authorization_to_demandes_stage_table', 5),
	(31, '2025_05_02_182508_create_departements_table', 5),
	(32, '2025_05_02_183018_add_department_id_to_demandes_stage_table', 5),
	(33, '2025_05_03_150034_add_intern_code_to_demandes_stage_table', 5),
	(34, '2025_05_03_152919_rename_signature_to_signature_path_in_demandes_stage', 5),
	(35, '2025_05_04_153154_add_account_created_to_demandes_stage_table', 5),
	(36, '2025_05_06_230543_add_superviseur_id_to_stagiaires_table', 5),
	(37, '2025_05_06_232134_add_foreign_key_to_stagiaires_table', 5),
	(38, '2025_05_06_233846_add_statut_to_taches_table', 5),
	(39, '2025_05_06_233921_add_statut_to_rapports_table', 5),
	(40, '2025_05_06_233943_add_statut_to_memoires_table', 5),
	(41, '2025_05_07_184212_add_more_fields_to_stagiaires_table', 5),
	(42, '2025_05_08_011513_add_added_manually_to_stagiaires_table', 5),
	(43, '2025_05_08_223828_create_attestations_table', 6),
	(44, '2025_05_08_234020_fix_missing_rapports_data', 7),
	(45, '2025_05_09_102038_add_feedback_to_rapports_table', 8),
	(46, '2025_05_09_104818_make_fichier_nullable_in_rapports_table', 9),
	(47, '2025_05_09_110602_fix_rapports_file_paths', 10),
	(48, '2025_05_09_120724_create_memoires_table', 11),
	(49, '2025_05_09_160004_create_memoires_table', 12),
	(50, '2025_05_09_173012_add_review_fields_to_memoires_table', 13),
	(51, '2025_05_09_204722_add_file_path_to_attestations_table', 14),
	(52, '2025_05_10_014647_update_statut_column_in_attestations_table', 15),
	(53, '2025_05_10_095954_update_statut_column_in_attestations_table', 15),
	(54, '2025_05_10_202220_move_rapports_to_public_folder', 16),
	(55, '2025_05_11_002116_add_department_and_supervisor_to_profiles_table', 17);

-- Listage de la structure de table geststagiaires. notifications
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table geststagiaires.notifications : ~0 rows (environ)

-- Listage de la structure de table geststagiaires. parametres
CREATE TABLE IF NOT EXISTS `parametres` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `stagiaire_id` bigint unsigned NOT NULL,
  `notifications` tinyint(1) NOT NULL DEFAULT '1',
  `email_alerts` tinyint(1) NOT NULL DEFAULT '1',
  `dark_mode` tinyint(1) NOT NULL DEFAULT '0',
  `language` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fr',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parametres_stagiaire_id_foreign` (`stagiaire_id`),
  CONSTRAINT `parametres_stagiaire_id_foreign` FOREIGN KEY (`stagiaire_id`) REFERENCES `stagiaires` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table geststagiaires.parametres : ~0 rows (environ)

-- Listage de la structure de table geststagiaires. password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table geststagiaires.password_reset_tokens : ~0 rows (environ)

-- Listage de la structure de table geststagiaires. personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table geststagiaires.personal_access_tokens : ~0 rows (environ)

-- Listage de la structure de table geststagiaires. profiles
CREATE TABLE IF NOT EXISTS `profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `stagiaire_id` bigint unsigned NOT NULL,
  `avatar_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supervisor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `profiles_stagiaire_id_foreign` (`stagiaire_id`),
  CONSTRAINT `profiles_stagiaire_id_foreign` FOREIGN KEY (`stagiaire_id`) REFERENCES `stagiaires` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table geststagiaires.profiles : ~2 rows (environ)
INSERT INTO `profiles` (`id`, `stagiaire_id`, `avatar_path`, `department`, `supervisor`, `bio`, `created_at`, `updated_at`) VALUES
	(1, 2, 'avatars/stagiaires/8mUzVngxVxiaFwHlCrpJNzs7sJl64QZOS3BxZX2S.jpg', NULL, NULL, NULL, '2025-05-08 18:16:49', '2025-05-08 18:17:24'),
	(2, 3, 'avatars/stagiaires/G2iroJZJaPVKABEagZwxHBVvtplrJyxKQllqJVJC.jpg', 'Ressources Humaines', 'De Bordeaux Carlos', NULL, '2025-05-09 12:53:18', '2025-05-10 23:29:04');

-- Listage de la structure de table geststagiaires. rapports
CREATE TABLE IF NOT EXISTS `rapports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `stagiaire_id` bigint unsigned NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `original_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comments` text COLLATE utf8mb4_unicode_ci,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en attente',
  `feedback` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `rapports_stagiaire_id_foreign` (`stagiaire_id`),
  CONSTRAINT `rapports_stagiaire_id_foreign` FOREIGN KEY (`stagiaire_id`) REFERENCES `stagiaires` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table geststagiaires.rapports : ~15 rows (environ)
INSERT INTO `rapports` (`id`, `stagiaire_id`, `file_path`, `original_name`, `comments`, `submitted_at`, `created_at`, `updated_at`, `statut`, `feedback`) VALUES
	(1, 3, 'rapports/4RAYPBrngBVpjIk591p2qa7vfvaH6VPD1tRrfnYp.pdf', 'ORGANIGRAMME.pdf', 'mon stage exceptionnel', '2025-05-08 23:03:40', '2025-05-08 23:03:40', '2025-05-09 06:33:59', 'rejeté', NULL),
	(2, 3, 'rapports/LagwQlQoa4gPou9eRtxvGXXkjH2136sLpI0p7Qhv.pdf', 'Plan de mémoire.pdf', 'j\'aime bien me foutre de la gueule de tout le monde', '2025-05-09 06:45:29', '2025-05-09 06:45:29', '2025-05-09 07:09:37', 'approuvé', NULL),
	(3, 1, 'rapports/OIiSW8xU9MVfNgpaOrdgpKzzV2jNexQONJKmzkm0.pdf', 'Autorisation de stage n° 0240.pdf', 'je suis un bon élément', '2025-05-09 07:30:48', '2025-05-09 07:30:48', '2025-05-09 07:46:07', 'approuvé', NULL),
	(4, 3, 'rapports/QD3j5pBvdE9z12vS7bzZeTl3twlKUjlcuEwy9xXr.pdf', 'IVY assistant virtuel - Lorraine AHODOMON & KINKPON Marie Sylvanus.pdf', 'gboké il n\'y a pas pitié dedans', '2025-05-09 07:55:45', '2025-05-09 07:55:45', '2025-05-09 08:10:08', 'approuvé', NULL),
	(5, 1, 'rapports/NuTbtwv6eejcGhA9wjv4GSFfvuuihHozZwz6SOhq.pdf', 'MEMOIRE DE OWEN & CHRIS.pdf', 'c\'est pour les pros no testing', '2025-05-09 08:13:00', '2025-05-09 08:13:00', '2025-05-09 09:24:03', 'rejeté', NULL),
	(6, 3, 'rapports/BIAkZVmJ7gGExLQ1yld8BlrZACi1ickGACV3JRfd.pdf', 'Plan de mémoire.pdf', 'jjjjjjjjjjjjjj nicke ta race', '2025-05-09 09:25:33', '2025-05-09 09:25:33', '2025-05-09 09:26:06', 'approuvé', NULL),
	(7, 1, 'rapports/u6nO7BFt9WmSQizfP8coPiEZYeMLGdqF6pI7POrV.pdf', 'INTERFACE GRAPHIQUE cours .pdf', 'c\'est mon rapport au long de ce stage', '2025-05-09 09:53:00', '2025-05-09 09:53:00', '2025-05-09 10:25:43', 'approuvé', NULL),
	(8, 3, 'rapports/nqO5P87rJgbkgiwDOwktmv8jXFSn6uiGP3hYf9ZO.pdf', 'Signature CS 02-04-2025 15.39.pdf', 'gjkjg dfghg dfghjhgf shjhg', '2025-05-09 12:54:34', '2025-05-09 12:54:34', '2025-05-09 20:25:54', 'approuvé', NULL),
	(9, 1, 'rapports/CzChbiA6YvDulKQAzG3IMKQWlPqOvTq0izUlg4GN.pdf', 'ORGANIGRAMME.pdf', 'it is my rapport', '2025-05-09 20:24:21', '2025-05-09 20:24:21', '2025-05-09 21:30:36', 'approuvé', NULL),
	(10, 3, 'rapports/1O63sZboLaVVJi9peNVvYzlF6nD4fMKfEELJRfJk.pdf', 'Signature CS 02-04-2025 15.39.pdf', 'lllllllllllllllll nnnnnnnnnnnn ooooooooo bghjkbhjgvgh hjhbj', '2025-05-09 21:29:34', '2025-05-09 21:29:34', '2025-05-09 21:30:16', 'approuvé', NULL),
	(11, 1, 'rapports/mnrUl4zfyo6s9a3Pv3cRdjOnmVyj0q5zOiqMsqhO.pdf', 'IVY assistant virtuel - Lorraine AHODOMON & KINKPON Marie Sylvanus.pdf', 'je fais des essai- version test 13', '2025-05-09 21:57:54', '2025-05-09 21:57:54', '2025-05-09 21:58:51', 'approuvé', NULL),
	(13, 3, 'rapports/BjHR8xmpJWbEGrEd9tsFtKxju7QbaFhIWo0jzxGP.pdf', 'Autorisation de stage n° 0240.pdf', 'je nick vos race tout le long de ce stage', '2025-05-10 01:44:54', '2025-05-10 01:44:54', '2025-05-10 01:46:01', 'approuvé', NULL),
	(14, 1, 'rapports/VSl5DD5VwCmVrCKboL8kIyViZREXs8yXcCtDCQzz.pdf', 'test-rapport.pdf', 'j\'ai fait un test pour voir si la logique est correcte', '2025-05-10 01:55:33', '2025-05-10 01:55:33', '2025-05-10 01:56:16', 'approuvé', NULL),
	(16, 4, 'rapports/7aF11qltLkZbWtRAVHGjHjfMe7djmRKUIh7bR7Qf.pdf', 'rapport 2.pdf', 'dgfhjkl mljkhgf molkjfghj', '2025-05-10 06:55:44', '2025-05-10 06:55:44', '2025-05-10 06:56:36', 'approuvé', NULL),
	(17, 2, 'rapports/GmL2fsTvRnRwxl9OdZ1pVpwExBBVq00y2xkO1gmY.pdf', 'dia.pdf', 'c\'est mon rapport test correcte-01', '2025-05-10 19:29:59', '2025-05-10 19:29:59', '2025-05-10 19:31:15', 'approuvé', NULL);

-- Listage de la structure de table geststagiaires. roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_nom_unique` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table geststagiaires.roles : ~5 rows (environ)
INSERT INTO `roles` (`id`, `nom`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'Stagiaire', 'Utilisateur Stagiaire', '2025-05-08 19:06:00', '2025-05-08 19:06:01'),
	(2, 'SG', 'Sécrétaire Générale', '2025-05-08 19:06:30', '2025-05-08 19:06:32'),
	(3, 'DPAF', 'Direction de Planification des Affaires Sociales et Financières', '2025-05-08 19:07:24', '2025-05-08 19:07:35'),
	(4, 'SRHDS', 'Services de Ressources Humaines..', '2025-05-08 19:08:23', '2025-05-08 19:08:24'),
	(5, 'Superviseur', 'Superviseur', '2025-05-08 19:08:50', '2025-05-08 19:08:51');

-- Listage de la structure de table geststagiaires. sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table geststagiaires.sessions : ~1 rows (environ)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('AKSiuODMDAfrF97I2CveyonAGMUUND6X0IcVIhac', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZXRVZ1lVQjBMTVhOZTl5NHpkNWwxaU96QTNWSnpqdGNxSDZGZXFFOSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fX0=', 1747154808);

-- Listage de la structure de table geststagiaires. sgs
CREATE TABLE IF NOT EXISTS `sgs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sgs_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table geststagiaires.sgs : ~1 rows (environ)
INSERT INTO `sgs` (`id`, `nom`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'victoria', 'sg@gmail.com', '$2y$12$DdpZLQNGwKs6Eq.qKEYhT.Xdj94/vOQhpol2noYB.RaVR9XSDEbNq', NULL, '2025-05-08 17:18:40', '2025-05-08 17:18:40');

-- Listage de la structure de table geststagiaires. srhds
CREATE TABLE IF NOT EXISTS `srhds` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `srhds_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table geststagiaires.srhds : ~1 rows (environ)
INSERT INTO `srhds` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Goldung', 'srhds@gmail.com', '$2y$12$jkNB2jDTx1odMv96Wxosgen.Wc9Ihrx/ZnO/ylKMi0GI45.Nn5ZIm', NULL, '2025-05-08 17:21:25', '2025-05-08 17:21:25');

-- Listage de la structure de table geststagiaires. stagiaires
CREATE TABLE IF NOT EXISTS `stagiaires` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `intern_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_validated` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint unsigned NOT NULL DEFAULT '1',
  `superviseur_id` bigint unsigned DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `niveau_etude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'actif',
  `added_manually` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `stagiaires_email_unique` (`email`),
  UNIQUE KEY `stagiaires_intern_id_unique` (`intern_id`),
  KEY `stagiaires_role_id_foreign` (`role_id`),
  KEY `stagiaires_superviseur_id_foreign` (`superviseur_id`),
  CONSTRAINT `stagiaires_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  CONSTRAINT `stagiaires_superviseur_id_foreign` FOREIGN KEY (`superviseur_id`) REFERENCES `superviseurs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table geststagiaires.stagiaires : ~4 rows (environ)
INSERT INTO `stagiaires` (`id`, `nom`, `prenom`, `email`, `intern_id`, `password`, `is_validated`, `remember_token`, `created_at`, `updated_at`, `role_id`, `superviseur_id`, `telephone`, `niveau_etude`, `date_debut`, `date_fin`, `statut`, `added_manually`) VALUES
	(1, 'BATMAN', 'robin', 'chrisdaiki7@gmail.com', 'STG-SMGUOB', '$2y$12$oqARqn1N.fTnMES3FsHDcuqLGla6K5DddrWO3NbdHXBetd5rOq2Pu', 1, NULL, '2025-05-08 18:09:21', '2025-05-13 08:20:21', 1, 1, NULL, NULL, NULL, NULL, 'actif', 0),
	(2, 'vonyle', 'trisha', 'trishavonyle@gmail.com', 'STG-ECPVHS', '$2y$12$MOEfqxrQvfJBZkTyHCZdjuZisB2221wAwfSUDaV2uDvMoriZ8DhdK', 1, NULL, '2025-05-08 18:16:07', '2025-05-12 12:59:15', 1, 1, NULL, NULL, NULL, NULL, 'terminé', 0),
	(3, 'Helsing', 'benoit', 'benoithelsing01@gmail.com', 'STG-QKMJNW', '$2y$12$m7lNIL1fPWh4Dh6ymEAfn.B0SRoEvQgWUXtz7.HH/p.jwGV0HABxK', 1, NULL, '2025-05-08 18:22:09', '2025-05-12 12:59:15', 1, 1, NULL, NULL, NULL, NULL, 'terminé', 0),
	(4, 'zer', 'rtyui', 'zer@gmail.com', 'STG-6DQUW4', '$2y$12$ACYV4c5Ry/DNxIUGnlblnenDETzXbyPnsXzuMw9HnsR5M9NB8hiVe', 1, NULL, '2025-05-10 01:58:00', '2025-05-13 08:20:38', 1, 1, NULL, NULL, NULL, NULL, 'actif', 0);

-- Listage de la structure de table geststagiaires. superviseurs
CREATE TABLE IF NOT EXISTS `superviseurs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poste` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `departement` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `superviseurs_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table geststagiaires.superviseurs : ~1 rows (environ)
INSERT INTO `superviseurs` (`id`, `nom`, `prenom`, `email`, `password`, `poste`, `departement`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'De Bordeaux', 'carlos', 'akoffodjichris@gmail.com', '$2y$12$w1ZrfISMhrLXoH/bIUuK6Onm5VNX0t5zaM5pwWJbWpt/ldbPHC0X.', 'directeur', 'informatique', NULL, '2025-05-08 18:24:03', '2025-05-08 18:24:03');

-- Listage de la structure de table geststagiaires. taches
CREATE TABLE IF NOT EXISTS `taches` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','in_progress','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `deadline` datetime NOT NULL,
  `stagiaire_id` bigint unsigned NOT NULL,
  `assigned_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `taches_stagiaire_id_foreign` (`stagiaire_id`),
  KEY `taches_assigned_by_foreign` (`assigned_by`),
  CONSTRAINT `taches_assigned_by_foreign` FOREIGN KEY (`assigned_by`) REFERENCES `superviseurs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `taches_stagiaire_id_foreign` FOREIGN KEY (`stagiaire_id`) REFERENCES `stagiaires` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table geststagiaires.taches : ~4 rows (environ)
INSERT INTO `taches` (`id`, `title`, `description`, `status`, `deadline`, `stagiaire_id`, `assigned_by`, `created_at`, `updated_at`) VALUES
	(1, 'cahier de charge', 'rendu du cahier de charge des entreprises passés dans la semaine', 'completed', '2025-05-13 00:00:00', 3, 1, '2025-05-08 20:25:27', '2025-05-09 13:07:29'),
	(2, 'directeur', 'decris owen', 'pending', '2025-05-10 00:00:00', 3, 1, '2025-05-09 12:52:17', '2025-05-10 19:42:58'),
	(3, 'gag', 'je veux une révision des plateformes developpées', 'completed', '2025-05-11 00:00:00', 2, 1, '2025-05-10 19:44:48', '2025-05-10 21:38:51'),
	(4, 'test taches2.0', 'je veux voir ce qui se passe ici afin de les optimiser', 'completed', '2025-05-12 00:00:00', 2, 1, '2025-05-10 21:40:29', '2025-05-10 22:17:43');

-- Listage de la structure de table geststagiaires. users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint unsigned DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table geststagiaires.users : ~0 rows (environ)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
