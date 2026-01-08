<?php

declare(strict_types=1);

$featuresInfo = [];
$featureNames = [];

try {
    $statement = $database->query('SELECT * FROM features');
    $featuresInfo = $statement->fetchAll(PDO::FETCH_ASSOC);

    $safeFeatures = $features ?? [];
    $featureNames = array_column($safeFeatures, 'feature');
} catch (PDOException $e) {
} ?>

<h2 id="our-features">Our features</h2>
<section class="features-grid-container">

    <?php foreach ($featuresInfo as $featureInfo) :
        if (in_array($featureInfo['feature_name'], $featureNames)) : ?>
            <div>
                <span class="feature-img-container">
                    <img src="./assets/images/features/<?= htmlspecialchars(trim(strtolower($featureInfo['activity_category']))) . "-" . htmlspecialchars(trim(strtolower($featureInfo['price_category']))) ?>.jpg" alt=">Image showing the feature">
                </span>
                <span class="feature-presentation-text">
                    <h4><?= htmlspecialchars(trim(ucfirst($featureInfo['feature_name']))) ?></h4>
                    <p><?= htmlspecialchars(trim(ucfirst($featureInfo['feature_description']))) ?></p>
                </span>
            </div>

    <?php endif;
    endforeach; ?>
</section>