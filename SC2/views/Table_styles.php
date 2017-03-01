<?php

/**
 * Created by PhpStorm.
 * User: vic
 * Date: 2017-02-26
 * Time: 1:23 AM
 *
 *
 */


/**
 * Class Table_styles
 * The reason for creating this class is to ensure every user can pick different colors for different subjects.
 */
class Table_styles
{

    function display($sql_result)
    {
        echo '<style>';
        while ($row = $sql_result->fetch_assoc()) : ?>
            .subject-id-<?=$row[subject_id];?> {
            background-color: <?=$row[color];?>;
            }

            .start-button-<?=$row[subject_id];?> {
                color: <?=$row[color];?>;
            }
        <?endwhile;
        echo '</style>';
        ?>


        <?

    }
}

?>