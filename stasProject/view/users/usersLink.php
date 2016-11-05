<?php
/**
 * Created by PhpStorm.
 * User: Lida
 * Date: 05.11.2016
 * Time: 1:15
 */
?>
<div class="usersBlock">
    <?php foreach ($arrayData as $element) { ?>
        <a href="https://vk.com/id<?php echo $element['id']; ?>"
           target="_blank">Перейти</a>
    <? } ?>
</div>

