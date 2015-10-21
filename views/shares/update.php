<form method="post" action="<?= base_url() ?>shares/shares/update/<?= $item->id ?>" class="modal-wrapper column-4"
      validate-form="true"
      validation-error="<?= $this->lang->line("please_check_marked_fields") ?>">
    <div class="modal-header">
        <?= $this->lang->line("update_share") ?>
    </div>
    <div class="modal-content">
        <div class="inline-form-row">
            <div class="column-6">
                <label for="share_name"><?= $this->lang->line("share_name") ?></label>
            </div>
            <div class="column-6">
                <input type="text" id="share_name" name="share_name" class="full-width" required-field="true"
                       validation="[not-empty]" value="<?= $item->share_name ?>"/>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="inline-form-row">
            <div class="column-6">
                <label for="buying_price"><?= $this->lang->line("buying_price") ?></label>
            </div>
            <div class="column-6">
                <input type="text" id="buying_price" name="buying_price" class="full-width" required-field="true"
                       validation="[not-empty]" value="<?= $item->buying_price ?>"/>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="inline-form-row">
            <div class="column-6">
                <label for="selling_price"><?= $this->lang->line("selling_price") ?></label>
            </div>
            <div class="column-6">
                <input type="text" id="selling_price" name="selling_price" class="full-width" required-field="true"
                       validation="[not-empty]" value="<?= $item->selling_price ?>"/>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="inline-form-row">
            <div class="column-6">
                <label for="quantity"><?= $this->lang->line("quantity") ?></label>
            </div>
            <div class="column-6">
                <input type="text" id="quantity" name="quantity" class="full-width" required-field="true"
                       validation="[not-empty]" value="<?= $item->quantity ?>"/>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="inline-form-row">
            <div class="column-6">
                <label for="commision"><?= $this->lang->line("commision") ?></label>
            </div>
            <div class="column-6">
                <input type="text" id="commision" name="commision" class="full-width" required-field="true"
                       validation="[not-empty]" value="<?= $item->commision ?>"/>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="inline-form-row">
            <div class="column-6">
                <label for="status"><?= $this->lang->line("status") ?></label>
            </div>
            <div class="column-6">
                <select name="status">
                    <option <?php if ($item->commision == 1) echo 'selected'; ?>
                        value="1"><?= $this->lang->line('open_share_status'); ?></option>
                    <option <?php if ($item->commision == 0) echo 'selected'; ?>
                        value="0"><?= $this->lang->line('closed_share_status'); ?></option>
                </select>
            </div>
            <div class="clearfix"></div>
        </div>
        <?php
        $this->event->register("ShareCreateFormRow", $item);
        ?>
        <div class="form-error-handler" error-handler="true"></div>
    </div>
    <div class="modal-footer">
        <input type="submit" value="<?= $this->lang->line("update") ?>" class="button medium-button primary-button"/>
        <a href="#" class="button medium-button secondary-button close-modal-window">
            <?= $this->lang->line("close") ?>
        </a>
    </div>
</form>