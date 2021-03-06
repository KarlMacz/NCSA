<?php
    session_start();

    if(!isset($_SESSION['account_username'])) {
        header('Location: ./../');
    }

    include_once('assets/system/header.php');
?>

<div class="app-bar fixed-top shadow" data-role="appbar">
    <a class="app-bar-element branding" href="./"><img class="app-logo" src="assets/img/logo.png">&nbsp;&nbsp;Nazareth Christian School of Antipolo</a>
    <?php
        if(isset($_SESSION['account_username'])) {
            $name = $_SESSION['account_first_name'] . ' ' . $_SESSION['account_last_name'];

            echo '<ul class="app-bar-menu place-right">';
            echo '<li><a class="app-bar-element dropdown-toggle">' . $name . '&nbsp;&nbsp;<img class="app-logo" src="./../user_images/' . $_SESSION['account_image'] . '"></a>';
            echo '<ul class="d-menu place-right" data-role="dropdown">';
            echo '<li><a href="./../">Online Public Access Catalog</a></li>';
            echo '<li><a href="./../reservations.php">My Reservations</a></li>';
            echo '<li class="divider"></li>';
            //echo '<li><a href="">Change Account Picture</a></li>';
            echo '<li><a href="logout.php">Logout</a></li>';
            echo '</ul>';
            echo '</li>';
            echo '</ul>';
        } else {
            echo '<div class="place-right">';
            echo '<a class="app-bar-element" href="login.php"><span class="mif-switch"></span>&nbsp;&nbsp;Login</a>';
            echo '</div>';
        }
    ?>
</div>
<div id="main-block">
    <div class="flex-grid" style="height: 100%;">
        <div class="row" style="height: 100%;">
            <div id="cell-sidebar" class="cell bg-lightDark size-x300" style="overflow-y: scroll; height: 100%;">
                <ul class="sidebar2 dark">
                    <li><a href="./"><span class="mif-meter icon"></span><span class="title">Dashboard</span></a></li>
                    <li class="divider"></li><li class="divider"></li>
                    <li><a href="./reserved_materials.php"><span class="mif-history icon"></span><span class="title">Reserved Materials</span></a></li>
                    <li><a href="./loan_materials.php"><span class="mif-exit icon"></span><span class="title">Loan Materials</span></a></li>
                    <li><a href="./receive_materials.php"><span class="mif-enter icon"></span><span class="title">Receive Materials</span></a></li>
                    <li class="divider"></li><li class="divider"></li>
                    <li><a href="./manage_materials.php"><span class="mif-books icon"></span><span class="title">Manage Materials</span></a></li>
                    <li><a href="./manage_authors.php"><span class="mif-users icon"></span><span class="title">Manage Authors</span></a></li>
                    <li><a href="./manage_publishers.php"><span class="mif-printer icon"></span><span class="title">Manage Publishers</span></a></li>
                    <li><a href="./manage_categories.php"><span class="mif-list2 icon"></span><span class="title">Manage Categories</span></a></li>
                    <li class="divider"></li><li class="divider"></li>
                    <li><a href="./manage_faculties.php"><span class="mif-users icon"></span><span class="title">Manage Faculty Information</span></a></li>
                    <li class="active"><a href="./manage_students.php"><span class="mif-users mif-ani-shuttle icon"></span><span class="title">Manage Student Information</span></a></li>
                    <li><a href="./manage_weeding.php"><span class="mif-books icon"></span><span class="title">Manage Weeded Materials</span></a></li>
                    <li><a href="./manage_holidays.php"><span class="mif-calendar icon"></span><span class="title">Manage Holidays</span></a></li>
                    <li><a href="./settled_penalties.php"><span class="mif-dollars icon"></span><span class="title">Settled Penalties</span></a></li>
                    <li class="divider"></li><li class="divider"></li>
                    <li><a href="./view_logs.php"><span class="mif-clipboard icon"></span><span class="title">View Logs</span></a></li>
                    <li class="divider"></li><li class="divider"></li>
                    <li><a href="./generate_reports.php"><span class="mif-printer icon"></span><span class="title">Generate Reports</span></a></li>
                    <li class="divider"></li><li class="divider"></li>
                    <li><a href="./settings.php"><span class="mif-cog icon"></span><span class="title">Manage Settings</span></a></li>
                </ul>
            </div>
            <div id="cell-content" class="cell auto-size padding20 pane-scroll">
                <h1 class="text-light">Manage Student Information</h1>
                <hr><br>
                <div class="align-right">
                    <a class="button primary beautify beautify-mif" data-button="add-student-button" data-role="hint" data-hint="Add Student" data-hint-background="#dc4fad" data-hint-color="#ffffff" data-hint-mode="2" data-hint-position="top"><span class="mif mif-plus"></span>&nbsp;&nbsp;Add</a>
                </div>
                <table id="students-table" class="table striped border bordered">
                    <thead>
                        <tr>
                            <th width="15%">Student ID</th>
                            <th>Name</th>
                            <th>Year Level</th>
                            <th>Material(s) On Hand</th>
                            <th width="15%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            require_once('requests/connection.php');

                            $connection = new Connection();
                            $connection->open();

                            $connection->query("SELECT * FROM accounts INNER JOIN students ON accounts.Account_ID=students.Student_ID");

                            while($row = $connection->fetch_assoc()) {
                                if(strlen($row['Student_Middle_Name']) > 1) {
                                    $name = $row['Student_Last_Name'] . ', ' . $row['Student_First_Name'] . ' ' . substr($row['Student_Middle_Name'], 0, 1) . '.';
                                } else {
                                    $name = $row['Student_Last_Name'] . ', ' . $row['Student_First_Name'];
                                }

                                echo '<tr>';
                                echo '<td class="align-center">' . $row['Student_ID'] . '</td>';
                                echo '<td>' . $name . '</td>';
                                echo '<td>' . $row['Year_Level'] . '</td>';
                                echo '<td>' . $row['On_Hand'] . '</td>';
                                echo '<td class="align-center"><a class="button success mini-button beautify" data-button="edit-student-button" data-var-id="' . $row['Student_ID'] . '" data-role="hint" data-hint="Edit Student" data-hint-background="#dc4fad" data-hint-color="#ffffff" data-hint-mode="2" data-hint-position="top"><span class="mif mif-pencil"></span></a><a class="button danger mini-button beautify" data-button="delete-student-button" data-var-id="' . $row['Student_ID'] . '" data-role="hint" data-hint="Delete Student" data-hint-background="#dc4fad" data-hint-color="#ffffff" data-hint-mode="2" data-hint-position="top"><span class="mif mif-cross"></span></a></td>';
                                echo '</tr>';
                            }

                            $connection->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="dialog" class="dialog" data-overlay-click-close="true" data-overlay="true" data-overlay-color="op-dark" data-width="50%" data-role="dialog">
    <div id="dialog-inner" class="container-fluid"></div>
</div>
<script src="assets/js/manage_students.js"></script>

<?php
    include_once('assets/system/footer.php');
?>