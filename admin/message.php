<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php
include_once '../helpers/Format.php';
include_once '../classes/Utility.php';
$utility = new Utility();
$fm = new Format();
?>
<div class="grid_10">
    <div class="box round first grid">
        <?php
        if (isset($_GET['seenid'])) {
            $seenid = $_GET['seenid'];
            $seenMessage = $utility->seenMessage($seenid);
        }
        if (isset($_GET['unseenid'])) {
            $unseenid = $_GET['unseenid'];
            $unseenMessage = $utility->unseenMessage($unseenid);
        }
        if (isset($_GET['delid'])) {
            $delid = $_GET['delid'];
            $deleteMessage = $utility->deleteMessage($delid);
        }
        ?>
        <h2>Inbox</h2>
        <?php
        if (isset($seenMessage)) {
            echo $seenMessage;
        }
        if (isset($unseenMessage)) {
            echo $unseenMessage;
        }
        if (isset($deleteMessage)) {
            echo $deleteMessage;
        }
        ?>
        <div class="block">
            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th>Serial No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $getMessage = $utility->getMessage();
                    if ($getMessage) {
                        $i = 0;
                        while ($result = $getMessage->fetch_assoc()) {
                            $i++ ?>
                            <tr class="odd gradeX">
                                <td>
                                    <?php echo $i; ?>
                                </td>
                                <td>
                                    <?php echo $result['name']; ?>
                                </td>
                                <td>
                                    <?php echo $result['email']; ?>
                                </td>
                                <td>
                                    <?php echo $result['phone']; ?>
                                </td>
                                <td>
                                    <?php echo $fm->textShorten($result['body'], 30); ?>
                                </td>
                                <td>
                                    <?php echo $fm->formatDate($result['date']); ?>
                                </td>
                                <td>
                                    <a href="viewmsg.php?msgid=<?php echo $result['id']; ?>">View</a> ||
                                    <a href="replaymsg.php?msgid=<?php echo $result['id']; ?>">Reply</a> ||
                                    <a onclick="return confirm('Are You Sure to Move Message?')"
                                        href="?seenid=<?php echo $result['id']; ?>">Seen</a>
                                </td>
                            </tr>
                        <?php }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="box round first grid">
        <h2>Seen Message</h2>
        <div class="block">
            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th>Serial No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $getSeenMessage = $utility->getSeenMessage();

                    if ($getSeenMessage) {
                        $i = 0;
                        while ($result = $getSeenMessage->fetch_assoc()) {
                            $i++
                                ?>
                            <tr class="odd gradeX">
                                <td>
                                    <?php echo $i; ?>
                                </td>
                                <td>
                                    <?php echo $result['name']; ?>
                                </td>
                                <td>
                                    <?php echo $result['email']; ?>
                                </td>
                                <td>
                                    <?php echo $result['phone']; ?>
                                </td>
                                <td>
                                    <?php echo $fm->textShorten($result['body'], 30); ?>
                                </td>
                                <td>
                                    <?php echo $fm->formatDate($result['date']); ?>
                                </td>
                                <td>
                                    <a href="viewmsg.php?msgid=<?php echo $result['id']; ?>">View</a> ||
                                    <a onclick="return confirm('Are You Sure to Move Message?')"
                                        href="?unseenid=<?php echo $result['id']; ?>">UnSeen</a> ||
                                    <a onclick="return confirm('Are You Sure to Delete?')"
                                        href="?delid=<?php echo $result['id']; ?>">Delete</a>
                                </td>
                            </tr>
                        <?php }
                    } ?>
                </tbody>
            </table>

        </div>
    </div>

</div>
<div class="clear">
</div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();
        $('.datatable').dataTable();
        setSidebarHeight();
    });
</script>
<?php include 'inc/footer.php'; ?>