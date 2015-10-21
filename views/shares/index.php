<section class="content">
    <div class="content-inner">
        <div class="tabs-wrapper">
            <ul class="tabs-list" id="tabs-list">
                <li class="active">
                    <a href="#">
                        <?= $this->lang->line("shares") ?>
                        <?php
                        $_section_description = $this->language->getSectionDescription("shares", "shares");
                        if ($_section_description != "") {
                            ?>
                            <i class="typcn typcn-info-large" tooltip-text="<?= $_section_description ?>"></i>
                            <?php
                        }
                        ?>
                    </a>
                </li>
            </ul>
            <script>
                var _tabs = new Tabs("#tabs-list").bindEvents();
            </script>
            <div class="clearfix"></div>
        </div>
        <div class="content-header">
            <?php
            if ($this->acl->checkPermissions("shares", "shares", "create")) {
                ?>
                <a href="<?= base_url() ?>shares/shares/create" class="button big-button primary-button modal-window">
                    <i class="typcn typcn-plus"></i>
                    <?= $this->lang->line("create_new_share") ?>
                </a>
                <?php
            }
            ?>
        </div>
        <div class="content-body">
            <?php
            $this->sidebar->renderSidebar("left-sidebar");
            ?>
            <div class="content-action bordered-left-sidebar">
                <div class="content-action-inner">
                    <div class="content-action-header xs-static-hide"></div>
                    <div class="content-action-subheader">
                    </div>
                    <table class="work-table" cellpadding="0" cellspacing="0">
                        <thead>
                        <tr>
                            <?php
                            $columns = 7;
                            ?>
                            <th sort-column="shares.share_name" <?= @$_GET['sort-column'] == "" ? "sort-direction=\"asc\"" : "" ?>><?= $this->lang->line("share_name") ?></th>
                            <th sort-column="shares.buying_price"><?= $this->lang->line("buying_price") ?></th>
                            <th sort-column="shares.selling_price"><?= $this->lang->line("selling_price") ?></th>
                            <th sort-column="shares.quantity"><?= $this->lang->line("quantity") ?></th>
                            <th sort-column="shares.commision"><?= $this->lang->line("commision") ?></th>
                            <th><?= $this->lang->line("pl") ?></th>
                            <th sort-column="shares.status"><?= $this->lang->line("status") ?></th>
                            <?php
                            $this->event->register("SharesTableHeading", $columns);
                            ?>
                            <?php
                            if ($this->acl->checkPermissions("shares", "shares", "update") || $this->acl->checkPermissions("shares", "shares", "delete")) {
                                $columns++
                                ?>
                                <th></th>
                                <?php
                            }
                            ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        for ($i = 0; $i < count($items); $i++) {
                            $pl = (($items[$i]->selling_price - $items[$i]->buying_price) * $items[$i]->quantity) - $items[$i]->commision;
                            ?>
                            <tr>
                                <td class="align-center"><?= $items[$i]->share_name ?></td>
                                <td class="align-center"><?= $items[$i]->buying_price ?></td>
                                <td class="align-center"><?= $items[$i]->selling_price ?></td>
                                <td class="align-center"><?= $items[$i]->quantity ?></td>
                                <td class="align-center"><?= $items[$i]->commision ?></td>
                                <td class="align-center"><?= $pl; ?></td>
                                <td class="align-center">
                                    <?php if ($items[$i]->status == 1) {
                                        echo $this->lang->line('open_share_status');
                                    } else {
                                        echo $this->lang->line('closed_share_status');
                                    } ?>
                                </td>
                                <?php
                                $this->event->register("SharesTableRow", $items[$i], $i);
                                ?>
                                <?php
                                if ($this->acl->checkPermissions("shares", "shares", "update") || $this->acl->checkPermissions("shares", "shares", "delete")) {
                                    ?>
                                    <td class="align-center">
                                        <?php
                                        if ($this->acl->checkPermissions("shares", "shares", "update")) {
                                            ?>
                                            <a href="<?= base_url() ?>shares/shares/update/<?= $items[$i]->id ?>"
                                               class="table-action-button modal-window"
                                               tooltip-text="<?= $this->lang->line("edit_share") ?>"><i
                                                    class="typcn typcn-pencil"></i></a>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($this->acl->checkPermissions("shares", "shares", "delete")) {
                                            ?>
                                            <a href="<?= base_url() ?>shares/shares/delete/<?= $items[$i]->id ?>"
                                               class="table-action-button popup-action" popup-type="confirmation"
                                               popup-message="<?= $this->lang->line("you_really_want_to_delete_share") ?>"
                                               popup-buttons="confirm:<?= $this->lang->line("yes") ?>,close:<?= $this->lang->line("cancel") ?>"
                                               tooltip-text="<?= $this->lang->line("delete_share") ?>"><i
                                                    class="typcn typcn-trash"></i></a>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <?php
                                }
                                ?>
                            </tr>
                            <?php
                        }
                        if (count($items) == 0) {
                            ?>
                            <tr>
                                <td class="no-records-found-row"
                                    colspan="<?= $columns ?>"><?= $this->lang->line("no_records_found") ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
            <div class="content-footer">
                <?php
                $this->pagination->drawPagination();
                ?>
            </div>
        </div>
    </div>
</section>