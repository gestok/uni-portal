-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2025 at 06:44 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chondromatidis`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `deadline` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`id`, `lesson_id`, `title`, `description`, `thumbnail`, `created_by`, `deadline`, `created_at`) VALUES
(1, 1, 'HTML & CSS', 'Η εργασία περιλαμβάνει τη σχεδίαση και την ανάπτυξη μιας responsive ιστοσελίδας με χρήση HTML5 και CSS3. Θα εφαρμόσετε τεχνικές όπως media queries, flexible grids και εικόνες που προσαρμόζονται αυτόματα, ώστε η σελίδα να εμφανίζεται σωστά σε όλες τις συσκευές (desktop, tablet, κινητό).', 'web.webp', 9, '2025-06-15', '2025-03-19 00:01:37'),
(2, 1, 'JavaScript Basics', 'Σε αυτήν την εργασία θα δημιουργήσετε μια διαδραστική φόρμα με validation. Χρησιμοποιώντας JavaScript, θα υλοποιήσετε λειτουργίες όπως έλεγχο εγκυρότητας email, απαιτούμενων πεδίων και προβολή μηνυμάτων σφάλματος/επιτυχίας.', 'js.webp', 9, '2025-06-25', '2025-03-19 00:01:37'),
(3, 1, 'Python Fundamentals', 'Θα γράψετε Python scripts για την υλοποίηση βασικών αλγορίθμων (π.χ. ταξινόμησης, αναζήτησης) και την επίλυση μαθηματικών προβλημάτων. Επίσης, θα εξασκηθείτε στη χρήση δομών δεδομένων όπως λίστες και λεξικά.', 'python.webp', 9, '2025-07-05', '2025-03-19 00:01:37'),
(4, 1, 'React Introduction', 'Δημιουργήστε ένα Single Page Application (SPA) με React.js. Θα μάθετε να χρησιμοποιείτε components, state management και routing, με στόχο την ανάπτυξη μιας δυναμικής εφαρμογής χωρίς ανανέωση της σελίδας.', 'react.webp', 9, '2025-07-15', '2025-03-19 00:01:37'),
(5, 2, 'Σχεδιασμός ER Diagram', 'Θα σχεδιάσετε ένα Entity-Relationship Diagram (ERD) για μια βιβλιοθήκη, ορίζοντας οντότητες (π.χ. βιβλία, μέλη, δανεισμοί), τις σχέσεις μεταξύ τους και τα βασικά χαρακτηριστικά. Η εργασία εστιάζει στην οπτικοποίηση της δομής της βάσης δεδομένων.', 'er.webp', 10, '2025-06-20', '2025-03-19 00:01:37'),
(6, 2, 'SQL Queries', 'Ασκηθείτε στη σύνταξη 10 σύνθετων ερωτημάτων SQL σε μια υπάρχουσα βάση δεδομένων. Θα χρησιμοποιήσετε JOINs, subqueries, aggregate functions και filters για την εξαγωγή συγκεκριμένων δεδομένων.', 'sql.webp', 10, '2025-07-01', '2025-03-19 00:01:37'),
(7, 2, 'Normalization', 'Μετατρέψτε έναν μη κανονικοποιημένο πίνακα σε Third Normal Form (3NF). Θα αναλύσετε εξαρτήσεις μεταξύ γνωρισμάτων, θα διαχωρίσετε δεδομένα και θα εξαλείψετε πλεονάζουσες πληροφορίες.', 'normalization.webp', 10, '2025-07-10', '2025-03-19 00:01:37'),
(8, 2, 'NoSQL Databases', 'Συγκρίνετε τα χαρακτηριστικά των MongoDB (NoSQL) και MySQL (SQL). Θα αναλύσετε διαφορές σε σχέση με την κλιμακωσιμότητα, την ευελιξία του σχήματος και τη χρήση σε εφαρμογές υψηλής απόδοσης.', 'nosql.webp', 10, '2025-07-20', '2025-03-19 00:01:37'),
(9, 3, 'TCP/IP Analysis', 'Χρησιμοποιώντας το Wireshark, θα καταγράψετε και θα αναλύσετε πακέτα δικτύου. Θα μελετήσετε πρωτοκόλλα όπως TCP, UDP και HTTP, ενώ θα ερμηνεύσετε πληροφορίες headers και payloads.', 'wireshark.webp', 11, '2025-06-18', '2025-03-19 00:01:37'),
(10, 3, 'Network Security', 'Ρυθμίστε ένα firewall με βάση τις απαιτήσεις ασφαλείας ενός δικτύου. Θα δημιουργήσετε κανόνες για να ελέγξετε την εισερχόμενη/εξερχόμενη κίνηση και θα εφαρμόσετε τεχνικές όπως η χρήση jetables (προσωρινών κανόνων).', 'firewall.webp', 11, '2025-06-28', '2025-03-19 00:01:37'),
(11, 3, 'VPN Configuration', 'Εγκαταστήστε και ρυθμίστε έναν OpenVPN server. Θα δημιουργήσετε πιστοποιητικά ασφαλείας, θα ορίσετε παραμέτρους κρυπτογράφησης και θα δοκιμάσετε τη σύνδεση από έναν client.', 'vpn.png', 11, '2025-07-08', '2025-03-19 00:01:37'),
(12, 3, 'HTTP/2 vs HTTP/3', 'Συγκρίνετε τα πρωτόκολλα HTTP/2 και HTTP/3 ως προς την απόδοση, την αξιοπιστία και τις τεχνολογίες που χρησιμοποιούν (π.χ. multiplexing, QUIC). Θα αναφέρετε πλεονεκτήματα και περιορισμούς κάθε εκδοχής.', 'http.png', 11, '2025-07-18', '2025-03-19 00:01:37'),
(13, 4, 'Γραμμική Παλινδρόμηση', 'Υλοποιήστε ένα μοντέλο γραμμικής παλινδρόμησης σε Python με βιβλιοθήκες όπως NumPy και scikit-learn. Θα εκπαιδεύσετε το μοντέλο σε δεδομένα, θα αξιολογήσετε την ακρίβειά του και θα οπτικοποιήσετε τα αποτελέσματα.', 'regression.png', 12, '2025-06-22', '2025-03-19 00:01:37'),
(14, 4, 'Νευρωνικά Δίκτυα', 'Κατασκευάστε ένα νευρωνικό δίκτυο για την ταξινόμηση εικόνων από το MNIST dataset. Θα χρησιμοποιήσετε TensorFlow/Keras, θα ορίσετε layers (Dense, Convolutional) και θα μετρήσετε την απόδοση του μοντέλου.', 'mnist.jpg', 12, '2025-07-02', '2025-03-19 00:01:37'),
(15, 4, 'Φυσική Γλώσσα', 'Πραγματοποιήστε sentiment analysis σε κείμενο χρησιμοποιώντας τεχνικές επεξεργασίας φυσικής γλώσσας (NLP). Θα εφαρμόσετε tokenization, θα εκπαιδεύσετε ένα μοντέλο (π.χ. με TF-IDF) και θα αναλύσετε συναισθηματικές προδιαγραφές.', 'nlp.jpg', 12, '2025-07-12', '2025-03-19 00:01:37'),
(16, 4, 'GANs', 'Δημιουργήστε generative εικόνες με Generative Adversarial Networks (GANs). Θα υλοποιήσετε ένα δίκτυο generator και discriminator, θα εκπαιδεύσετε το σύστημα σε ένα dataset και θα παραγάγετε νέες εικόνες.', 'gan.jpg', 12, '2025-07-22', '2025-03-19 00:01:37'),
(17, 5, 'Binary Trees', 'Υλοποιήστε ένα δυαδικό δέντρο σε Python ή Java. Θα ορίσετε λειτουργίες για εισαγωγή, διαγραφή και αναζήτηση κόμβων, καθώς και για traversals (in-order, pre-order).', 'tree.jpg', 9, '2025-06-17', '2025-03-19 00:01:37'),
(18, 5, 'Sorting Algorithms', 'Συγκρίνετε αλγορίθμους ταξινόμησης (π.χ. QuickSort, MergeSort, BubbleSort) ως προς την πολυπλοκότητα χρόνου και την απόδοση. Θα υλοποιήσετε τουλάχιστον 2 αλγορίθμους και θα μετρήσετε τον χρόνο εκτέλεσής τους.', 'sort.jpg', 9, '2025-06-27', '2025-03-19 00:01:37'),
(19, 5, 'Graph Traversal', 'Υλοποιήστε τους αλγορίθμους BFS (Breadth-First Search) και DFS (Depth-First Search) για την διέλευση γράφων. Θα δοκιμάσετε τους αλγορίθμους σε διαφορετικά γραφήματα και θα αναλύσετε τα αποτελέσματα.', 'graph.jpg', 9, '2025-07-07', '2025-03-19 00:01:37'),
(20, 5, 'Hash Tables', 'Δημιουργήστε μια hash table με open addressing τεχνική (π.χ. linear probing). Θα ορίσετε συναρτήσεις κατακερματισμού, θα χειριστείτε collisions και θα μετρήσετε την απόδοση της δομής.', 'hash.jpg', 9, '2025-07-17', '2025-03-19 00:01:37');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `title`, `description`, `created_at`) VALUES
(1, 'Εισαγωγή στον Προγραμματισμό', 'Βασικές αρχές προγραμματισμού με Python', '2025-03-19 00:01:37'),
(2, 'Βάσεις Δεδομένων', 'Σχεσιακό μοντέλο και SQL', '2025-03-19 00:01:37'),
(3, 'Δίκτυα Υπολογιστών', 'Πρωτόκολλα δικτύωσης και ασφάλεια', '2025-03-19 00:01:37'),
(4, 'Τεχνητή Νοημοσύνη', 'Μηχανική μάθηση και νευρωνικά δίκτυα', '2025-03-19 00:01:37'),
(5, 'Δομές Δεδομένων', 'Αλγόριθμοι και δομές δεδομένων', '2025-03-19 00:01:37');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `job` varchar(255) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`user_id`, `fullname`, `job`, `mobile`, `linkedin`, `facebook`, `youtube`, `instagram`, `twitter`, `last_updated`) VALUES
(1, 'Μαρία Παπαδοπούλου', 'Φοιτήτρια Πληροφορικής', '6934567890', 'linkedin.com/maria', 'facebook.com/maria', 'youtube.com/maria', 'instagram.com/maria_p', 'twitter.com/maria_p', '2025-03-19 00:01:37'),
(2, 'Γιάννης Κωνσταντίνου', 'Φοιτητής Ηλεκτρολόγων Μηχ.', '6945678901', 'linkedin.com/giannis', NULL, NULL, 'instagram.com/giannis_k', NULL, '2025-03-19 00:01:37'),
(3, 'Ελένη Αντωνοπούλου', 'Φοιτήτρια Οικονομικών', '6956789012', NULL, 'facebook.com/eleni', NULL, 'instagram.com/eleni_a', 'twitter.com/eleni_a', '2025-03-19 00:01:37'),
(4, 'Δημήτρης Ιωάννου', 'Φοιτητής Αρχιτεκτονικής', '6967890123', 'linkedin.com/dimitris', NULL, 'youtube.com/dimitris', NULL, NULL, '2025-03-19 00:01:37'),
(5, 'Σοφία Μαρίνου', 'Φοιτήτρια Βιολογίας', '6978901234', NULL, NULL, NULL, 'instagram.com/sophia_m', NULL, '2025-03-19 00:01:37'),
(6, 'Αντώνης Παππάς', 'Φοιτητής Χημικών Μηχ.', '6989012345', 'linkedin.com/antonis', 'facebook.com/antonis', NULL, NULL, 'twitter.com/antonis_p', '2025-03-19 00:01:37'),
(7, 'Χρύσα Παυλίδου', 'Φοιτήτρια Φυσικής', '6990123456', NULL, NULL, 'youtube.com/chrysa', 'instagram.com/chrysa_p', NULL, '2025-03-19 00:01:37'),
(8, 'Νίκος Αλεξίου', 'Φοιτητής Μαθηματικών', '6901234567', 'linkedin.com/nikos', NULL, NULL, NULL, 'twitter.com/nikos_a', '2025-03-19 00:01:37'),
(9, 'Κώστας Παπαδόπουλος', 'Καθηγητής Πληροφορικής', '6912345678', 'linkedin.com/kostas', NULL, 'youtube.com/prof_pap', 'instagram.com/prof_pap', 'twitter.com/prof_pap', '2025-03-19 00:01:37'),
(10, 'Ανδρέας Γεωργίου', 'Καθηγητής Βάσεων Δεδομένων', '6923456789', NULL, 'facebook.com/andreas', NULL, NULL, 'twitter.com/andreas_g', '2025-03-19 00:01:37'),
(11, 'Ευαγγελία Στεφάνου', 'Καθηγήτρια Δικτύων', '6934567890', 'linkedin.com/evangelia', NULL, NULL, 'instagram.com/evangelia_s', NULL, '2025-03-19 00:01:37'),
(12, 'Μαρία Ιωάννου', 'Καθηγήτρια Τεχνητής Νοημοσύνης', '6945678901', NULL, NULL, 'youtube.com/maria_ai', 'instagram.com/maria_ai', 'twitter.com/maria_ai', '2025-03-19 00:01:37'),
(13, 'Γιώργος Χ.', 'Developer', '6912323212', '', '', '', '', '', '2025-03-20 19:29:49');

-- --------------------------------------------------------

--
-- Table structure for table `student_lessons`
--

CREATE TABLE `student_lessons` (
  `student_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_lessons`
--

INSERT INTO `student_lessons` (`student_id`, `lesson_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 2),
(2, 4),
(3, 1),
(3, 3),
(3, 4),
(3, 5),
(4, 1),
(4, 3),
(4, 5),
(5, 1),
(5, 2),
(6, 2),
(6, 5),
(7, 5),
(8, 1),
(8, 2),
(8, 3),
(8, 4),
(8, 5),
(13, 1),
(13, 2),
(13, 3),
(13, 4),
(13, 5);

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `grade` decimal(5,2) DEFAULT NULL CHECK (`grade` between 0 and 100),
  `status` enum('submitted','under_review','graded') DEFAULT 'submitted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`id`, `assignment_id`, `user_id`, `title`, `description`, `file_path`, `submitted_at`, `grade`, `status`) VALUES
