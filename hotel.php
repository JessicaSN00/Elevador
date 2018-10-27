<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <link rel="stylesheet" href="public/styles/style.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="main.js"></script>
</head>
<body>
    <!--<form method="post" action="main.php">
        <input type="text" name="user">
        <input type="text" value="<? $_GET['user']?>" name="actual_floor">
        <input type="text" name="user2">
        <input type="text" value="<? $_GET['user2']?>" name="actual_floor2">
        <input type="submit" value="Click" />
    </form>-->
    <form method="post" action="main.php">
        <div class="field_wrapper">
            <div>
            <input type="text" value="<? $_GET['user_1']?>" name="actual_floor_1" placeholder="Piso Actual">
            <input type="text" name="user_1" placeholder="Nombre Usuario">
            <a href="javascript:void(0);" class="add_button" title="Add field"><img src="public/images/add-icon.png"/></a>
            </div>
        </div>
        <input type="submit" value="Click" />
    </form>
    <script type="text/javascript">
    $(document).ready(function(){
        var maxField = 30; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var x = 1; //Initial field counter is 1
        
        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){ 
                x++; //Increment field counter
                $(wrapper).append('<div><input type="text" value="<? $_GET['user_'+x+'']?>" name="actual_floor_'+x+'" placeholder="Piso Actual"><input type="text" name="user_'+x+'" placeholder="Nombre Usuario"><a href="javascript:void(0);" class="remove_button"><img src="public/images/remove-icon.png"/></a></div>'); //Add field html
            }
        });
        
        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });
</script>
</body>
</html>