<?php
session_start();
require('../db/db_connection_festive.php'); // Ensure this path is correct

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

// Fetch the current user's name
$user_query = "SELECT name FROM user WHERE id = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$stmt->bind_result($judge_name);
$stmt->fetch();
$stmt->close();

// Fetch the list of judges
$judge_query = "SELECT name FROM user WHERE role = 1";
$judge_stmt = $conn->query($judge_query);
$judges = [];
while ($judge_row = $judge_stmt->fetch_assoc()) {
    $judges[] = $judge_row['name'];
}
$judge_stmt->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JUDGING SHEET</title>
    <link rel="stylesheet" href="css/festive.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <style>
        .overall button {
            border-radius: 10px;
            background-color: #536cff;
            border: none;
            color: #030404;
            text-align: center;
            font-size: 14px;
            padding: 20px;
            width: 100%;
            cursor: pointer;
            margin: 5px;
            top: 0;
            height: 70px;
            font-weight: bold;
            display: inline-block;
            z-index: 3;
        }

        .overall button:hover {
            background-color: #011f85;
            color: #ffffff;
        }

        .top10 {
            background-color: blue;
            color: white;
        }

        .judge-signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }

        .judge-signature {
            text-align: center;
            width: 45%;
        }

        .judge-signature .line {
            border-bottom: 1px solid black;
            margin-bottom: 5px;
        }

        .no-underline {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="tnalaklogo">
        <img src="../tnalak.png" alt="t'nalak image">
    </div>
    <div class="overall">
        <a href="judgesfestive.php"><button class="judging">Tabulation Sheet</button></a>
        <a href="overallfestive.php"><button>Judging Sheet</button></a>
        <a href="../sync_festive.php"><button>Sync Data</button></a>
    </div>
    <div class="emblem">
        <img src="../emblem.png" alt="t'nalak image">
    </div>

    <div class="container_festive"> 
        <div class="judge-signatures">
            <?php 
            $judgeCount = 1;
            foreach ($judges as $judge) : ?>
                <div class="judge-signature" style="font-family:Kanit, sans-serif; text-decoration:none">
                    <a href="/festive/indivfestive.php?judge=<?php echo htmlspecialchars($judge); ?>" class="no-underline">
                        <img src="/images/tnalakfest.png" style="height:auto; width:70%" alt="">
                        <p style="font-size:100%"><?php echo htmlspecialchars($judge); ?></p>
                    </a>
                    <p style="font-size:20px">Judge <?php echo $judgeCount; ?></p>
                </div>
            <?php 
            $judgeCount++;
            endforeach; ?>
        </div>
    </div>
</body>

</html>
