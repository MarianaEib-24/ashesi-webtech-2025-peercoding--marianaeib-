<?php
include('../includes/config.php');

$sql = "CREATE TABLE IF NOT EXISTS `tblrequests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `StudentId` varchar(100) DEFAULT NULL,
  `BookId` int(11) DEFAULT NULL,
  `RequestDate` timestamp NULL DEFAULT current_timestamp(),
  `Status` int(1) DEFAULT '0' COMMENT '0:Pending, 1:Approved, 2:Declined',
  `Remark` mediumtext DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$query = $dbh->prepare($sql);
$query->execute();

echo "Table tblrequests created successfully";
?>
