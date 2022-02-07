<form method="GET" action="/set">
    <select name="lang"><?php foreach (app()->getLangs() as $lang) {
        echo "<option value='$lang'" . ($lang === val('lang') ? ' selected' : '') . ">$lang</option>";
} ?></select>
    <button type="submit" name="action" value="change"><?= val('Change') ?></button>
</form>