(1, 1, 1, 'Ιστοσελίδα Εστιατορίου', 'HTML/CSS με Bootstrap', 'uploads/submissions/lesson_1/restaurant.pdf', '2025-03-19 00:01:37', 85.50, 'graded'),
(2, 2, 1, 'Todo List App', 'JavaScript με localStorage', 'uploads/submissions/lesson_1/todo.zip', '2025-03-19 00:01:37', NULL, 'under_review'),
(3, 5, 1, 'Βιβλιοθήκη ER Diagram', 'Σχεδίαση με Draw.io', 'uploads/submissions/lesson_1/library.pdf', '2025-03-19 00:01:37', 92.00, 'graded'),
(4, 9, 1, 'Wireshark Analysis', 'TCP packet capture', 'uploads/submissions/lesson_1/wireshark.pdf', '2025-03-19 00:01:37', 78.00, 'graded'),
(5, 13, 1, 'Linear Regression', 'Πρόβλεψη τιμών κατοικίας', 'uploads/submissions/lesson_1/regression.pdf', '2025-03-19 00:01:37', NULL, 'submitted'),
(6, 3, 2, 'Python Algorithms', 'Bubble sort & Binary search', 'uploads/submissions/lesson_2/algorithms.pdf', '2025-03-19 00:01:37', 88.00, 'graded'),
(7, 6, 2, 'SQL Practice', 'Ερωτήματα για βιβλιοθήκη', 'uploads/submissions/lesson_2/queries.pdf', '2025-03-19 00:01:37', 95.50, 'graded'),
(8, 10, 2, 'Firewall Rules', 'iptables configuration', 'uploads/submissions/lesson_2/firewall.pdf', '2025-03-19 00:01:37', NULL, 'under_review'),
(9, 14, 2, 'Neural Network', 'MNIST με TensorFlow', 'uploads/submissions/lesson_2/mnist.pdf', '2025-03-19 00:01:37', 81.00, 'graded'),
(10, 17, 2, 'Binary Tree', 'Υλοποίηση σε C++', 'uploads/submissions/lesson_2/tree.pdf', '2025-03-19 00:01:37', 89.50, 'graded'),
(11, 4, 3, 'React Portfolio', 'Προσωπικό portfolio site', 'uploads/submissions/lesson_3/portfolio.pdf', '2025-03-19 00:01:37', NULL, 'submitted'),
(12, 7, 3, 'Normalization', 'Μετατροπή σε 3NF', 'uploads/submissions/lesson_3/normalization.pdf', '2025-03-19 00:01:37', 76.50, 'graded'),
(13, 11, 3, 'OpenVPN Setup', 'AWS server configuration', 'uploads/submissions/lesson_3/vpn_config.pdf', '2025-03-19 00:01:37', 94.00, 'graded'),
(14, 15, 3, 'NLP Project', 'Sentiment analysis κειμένων', 'uploads/submissions/lesson_3/nlp.pdf', '2025-03-19 00:01:37', NULL, 'under_review'),
(15, 18, 3, 'Sorting Comparison', 'QuickSort vs MergeSort', 'uploads/submissions/lesson_3/sorting.pdf', '2025-03-19 00:01:37', 87.00, 'graded'),
(16, 8, 4, 'NoSQL Report', 'Σύγκριση MongoDB/MySQL', 'uploads/submissions/lesson_4/nosql.pdf', '2025-03-19 00:01:37', 90.00, 'graded'),
(17, 12, 4, 'HTTP/3 Research', 'Παρουσίαση QUIC protocol', 'uploads/submissions/lesson_4/http3.pdf', '2025-03-19 00:01:37', 83.50, 'graded'),
(18, 16, 4, 'GAN Project', 'Generated faces με DCGAN', 'uploads/submissions/lesson_4/dcgan.pdf', '2025-03-19 00:01:37', NULL, 'submitted'),
(19, 19, 4, 'Graph Traversal', 'BFS για social network', 'uploads/submissions/lesson_4/graph.pdf', '2025-03-19 00:01:37', 91.00, 'graded'),
(20, 20, 4, 'Hash Table', 'Υλοποίηση με Python', 'uploads/submissions/lesson_4/hash_table.pdf', '2025-03-19 00:01:37', 84.50, 'graded'),
(21, 1, 5, 'E-commerce Site', 'Responsive design', 'uploads/submissions/lesson_5/ecommerce.pdf', '2025-03-19 00:01:37', 79.00, 'graded'),
(22, 5, 5, 'ER Diagram', 'Σχεδίαση για νοσοκομείο', 'uploads/submissions/lesson_5/hospital.pdf', '2025-03-19 00:01:37', 88.50, 'graded'),
(23, 9, 5, 'Network Traffic', 'Analysis με Wireshark', 'uploads/submissions/lesson_5/traffic.pdf', '2025-03-19 00:01:37', 75.50, 'graded'),
(24, 13, 5, 'House Price Prediction', 'Linear regression model', 'uploads/submissions/lesson_5/houses.pdf', '2025-03-19 00:01:37', 82.00, 'graded'),
(25, 17, 5, 'Tree Implementation', 'Binary tree in Java', 'uploads/submissions/lesson_5/tree.pdf', '2025-03-19 00:01:37', NULL, 'under_review'),
(26, 2, 6, 'Calculator App', 'JavaScript calculator', 'uploads/submissions/lesson_6/calculator.pdf', '2025-03-19 00:01:37', 93.00, 'graded'),
(27, 6, 6, 'Library Queries', 'Complex SQL queries', 'uploads/submissions/lesson_6/library.pdf', '2025-03-19 00:01:37', 97.00, 'graded'),
(28, 10, 6, 'Firewall Setup', 'Ubuntu server rules', 'uploads/submissions/lesson_6/iptables.pdf', '2025-03-19 00:01:37', 86.50, 'graded'),
(29, 14, 6, 'CNN Model', 'CIFAR-10 classification', 'uploads/submissions/lesson_6/cnn.pdf', '2025-03-19 00:01:37', 89.00, 'graded'),
(30, 18, 6, 'Sorting Algorithms', 'Υλοποίηση 5 αλγορίθμων', 'uploads/submissions/lesson_6/sorting.pdf', '2025-03-19 00:01:37', 94.50, 'graded'),
(31, 3, 7, 'Data Structures', 'Python implementations', 'uploads/submissions/lesson_7/structures.pdf', '2025-03-19 00:01:37', 80.50, 'graded'),
(32, 7, 7, '3NF Conversion', 'Case study για e-shop', 'uploads/submissions/lesson_7/normalization.pdf', '2025-03-19 00:01:37', 77.00, 'graded'),
(33, 11, 7, 'VPN Client', 'OpenVPN client setup', 'uploads/submissions/lesson_7/client.pdf', '2025-03-19 00:01:37', NULL, 'submitted'),
(34, 15, 7, 'Twitter Analysis', 'Sentiment analysis API', 'uploads/submissions/lesson_7/twitter.pdf', '2025-03-19 00:01:37', 84.00, 'graded'),
(35, 19, 7, 'Social Network BFS', 'Graph traversal example', 'uploads/submissions/lesson_7/network.pdf', '2025-03-19 00:01:37', 92.50, 'graded'),
(36, 4, 8, 'React E-shop', 'Full e-commerce solution', 'uploads/submissions/lesson_8/eshop.pdf', '2025-03-19 00:01:37', NULL, 'under_review'),
(37, 8, 8, 'NoSQL Performance', 'Benchmark MongoDB vs MySQL', 'uploads/submissions/lesson_8/benchmark.pdf', '2025-03-19 00:01:37', 91.50, 'graded'),
(38, 12, 8, 'HTTP/3 Presentation', 'QUIC protocol analysis', 'uploads/submissions/lesson_8/quic.pdf', '2025-03-19 00:01:37', 88.00, 'graded'),
(39, 16, 8, 'GAN Art', 'Generated artworks', 'uploads/submissions/lesson_8/artgan.pdf', '2025-03-19 00:01:37', 79.50, 'graded'),
(40, 20, 8, 'Hash Collisions', 'Επίλυση collisions', 'uploads/submissions/lesson_8/hash.pdf', '2025-03-19 00:01:37', 85.00, 'graded'),
(41, 1, 13, 'Recreating Spotify in HTML/CSS', 'Spotify mockup in HTML/CSS με νέο αρχείο!', 'D:\\xampp2\\htdocs\\uni_portal/uploads/submissions/lesson_1/67dd91694ca51_spotify.pdf', '2025-03-21 16:18:49', NULL, 'submitted');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_lessons`
--

CREATE TABLE `teacher_lessons` (
  `teacher_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_lessons`
--

INSERT INTO `teacher_lessons` (`teacher_id`, `lesson_id`) VALUES
(9, 1),
(9, 5),
(10, 2),
(11, 3),
(12, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','teacher') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'student1@uni.gr', 'student1', 'student1', 'student', '2025-03-18 23:53:51'),
(2, 'student2@uni.gr', 'student2', 'f2e5aafc64a04ac704c644ce38c34d1d7f7493561687c66e43eeda8186744134', 'student', '2025-03-18 23:53:51'),
(3, 'student3@uni.gr', 'student3', 'f2e5aafc64a04ac704c644ce38c34d1d7f7493561687c66e43eeda8186744134', 'student', '2025-03-18 23:53:51'),
(4, 'student4@uni.gr', 'student4', 'f2e5aafc64a04ac704c644ce38c34d1d7f7493561687c66e43eeda8186744134', 'student', '2025-03-18 23:53:51'),
(5, 'student5@uni.gr', 'student5', 'f2e5aafc64a04ac704c644ce38c34d1d7f7493561687c66e43eeda8186744134', 'student', '2025-03-18 23:53:51'),
(6, 'student6@uni.gr', 'student6', 'f2e5aafc64a04ac704c644ce38c34d1d7f7493561687c66e43eeda8186744134', 'student', '2025-03-18 23:53:51'),
(7, 'student7@uni.gr', 'student7', 'f2e5aafc64a04ac704c644ce38c34d1d7f7493561687c66e43eeda8186744134', 'student', '2025-03-18 23:53:51'),
(8, 'student8@uni.gr', 'student8', 'f2e5aafc64a04ac704c644ce38c34d1d7f7493561687c66e43eeda8186744134', 'student', '2025-03-18 23:53:51'),
(9, 'teacher1@uni.gr', 'teacher1', '560d4d8b173df72e813f0f1914aeb5df3240b53457000c55a1baa84fc389fa1e', 'teacher', '2025-03-18 23:53:51'),
(10, 'teacher2@uni.gr', 'teacher2', '560d4d8b173df72e813f0f1914aeb5df3240b53457000c55a1baa84fc389fa1e', 'teacher', '2025-03-18 23:53:51'),
(11, 'teacher3@uni.gr', 'teacher3', '560d4d8b173df72e813f0f1914aeb5df3240b53457000c55a1baa84fc389fa1e', 'teacher', '2025-03-18 23:53:51'),
(12, 'teacher4@uni.gr', 'teacher4', '560d4d8b173df72e813f0f1914aeb5df3240b53457000c55a1baa84fc389fa1e', 'teacher', '2025-03-18 23:53:51'),
(13, 'george@gmail.com', 'test', '$2y$10$kovDXbXR6PgcGVzJqoT9Ke0uG8q219zvpE/pteAoMqXL53ioJr6Pu', 'student', '2025-03-19 18:06:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `idx_lesson` (`lesson_id`),
  ADD KEY `idx_deadline` (`deadline`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_title` (`title`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `student_lessons`
--
ALTER TABLE `student_lessons`
  ADD PRIMARY KEY (`student_id`,`lesson_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_assignment` (`assignment_id`),
  ADD KEY `idx_student` (`user_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `teacher_lessons`
--
ALTER TABLE `teacher_lessons`
  ADD PRIMARY KEY (`teacher_id`,`lesson_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_role` (`role`),
  ADD KEY `idx_username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assignments_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_lessons`
--
ALTER TABLE `student_lessons`
  ADD CONSTRAINT `student_lessons_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_lessons_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `submissions_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `submissions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teacher_lessons`
--
ALTER TABLE `teacher_lessons`
  ADD CONSTRAINT `teacher_lessons_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_lessons_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
