<?php if ($error_warning) { ?>
<div class="alert alert-error"><?php echo $error_warning; ?><a class="close" data-dismiss="alert">×</a></div>
<?php } ?>

<div class="box">
    <div class="heading">
        <h2><?php echo $heading_title; ?></h2>

        <div class="buttons">
            <button onclick="$('#form').submit();" class="btn btn-primary"><?php echo $button_save; ?></button>
            <button onclick="location = '<?php echo $cancel; ?>';" class="btn"><?php echo $button_cancel; ?></button>
        </div>
    </div>
    <div class="content">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
            <table class="form">
                <tr>
                    <td><span class="required">*</span> <?php echo $entry_name; ?></td>
                    <td><?php foreach ($languages as $language) { ?>
                        <input type="text" name="option_description[<?php echo $language['language_id']; ?>][name]"
                               value="<?php echo isset($option_description[$language['language_id']]) ? $option_description[$language['language_id']]['name'] : ''; ?>"/>
                        <img src="view/image/flags/<?php echo $language['image']; ?>"
                             title="<?php echo $language['name']; ?>"/><br/>
                        <?php if (isset($error_name[$language['language_id']])) { ?>
                        <span class="error"><?php echo $error_name[$language['language_id']]; ?></span><br/>
                        <?php } ?>
                        <?php } ?></td>
                </tr>
                <tr>
                    <td><?php echo $entry_type; ?></td>
                    <td><select name="type">
                            <optgroup label="<?php echo $text_choose; ?>">
                                <option value="select" <?php echo isSelected($type, 'select');?>><?php echo $text_select; ?></option>
                                <option value="radio" <?php echo isSelected($type, 'radio');?>><?php echo $text_radio; ?></option>
                                <option value="checkbox" <?php echo isSelected($type, 'checkbox');?>><?php echo $text_checkbox; ?></option>
                                <option value="color" <?php echo isSelected($type, 'color');?>><?php echo $text_color; ?></option>

                            </optgroup>
                            <optgroup label="<?php echo $text_input; ?>">
                                <option value="text" <?php echo isSelected($type, 'text');?>><?php echo $text_text; ?></option>
                                <option value="textarea" <?php echo isSelected($type, 'textarea');?>><?php echo $text_textarea; ?></option>
                            </optgroup>
                            <optgroup label="<?php echo $text_file; ?>">
                                <option value="file" <?php echo isSelected($type, 'file');?>><?php echo $text_file; ?></option>
                            </optgroup>
                            <optgroup label="<?php echo $text_date; ?>">
                                <option value="date" <?php echo isSelected($type, 'date');?>><?php echo $text_date; ?></option>
                                <option value="time" <?php echo isSelected($type, 'time');?>><?php echo $text_time; ?></option>
                                <option value="datetime" <?php echo isSelected($type, 'datetime');?>><?php echo $text_datetime; ?></option>
                            </optgroup>
                            <optgroup label="<?php echo $text_virtual_product; ?>">
                                <option value="virtual_product" <?php echo isSelected($type, 'virtual_product');?>><?php echo $text_virtual_product; ?></option>
                            </optgroup>
                            <optgroup label="<?php echo $text_union_option; ?>">
                                <option value="union_option" <?php echo isSelected($type, 'union_option');?>><?php echo $text_union_option; ?></option>
                            </optgroup>
                        </select>&nbsp;<label style="display:inline;"><input type="checkbox" name="fixed"
                                                                             style="display:inline;"
                                                                             value="1" <?php if($fixed) echo 'checked="checked"';?>
                            /><?php echo $entry_fixed;?></label></td>
                </tr>
                <tr>
                    <td><?php echo $entry_sort_order; ?></td>
                    <td><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="1"/></td>
                </tr>
            </table>
            <table id="option-value" class="list">
                <thead>
                <tr>
                    <td class="left"><span class="required">*</span> <?php echo $entry_value; ?></td>
                    <td class="right"><?php echo $entry_sort_order; ?></td>
                    <td></td>
                </tr>
                </thead>
                <?php $option_value_row = 0; ?>
                <?php foreach ($option_values as $option_value) { ?>
                <tbody id="option-value-row<?php echo $option_value_row; ?>">
                <tr>
                    <td class="left"><input type="hidden"
                                            name="option_value[<?php echo $option_value_row; ?>][option_value_id]"
                                            value="<?php echo $option_value['option_value_id']; ?>"/>
                        <?php if($type=='union_option'){ ?>
                        <select name="option_value[<?php echo $option_value_row; ?>][option_value_description][0][name]" >
                            <?php foreach ($options as $option) { ?>
                            <option value="<?php echo $option['option_id']; ?>" <?php echo isSelected($option_value['option_value_description'][0]['name'],$option['option_id']);?>><?php echo $option['name']; ?></option>
                            <?php }?>
                            </select>
                        <?php }else{ ?>
                        <?php foreach ($languages as $language) { ?>
                        <input type="text"
                               name="option_value[<?php echo $option_value_row; ?>][option_value_description][<?php echo $language['language_id']; ?>][name]"
                               value="<?php echo isset($option_value['option_value_description'][$language['language_id']]) ? $option_value['option_value_description'][$language['language_id']]['name'] : ''; ?>"/>
                        <img src="view/image/flags/<?php echo $language['image']; ?>"
                             title="<?php echo $language['name']; ?>"/><br/>
                        <?php if (isset($error_option_value[$option_value_row][$language['language_id']])) { ?>
                        <span class="error"><?php echo $error_option_value[$option_value_row][$language['language_id']]; ?></span>
                        <?php } ?>
                        <?php } ?>
                        <?php } ?>
                    </td>
                    <td class="right"><input type="text"
                                             name="option_value[<?php echo $option_value_row; ?>][sort_order]"
                                             value="<?php echo $option_value['sort_order']; ?>" size="1"/></td>
                    <td class="left">
                        <button onclick="$('#option-value-row<?php echo $option_value_row; ?>').remove();"
                                class="btn"><?php echo $button_remove; ?></button>
                    </td>
                </tr>
                </tbody>
                <?php $option_value_row++; ?>
                <?php } ?>
                <tfoot>
                <tr>
                    <td colspan="2"></td>
                    <td class="left"><a onclick="addOptionValue();"
                                        class="btn"><?php echo $button_add_option_value; ?></a></td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>
