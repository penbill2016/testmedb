<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="./test_login.php" method="POST">
        <div class="inputbox">
            <label for="account">帳號</label>
            <input id="account" name="account" type="text">
        </div>
        <div class="inputbox">
            <label for="password">密碼</label>
            <input id="password" name="password" type="text">
        </div>
        <div class="inputbox">
            <button id="loginbtn" type="button">送出</button>
        </div>
    </form>
</body>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
<script>
    $('#loginbtn').on('click',function(){
        $.ajax({
            type: "POST",
            url: "http://localhost/testmedb/api/login.php",
            data: {
                account:$('#account').val(),
                password:$('#password').val()
            },
            success: function (response) {
                if(response == '1')
                    alert('登入');
                else{
                    alert('帳號或密碼錯誤');
                }
            },
            error: function(){
                alert("error");
            }
        });
    });
</script>
</html>