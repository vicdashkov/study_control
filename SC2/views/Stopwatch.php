<?php

/**
 * Created by PhpStorm.
 * User: vic
 * Date: 2017-02-01
 * Time: 9:25 PM
 */
class Stopwatch
{
    public function display()
    {
        ?>
        <div class="modal fade" tabindex="-1" role="dialog" id="stopwatch-modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Stopwatch</h4>
                    </div>
                    <div class="modal-body">
                        <h1>
                            <time>00:00:00</time>
                        </h1>
                        <div id="stopwatch-description">

                        </div>


                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width:0">
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default timer-stop" data-dismiss="modal">Stop</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <?
    }
}

?>