<?
function display_months_header($months, $username)
{
    $reversed_months = array_reverse($months);
    ?>

    <nav class="navbar navbar-default navbar-fixed-top" id="month-header">
        <div class="container">
            <div class="navbar-header">


                <div class="dropdown-container">
                    <div class="btn-group account">
                        <button class="btn btn-link dropdown-toggle" type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            <a class="navbar-brand" href="#"><span class="glyphicon glyphicon-user"></span> </a>
                        </button>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header"><?= $username; ?></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#" data-toggle="modal" data-target="#subjects-modal">Add a subject</a></li>
                            <li><a href="login.php">Logout</a></li>
                        </ul>
                    </div>
                </div>


            </div>
            <ul class="nav nav-tabs list" id="myTab">

                <?

                if (sizeof($months) == 0) {
                    $month = new Month();
                    $month->fill_up(null);
//            $this->_display_month($month);
                    array_push($reversed_months, $month);
                }


                $i = 0;
                foreach ($reversed_months as $month) {
                    $month_number = $month->get_month_number();

                    $dateObj = DateTime::createFromFormat('!m', $month_number);
                    $month_date = $dateObj->format('F');
                    $year = $month->get_month_year();

                    $month_name = $month_date . ' ' . $year;

                    if ($i == 0) {
                        echo '<li class="active"><a href="#" class="display-month-footer" data-value="'
                            . $month_date . '-' . $month->get_month_year() . '">'
                            . $month_name . '</a></li>';
                    } else {

                        echo '<li><a href="#" class="display-month-footer " data-value="'
                            . $month_date . '-' . $month->get_month_year() . '">'
                            . $month_name . '</a></li>';
                    }
                    $i++;
                }
                ?>

            </ul>
        </div>
    </nav>


<? } ?>