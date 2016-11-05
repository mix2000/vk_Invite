<?php
/**
 * Created by PhpStorm.
 * User: one
 * Date: 31.10.2016
 * Time: 13:55
 */
?>
<div class="usersBlock">
    <?php foreach ($arrayData as $element) { ?>
        <a href="https://vk.com/id<?php echo $element->uid; ?>"
           target="_blank"><?php echo $element->first_name . ' ' . $element->last_name; ?></a>
    <? } ?>
</div>
