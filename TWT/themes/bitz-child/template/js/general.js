var glob_shown_posts = new Array();
var td_ajax_url = "https://techwebtrends.com/wp-admin/admin-ajax.php";
jQuery(document).on('keyup', '.validate_email', function () {
    jQuery(this).parents('form').find('.button-submit').attr('disabled', true);
});

jQuery(document).ready(function () {
    jQuery('.mp-date').each(function() {
const $this = jQuery(this);
const str = $this.find('time').html();
if (str) {
    const result = str.slice(0, str.lastIndexOf(','));
    $this.find('time').html(result);
}
});
});

jQuery(document).ready(function () {
    jQuery('.meta-date').each(function() {
const $this = jQuery(this);
const str = $this.find('time').html();
if (str) {
    const result = str.slice(0, str.lastIndexOf(','));
    $this.find('time').html(result);
}
});
});

jQuery(document).ready(function () {
    jQuery('.meta-date').each(function() {
const $this = jQuery(this);
const str = $this.find('span').html();
if (str) {
    const result = str.slice(0, str.lastIndexOf(','));
    $this.find('span').html(result);
}
});
});