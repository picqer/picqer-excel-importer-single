<?php include('view-header.php'); ?>
<h2>Preview</h2>
<p>Is this how we need to process this file?</p>

<ul>
    <?php foreach ($products as $productcode => $amount): ?>
        <li>Product &quot;<?php echo $productcode; ?>&quot;: <strong><?php echo $amount; ?></strong>x</li>
    <?php endforeach; ?>
</ul>

<p><a href="app.php?step=import"><strong>Yes, this is the right data, create order now</strong></a>, or <a href="app.php?step=cancel">cancel import</a></p>
<?php include('view-footer.php'); ?>
