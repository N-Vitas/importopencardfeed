<?php
$crontime = [];
foreach (wp_get_schedules() as $key => $value) {
    $crontime[$key] = $value['display'];
}
$cron_zadachi = get_option( 'cron' );

$gmt_time = microtime( true );
$results   = array();
foreach ( $cron_zadachi as $timestamp => $cronhooks ) {
    if ( $timestamp > $gmt_time ) {
        continue;
    }
    $results[] = $cronhooks;
}

var_dump(is_singular('importopencardfeed-admin'));
?>
<div class="wrap">
<h1><?php echo $setting->name ?></h1>

<form method="post" novalidate="novalidate">
<input type="hidden" name="option_page" value="general"><input type="hidden" name="action" value="update"><input type="hidden" id="_wpnonce" name="_wpnonce" value="4574fb9d50"><input type="hidden" name="_wp_http_referer" value="/wordpress/wp-admin/options-general.php">
<table class="form-table" role="presentation">

<tbody><tr>
<th scope="row"><label for="url">URL Адрес файла импорта</label></th>
<td><input name="url" type="text" id="url" value="<?php esc_attr_e($setting->url, 'importopencardfeed') ?>" class="regular-text"></td>
</tr>

<tr>
<th scope="row">Активация импорта</th>
<td> <fieldset><label for="run">
<input name="run" type="checkbox" id="run" <?php echo $setting->run == 1 ? 'checked' : '' ?> value="1">
	Вкл/Выкл</label>
</fieldset></td>
</tr>

<tr>
<th scope="row"><label for="crontime">Частота обновления</label></th>
<td>
<select name="crontime" id="crontime">
    <?php foreach ($crontime as $key => $value):?>
	    <option <?php echo $setting->crontime == $key ? 'selected' : '' ?> value="<?php esc_attr_e($key, 'importopencardfeed') ?>"><?php echo $value ?></option>
    <?php endForeach;?>
</select>
</td>
</tr>
</tbody></table>
<input name="action" type="hidden" id="action" value="importopencardfeed" />

<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Сохранить изменения"></p></form>

</div>