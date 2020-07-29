$(function() {
    $('.starRating label').on('click', function() {
        let id = $(this).attr('for');
        console.log(id);
        let star = $(`#${id}`).val();
        console.log(`Stars clicked: ${star}`);
        $.post(`/product/${PRODUCT_ID}/vote`, {vote: star});
    });
});