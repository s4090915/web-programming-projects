<?php
include 'includes/db_connect.inc';
include 'includes/header.inc';
include 'includes/nav.inc';

$query = "SELECT petid, petname, type, age, location, image FROM pets";
$result = $pdo->query($query);
?>

<main class="pets-main">
    <body class="pets-background">

    <h1 class="petmain-title">Discover Pets Victoria</h1>

    <p class="petmain-description">
    Pets Victoria is a dedicated pet adoption organization based in Victoria, Australia, focused on providing a safe and loving environment for pets in need. With a compassionate approach, Pets Victoria works tirelessly to rescue, rehabilitate, and rehome dogs, cats, and other animals. Their mission is to connect these deserving pets with caring individuals and families, creating lifelong bonds. The organization offers a range of services, including adoption counseling, pet education, and community support programs, all aimed at promoting responsible pet ownership and reducing the number of homeless animals.
    </p>

    <div class="pets-content">
        <div class="pets-image">
            <img src="images/pets.jpeg" alt="Pets Image">
        </div>

        <?php if ($result->rowCount() > 0) { ?>
            <table class="pets-table">
                <thead>
                    <tr>
                        <th>Pet</th>
                        <th>Type</th>
                        <th>Age</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
                        <tr>
                            <td><a href="details.php?id=<?= $row['petid']; ?>"><?= $row['petname']; ?></a></td>
                            <td><?= $row['type']; ?></td>
                            <td><?= $row['age']; ?> months</td>
                            <td><?= $row['location']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>No pets found in the database.</p>
        <?php } ?>
    </div>
</main>

<?php
include 'includes/footer.inc';
?>
