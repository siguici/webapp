<form method="GET" action="/settings">
    <select class="field" name="lang"><?php foreach (app()->getLangs() as $lang) {
        echo "<option value='$lang'" . ($lang === val('lang') ? ' selected' : '') . ">$lang</option>";
} ?></select><button class="action button" type="submit" name="action" value="change"><?= val('Change') ?></button>
</form>
