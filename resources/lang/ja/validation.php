<?php
return [
    'unique' => 'この :attribute は既に登録があります。',
    'confirmed' => ':attribute が確認用の入力と一致しません。',
    'date' => ':attribute は正しい日付を入力してください。',
    'attributes' => [
        'task_name' => 'タスク名',
        'task_content' => 'タスク内容',
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'ymd_from' => '終了日',
        'ymd_to' => '開始日',
    ],
    'max' => [
    'string' => ':attribute は :max 文字以内で入力してください。',
    ],
    'min' => [
        'string' => ':attribute は :min 文字以上で入力してください。',
    ],

];

?>
