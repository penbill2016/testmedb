<!--session要由JS處理-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
    <h3 id="user"></h3>
    <button id="addfolder" type="button">
        新增資料夾
    </button>
    <button id="addtest" type="button">
        新增測驗
    </button>
<body>
    
</body>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
<script>
    var u_account='popo';
    var u_password=12345;
    $.ajax({
        type: "POST",
        url: "http://localhost/testmedb/api/login.php",
        data: {
            account:u_account,
            password:u_password
        },
        success: function (response) {
            if(response == '1')
                $("#user").html(u_account);
            else{
                alert('帳號或密碼錯誤');
            }
        },
        error: function(){
            alert("error");
        }
    });
    $("#addfolder").on('click',function(){
        
    });
    $("#addtest").on('click',function(){

    });



</script>


</html>