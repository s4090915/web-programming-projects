<?php
include 'includes/db_connect.inc';
include 'includes/header.inc';
include 'includes/nav.inc';


if (isset($_GET['id'])) {
    $petid = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM pets WHERE petid = :petid");
    $stmt->bindParam(':petid', $petid);
    $stmt->execute();
    $pet = $stmt->fetch();

    
    $imagePath = $pet['image'];
    
    
    $imagePath = str_replace('.jpg', '.jpeg', $imagePath);
}
?>

<main>
<body class="details-background">
<div class="details-container">
        <?php if ($pet): ?>
        <div class="details-image">
            <img src="images/<?php echo $imagePath; ?>" alt="<?php echo $pet['caption']; ?>">
        </div>
        <div class="details-info">
            <h2><?php echo $pet['petname']; ?></h2>
            <div class="details-icons">
                <div class="icon">
                    <i class="material-icons">access_time</i> 
                    <p><?php echo $pet['age']; ?> months</p>
                </div>
                <div class="icon">
                    <i class="material-icons">pets</i> 
                    <p><?php echo $pet['type']; ?></p>
                </div>
                <div class="icon">
                    <i class="material-icons">location_on</i> 
                    <p><?php echo $pet['location']; ?></p>
                </div>
            </div>
            <div class="details-description">
                <p><strong>Description:</strong> <?php echo $pet['description']; ?></p>
            </div>
        </div>
        <?php else: ?>
        <p>Pet not found!</p>
        <?php endif; ?>
    </div>
</main>

<?php
include 'includes/footer.inc';
?>
