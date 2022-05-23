<?php
session_start();

// 這邊只是為了 Demo
// 一般不會寫死在程式碼中 不方便新增用戶
$users = [
    'waiting' => [
        'password' => '1234',
        'nickname' => '等待',
    ],
    'slumdar' => [
        'password' => '5678',
        'nickname' => '史朗德',
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
            if ($_POST['password'] === $users[$_POST['account']]['password']) {
                // 登入成功
                // $output['msg'] = $users[$_POST['account']]['nickname'] . '登入成功';
                $_SESSION['user'][$_POST['account']] = [
                    'nickname' => $users[$_POST['account']]['nickname']
                ];
                $output['msg'] = $_SESSION['user'][$_POST['account']]['nickname'] . '升天吧';
                // session_destroy();

            } else {
                // 帳號正確但密碼錯誤
                $output['msg'] = '密碼錯誤';
            }
        } else {
            // 帳號錯誤
            $output['msg'] = '帳號錯誤';
        }

        echo json_encode($output['msg']);
        exit;
    } else {
        $output['msg'] = '帳號不存在';
        echo json_encode($output['msg']);
        exit;
    }
}
