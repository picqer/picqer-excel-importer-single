<?php include('view-header.php'); ?>

<h2>Import your Excel</h2>
<p>Upload your Excel you want to import as an order.</p>
<p>Use the second tab for the product codes and the first tab for the amount of products needed per product code.</p>
<form method="post" action="app.php?step=preview" enctype="multipart/form-data">
    <p>
        <label for="customerid">Customer ID</label><br/>
        <input type="text" name="customerid" id="customerid">
    </p>
    <p>
        <label for="reference">Order reference</label><br/>
        <input type="text" name="reference" id="reference" value="">
    </p>
    <p>
        <label for="file">Excel file (.xlsx)</label><br/>
        <input type="file" name="file" id="file">
    </p>
    <p><input type="submit" value="Upload"></p>
</form>

<?php include('view-footer.php'); ?>
