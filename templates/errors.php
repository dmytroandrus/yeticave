<!DOCTYPE>
<?php
if (isset($errors)) :
    foreach ($errors as $error) :
?>
        <span style="color:red">
            <ul>
                <h1><?= $error ?></h1>
            </ul>
        </span>
<?php
    endforeach;
endif; ?>