<html lang="en"><head><meta charset="UTF-8">
</head>
<body>
<p style="font-size:15px;margin:0px;">
Dear Sir, <br>
Good day. 
<br>
The following Kaizen has been submitted to the Kaizen platform. <br>

<?php foreach ($klist as $value) {
?>
KAIZEN NO: <?php echo $value->serial_no; ?> from <?php echo $value->department_name ; ?> department <br>
<?php } ?>

Please review it on the Kaizen Portal. <br>
<a href="https://kaizen.vlmbd.com/kaizenreceive/lists">Click for Login</a>
<br><br>
Thanks by <br>
Lean Team <br><br>
<span style="color: red">This is an auto-generated email from Kaizen Software. No Need to Reply.</span>
</body>
</html>