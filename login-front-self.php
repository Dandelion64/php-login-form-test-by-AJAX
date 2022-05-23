<?php
session_start();

// 這邊只是為了 Demo
// 一般不會寫死在程式碼中 不方便新增用戶
$users = [
    'waiting' => [
        'password' => '1234',
        'nickname' => '等待'
    ],
    'slumdar' => [
        'password' => '5678',
        'nickname' => '史朗德'
    ],
];

$output = [
    'postData' => $_POST, // 除錯用的欄位
];

if (isset($_POST['account'])) {
    // echo json_encode($_POST);
    // exit; // 立刻中止 php 程式執行
    // die(); // 和 exit; 很像

    // empty() 如果是空字串 空數值 空陣列 或未設定 true
    if (!empty($_POST['account']) and !empty($_POST['password'])) {
        if (!empty($users[$_POST['account']])) {
            if($_POST['password'] === $users[$_POST['account']]['password']) {
                // 登入成功
                $output['msg'] = '登入成功';
                echo json_encode($output['msg'], JSON_UNESCAPED_UNICODE);
                exit;
            } else {
                // 帳號正確但密碼錯誤
                $output['msg'] = '密碼錯誤';
                echo json_encode($output['msg'], JSON_UNESCAPED_UNICODE);
                exit;
            }
        } else {
            // 帳號錯誤
            $output['msg'] = '帳號錯誤';
            echo json_encode($output['msg'], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN-IN</title>
    <style type="text/css">
        body {
            line-height: 1.5;
        }
        .errorMessage {
            font-size: 2rem;
            color: #f00;
            font-weight: 900;
        }
    </style>
</head>
<body>
    <form name="formLogin" method="post" onsubmit="sendData(); return false;">
        <input type="text" name="account" placeholder="帳號">
        <br />
        <input type="password" name="password" placeholder="密碼">
        <input type="submit" value="Login" />
    </form>
    <div class="errorMessage"></div>
    <script>
        
        // 同步箭頭函式的宣告方式
        const sendData = async () => {
            const f = document.forms['formLogin'];
            const ac = f.elements.account.value;
            const pw = f.elements.password.value;
            const erm = document.querySelector(".errorMessage");
            if ( !ac || !pw ) {
                erm.innerHTML = `請輸入完整資料`;
            } else {
                erm.innerHTML = ``;
                const fd = new FormData(document.formLogin);
                const r = await fetch("login-front-self.php", {
                    method: "POST",
                    body: fd,
                });
                // console.log(fd);
            }
        }

    </script>
</body>
</html>