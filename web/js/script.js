var product = {
    price: function(el) {
        $.ajax({
            method: 'PUT',
            url: '/api/products/' + el.dataset.productId,
            data: { price: el.value },
            success: function(data) {
                el.value = data.price
            }
        })
    }
}
