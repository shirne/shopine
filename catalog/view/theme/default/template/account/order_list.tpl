<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <h1><?php echo $heading_title; ?></h1>
    <div class="filterform">
            <div class="floatRight buttonbox">
            <a href="<?php echo $export;?>" class="button"><?php echo $button_export; ?></a>
            </div>
            <form name="filter" class="floatLeft">
            <label><?php echo $text_date;?></label><input type="text" name="filter_start_date" value="<?php echo $filter_start_date?>"  class="datepicker"/>-<input type="text" name="filter_end_date" value="<?php echo $filter_end_date?>"  class="datepicker"/>
            <label><?php echo $text_status;?>&nbsp;<select name="filter_order_status"><option value="">==全部==</option><?php foreach ($order_status as $key => $status):?>
                <option value="<?php echo $status['order_status_id'];?>" <?php if($status['order_status_id']==$filter_order_status) echo 'selected';?>><?php echo $status['name']?></option>
            <?php endforeach;?></select></label>
            <input type="text" placeholder="<?php echo $text_search;?>" value="<?php echo $filter_order_id?>" name="filter_order_id" />
            <input type="submit" class="button" value="<?php echo $button_search;?>" />
            </form>
        </div>
        <script type="text/javascript">
        $('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});
        </script>
    <?php if ($orders) { ?>
    <table class="list">
        <thead>
            <tr>
                <td class="left"><?php echo $text_order_id; ?></td>
                <td><?php echo $text_status; ?></td>
                <td><?php echo $text_products; ?></td>
                <td><?php echo $text_total; ?></td>
                <td><?php echo $text_date_added; ?></td>

                <td class="center"><?php echo $text_action; ?></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order) { ?>
            <tr>
                <td class="left">#<?php echo $order['order_id']; ?></td>
                <td><?php echo $order['status']; ?></td>
                <td><?php echo $order['products']; ?></td>
                <td><?php echo $order['total']; ?></td>
                <td><?php echo $order['date_added']; ?></td>

                <td class="center"><a href="<?php echo $order['href']; ?>"><span><?php echo $button_view; ?></span></a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="pagination"><?php echo $pagination; ?></div>
    <?php } else { ?>
    <div class="content"><?php echo $issearch?$text_search_empty:$text_empty; ?></div>
    <?php } ?>

    <?php echo $content_bottom; ?></div>
    <?php echo $footer; ?>