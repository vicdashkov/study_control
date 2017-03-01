<?php
/**
 * Created by PhpStorm.
 * User: vic
 * Date: 2017-02-19
 * Time: 9:37 PM
 */


function display_subjects($mysql_result)
{
    ?>
    <div class="modal fade" tabindex="-1" role="dialog" id="subjects-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Please choose a subject</h4>
                </div>
                <div class="modal-body">
                    <div class="list-group subjects-list">
                        <? while ($row = $mysql_result->fetch_assoc()) : ?>
                            <a data-value="<?= $row[subject_id]; ?>"
                               class="list-group-item subject-li"><?= $row[description]; ?></a>
                        <? endwhile; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<? } ?>