</div>

<script type="text/javascript"><!--

    var options = [];
    var languages = [];
    <?php foreach($options as $option):?>
    options.push(<?php echo json_encode($option)?>);
    <?php endforeach;?>
    <?php foreach($languages as $language):?>
    languages.push(<?php echo json_encode($language)?>);
    <?php endforeach;?>

    var option_value_row = <?php echo $option_value_row; ?>;
    var oldvalue=$('select[name=\'type\']').val();
    //value  /  union
    var addMode = oldvalue=='union_option'?'union':"value";
    $('select[name=\'type\']').bind('change', function () {
        if (this.value == 'select' || this.value == 'radio' || this.value == 'text' || this.value == 'checkbox' || this.value == 'color' || this.value == 'virtual_product' ) {
            $('#option-value').show();
            if(oldvalue == 'union_option') {
                $('#option-value tbody').remove();
            }
            addMode='value';
        }else if(this.value=='union_option'){
            $('#option-value').show();
            if(oldvalue != 'union_option') {
                $('#option-value tbody').remove();
            }
            addMode='union';
        } else {
            $('#option-value').hide();
        }
    });

    function addOptionValue() {
        html = '<tbody id="option-value-row' + option_value_row + '">';
        html += '<tr>';
        if (addMode == 'value') {
            html += '<td class="left"><input type="hidden" name="option_value[' + option_value_row + '][option_value_id]" value="" />';
            for (var i = 0; i < languages.length; i++) {
                html += '<input type="text" name="option_value[' + option_value_row + '][option_value_description][' + languages[i].language_id + '][name]" value="" /> <img src="view/image/flags/' + languages[i].image + '" title="' + languages[i].name + '" /><br />';
            }
            html += '</td>';
        } else {
            html += '<td><input type="hidden" name="option_value[' + option_value_row + '][option_value_id]" value=""/> <select name="option_value[' + option_value_row + '][option_value_description][0][name]" >';
            for (var i = 0; i < options.length; i++) {
                html += '<option value="' + options[i].option_id + '">' + options[i].name + '</option>';
            }
            html += '</select></td>';
        }
        html += '<td class="right"><input type="text" name="option_value[' + option_value_row + '][sort_order]" value="" size="1" /></td>';
        html += '<td class="left"><button onclick="$(\'#option-value-row' + option_value_row + '\').remove();" class="btn"><?php echo $button_remove; ?></button></td>';
        html += '</tr>';
        html += '</tbody>';

        $('#option-value tfoot').before(html);

        option_value_row++;
    }
    //--></script>
