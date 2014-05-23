<?php echo $head?>
</head>
<body>
<h1>header</h1>
<?
    print_r($_POST);
    print_r($_FILES);
?>
<form id="data" method="post" enctype="multipart/form-data">
    <input type="text" name="first" value="Bob" />
    <input type="text" name="middle" value="James" />
    <input type="text" name="last" value="Smith" />
    <input name="image" type="file" />
    <button>Submit</button>
</form>

<form action="<?echo THEMEURL.'upload.php'?>" target="my-iframe" method="post">
            
  <label for="text">Some text:</label>
  <input type="text" name="text" id="text">
            
  <input type="submit" value="post">
            
</form>
        
<iframe name="my-iframe" ></iframe>



<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<?php
 echo '<script type="text/javascript">var ajaxurl = "'.THEMEURL.'upload.php"</script>'
?>

<script>
$("form#data").submit(function(){

    var formData = new FormData($(this)[0]);
    var url = "";
 console.log($(this).serializeArray());
    
    $.ajax({
        url: ajaxurl ,
        type: 'POST',
        data: formData,
        async: false,
        success: function (data) {
            
            alert(data.files.name);
        

        },
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
    });

    return false;
});
</script>
