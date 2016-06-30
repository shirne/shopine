 <?php if ($error_warning) { ?>
  <div class="alert alert-error"><?php echo $error_warning; ?><a class="close" data-dismiss="alert">×</a></div>
  <?php } ?>
  <div class="box">
    <div class="heading" >
      <h2><?php echo $heading_title; ?></h2>
      <div class="buttons">
	      <button id="fat-btn" data-loading-text="loading..." onclick="$('#form').submit();" class="btn btn-primary">
	            <?php echo $button_save; ?>
	      </button>
	      <input type="button" onclick="location = '<?php echo $cancel; ?>'" class="btn" value="<?php echo $button_cancel; ?>">
		</div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs"><a href="#tab-general" class="first"><?php echo $tab_general; ?></a></div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" class="form-horizontal">
        <div id="tab-general">
          <div id="languages" class="htabs" >
            <?php foreach ($languages as $language) { ?>
           		 <a href="#language<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
			<?php } ?>
          </div>
          <?php foreach ($languages as $language) { ?>
          <div id="language<?php echo $language['language_id']; ?>">
            <table class="form">
              <tr>
                <td><span class="required">*</span> <?php echo $entry_name; ?></td>
                <td><input type="text" name="category_description[<?php echo $language['language_id']; ?>][name]" size="100" class="span6" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['name'] : ''; ?>" />
                  <?php if (isset($error_name[$language['language_id']])) { ?>
                  <span class="help-inline error"><?php echo $error_name[$language['language_id']]; ?></span>
                  <?php } ?></td> 
              </tr>
               <tr>
                <td><?php echo $entry_description; ?></td>
                <td><textarea name="category_description[<?php echo $language['language_id']; ?>][description]" class="editor"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['description'] : ''; ?></textarea></td>
              </tr>
            </table>
          </div>
          <?php } ?>
          <table class="form">
          <tr>
              <td><?php echo $entry_parent; ?></td>
              <td><select name="parent_id">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($categories as $category) { ?>
                  <?php if ($category['information_category_id'] == $parent_id) { ?>
                  <option value="<?php echo $category['information_category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $category['information_category_id']; ?>"><?php echo $category['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_sort_order; ?></td>
              <td><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
            </tr>
            </table>
        </div>
      </form>
      		
    </div>

  </div>
<?php echo $editorinit?>
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
$('#languages a').tabs();

//--></script> 
