<?php
/**
 * Created by PhpStorm.
 * User: vic
 * Date: 2017-02-04
 * Time: 12:14 AM
 */
?>

<?
include_once('main_table/Unit.php');

function display_start_button($unit)
{
    $duration = $unit->getDuration();
    $name = $unit->getName();
    $description = $unit->getDescription();
    $id = $unit->getSubjectid();
    $color = $unit->getColor();

    $width_percent = (100 / 30) * $duration;
    ?>

    <button type="button" data-backdrop="static" data-keyboard="false"
            class="btn btn-default start-button timer-start start-button-<?= $id ?>" id="<?= $id ?>" data-toggle="modal"
            data-target="#stopwatch-modal"
            data-toggle="popover"
            data-container="body"

            data-placement="top"
            data-content="Time to complete Unit: <?= 30 - (int)$duration; ?> mins"

            data-color="<?=$color;?>"
            data-width="<?=$width_percent;?>"
    >


        <?= $name ?>

        <div class="hidden-description" id="hidden-description-<?= $id ?>">
            <?= $description ?>
        </div>

    </button>



    <!--    </div>-->
<? } ?>
