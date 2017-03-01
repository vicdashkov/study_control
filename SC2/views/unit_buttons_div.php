<?php
/**
 * Created by PhpStorm.
 * User: vic
 * Date: 2017-02-24
 * Time: 1:29 AM
 */


?>


<?
function display_unit_buttons($converter)
{
    $leftovers = $converter->getLeftovers();

    ?>

    <div id="unit-buttons-div">

        <div class="panel panel-default" id="non-acadivic_buttons">
            <div class="panel-heading">
                <h3 class="panel-title">Non Academic</h3>
            </div>
            <div class="panel-body btn-group-vertical">
                <?
                $i = 0;
                foreach ($leftovers as $leftover) {


                    $subject_type = $leftover->getSubjectType();
                    $active = $leftover->getActive();

                    if ($subject_type == 1 && $active==1) {
                        /// button display
                        display_start_button($leftover);
                        $i++;
                    }

                }

                if ($i == 0) {
                    echo '<button type="button" class="btn btn-default" data-toggle="modal" data-target="#subjects-modal">Add a subject</button>';
                }
                ?>
            </div>
        </div>


        <div class="panel panel-default" id="academic_buttons">
            <div class="panel-heading">
                <h3 class="panel-title">Academic</h3>
            </div>
            <div class="panel-body ">

                <div class="btn-group-vertical">
                    <?
//
//                    if ($leftovers == null) {
//                        echo '<button type="button" class="btn btn-default" data-toggle="modal" data-target="#subjects-modal">Add a subject</button>';
//                    }

                    $i = 0;
                    foreach ($leftovers as $leftover) {
                        $subject_type = $leftover->getSubjectType();
                        $active = $leftover->getActive();
                        if ($subject_type == 0 && $active == 1) {

                            display_start_button($leftover);
                            $i++;
                        }

                    }
                    if ($i == 0) {
                        echo '<button type="button" class="btn btn-default" data-toggle="modal" data-target="#subjects-modal">Add a subject</button>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

<?php } ?>