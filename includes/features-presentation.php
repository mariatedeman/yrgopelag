<?php

declare(strict_types=1);

$database = new PDO('sqlite:' . dirname(__DIR__) . '/app/database/yrgopelag.db');
$statement = $database->query('SELECT * FROM features');
$featuresInfo = $statement->fetchAll(PDO::FETCH_ASSOC);

$featureNames = array_column($features, 'feature'); ?>

<h2 id="our-features">Our features</h2>
<section class="features-grid-container">

    <?php foreach ($featuresInfo as $featureInfo) :
        if (in_array($featureInfo['feature_name'], $featureNames)) : ?>
            <div>
                <span class="feature-img-container">
                    <img src="/assets/images/features/<?= htmlspecialchars(trim($featureInfo['activity_category'])) . "-" . htmlspecialchars(trim($featureInfo['price_category'])) ?>.jpg" alt="">
                </span>
                <span class="feature-presentation-text">
                    <h4><?= htmlspecialchars(trim(ucfirst($featureInfo['feature_name']))) ?></h4>
                    <p><?= htmlspecialchars(trim(ucfirst($featureInfo['feature_description']))) ?></p>
                </span>
            </div>

    <?php endif;
    endforeach ?>
</section>