<?php $s = isset($_GET['s']) ? _h($_GET['s']) : '';?>
<form action="/" method="get" class="uk-search" data-uk-search>
    <input class="uk-search-field" type="search" placeholder="search..." name="s" value="<?php echo $s;?>">
</form>

