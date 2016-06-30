 <?php if ($error_warning) { ?>
  <div class="alert alert-error"><?php echo $error_warning; ?><a class="close" data-dismiss="alert">×</a></div>
  <?php } ?>

  <div class="box">
    <div class="heading">
      <h2><?php echo $heading_title; ?></h2>
      <div class="buttons"><button onclick="$('#form').submit();" class="btn btn-primary"><?php echo $button_save; ?></button> <button onclick="location = '<?php echo $cancel; ?>';" class="btn"><?php echo $button_cancel; ?></button></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_name; ?></td>
            <td><input type="text" name="name" value="<?php echo $name; ?>" size="100" />
              <?php if ($error_name) { ?>
              <span class="error"><?php echo $error_name; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="status">
                <?php if ($status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
        </table>
        <table id="images" class="list">
          <thead>
            <tr>
              <td class="left"><?php echo $entry_title; ?></td>
              <td class="left"><?php echo $entry_link; ?></td>
              <td class="left"><?php echo $entry_image; ?></td>
              <td></td>
            </tr>
          </thead>
          <?php $site_row = 0; ?>
          <?php foreach ($flink_sites as $flink_site) { ?>
          <tbody id="image-row<?php echo $site_row; ?>">
            <tr>
              <td class="left"><?php foreach ($languages as $language) { ?>
                <input type="text" name="flink_site[<?php echo $site_row; ?>][flink_site_description][<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($flink_site['flink_site_description'][$language['language_id']]) ? $flink_site['flink_site_description'][$language['language_id']]['title'] : ''; ?>" />
                <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
                <?php if (isset($error_flink_site[$site_row][$language['language_id']])) { ?>
                <span class="error"><?php echo $error_flink_site[$site_row][$language['language_id']]; ?></span>
                <?php } ?>
                <?php } ?></td>
              <td class="left"><input type="text" name="flink_site[<?php echo $site_row; ?>][link]" value="<?php echo $flink_site['link']; ?>" /></td>
              <td class="left"><input type="hidden" name="flink_site[<?php echo $site_row; ?>][image]" value="<?php echo $flink_site['image']; ?>" id="image<?php echo $site_row; ?>"  />
                <img src="<?php echo $flink_site['preview']; ?>" alt="" id="preview<?php echo $site_row; ?>" class="image" onclick="image_upload('image<?php echo $site_row; ?>', 'preview<?php echo $site_row; ?>');" /></td>
              <td class="left"><a onclick="$('#image-row<?php echo $site_row; ?>').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>
            </tr>
          </tbody>
          <?php $site_row++; ?>
          <?php } ?>
          <tfoot>
            <tr>
              <td colspan="3"></td>
              <td class="left"><a onclick="addSite();" class="button"><span><?php echo $button_add_flink; ?></span></a></td>
            </tr>
          </tfoot>
        </table>
      </form>
    </div>
  </div>

<script type="text/javascript"><!--
var site_row = <?php echo $site_row; ?>;

function addSite() {
    html  = '<tbody id="image-row' + site_row + '">';
	html += '<tr>';
    html += '<td class="left">';
	<?php foreach ($languages as $language) { ?>
	html += '<input type="text" name="flink_site[' + site_row + '][flink_site_description][<?php echo $language['language_id']; ?>][title]" value="" /> <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />';
    <?php } ?>
	html += '</td>';	
	html += '<td class="left"><input type="text" name="flink_site[' + site_row + '][link]" value="" /></td>';	
	html += '<td class="left"><input type="hidden" name="flink_site[' + site_row + '][image]" value="" id="image' + site_row + '" /><img src="<?php echo $no_image; ?>" alt="" id="preview' + site_row + '" class="image" onclick="image_upload(\'image' + site_row + '\', \'preview' + site_row + '\');" /></td>';
	html += '<td class="left"><a onclick="$(\'#image-row' + site_row  + '\').remove();" class="button"><span><?php echo $button_remove; ?></span></a></td>';
	html += '</tr>';
	html += '</tbody>'; 
	
	$('#images tfoot').before(html);
	
	site_row++;
}
//--></script>