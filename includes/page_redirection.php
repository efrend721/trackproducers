<?php
$current_page = basename($_SERVER['PHP_SELF']);

$page_configurations = [
    'projectlistdetailareaview.php' => [
        'redirectLocation' => 'projectlistdetailview.php',
        'buttonType' => 'form',
        'buttonText' => 'Back',
        'hiddenInputName' => 'process',
        'hiddenInputValue' => $idjob
    ],
    'projectlistaddlogview.php' => [
        'redirectLocation' => 'projectlistview.php', // Change this to the correct name of the project list page
        'buttonType' => 'none', // Special type to indicate no button
        'buttonText' => '',
        'hiddenInputName' => '',
        'hiddenInputValue' => ''
    ],
    'projectlistphotoview.php' => [
        'redirectLocation' => 'projectlistview.php', // Change this to the correct name of the project list page
        'buttonType' => 'none', // Special type to indicate no button
        'buttonText' => '',
        'hiddenInputName' => '',
        'hiddenInputValue' => ''
    ]
    // Add more configurations here
];

$default_configuration = [
    'redirectLocation' => 'projectview.php',
    'buttonType' => 'button',
    'buttonText' => 'Back'
];

$config = $page_configurations[$current_page] ?? $default_configuration;

$buttonAttributes = ''; // Ensure it's empty initially

if ($config['buttonType'] == 'form') {
    $buttonAttributes = <<<HTML
        <form method="post" action="../views/{$config['redirectLocation']}" class="float-end">
            <input type="hidden" name="{$config['hiddenInputName']}" value="{$config['hiddenInputValue']}">
            <button type="submit" name="back" class="btn btn-primary">
                {$config['buttonText']}
            </button>
        </form>
HTML;
} elseif ($config['buttonType'] == 'button') {
    $buttonAttributes = <<<HTML
        <button 
            type="button" 
            name="back" 
            class="btn btn-primary float-end" 
            onclick="location.href='../views/{$config['redirectLocation']}'">
            {$config['buttonText']}
        </button>
HTML;
}

// Echo the button attributes only if it's not 'none'
if ($config['buttonType'] != 'none') {
    
    if ($driver != $user_id) {
        echo $buttonAttributes;
    }
}
?>
