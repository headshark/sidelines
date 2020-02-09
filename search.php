<?php
require_once("includes/header.php");

?>
<div class="textBoxContainer">
    <input type="text" class="searchInput" placeholder="Search">
</div>

<div class="results"></div>

<script>
$(function() {
    let username = '<?php echo $userLoggedIn; ?>';
    let timer;

    $('.searchInput').keyup(function() {
        clearTimeout(timer);

        timer = setTimeout(function() {
            let val = $('.searchInput').val();
            
            if (val != '') {
                $.post('ajax/getSearchResults.php', { term: val, username: username }, function(data) {
                    $('.results').html(data);
                    console.log(data);
                });
            } else {
                $('.results').html('');
            }
        }, 500);
    });
});
</script>
